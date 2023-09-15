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
			:resource="resource"
			:formErrors="errors.formErrors"
			:inputErrors="errors.inputErrors"
			@submit="save"
		>
			<template #default="{ submit }">
				<div class="flex justify-end gap-4">
					<Button
						type="secondary"
						@click="showDestroyModal = true"
						destructive
						:label="$t('common.form.delete')"
					/>

					<Button
						@click="submit"
						:loading="loading.update"
						:label="$t('common.form.update')"
					/>
				</div>
			</template>
		</PropertyForm>
	</Layout>
</template>

<script lang="ts">
	import Vue from 'vue'
	import Layout from '@/layouts/Main.vue'
	import Button from '@/components/Button.vue'
	import PropertiesApi, { Property } from '@/services/real-estate/properties'
	import { AxiosResponse } from 'axios'
	import { ErrorResponse, ValidationErrorResponse } from '@/services/http'
	import DeleteResourceModal from '@/components/modals/DeleteResourceModal.vue'
	import PropertyForm from './shared/PropertyForm.vue'
	import { parseOutboundPropertyForm } from './shared/helpers'
	import { PropertyForm as PropertyFormType } from './shared/types'
	import useUiStore from '@/stores/ui'
	import { mapActions } from 'pinia'

	export default Vue.extend({
		components: { Layout, Button, PropertyForm, DeleteResourceModal },

		data() {
			return {
				resource: {} as Property,
				loading: {
					update: false,
					destroy: false,
				} as { [key: string]: boolean },
				errors: {
					formErrors: [] as string[],
					inputErrors: {} as { [field: string]: string[] },
				},
				showDestroyModal: false as boolean,
			}
		},

		methods: {
			...mapActions(useUiStore, ['fireAlert', 'queueAlert']),

			async save(form: PropertyFormType) {
				this.loading.update = true

				await PropertiesApi.update(this.resource.id, parseOutboundPropertyForm(form))
					.then(res => this.$router.push({ name: 'real-estate.properties.index' }))
					.catch((res: AxiosResponse<ErrorResponse>) => {
						if (res.status == 422) {
							this.errors.inputErrors = (res.data as ValidationErrorResponse).errors
						}

						this.errors.formErrors = [res.data.message]
					})

				this.loading.update = false
			},

			async destroy() {
				this.loading.destroy = true

				await PropertiesApi.destroy(this.resource.id)
					.then(res => this.$router.push({ name: 'real-estate.properties.index' }))
					.catch((res: AxiosResponse<ErrorResponse>) =>
						this.fireAlert({
							title: <string>this.$t(
								'routes.real-estate.properties.edit.error-deleting-account',
								{
									name: this.resource.name,
								},
							),
							description: res.data.message,
							type: 'error',
						}),
					)

				this.loading.destroy = false
			},
		},

		async beforeRouteEnter(to, from, next) {
			await PropertiesApi.show(to.params.id as unknown as number)
				.then(res =>
					next((vm: any) => {
						vm.resource = res.data.data
					}),
				)
				.catch((res: AxiosResponse<ErrorResponse>) =>
					next((vm: any) => {
						const uiStore = useUiStore()

						uiStore.queueAlert({
							title: vm.$tc(
								'routes.real-estate.properties.edit.error-fetching-account',
							),
							description: res.data.message,
							type: 'error',
						})

						vm.$router.push({
							name: 'real-estate.properties.index',
						})
					}),
				)
		},
	})
</script>
