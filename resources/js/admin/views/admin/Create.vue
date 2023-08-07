<template>
	<Layout>
		<div class="flex items-center">
			<router-link :to="{ name: 'admin.index' }" class="p-1 mr-2 bg-white rounded shadow">
				<icon name="chevron-left" class="w-6 h-6" />
			</router-link>

			<h1 class="text-xl font-medium">Create an Admin Account</h1>
		</div>

		<formulate-form @submit="save" v-model="form" name="main" class="resource-form">
			<div class="form__field-group grid-cols-2">
				<formulate-input
					name="name"
					type="text"
					label="Name"
					placeholder="Yerin Arelius"
					validation="required"
				/>
				<formulate-input
					name="email"
					type="email"
					label="Email"
					placeholder="example@email.com"
					validation="required|email"
				/>
			</div>

			<div class="form__field-group grid-cols-2">
				<formulate-input
					name="password"
					type="password"
					label="Password"
					validation="required"
				/>
				<formulate-input
					name="password_confirm"
					type="password"
					label="Confirm password"
					validation="required|confirm"
					validation-name="Password confirmation"
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
				Creating
				<loading-spinner size="xs" color="white" class="ml-3" v-if="loading" />
			</template>

			<template v-else>Create</template>
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
