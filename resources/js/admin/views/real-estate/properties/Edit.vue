<template>
	<Layout>
		<DeleteResourceModal
			v-if="showDestroyModal"
			:title="$t('routes.real-estate.properties.edit.delete-property-modal-title')"
			@close="showDestroyModal = false"
			@confirm="destroy()"
			:loading="loading.destroy"
		>
			<p
				v-html="
					$t('routes.real-estate.properties.edit.attempting-to-delete-property', {
						name: resource.name,
					})
				"
			></p>
		</DeleteResourceModal>

		<PropertyForm
			:title="$t('routes.real-estate.properties.edit.title')"
			:form="form"
			:resource="resource"
			@submit="save"
		/>

		<div class="flex justify-end gap-4">
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
	import Button from '@/components/Button.vue'
	import PropertiesApi, { Property } from '@/services/real-estate/properties'
	import { AxiosResponse } from 'axios'
	import { ErrorResponse, ValidationErrorResponse } from '@/services/http'
	import { RouteParams } from '@/router'
	import DeleteResourceModal from '@/components/modals/DeleteResourceModal.vue'
	import { EditForm } from './shared/types'
	import PropertyForm from './shared/PropertyForm.vue'
	import { parseOutboundPropertyForm } from './shared/helpers'

	export default Vue.extend({
		components: { Layout, Button, PropertyForm, DeleteResourceModal },

		data() {
			return {
				resource: {} as Property,
				loading: {
					update: false,
					destroy: false,
				} as { [key: string]: boolean },
				form: {} as EditForm,
				showDestroyModal: false as boolean,
			}
		},

		methods: {
			async save() {
				this.loading.update = true
				this.$formulate.resetValidation('main')

				await PropertiesApi.update(this.resource.id, parseOutboundPropertyForm(this.form))
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

				this.loading.update = false
			},

			async destroy() {
				this.loading.destroy = true
				await PropertiesApi.destroy(this.resource.id)
					.then(res => this.$router.push({ name: 'real-estate.properties.index' }))
					.catch((res: AxiosResponse<ErrorResponse>) =>
						this.$router.push({
							name: 'real-estate.properties.index',
							/** @ts-ignore */
							params: {
								error: {
									title: this.$t(
										'routes.real-estate.properties.edit.error-deleting-account',
										{
											name: this.resource.name,
										},
									),
									description: res.data.message,
								},
							} as RouteParams,
						}),
					)
			},
		},

		async beforeRouteEnter(to, from, next) {
			await PropertiesApi.show(to.params.id as unknown as number)
				.then(res =>
					next((vm: any) => {
						const property = res.data.data as Property
						const form: EditForm = {
							...property,
							location_id: property.location.sector_id,
							available: property.available ? 'true' : 'false',
							description: property.description || '',
						}

						vm.resource = property
						vm.form = form
					}),
				)
				.catch((res: AxiosResponse) =>
					next((vm: any) =>
						vm.$router.push({
							name: 'real-estate.properties.index',
							params: {
								error: {
									title: this.$tc(
										'routes.real-estate.properties.edit.error-fetching-account',
									),
									description: (res.data as ErrorResponse).message,
								},
							} as RouteParams,
						}),
					),
				)
		},
	})
</script>
