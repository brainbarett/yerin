<template>
	<Layout>
		<DeleteResourceModal
			v-if="showDestroyModal"
			:title="$t('routes.roles.edit.delete-role-modal-title')"
			@close="showDestroyModal = false"
			@confirm="destroy()"
			:loading="loading.destroy"
		>
			<p
				v-html="
					$t('modals.delete-resource.attempting-to-delete-resource', {
						name: resource.name,
					})
				"
			></p>
		</DeleteResourceModal>

		<div class="flex flex-col items-start gap-2">
			<Header :title="$t('routes.roles.edit.title')" :back="{ name: 'roles.index' }" />
			<span
				v-if="resource.super_admin"
				class="px-2 mr-2 font-bold text-yellow-600 rounded bg-amber-200"
			>
				Super Admin
			</span>
		</div>

		<formulate-form @submit="save" v-model="form" name="main">
			<div class="resource-form__section">
				<div class="form__field-group">
					<formulate-input
						name="name"
						type="text"
						:label="$t('common.form.fields.name')"
						placeholder="Monarch"
						validation="required"
					/>
				</div>
			</div>

			<div v-if="!resource.super_admin" class="p-0 resource-form__section">
				<Permissions
					:selected="form.permissions"
					@add-permission="form.permissions.push($event)"
					@remove-permission="
						form.permissions = form.permissions.filter(
							permission => permission != $event,
						)
					"
				/>
			</div>
		</formulate-form>

		<div class="flex items-center justify-end gap-4">
			<Button
				v-if="!resource.system_role"
				category="secondary"
				variant="danger"
				@click="showDestroyModal = true"
				:label="$t('common.form.delete')"
			/>

			<Button
				@click="$formulate.submit('main')"
				:loading="loading.update"
				:disabled="loading.update"
				:label="$t('common.form.update')"
			/>
		</div>
	</Layout>
</template>

<script lang="ts">
	import Vue from 'vue'
	import { Layout } from '@/layouts/main'
	import Header from '@/components/Header.vue'
	import Button from '@/components/Button.vue'
	import { RolesApi, Role, UpdateRequest } from '@/services/roles'
	import { AxiosResponse } from 'axios'
	import { ErrorResponse } from '@/services/http'
	import Permissions from './shared/Permissions.vue'
	import DeleteResourceModal from '@/components/modals/DeleteResourceModal.vue'
	import { useUiStore } from '@/stores/ui'
	import { mapActions } from 'pinia'

	type Form = {
		name: string
		permissions: string[]
	}

	export default Vue.extend({
		components: { Layout, Header, Button, Permissions, DeleteResourceModal },

		data() {
			return {
				resource: {} as Role,
				loading: {
					update: false,
					destroy: false,
				},
				form: {
					name: '',
					permissions: [],
				} as Form,
				showDestroyModal: false as boolean,
			}
		},

		methods: {
			...mapActions(useUiStore, ['fireAlert', 'queueAlert']),

			async save(form: Form) {
				this.loading.update = true
				this.$formulate.resetValidation('main')

				const parsedFormData: UpdateRequest = form
				await RolesApi.update(this.resource.id, parsedFormData)
					.then(() => this.$router.push({ name: 'roles.index' }))
					.catch((res: AxiosResponse<ErrorResponse>) => {
						this.$formulate.handleApi(res.data, 'main')
					})

				this.loading.update = false
			},

			async destroy() {
				this.loading.destroy = true

				await RolesApi.destroy(this.resource.id)
					.then(() => this.$router.push({ name: 'roles.index' }))
					.catch((res: AxiosResponse<ErrorResponse>) => {
						this.fireAlert({
							title: <string>this.$t('common.error-deleting-resource', {
								name: this.resource.name,
							}),
							description: res.data.message,
							type: 'error',
						})
					})

				this.loading.destroy = false
			},
		},

		async beforeRouteEnter(to, from, next) {
			await RolesApi.show(to.params.id as unknown as number)
				.then(res => {
					next((vm: any) => {
						const role = res.data.data
						const form: Form = role

						vm.resource = role
						vm.form = form
					})
				})
				.catch((res: AxiosResponse<ErrorResponse>) =>
					next((vm: any) => {
						const uiStore = useUiStore()

						uiStore.queueAlert({
							title: vm.$tc('common.error-fetching-data'),
							description: res.data.message,
							type: 'error',
						})

						vm.$router.push({ name: 'roles.index' })
					}),
				)
		},
	})
</script>
