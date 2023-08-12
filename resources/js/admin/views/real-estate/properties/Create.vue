<template>
	<Layout>
		<formulate-form @submit="save" name="main" class="resource-form flex gap-6">
			<div class="w-56 relative">
				<div class="fixed w-56">
					<div class="flex items-center">
						<router-link
							:to="{ name: 'real-estate.properties.index' }"
							class="p-1 mr-2 bg-white rounded shadow"
						>
							<icon name="chevron-left" class="w-6 h-6" />
						</router-link>

						<h1 class="text-xl font-medium">Create a Property</h1>
					</div>

					<div class="sidebar">
						<div class="sidebar__item-group">
							<div class="sidebar__item">
								<a href="#basic-info" class="sidebar__button">Basic info</a>
							</div>

							<div class="sidebar__item">
								<a href="#images" class="sidebar__button">Images</a>
							</div>

							<div class="sidebar__item">
								<a href="#listings" class="sidebar__button">Listings</a>
							</div>
						</div>
					</div>

					<formulate-errors />
				</div>
			</div>

			<div class="flex flex-col">
				<div id="basic-info" class="resource-form__section !mt-0">
					<div class="form__field-group grid-cols-4">
						<formulate-input
							v-model="form.type"
							type="select"
							:options="propertyTypes"
							label="Property type"
							validation="required"
						/>

						<formulate-input
							v-model="form.available"
							type="radio"
							:options="[
								{ value: 'true', label: 'Available' },
								{ value: 'false', label: 'Not Available' },
							]"
							label="Availability"
							validation="required"
							class="horizontal"
						/>

						<formulate-input
							v-model="form.reference"
							type="text"
							label="Reference"
							validation="required|matches:/^[A-Za-z0-9_-]+$/"
						/>

						<formulate-input
							v-model="form.name"
							type="text"
							label="Name or address"
							validation="required"
						/>

						<div class="col-span-4">
							<label class="input-label">Description</label>
							<ckeditor
								v-model="form.description"
								:editor="ckeditor.editor"
								:config="ckeditor.config"
							/>
						</div>
					</div>

					<div class="form__field-group grid-cols-3">
						<formulate-input
							v-model="form.bedrooms"
							type="text"
							label="Bedrooms"
							validation="required|number"
						/>

						<formulate-input
							v-model="form.full_bathrooms"
							type="text"
							label="Full bathrooms"
							validation="required|number"
						/>

						<formulate-input
							v-model="form.half_bathrooms"
							type="text"
							label="Half bathrooms"
							validation="required|number"
						/>
					</div>

					<div class="form__field-group grid-cols-3">
						<formulate-input
							v-model="form.lot_area"
							type="text"
							label="Lot area (m2)"
							validation="optional|number"
						/>

						<formulate-input
							v-model="form.construction_area"
							type="text"
							label="Construction area (m2)"
							validation="optional|number"
						/>

						<formulate-input
							v-model="form.construction_year"
							type="text"
							label="Construction year"
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
						<div class="grid grid-cols-10 items-center gap-12">
							<div class="col-span-2 flex items-center gap-2">
								<input
									type="checkbox"
									id="listing-type-sale-checkbox"
									v-model="enabledListingTypes.SALE"
									class="h-5 w-5 cursor-pointer"
								/>
								<label
									for="listing-type-sale-checkbox"
									class="whitespace-nowrap cursor-pointer"
									>Sale price</label
								>
							</div>

							<formulate-input
								v-model="form.listings.SALE"
								type="text"
								validation="optional|number"
								:disabled="!enabledListingTypes.SALE"
								class="col-span-8"
							/>
						</div>

						<div class="grid grid-cols-10 items-center gap-12">
							<div class="col-span-2 flex items-center gap-2">
								<input
									type="checkbox"
									id="listing-type-rent-checkbox"
									v-model="enabledListingTypes.RENT"
									class="h-5 w-5 cursor-pointer"
								/>
								<label
									for="listing-type-rent-checkbox"
									class="whitespace-nowrap cursor-pointer"
									>Rent terms</label
								>
							</div>

							<div class="form__field-group grid-cols-4 col-span-8">
								<formulate-input
									v-for="(price, term) in form.listings.RENT"
									:key="term"
									v-model="form.listings.RENT[term]"
									type="text"
									validation="optional|number"
									:disabled="!enabledListingTypes.RENT"
									class="w-full"
									:label="term"
								/>
							</div>
						</div>
					</div>
				</div>
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
	import PropertiesApi, {
		propertyTypes,
		rentTerms,
		StoreRequest,
	} from '@/services/real-estate/properties'
	import { AxiosResponse } from 'axios'
	import { ErrorResponse, ValidationErrorResponse } from '@/services/http'
	import CKEditorSettings from '@/utils/ckeditor-settings'
	import { Image } from '@/services/images'
	import ImageUpload from '@/components/form-fields/ImageUpload.vue'

	type StringBoolean = 'true' | 'false'

	type Form = Omit<StoreRequest, 'available' | 'listings' | 'images'> & {
		available: StringBoolean
		images: Image[]
		listings: {
			SALE: number | null
			RENT: Record<(typeof rentTerms)[number], number | null>
		}
	}

	export default Vue.extend({
		components: { Layout, ImageUpload },

		data() {
			return {
				loading: false as boolean,
				propertyTypes,
				ckeditor: CKEditorSettings,
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
			}
		},

		methods: {
			async save() {
				this.loading = true
				this.$formulate.resetValidation('main')

				await PropertiesApi.store(this.parseOutboundForm(this.form))
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

			parseOutboundForm(data: Form): StoreRequest {
				// vue-formulate doesnt make '' = null on optional fields like listings price & rent
				const listings: StoreRequest['listings'] = {}

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
	})
</script>
