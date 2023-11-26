<template>
	<Layout>
		<Header :title="$t('routes.roles.create.title')" :back="{ name: 'roles.index' }" />

		<formulate-form @submit="save" v-model="form" name="main">
			<div class="resource-form__section">
				<div class="form__field-group">
					<formulate-input
						name="name"
						type="text"
						:label="$t('common.form.fields.name')"
						placeholder="Monarch"
						validation="required"
					/>
				</div>
			</div>

			<div class="p-0 resource-form__section">
				<Permissions
					:selected="form.permissions"
					@add-permission="form.permissions.push($event)"
					@remove-permission="
						form.permissions = form.permissions.filter(
							permission => permission != $event,
						)
					"
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
	import { RolesApi, StoreRequest } from '@/services/roles'
	import { AxiosResponse } from 'axios'
	import { ErrorResponse } from '@/services/http'
	import Permissions from './shared/Permissions.vue'

	type Form = {
		name: string
		permissions: string[]
	}

	export default Vue.extend({
		components: { Layout, Header, Button, Permissions },

		data() {
			return {
				loading: false as boolean,
				form: {
					name: '',
					permissions: [],
				} as Form,
			}
		},

		methods: {
			async save(form: Form) {
				this.loading = true
				this.$formulate.resetValidation('main')

				const parsedFormData: StoreRequest = form
				await RolesApi.store(parsedFormData)
					.then(() => this.$router.push({ name: 'roles.index' }))
					.catch((res: AxiosResponse<ErrorResponse>) => {
						this.$formulate.handleApi(res.data, 'main')
					})

				this.loading = false
			},
		},
	})
</script>
