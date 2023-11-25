<template>
	<Layout>
		<Header :title="$t('routes.auth.profile.title')" />

		<formulate-form
			@submit="updateAccountInfo"
			v-model="forms.accountInfo"
			name="account-info"
			class="resource-form__section !gap-6"
		>
			<h2>{{ $t('routes.auth.profile.account-info') }}</h2>

			<div class="form__field-group md:grid-cols-3">
				<formulate-input
					name="name"
					:validation-name="$t('common.form.fields.name')"
					type="text"
					:label="$t('common.form.fields.name')"
					validation="required"
				/>
				<formulate-input
					name="email"
					:validation-name="$t('common.form.fields.email')"
					type="email"
					:label="$t('common.form.fields.email')"
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

			<div>
				<Button
					@click="$formulate.submit('account-info')"
					class="ml-auto"
					:loading="loading.accountInfo"
					:disabled="loading.accountInfo"
					:label="$t('common.form.update')"
				/>
			</div>
		</formulate-form>

		<formulate-form
			@submit="updatePassword"
			v-model="forms.changePassword"
			name="change-password"
			class="resource-form__section !gap-6"
		>
			<h2>{{ $t('common.form.update-password') }}</h2>

			<div class="form__field-group md:grid-cols-3">
				<formulate-input
					name="old_password"
					:validation-name="$t('routes.auth.profile.form.fields.old-password')"
					type="password"
					:label="$t('routes.auth.profile.form.fields.old-password')"
					validation="required"
				/>
				<formulate-input
					name="password"
					:validation-name="$t('routes.auth.profile.form.fields.new-password')"
					type="password"
					:label="$t('routes.auth.profile.form.fields.new-password')"
					validation="required"
				/>
				<formulate-input
					name="password_confirm"
					:validation-name="$t('routes.auth.profile.form.fields.confirm-new-password')"
					type="password"
					:label="$t('routes.auth.profile.form.fields.confirm-new-password')"
					validation="required|confirm"
				/>
			</div>

			<div>
				<Button
					@click="$formulate.submit('change-password')"
					class="ml-auto"
					:loading="loading.changePassword"
					:disabled="loading.changePassword"
					:label="$t('common.form.update')"
				/>
			</div>
		</formulate-form>
	</Layout>
</template>

<script lang="ts">
	import Vue from 'vue'
	import { Layout } from '@/layouts/main'
	import Header from '@/components/Header.vue'
	import Button from '@/components/Button.vue'
	import useAuthStore from '@/stores/auth'
	import { mapActions, mapState } from 'pinia'
	import AdminApi, { Language } from '@/services/admin'
	import { AxiosResponse } from 'axios'
	import { ErrorResponse, ValidationErrorResponse } from '@/services/http'
	import useUiStore from '@/stores/ui'

	type AccountInfo = {
		name: string
		email: string
		language: Language
	}

	type ChangePassword = {
		old_password: string
		password: string
	}

	export default Vue.extend({
		components: { Layout, Header, Button },

		data() {
			return {
				loading: {
					accountInfo: false,
					changePassword: false,
				},

				forms: {
					accountInfo: {} as AccountInfo,
					changePassword: {} as ChangePassword,
				},

				languages: {
					es: this.$t('common.spanish'),
					en: this.$t('common.english'),
				},
			}
		},

		computed: {
			...mapState(useAuthStore, ['user']),
		},

		methods: {
			...mapActions(useUiStore, ['fireAlert']),
			...mapActions(useAuthStore, ['setUser']),

			async updateAccountInfo(form: AccountInfo) {
				this.loading.accountInfo = true
				this.$formulate.resetValidation('account-info')

				await AdminApi.update(this.user!.id, form)
					.then(res => {
						this.fireAlert({
							title: this.$tc(
								'routes.auth.profile.messages.update-account-info-success',
							),
							type: 'info',
						})

						this.setUser(res.data.data)
					})
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
							'account-info',
						)
					})

				this.loading.accountInfo = false
			},

			async updatePassword(form: ChangePassword) {
				this.loading.changePassword = true
				this.$formulate.resetValidation('change-password')

				await AdminApi.updatePassword(this.user!.id, form)
					.then(() => {
						this.fireAlert({
							title: this.$tc('common.form.update-password-success'),
							type: 'info',
						})

						this.$formulate.reset('change-password')
					})
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
							'change-password',
						)
					})

				this.loading.changePassword = false
			},
		},

		created() {
			this.forms.accountInfo = {
				name: this.user!.name,
				email: this.user!.email,
				language: this.user!.language,
			}
		},
	})
</script>