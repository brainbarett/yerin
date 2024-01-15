<template>
	<Layout>
		<DeleteResourceModal
			v-if="showDestroyModal"
			:title="$t('routes.users.edit.delete-user-modal-title')"
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

		<Header :title="$t('routes.users.edit.title')" :back="{ name: 'users.index' }" />

		<formulate-form @submit="save" v-model="form" name="main" class="resource-form__section">
			<div class="form__field-group md:grid-cols-3">
				<formulate-input
					name="name"
					type="text"
					:label="$t('common.form.fields.name')"
					placeholder="Yerin Arelius"
					validation="required"
				/>
				<formulate-input
					name="email"
					type="email"
					:label="$t('common.form.fields.email')"
					placeholder="example@email.com"
					validation="required|email"
				/>
				<formulate-input
					name="language"
					type="select"
					:options="languages"
					:label="$t('common.language')"
					validation="required"
				/>

				<formulate-input
					name="role"
					type="select"
					:options="roles"
					:label="$t('routes.users.shared.form.fields.role')"
				/>
			</div>
		</formulate-form>

		<div class="flex items-center justify-end gap-4">
			<Button
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
	import { UsersApi, User, Language, UpdateRequest } from '@/services/users'
	import { AxiosResponse } from 'axios'
	import { ErrorResponse } from '@/services/http'
	import DeleteResourceModal from '@/components/modals/DeleteResourceModal.vue'
	import { useUiStore } from '@/stores/ui'
	import { mapActions } from 'pinia'
	import { RolesApi } from '@/services/roles'

	type Form = {
		name: string
		email: string
		language: Language
		role: number | null
	}

	export default Vue.extend({
		components: { Layout, Header, Button, DeleteResourceModal },

		data() {
			return {
				resource: {} as User,
				loading: {
					update: false,
					destroy: false,
				} as { [key: string]: boolean },
				form: {} as Form,
				languages: {
					es: this.$t('common.spanish'),
					en: this.$t('common.english'),
				},
				showDestroyModal: false as boolean,
				roles: [] as Array<{ label: string; value: number }>,
			}
		},

		methods: {
			...mapActions(useUiStore, ['fireAlert', 'queueAlert']),

			async save(form: Form) {
				this.loading.update = true
				this.$formulate.resetValidation('main')

				const parsedFormData: UpdateRequest = form
				await UsersApi.update(this.resource.id, parsedFormData)
					.then(() => this.$router.push({ name: 'users.index' }))
					.catch((res: AxiosResponse<ErrorResponse>) => {
						this.$formulate.handleApi(res.data, 'main')
					})

				this.loading.update = false
			},

			async destroy() {
				this.loading.destroy = true

				await UsersApi.destroy(this.resource.id)
					.then(() => this.$router.push({ name: 'users.index' }))
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

		created() {
			RolesApi.index()
				.then(res => {
					this.roles = res.data.data.map(role => ({
						value: role.id,
						label: role.name,
					}))
				})
				.catch((res: AxiosResponse<ErrorResponse>) =>
					this.fireAlert({
						title: res.data.message,
						type: 'error',
					}),
				)
		},

		async beforeRouteEnter(to, from, next) {
			await UsersApi.show(to.params.id as unknown as number)
				.then(res => {
					next((vm: any) => {
						const user = res.data.data
						const form: Form = { ...user, role: user.role.id }

						vm.resource = user
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

						vm.$router.push({ name: 'users.index' })
					}),
				)
		},
	})
</script>
