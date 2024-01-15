<template>
	<Layout vh>
		<Modal
			v-if="form.create.visible"
			:title="`${$t('common.form.creating')}`"
			@close="form.create.visible = false"
		>
			<formulate-form @submit="create" name="create">
				<div class="form__field-group">
					<formulate-input
						v-model="form.create.fields.name"
						name="name"
						type="text"
						:label="$t('common.form.fields.name')"
						validation="required"
					/>
				</div>

				<Button
					:loading="form.create.loading"
					:disabled="form.create.loading"
					@click="$formulate.submit('create')"
					:label="$t('common.form.create')"
					class="mt-5 ml-auto"
				/>
			</formulate-form>
		</Modal>

		<Modal
			v-if="form.update.visible"
			:title="`${$t('common.form.updating')}: ${form.update.resource.name}`"
			@close="form.update.visible = false"
		>
			<formulate-form @submit="update" name="update">
				<div class="form__field-group">
					<formulate-input
						v-model="form.update.fields.name"
						name="name"
						type="text"
						:label="$t('common.form.fields.name')"
						validation="required"
					/>
				</div>

				<div class="flex items-center justify-end gap-4 mt-5">
					<Button
						category="secondary"
						variant="danger"
						@click="showDestroyForm(form.update.resource)"
						:label="$t('common.form.delete')"
					/>

					<Button
						:loading="form.update.loading"
						:disabled="form.update.loading"
						@click="$formulate.submit('update')"
						:label="$t('common.form.update')"
					/>
				</div>
			</formulate-form>
		</Modal>

		<DeleteResourceModal
			v-if="form.destroy.visible"
			:title="$t('routes.real-estate.amenities.index.delete-amenity-modal-title')"
			@close="form.destroy.visible = false"
			@confirm="destroy()"
			:loading="form.destroy.loading"
		>
			<p
				v-html="
					$t('modals.delete-resource.attempting-to-delete-resource', {
						name: form.destroy.resource.name,
					})
				"
			></p>
		</DeleteResourceModal>

		<div class="flex flex-col h-full">
			<Header :title="$t('routes.real-estate.amenities.index.title')">
				<template #extra-content>
					<Button
						:label="$t('routes.real-estate.amenities.index.add-amenity')"
						class="ml-auto"
						@click="showCreateForm()"
					/>
				</template>
			</Header>

			<DataGrid
				:loading="loadingTable"
				:columns="columns"
				:rows="rows"
				class="h-full mt-3 overflow-hidden"
			>
				<template #row="{ row, field }">
					<button @click="showUpdateForm(row)" class="flex items-center">
						{{ row[field] }}
					</button>
				</template>
			</DataGrid>
		</div>
	</Layout>
</template>

<script lang="ts">
	import Vue from 'vue'
	import { Layout } from '@/layouts/main'
	import Header from '@/components/Header.vue'
	import Button from '@/components/Button.vue'
	import { AmenitiesApi, Amenity } from '@/services/real-estate/amenities'
	import { default as DataGrid } from '@/components/data-table/Table.vue'
	import Modal from '@/components/modals/Modal.vue'
	import DeleteResourceModal from '@/components/modals/DeleteResourceModal.vue'
	import { Column } from '@/components/data-table/types'
	import { ErrorResponse } from '@/services/http'
	import { AxiosResponse } from 'axios'
	import { useUiStore } from '@/stores/ui'
	import { mapActions } from 'pinia'

	type AmenityForm = { name: string }

	export default Vue.extend({
		components: { Layout, Header, Button, DataGrid, Modal, DeleteResourceModal },

		data() {
			const columns: Column<keyof Amenity>[] = [
				{
					label: this.$tc('common.form.fields.name'),
					field: 'name',
					searchable: true,
				},
			]

			return {
				loadingTable: false,
				columns,
				rows: [] as Amenity[],
				form: {
					create: {
						visible: false,
						loading: false,
						fields: {
							name: '' as string,
						} as AmenityForm,
					},
					update: {
						visible: false,
						loading: false,
						fields: {
							name: '' as string,
						} as AmenityForm,
						resource: {} as Amenity,
					},
					destroy: {
						visible: false,
						loading: false,
						resource: {} as Amenity,
					},
				},
			}
		},

		methods: {
			...mapActions(useUiStore, ['fireAlert']),

			fetchTableData() {
				this.loadingTable = true

				AmenitiesApi.index()
					.then(res => (this.rows = res.data.data))
					.catch((res: AxiosResponse<ErrorResponse>) =>
						this.fireAlert({
							title: this.$tc('common.error-fetching-data'),
							description: res.data.message,
							type: 'error',
						}),
					)

				this.loadingTable = false
			},

			showCreateForm() {
				this.form.create.fields.name = ''
				this.form.create.visible = true
			},

			showUpdateForm(amenity: Amenity) {
				this.form.update.resource = amenity
				this.form.update.fields.name = amenity.name
				this.form.update.visible = true
			},

			showDestroyForm(amenity: Amenity) {
				this.form.destroy.resource = amenity
				this.form.destroy.visible = true
			},

			async create(form: AmenityForm) {
				this.form.create.loading = true

				await AmenitiesApi.store(form)
					.then(() => {
						this.form.create.visible = false
						this.fireAlert({
							title: this.$tc(
								'routes.real-estate.amenities.index.create-amenity-success',
							),
							type: 'info',
						})
						this.fetchTableData()
					})
					.catch((res: AxiosResponse<ErrorResponse>) => {
						this.$formulate.handleApi(res.data, 'create')
					})

				this.form.create.loading = false
			},
			async update(form: AmenityForm) {
				this.form.update.loading = true

				await AmenitiesApi.update(this.form.update.resource.id, form)
					.then(() => {
						this.form.update.visible = false
						this.fireAlert({
							title: this.$tc(
								'routes.real-estate.amenities.index.update-amenity-success',
							),
							type: 'info',
						})
						this.fetchTableData()
					})
					.catch((res: AxiosResponse<ErrorResponse>) => {
						this.$formulate.handleApi(res.data, 'update')
					})

				this.form.update.loading = false
			},
			async destroy() {
				this.form.destroy.loading = true

				await AmenitiesApi.destroy(this.form.destroy.resource.id)
					.then(() => {
						this.form.update.visible = false
						this.form.destroy.visible = false
						this.fireAlert({
							title: this.$tc(
								'routes.real-estate.amenities.index.destroy-amenity-success',
							),
							type: 'info',
						})
						this.fetchTableData()
					})
					.catch((res: AxiosResponse<ErrorResponse>) => {
						this.fireAlert({
							title: this.$tc('common.error-deleting-resource'),
							description: res.data.message,
							type: 'error',
						})
					})

				this.form.destroy.loading = false
			},
		},

		created() {
			this.fetchTableData()
		},
	})
</script>
