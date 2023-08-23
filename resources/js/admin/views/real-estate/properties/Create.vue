<template>
	<Layout>
		<PropertyForm
			:title="$t('routes.real-estate.properties.create.title')"
			:form="form"
			@submit="save"
		/>

		<Button
			@click="$formulate.submit('main')"
			class="ml-auto"
			:loading="loading"
			:label="$t('common.form.create')"
		/>
	</Layout>
</template>

<script lang="ts">
	import Vue from 'vue'
	import Layout from '@/layouts/Main.vue'
	import Button from '@/components/Button.vue'
	import PropertiesApi from '@/services/real-estate/properties'
	import { AxiosResponse } from 'axios'
	import { ErrorResponse, ValidationErrorResponse } from '@/services/http'
	import PropertyForm from './shared/PropertyForm.vue'
	import { CreateForm } from './shared/types'
	import { parseOutboundPropertyForm } from './shared/helpers'

	export default Vue.extend({
		components: { Layout, Button, PropertyForm },

		data() {
			return {
				loading: false as boolean,
				form: {} as CreateForm,
			}
		},

		methods: {
			async save() {
				this.loading = true
				this.$formulate.resetValidation('main')

				await PropertiesApi.store(parseOutboundPropertyForm(this.form))
					.then(res => this.$router.push({ name: 'real-estate.properties.index' }))
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

						document.getElementById('content__scroll-box')!.scrollTo({ top: 0 })
					})

				this.loading = false
			},
		},
	})
</script>
