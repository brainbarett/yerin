<template>
	<Layout vh>
		<Modal
			v-if="updatePasswordForm.visible"
			:title="`${$t('common.form.updating')}: ${updatePasswordForm.user.name}`"
			@close="closeUpdatePasswordForm"
		>
			<formulate-form @submit="updatePassword" name="update-password">
				<div class="form__field-group md:grid-cols-2">
					<formulate-input
						v-model="updatePasswordForm.password"
						name="password"
						type="password"
						:label="$t('routes.users.shared.form.fields.new-password')"
						validation="required"
					/>
					<formulate-input
						v-model="updatePasswordForm.password_confirm"
						name="password_confirm"
						type="password"
						:label="$t('routes.users.shared.form.fields.new-password-confirmation')"
						validation="required|confirm"
					/>
				</div>

				<div class="flex items-center justify-end gap-4 mt-5">
					<Button
						category="terciary"
						@click="closeUpdatePasswordForm"
						:label="$t('common.form.cancel')"
					/>
					<Button
						:loading="updatePasswordForm.loading"
						:disabled="updatePasswordForm.loading"
						@click="$formulate.submit('update-password')"
						:label="$t('common.form.update')"
					/>
				</div>
			</formulate-form>
		</Modal>

		<div class="flex flex-col h-full">
			<Header :title="$t('routes.users.index.title')">
				<template #extra-content>
					<Button
						:to="{ name: 'users.create' }"
						:label="$t('routes.users.index.add-user')"
						class="ml-auto"
					/>
				</template>
			</Header>

			<DataGrid
				:loading="loading"
				:columns="columns"
				:rows="rows"
				class="h-full mt-3 overflow-hidden"
				hasActions
			>
				<template #row="{ row, field }">
					<router-link
						:to="{ name: 'users.edit', params: { id: row.id } }"
						class="flex items-center"
					>
						{{ row[field] }}
					</router-link>
				</template>

				<template #row-actions="{ row }">
					<v-dropdown placement="left" class="ml-auto w-fit">
						<button type="button" class="block p-1 ml-auto bg-gray-100 rounded">
							<icon name="dots-horizontal" set="outline" class="w-5 h-5" />
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
								{{ $t('routes.users.shared.form.update-password') }}
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
	import { UsersApi, User } from '@/services/users'
	import { AxiosResponse } from 'axios'
	import { ErrorResponse } from '@/services/http'
	import Modal from '@/components/modals/Modal.vue'
	import { useUiStore } from '@/stores/ui'
	import { mapActions } from 'pinia'

	export default Vue.extend({
		components: { Layout, Header, Button, DataGrid, Modal },

		data() {
			const columns: Column<keyof User>[] = [
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
				rows: [] as User[],
				updatePasswordForm: {
					visible: false,
					user: null as null | User,
					loading: false,
					password: '' as string,
					password_confirm: '' as string,
				},
			}
		},

		methods: {
			...mapActions(useUiStore, ['fireAlert']),

			showUpdatePasswordForm(user: User) {
				this.updatePasswordForm.visible = true
				this.updatePasswordForm.user = user
			},

			closeUpdatePasswordForm() {
				this.updatePasswordForm.visible = false
				this.updatePasswordForm.user = null
				this.$formulate.reset('update-password')
			},

			updatePassword() {
				this.updatePasswordForm.loading = true
				this.$formulate.resetValidation('update-password')

				UsersApi.updatePassword(this.updatePasswordForm.user!.id, {
					password: this.updatePasswordForm.password,
				})
					.then(() => {
						this.closeUpdatePasswordForm()
						this.fireAlert({
							title: this.$tc(
								'routes.users.shared.form.messages.update-password-success',
							),
							type: 'info',
						})
					})
					.catch((res: AxiosResponse<ErrorResponse>) => {
						this.$formulate.handleApi(res.data, 'update-password')
					})
					.finally(() => (this.updatePasswordForm.loading = false))
			},
		},

		created() {
			this.loading = true

			UsersApi.index()
				.then(res => (this.rows = res.data.data))
				.catch((res: AxiosResponse<ErrorResponse>) =>
					this.fireAlert({
						title: this.$tc('common.error-fetching-data'),
						description: res.data.message,
						type: 'error',
					}),
				)
				.finally(() => (this.loading = false))
		},
	})
</script>
