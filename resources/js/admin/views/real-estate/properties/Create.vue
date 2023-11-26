<template>
	<Layout>
		<PropertyForm
			:title="$t('routes.real-estate.properties.create.title')"
			:formErrors="errors.formErrors"
			:inputErrors="errors.inputErrors"
			@submit="save"
		>
			<template #default="{ submit }">
				<Button
					@click="submit"
					class="ml-auto"
					:loading="loading"
					:disabled="loading"
					:label="$t('common.form.create')"
				/>
			</template>
		</PropertyForm>
	</Layout>
</template>

<script lang="ts">
	import Vue from 'vue'
	import { Layout } from '@/layouts/main'
	import Button from '@/components/Button.vue'
	import { PropertiesApi } from '@/services/real-estate/properties'
	import { AxiosResponse } from 'axios'
	import { ErrorResponse, ValidationErrorResponse } from '@/services/http'
	import PropertyForm from './shared/PropertyForm.vue'
	import { PropertyForm as PropertyFormType } from './shared/types'
	import { parseOutboundPropertyForm } from './shared/helpers'

	export default Vue.extend({
		components: { Layout, Button, PropertyForm },

		data() {
			return {
				loading: false as boolean,
				errors: {
					formErrors: [] as string[],
					inputErrors: {} as { [field: string]: string[] },
				},
			}
		},

		methods: {
			async save(form: PropertyFormType) {
				this.loading = true

				await PropertiesApi.store(parseOutboundPropertyForm(form))
					.then(() => this.$router.push({ name: 'real-estate.properties.index' }))
					.catch((res: AxiosResponse<ErrorResponse>) => {
						if (res.status == 422) {
							this.errors.inputErrors = (res.data as ValidationErrorResponse).errors
						}

						this.errors.formErrors = [res.data.message]
					})

				this.loading = false
			},
		},
	})
</script>
