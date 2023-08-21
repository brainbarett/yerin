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

		<formulate-form
			@submit="save"
			name="main"
			class="resource-form flex flex-col lg:flex-row items-start gap-6"
		>
			<div class="sidebar">
				<Header
					:title="$t('routes.real-estate.properties.edit.title')"
					:back="{ name: 'real-estate.properties.index' }"
				/>

				<div class="sidebar__item-group">
					<div class="sidebar__item">
						<a href="#basic-info" class="sidebar__button">{{
							$t('routes.real-estate.properties.shared.form.sections.basic-info')
						}}</a>
					</div>

					<div class="sidebar__item">
						<a href="#images" class="sidebar__button">{{
							$t('routes.real-estate.properties.shared.form.sections.images')
						}}</a>
					</div>

					<div class="sidebar__item">
						<a href="#listings" class="sidebar__button">{{
							$t('routes.real-estate.properties.shared.form.sections.listings')
						}}</a>
					</div>
				</div>

				<formulate-errors />
			</div>

			<div class="flex flex-col w-full">
				<div id="basic-info" class="resource-form__section !mt-0">
					<div class="form__field-group lg:grid-cols-4">
						<formulate-input
							v-model="form.type"
							type="select"
							:validation-name="
								$t('routes.real-estate.properties.shared.form.fields.property-type')
							"
							:options="propertyTypes"
							:label="
								$t('routes.real-estate.properties.shared.form.fields.property-type')
							"
							validation="required"
						/>

						<formulate-input
							v-model="form.available"
							type="radio"
							:validation-name="
								$t('routes.real-estate.properties.shared.form.fields.availability')
							"
							:options="[
								{
									value: 'true',
									label: $t('routes.real-estate.properties.shared.available'),
								},
								{
									value: 'false',
									label: $t('routes.real-estate.properties.shared.not-available'),
								},
							]"
							:label="
								$t('routes.real-estate.properties.shared.form.fields.availability')
							"
							validation="required"
							class="horizontal"
						/>

						<formulate-input
							v-model="form.reference"
							type="text"
							:validation-name="
								$t('routes.real-estate.properties.shared.form.fields.reference')
							"
							:label="
								$t('routes.real-estate.properties.shared.form.fields.reference')
							"
							validation="required|matches:/^[A-Za-z0-9_-]+$/"
						/>

						<formulate-input
							v-model="form.name"
							type="text"
							:validation-name="$t('common.form.fields.name')"
							:label="$t('common.form.fields.name')"
							validation="required"
						/>

						<div class="lg:col-span-4">
							<label class="input-label">{{
								$t('common.form.fields.description')
							}}</label>
							<ckeditor
								v-model="form.description"
								:editor="ckeditor.editor"
								:config="ckeditor.config"
							/>
						</div>
					</div>

					<div class="form__field-group lg:grid-cols-3">
						<formulate-input
							v-model="form.bedrooms"
							type="text"
							:validation-name="
								$t('routes.real-estate.properties.shared.form.fields.bedrooms')
							"
							:label="$t('routes.real-estate.properties.shared.form.fields.bedrooms')"
							validation="required|number"
						/>

						<formulate-input
							v-model="form.full_bathrooms"
							type="text"
							:validation-name="
								$t(
									'routes.real-estate.properties.shared.form.fields.full-bathrooms',
								)
							"
							:label="
								$t(
									'routes.real-estate.properties.shared.form.fields.full-bathrooms',
								)
							"
							validation="required|number"
						/>

						<formulate-input
							v-model="form.half_bathrooms"
							type="text"
							:validation-name="
								$t(
									'routes.real-estate.properties.shared.form.fields.half-bathrooms',
								)
							"
							:label="
								$t(
									'routes.real-estate.properties.shared.form.fields.half-bathrooms',
								)
							"
							validation="required|number"
						/>
					</div>

					<div class="form__field-group lg:grid-cols-3">
						<formulate-input
							v-model="form.lot_area"
							type="text"
							:validation-name="
								$t('routes.real-estate.properties.shared.form.fields.lot-area')
							"
							:label="
								$t('routes.real-estate.properties.shared.form.fields.lot-area') +
								'(m2)'
							"
							validation="optional|number"
						/>

						<formulate-input
							v-model="form.construction_area"
							type="text"
							:validation-name="
								$t(
									'routes.real-estate.properties.shared.form.fields.construction-area',
								)
							"
							:label="
								$t(
									'routes.real-estate.properties.shared.form.fields.construction-area',
								) + '(m2)'
							"
							validation="optional|number"
						/>

						<formulate-input
							v-model="form.construction_year"
							type="text"
							:validation-name="
								$t(
									'routes.real-estate.properties.shared.form.fields.construction-year',
								)
							"
							:label="
								$t(
									'routes.real-estate.properties.shared.form.fields.construction-year',
								)
							"
							validation="optional|date:YYYY"
						/>
					</div>
				</div>

				<div id="images" class="resource-form__section">
					<div class="form__field-group">
						<ImageUpload :images="form.images" />
					</div>
				</div>

				<div id="listings" class="resource-form__section">
					<div class="form__field-group">
						<div class="grid gap-2 lg:grid-cols-10 items-center lg:gap-12">
							<div class="lg:col-span-2 flex items-center gap-2">
								<input
									type="checkbox"
									id="listing-type-sale-checkbox"
									v-model="enabledListingTypes.SALE"
									class="h-5 w-5 cursor-pointer"
								/>
								<label
									for="listing-type-sale-checkbox"
									class="whitespace-nowrap cursor-pointer"
									>{{
										$t(
											'routes.real-estate.properties.shared.form.fields.sale-price',
										)
									}}</label
								>
							</div>

							<formulate-input
								v-model="form.listings.SALE"
								type="text"
								:validation-name="
									$t(
										'routes.real-estate.properties.shared.form.fields.sale-price',
									)
								"
								validation="optional|number"
								:disabled="!enabledListingTypes.SALE"
								class="col-span-8"
							/>
						</div>

						<div class="grid gap-2 lg:grid-cols-10 items-center lg:gap-12">
							<div class="lg:col-span-2 flex items-center gap-2">
								<input
									type="checkbox"
									id="listing-type-rent-checkbox"
									v-model="enabledListingTypes.RENT"
									class="h-5 w-5 cursor-pointer"
								/>
								<label
									for="listing-type-rent-checkbox"
									class="whitespace-nowrap cursor-pointer"
									>{{
										$t(
											'routes.real-estate.properties.shared.form.fields.rent-terms',
										)
									}}</label
								>
							</div>

							<div class="form__field-group lg:grid-cols-4 lg:col-span-8">
								<formulate-input
									v-for="(price, term) in form.listings.RENT"
									:key="term"
									v-model="form.listings.RENT[term]"
									type="text"
									:validation-name="
										$t(
											`routes.real-estate.properties.shared.form.fields.rent-${term.toLowerCase()}-price`,
										)
									"
									validation="optional|number"
									:disabled="!enabledListingTypes.RENT"
									class="w-full"
									:label="
										$t(
											`routes.real-estate.properties.shared.form.fields.rent-${term.toLowerCase()}`,
										)
									"
								/>
							</div>
						</div>
					</div>
				</div>
			</div>
		</formulate-form>

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
	import Header from '@/components/Header.vue'
	import Button from '@/components/Button.vue'
	import PropertiesApi, {
		Property,
		propertyTypes,
		rentTerms,
		UpdateRequest,
	} from '@/services/real-estate/properties'
	import { AxiosResponse } from 'axios'
	import { ErrorResponse, ValidationErrorResponse } from '@/services/http'
	import CKEditorSettings from '@/utils/ckeditor-settings'
	import { Image } from '@/services/images'
	import ImageUpload from '@/components/form-fields/ImageUpload.vue'
	import { RouteParams } from '@/router'
	import DeleteResourceModal from '@/components/modals/DeleteResourceModal.vue'
	import useLanguageStore from '@/stores/language'

	type StringBoolean = 'true' | 'false'

	type Form = Omit<UpdateRequest, 'description' | 'available' | 'listings' | 'images'> & {
		description: string
		available: StringBoolean
		images: Image[]
		listings: {
			SALE: number | null
			RENT: Record<(typeof rentTerms)[number], number | null>
		}
	}

	export default Vue.extend({
		components: { Layout, Header, Button, ImageUpload, DeleteResourceModal },

		data() {
			const ckeditor = CKEditorSettings
			ckeditor.config.language = useLanguageStore().language

			return {
				resource: {} as Property,
				loading: {
					update: false,
					destroy: false,
				} as { [key: string]: boolean },
				propertyTypes: propertyTypes.map(type => ({
					value: type,
					label: this.$t(`real-estate.property-types.${type.toLowerCase()}`),
				})),
				ckeditor,
				form: {
					images: [] as Image[],
					listings: {
						SALE: null,
						RENT: {
							DAY: null,
							WEEK: null,
							MONTH: null,
							YEAR: null,
						},
					},
				} as Form,
				enabledListingTypes: {
					RENT: false,
					SALE: false,
				},
				showDestroyModal: false as boolean,
			}
		},

		methods: {
			async save() {
				this.loading.update = true
				this.$formulate.resetValidation('main')

				await PropertiesApi.update(this.resource.id, this.parseOutboundForm(this.form))
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

			parseOutboundForm(data: Form): UpdateRequest {
				// vue-formulate doesnt make '' = null on optional fields like listings price & rent
				const listings: UpdateRequest['listings'] = {}

				if (data.listings.SALE != null && (data.listings.SALE as unknown) != '') {
					listings.SALE = data.listings.SALE
				}

				if (
					Object.values(data.listings.RENT).some(
						price => price != null && (price as unknown) != '',
					)
				) {
					listings.RENT = {}
					const rentals = data.listings.RENT

					for (const [term, price] of Object.entries(rentals)) {
						if (price != null && (price as unknown) != '') {
							listings.RENT[term as keyof typeof rentals] = price
						}
					}
				}

				return {
					...data,
					available: data.available == 'true',
					listings: Object.keys(listings).length ? listings : null,
					images: data.images.map((image, i) => ({ id: image.id, order: i })),
				}
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

		watch: {
			'enabledListingTypes.SALE': function (enabled) {
				if (!enabled) {
					this.form.listings.SALE = null
				}
			},
			'enabledListingTypes.RENT': function (enabled) {
				if (!enabled) {
					for (const term in this.form.listings.RENT) {
						this.form.listings.RENT[term as (typeof rentTerms)[number]] = null
					}
				}
			},
		},

		async beforeRouteEnter(to, from, next) {
			await PropertiesApi.show(to.params.id as unknown as number)
				.then(res =>
					next((vm: any) => {
						const property = res.data.data as Property
						const form: Form = {
							...property,
							available: property.available ? 'true' : 'false',
							description: property.description || '',
						}

						vm.resource = property
						vm.enabledListingTypes = {
							RENT: Object.values(property.listings.RENT).some(
								price => price != null,
							),
							SALE: property.listings.SALE != null,
						}
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
