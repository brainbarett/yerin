<template>
	<Layout>
		<h1 class="text-xl font-medium">Create a Property</h1>

		<formulate-form @submit="save" v-model="form" name="main" class="resource-form">
			<div class="form__field-group grid-cols-4">
				<formulate-input
					name="type"
					type="select"
					:options="propertyTypes"
					label="Property type"
					validation="required"
				/>

				<formulate-input
					name="available"
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
					name="reference"
					type="text"
					label="Reference"
					validation="required|matches:/^[A-Za-z0-9_-]+$/"
				/>

				<formulate-input
					name="name"
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
					name="bedrooms"
					type="number"
					label="Bedrooms"
					validation="required|number"
				/>

				<formulate-input
					name="full_bathrooms"
					type="number"
					label="Full bathrooms"
					validation="required|number"
				/>

				<formulate-input
					name="half_bathrooms"
					type="number"
					label="Half bathrooms"
					validation="required|number"
				/>
			</div>

			<div class="form__field-group grid-cols-3">
				<formulate-input
					name="lot_area"
					type="number"
					label="Lot area (m2)"
					validation="optional|number"
				/>

				<formulate-input
					name="construction_area"
					type="number"
					label="Construction area (m2)"
					validation="optional|number"
				/>

				<formulate-input
					name="construction_year"
					type="text"
					label="Construction year"
					validation="optional|date:YYYY"
				/>
			</div>

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
						type="number"
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
							type="number"
							validation="optional|number"
							:disabled="!enabledListingTypes.RENT"
							class="w-full"
							:label="term"
						/>
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

	type PseudoBoolean = 'true' | 'false'

	type Form = Omit<StoreRequest, 'available' | 'listings'> & {
		available: PseudoBoolean
		listings: {
			SALE: number | null
			RENT: Record<(typeof rentTerms)[number], number | null>
		}
	}

	export default Vue.extend({
		components: { Layout },

		data() {
			return {
				loading: false as boolean,
				propertyTypes,
				ckeditor: CKEditorSettings,
				form: {
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
			async save(form: Form) {
				this.loading = true
				this.$formulate.resetValidation('main')

				await PropertiesApi.store(this.parseOutboundForm(form))
					.then(res => alert('success'))
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
				const listings: StoreRequest['listings'] = {}
				for (const listingType in data.listings) {
					if (listingType == 'SALE') {
						const price = data.listings[listingType]

						if (price != null) {
							listings[listingType] = price
						}
					}

					if (listingType == 'RENT') {
						const rentals = data.listings[listingType]
						const validRentals: Partial<Record<(typeof rentTerms)[number], number>> = {}

						for (const term in rentals) {
							const price = rentals[term as keyof typeof rentals]

							if (price != null) {
								validRentals[term as keyof typeof rentals] = price
							}
						}

						if (Object.keys(validRentals).length) {
							listings[listingType] = validRentals
						}
					}
				}

				return {
					...data,
					available: data.available == 'true',
					listings: Object.keys(listings).length ? listings : null,
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