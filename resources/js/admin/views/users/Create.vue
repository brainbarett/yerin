<template>
	<Layout>
		<Header :title="$t('routes.users.create.title')" :back="{ name: 'users.index' }" />

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

			<div class="form__field-group md:grid-cols-2">
				<formulate-input
					name="password"
					type="password"
					:label="$t('routes.users.shared.form.fields.password')"
					validation="required"
				/>
				<formulate-input
					name="password_confirm"
					type="password"
					:label="$t('routes.users.shared.form.fields.password-confirmation')"
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
	import { UsersApi, Language, StoreRequest } from '@/services/users'
	import { AxiosResponse } from 'axios'
	import { ErrorResponse } from '@/services/http'
	import { RolesApi } from '@/services/roles'
	import { mapActions } from 'pinia'
	import { useUiStore } from '@/stores/ui'

	type Form = {
		name: string
		email: string
		password: string
		password_confirm: string
		language: Language
		role: number | null
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
				roles: [] as Array<{ label: string; value: number }>,
			}
		},

		methods: {
			...mapActions(useUiStore, ['fireAlert']),

			async save(form: Form) {
				this.loading = true
				this.$formulate.resetValidation('main')

				const parsedFormData: StoreRequest = form
				await UsersApi.store(parsedFormData)
					.then(() => this.$router.push({ name: 'users.index' }))
					.catch((res: AxiosResponse<ErrorResponse>) => {
						this.$formulate.handleApi(res.data, 'main')
					})

				this.loading = false
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
	})
</script>
