<template>
	<Layout>
		<Header :title="$t('routes.admin.create.title')" :back="{ name: 'admin.index' }" />

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

			<div class="form__field-group md:grid-cols-2">
				<formulate-input
					name="password"
					:validation-name="$t('common.form.fields.password')"
					type="password"
					:label="$t('common.form.fields.password')"
					validation="required"
				/>
				<formulate-input
					name="password_confirm"
					:validation-name="$t('routes.admin.shared.form.fields.password-confirmation')"
					type="password"
					:label="$t('routes.admin.shared.form.fields.password-confirmation')"
					validation="required|confirm"
				/>
			</div>
		</formulate-form>

		<Button
			@click="$formulate.submit('main')"
			class="ml-auto"
			:loading="loading"
			:disabled="loading"
			:label="$t('common.form.create')"
		/>
	</Layout>
</template>

<script lang="ts">
	import Vue from 'vue'
	import { Layout } from '@/layouts/main'
	import Header from '@/components/Header.vue'
	import Button from '@/components/Button.vue'
	import AdminApi, { Language, StoreRequest } from '@/services/admin'
	import { AxiosResponse } from 'axios'
	import { ErrorResponse, ValidationErrorResponse } from '@/services/http'

	type Form = {
		name: string
		email: string
		password: string
		password_confirm: string
		language: Language
	}

	export default Vue.extend({
		components: { Layout, Header, Button },

		data() {
			return {
				loading: false as boolean,
				form: {} as Form,
				languages: {
					es: this.$t('common.spanish'),
					en: this.$t('common.english'),
				},
			}
		},

		methods: {
			async save(form: Form) {
				this.loading = true
				this.$formulate.resetValidation('main')

				const parsedFormData: StoreRequest = form
				await AdminApi.store(parsedFormData)
					.then(res => this.$router.push({ name: 'admin.index' }))
					.catch((res: AxiosResponse) => {
						let inputErrors = {}

						if (res.status == 422) {
							inputErrors = (res.data as ValidationErrorResponse).errors
						}

						this.$formulate.handle(
							{
								formErrors: [(res.data as ErrorResponse).message],
								inputErrors,
							},
							'main',
						)
					})

				this.loading = false
			},
		},
	})
</script>
