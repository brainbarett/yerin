<template>
	<Layout>
		<div class="flex items-center">
			<router-link :to="{ name: 'admin.index' }" class="p-1 mr-2 bg-white rounded shadow">
				<icon name="chevron-left" class="w-6 h-6" />
			</router-link>

			<h1 class="text-xl font-medium">{{ $t('routes.admin.create.title') }}</h1>
		</div>

		<formulate-form @submit="save" v-model="form" name="main" class="resource-form__section">
			<div class="form__field-group grid-cols-2">
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
			</div>

			<div class="form__field-group grid-cols-2">
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

		<button
			@click="$formulate.submit('main')"
			type="button"
			class="button button--primary ml-auto h-9"
			:class="{ 'opacity-70': loading }"
			:disabled="loading"
		>
			<template v-if="loading">
				{{ $t('common.form.creating') }}
				<loading-spinner size="xs" color="white" class="ml-3" v-if="loading" />
			</template>

			<template v-else>{{ $t('common.form.create') }}</template>
		</button>
	</Layout>
</template>

<script lang="ts">
	import Vue from 'vue'
	import Layout from '@/layouts/Main.vue'
	import AdminApi, { StoreRequest } from '@/services/admin'
	import { AxiosResponse } from 'axios'
	import { ErrorResponse, ValidationErrorResponse } from '@/services/http'

	type Form = {
		name: string
		email: string
		password: string
		password_confirm: string
	}

	export default Vue.extend({
		components: { Layout },

		data() {
			return {
				loading: false as boolean,
				form: {} as Form,
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
