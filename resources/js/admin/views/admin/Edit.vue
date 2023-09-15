<template>
	<Layout>
		<DeleteResourceModal
			v-if="showDestroyModal"
			:title="$t('routes.admin.edit.delete-account-modal-title')"
			@close="showDestroyModal = false"
			@confirm="destroy()"
			:loading="loading.destroy"
		>
			<p
				v-html="
					$t('routes.admin.edit.attempting-to-delete-account', { name: resource.name })
				"
			></p>
		</DeleteResourceModal>

		<Header :title="$t('routes.admin.edit.title')" :back="{ name: 'admin.index' }" />

		<formulate-form @submit="save" v-model="form" name="main" class="resource-form__section">
			<div class="form__field-group md:grid-cols-3">
				<formulate-input
					name="name"
					:validation-name="$t('common.form.fields.name')"
					type="text"
					:label="$t('common.form.fields.name')"
					placeholder="Yerin Arelius"
					validation="required"
				/>
				<formulate-input
					name="email"
					:validation-name="$t('common.form.fields.email')"
					type="email"
					:label="$t('common.form.fields.email')"
					placeholder="example@email.com"
					validation="required|email"
				/>
				<formulate-input
					name="language"
					:validation-name="$t('common.language')"
					type="select"
					:options="languages"
					:label="$t('common.language')"
					validation="required"
				/>
			</div>
		</formulate-form>

		<div class="flex items-center justify-end gap-4">
			<Button
				type="secondary"
				@click="showDestroyModal = true"
				destructive
				:label="$t('common.form.delete')"
			/>

			<Button
				@click="$formulate.submit('main')"
				:loading="loading.update"
				:label="$t('common.form.create')"
			/>
		</div>
	</Layout>
</template>

<script lang="ts">
	import Vue from 'vue'
	import Layout from '@/layouts/Main.vue'
	import Header from '@/components/Header.vue'
	import Button from '@/components/Button.vue'
	import AdminApi, { Admin, Language, UpdateRequest } from '@/services/admin'
	import { AxiosResponse } from 'axios'
	import { ErrorResponse, ValidationErrorResponse } from '@/services/http'
	import DeleteResourceModal from '@/components/modals/DeleteResourceModal.vue'
	import useUiStore from '@/stores/ui'
	import { mapActions } from 'pinia'

	type Form = {
		name: string
		email: string
		language: Language
	}

	export default Vue.extend({
		components: { Layout, Header, Button, DeleteResourceModal },

		data() {
			return {
				resource: {} as Admin,
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
			}
		},

		methods: {
			...mapActions(useUiStore, ['fireAlert', 'queueAlert']),

			async save(form: Form) {
				this.loading.update = true
				this.$formulate.resetValidation('main')

				const parsedFormData: UpdateRequest = form
				await AdminApi.update(this.resource.id, parsedFormData)
					.then(res => this.$router.push({ name: 'admin.index' }))
					.catch((res: AxiosResponse<ErrorResponse>) => {
						let inputErrors = {}

						if (res.status == 422) {
							inputErrors = (res.data as ValidationErrorResponse).errors
						}

						this.$formulate.handle(
							{
								formErrors: [res.data.message],
								inputErrors,
							},
							'main',
						)
					})

				this.loading.update = false
			},

			async destroy() {
				this.loading.destroy = true

				await AdminApi.destroy(this.resource.id)
					.then(res => this.$router.push({ name: 'admin.index' }))
					.catch((res: AxiosResponse<ErrorResponse>) => {
						this.fireAlert({
							title: <string>this.$t('routes.admin.edit.error-deleting-account', {
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
			await AdminApi.show(to.params.id as unknown as number)
				.then(res => {
					next((vm: any) => {
						const admin = res.data.data
						const form: Form = admin

						vm.resource = admin
						vm.form = form
					})
				})
				.catch((res: AxiosResponse<ErrorResponse>) =>
					next((vm: any) => {
						const uiStore = useUiStore()

						uiStore.queueAlert({
							title: vm.$tc('routes.admin.edit.error-fetching-account'),
							description: res.data.message,
							type: 'error',
						})

						vm.$router.push({ name: 'admin.index' })
					}),
				)
		},
	})
</script>
