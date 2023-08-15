<template>
	<Layout>
		<DeleteResourceModal
			v-if="showDestroyModal"
			:title="$t('routes.admin.edit.delete-account-modal-title')"
			@close="showDestroyModal = false"
			@confirm="destroy()"
			:loading="loading.destroy"
		>
			<p>
				{{ $t('routes.admin.edit.attempting-to-delete-account') }}
				<span class="underline">{{ resource.name }}</span>
			</p>
		</DeleteResourceModal>

		<div class="flex items-center">
			<router-link :to="{ name: 'admin.index' }" class="p-1 mr-2 bg-white rounded shadow">
				<icon name="chevron-left" class="w-6 h-6" />
			</router-link>

			<h1 class="text-xl font-medium">{{ $t('routes.admin.edit.title') }}</h1>
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
					placeholder="(unchanged)"
					validation="optional"
				/>
				<formulate-input
					name="password_confirm"
					:validation-name="$t('routes.admin.shared.form.fields.password-confirmation')"
					type="password"
					:label="$t('routes.admin.shared.form.fields.password-confirmation')"
					:validation="`${form.password ? 'required' : 'optional'}|confirm`"
				/>
			</div>
		</formulate-form>

		<div class="flex justify-end gap-4">
			<button @click="showDestroyModal = true" class="button !text-red-400 h-9">
				{{ $t('common.form.delete') }}
			</button>

			<button
				@click="$formulate.submit('main')"
				type="button"
				class="button button--primary h-9"
				:class="{ 'opacity-70': loading.update }"
				:disabled="loading.update"
			>
				<template v-if="loading.update">
					{{ $t('common.form.updating') }}
					<loading-spinner size="xs" color="white" v-if="loading.update" />
				</template>

				<template v-else>{{ $t('common.form.update') }}</template>
			</button>
		</div>
	</Layout>
</template>

<script lang="ts">
	import Vue from 'vue'
	import Layout from '@/layouts/Main.vue'
	import AdminApi, { Admin, UpdateRequest } from '@/services/admin'
	import { AxiosResponse } from 'axios'
	import { ErrorResponse, ValidationErrorResponse } from '@/services/http'
	import { RouteParams } from '@/router'
	import DeleteResourceModal from '@/components/modals/DeleteResourceModal.vue'

	type Form = {
		name: string
		email: string
		password?: string
		password_confirm?: string
	}

	export default Vue.extend({
		components: { Layout, DeleteResourceModal },

		data() {
			return {
				resource: {} as Admin,
				loading: {
					update: false,
					destroy: false,
				} as { [key: string]: boolean },
				form: {} as Form,
				showDestroyModal: false as boolean,
			}
		},

		methods: {
			async save(form: Form) {
				this.loading.update = true
				this.$formulate.resetValidation('main')

				const parsedFormData: UpdateRequest = form
				await AdminApi.update(this.resource.id, parsedFormData)
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

				this.loading.update = false
			},

			async destroy() {
				this.loading.destroy = true
				await AdminApi.destroy(this.resource.id)
					.then(res => this.$router.push({ name: 'admin.index' }))
					.catch((res: AxiosResponse<ErrorResponse>) =>
						this.$router.push({
							name: 'admin.index',
							/** @ts-ignore */
							params: {
								error: {
									title: this.$t('routes.admin.edit.error-deleting-account', {
										name: this.resource.name,
									}),
									description: res.data.message,
								},
							} as RouteParams,
						}),
					)

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
				.catch((res: AxiosResponse) =>
					next((vm: any) =>
						vm.$router.push({
							name: 'admin.index',
							params: {
								error: {
									title: this.$tc('routes.admin.edit.error-fetching-account'),
									description: (res.data as ErrorResponse).message,
								},
							} as RouteParams,
						}),
					),
				)
		},
	})
</script>
