<template>
	<Layout vh>
		<Modal
			v-if="updatePasswordForm.visible"
			:title="`${$t('common.form.updating')}: ${updatePasswordForm.admin.name}`"
			@close="closeUpdatePasswordForm"
		>
			<formulate-form @submit="updatePassword" name="update-password">
				<div class="form__field-group md:grid-cols-2">
					<formulate-input
						v-model="updatePasswordForm.password"
						name="password"
						:validation-name="$t('common.form.fields.password')"
						type="password"
						:label="$t('common.form.fields.password')"
						validation="required"
					/>
					<formulate-input
						v-model="updatePasswordForm.password_confirm"
						name="password_confirm"
						:validation-name="
							$t('routes.admin.shared.form.fields.password-confirmation')
						"
						type="password"
						:label="$t('routes.admin.shared.form.fields.password-confirmation')"
						validation="required|confirm"
					/>
				</div>

				<div class="flex items-center justify-end gap-4 mt-5">
					<Button
						type="terciary"
						@click="closeUpdatePasswordForm"
						:label="$t('common.form.cancel')"
					/>
					<Button
						:loading="updatePasswordForm.loading"
						@click="$formulate.submit('update-password')"
						:label="$t('common.form.update')"
					/>
				</div>
			</formulate-form>
		</Modal>

		<div class="flex flex-col h-full">
			<Header :title="$t('routes.admin.index.title')">
				<template #extra-content>
					<Button
						:to="{ name: 'admin.create' }"
						:label="$t('routes.admin.index.add-admin-btn')"
						class="ml-auto"
					/>
				</template>
			</Header>

			<DataGrid
				:loading="loading"
				:columns="columns"
				:rows="rows"
				class="mt-3 h-full overflow-hidden"
				hasActions
			>
				<template #row="{ row, field }">
					<router-link
						:to="{ name: 'admin.edit', params: { id: row.id } }"
						class="flex items-center"
					>
						{{ row[field] }}
					</router-link>
				</template>

				<template #row-actions="{ row }">
					<v-dropdown placement="left" class="w-fit ml-auto">
						<button type="button" class="rounded p-1 bg-gray-100 block ml-auto">
							<icon name="dots-horizontal" set="outline" class="h-5 w-5" />
						</button>

						<template #popper="{ hide }">
							<button
								type="button"
								class="text-gray-600 text-sm p-2 hover:bg-[#f9f9f9]"
								@click="
									hide()
									showUpdatePasswordForm(row)
								"
							>
								{{ $t('common.form.change-password') }}
							</button>
						</template>
					</v-dropdown>
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
	import { Column } from '@/components/data-table/types'
	import { default as DataGrid } from '@/components/data-table/Table.vue'
	import AdminApi, { Admin } from '@/services/admin'
	import { AxiosResponse } from 'axios'
	import { ErrorResponse } from '@/services/http'
	import Modal from '@/components/modals/Modal.vue'
	import useUiStore from '@/stores/ui'
	import { mapActions } from 'pinia'

	export default Vue.extend({
		components: { Layout, Header, Button, DataGrid, Modal },

		data() {
			const columns: Column<keyof Admin>[] = [
				{
					label: this.$tc('common.form.fields.name'),
					field: 'name',
					searchable: true,
				},
				{
					label: this.$tc('common.form.fields.email'),
					field: 'email',
					searchable: true,
				},
			]

			return {
				loading: false,
				columns,
				rows: [] as Admin[],
				updatePasswordForm: {
					visible: false,
					admin: null as null | Admin,
					loading: false,
					password: '' as string,
					password_confirm: '' as string,
				},
			}
		},

		methods: {
			...mapActions(useUiStore, ['fireAlert']),

			showUpdatePasswordForm(admin: Admin) {
				this.updatePasswordForm.visible = true
				this.updatePasswordForm.admin = admin
			},

			closeUpdatePasswordForm() {
				this.updatePasswordForm.visible = false
				this.updatePasswordForm.admin = null
				this.$formulate.reset('update-password')
			},

			updatePassword() {
				this.updatePasswordForm.loading = true
				this.$formulate.resetValidation('update-password')

				AdminApi.updatePassword(
					this.updatePasswordForm.admin!.id,
					this.updatePasswordForm.password,
				)
					.then(() => {
						this.closeUpdatePasswordForm()
						alert('password successfuly updated')
					})
					.catch((res: AxiosResponse<ErrorResponse>) => {
						this.$formulate.handle(
							{
								formErrors: [res.data.message],
							},
							'update-password',
						)
					})
					.finally(() => (this.updatePasswordForm.loading = false))
			},
		},

		created() {
			this.loading = true

			AdminApi.index()
				.then(res => (this.rows = res.data.data))
				.catch((res: AxiosResponse<ErrorResponse>) =>
					this.fireAlert({
						title: this.$tc('routes.admin.index.error-fetching-data'),
						description: res.data.message,
						type: 'error',
					}),
				)
				.finally(() => (this.loading = false))
		},
	})
</script>
