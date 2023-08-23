<template>
	<formulate-form
		@submit="$emit('submit')"
		name="main"
		class="resource-form flex flex-col lg:flex-row items-start gap-6"
	>
		<div class="sidebar">
			<Header :title="title" :back="{ name: 'real-estate.properties.index' }" />

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
					<a href="#location" class="sidebar__button">{{ $t('common.location') }}</a>
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
						:label="$t('routes.real-estate.properties.shared.form.fields.availability')"
						validation="required"
						class="horizontal"
					/>

					<formulate-input
						v-model="form.reference"
						type="text"
						:validation-name="
							$t('routes.real-estate.properties.shared.form.fields.reference')
						"
						:label="$t('routes.real-estate.properties.shared.form.fields.reference')"
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
							$t('routes.real-estate.properties.shared.form.fields.full-bathrooms')
						"
						:label="
							$t('routes.real-estate.properties.shared.form.fields.full-bathrooms')
						"
						validation="required|number"
					/>

					<formulate-input
						v-model="form.half_bathrooms"
						type="text"
						:validation-name="
							$t('routes.real-estate.properties.shared.form.fields.half-bathrooms')
						"
						:label="
							$t('routes.real-estate.properties.shared.form.fields.half-bathrooms')
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
							$t('routes.real-estate.properties.shared.form.fields.lot-area') + '(m2)'
						"
						validation="optional|number"
					/>

					<formulate-input
						v-model="form.construction_area"
						type="text"
						:validation-name="
							$t('routes.real-estate.properties.shared.form.fields.construction-area')
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
							$t('routes.real-estate.properties.shared.form.fields.construction-year')
						"
						:label="
							$t('routes.real-estate.properties.shared.form.fields.construction-year')
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

			<div id="location" class="resource-form__section">
				<div class="form__field-group lg:grid-cols-4">
					<formulate-input
						v-model="selectedGeoLocations.countryId"
						type="select"
						:options="geoLocations.countries"
						:label="$t('common.country')"
						validation="required"
						:validation-name="$t('common.country')"
					/>

					<formulate-input
						v-model="selectedGeoLocations.stateId"
						type="select"
						:options="scopedStates"
						:label="$t('common.state')"
						validation="required"
						:validation-name="$t('common.state')"
					/>

					<formulate-input
						v-model="selectedGeoLocations.cityId"
						type="select"
						:options="scopedCities"
						:label="$t('common.city')"
						validation="required"
						:validation-name="$t('common.city')"
					/>

					<formulate-input
						v-model="selectedGeoLocations.sectorId"
						type="select"
						:options="scopedSectors"
						:label="$t('common.sector')"
						validation="required"
						:validation-name="$t('common.sector')"
					/>
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
								$t('routes.real-estate.properties.shared.form.fields.sale-price')
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
</template>

<script lang="ts">
	import Vue, { PropType } from 'vue'
	import Header from '@/components/Header.vue'
	import ImageUpload from '@/components/form-fields/ImageUpload.vue'
	import { CreateForm, EditForm } from './types'
	import CKEditorSettings from '@/utils/ckeditor-settings'
	import useLanguageStore from '@/stores/language'
	import { Property, propertyTypes, rentTerms } from '@/services/real-estate/properties'
	import GeoLocationsApi from '@/services/geo-locations'
	import { AxiosResponse } from 'axios'
	import { ErrorResponse } from '@/services/http'

	const ckeditor = CKEditorSettings

	type DropdownOption = { value: number; label: string }
	type DropdownCountry = DropdownOption
	type DropdownState = DropdownOption & { country_id: number }
	type DropdownCity = DropdownOption & { state_id: number }
	type DropdownSector = DropdownOption & { city_id: number }

	export default Vue.extend({
		components: { Header, ImageUpload },

		props: {
			title: String,
			form: Object as PropType<CreateForm | EditForm>,
			resource: {
				type: Object as PropType<Property>,
				required: false,
			},
		},

		data() {
			ckeditor.config.language = useLanguageStore().language

			return {
				ckeditor,
				propertyTypes: propertyTypes.map(type => ({
					value: type,
					label: this.$t(`real-estate.property-types.${type.toLowerCase()}`),
				})),
				enabledListingTypes: {
					RENT: false as boolean,
					SALE: false as boolean,
				},
				geoLocations: {
					countries: [] as DropdownCountry[],
					states: [] as DropdownState[],
					cities: [] as DropdownCity[],
					sectors: [] as DropdownSector[],
				},
				selectedGeoLocations: {
					countryId: null as number | null,
					stateId: null as number | null,
					cityId: null as number | null,
					sectorId: null as number | null,
				},
			}
		},

		computed: {
			scopedStates(): DropdownState[] {
				return this.geoLocations.states.filter(
					state => state.country_id == this.selectedGeoLocations.countryId,
				)
			},

			scopedCities(): DropdownCity[] {
				return this.geoLocations.cities.filter(
					city => city.state_id == this.selectedGeoLocations.stateId,
				)
			},

			scopedSectors(): DropdownSector[] {
				return this.geoLocations.sectors.filter(
					sector => sector.city_id == this.selectedGeoLocations.cityId,
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

			'selectedGeoLocations.countryId': function (countryId) {
				if (
					this.geoLocations.states.find(
						state => state.value == this.selectedGeoLocations.stateId,
					)?.country_id != countryId
				) {
					this.selectedGeoLocations.stateId = null
				}
			},
			'selectedGeoLocations.stateId': function (stateId) {
				if (
					this.geoLocations.cities.find(
						city => city.value == this.selectedGeoLocations.cityId,
					)?.state_id != stateId
				) {
					this.selectedGeoLocations.cityId = null
				}
			},
			'selectedGeoLocations.cityId': function (cityId) {
				if (
					this.geoLocations.sectors.find(
						sector => sector.value == this.selectedGeoLocations.sectorId,
					)?.city_id != cityId
				) {
					this.selectedGeoLocations.sectorId = null
				}
			},
			'selectedGeoLocations.sectorId': function (sectorId) {
				this.form.location_id = sectorId
			},
		},

		created() {
			this.form.images = []
			this.form.listings = {
				SALE: null,
				RENT: {
					DAY: null,
					WEEK: null,
					MONTH: null,
					YEAR: null,
				},
			}

			GeoLocationsApi.index()
				.then(res => {
					const data = res.data.data

					this.geoLocations.countries = data.countries.map(country => ({
						label: country.name,
						value: country.id,
					}))
					this.geoLocations.states = data.states.map(state => ({
						country_id: state.country_id,
						label: state.name,
						value: state.id,
					}))
					this.geoLocations.cities = data.cities.map(city => ({
						state_id: city.state_id,
						label: city.name,
						value: city.id,
					}))
					this.geoLocations.sectors = data.sectors.map(sector => ({
						city_id: sector.city_id,
						label: sector.name,
						value: sector.id,
					}))

					if (this.resource) {
						this.selectedGeoLocations = {
							countryId: this.resource.location.country_id,
							stateId: this.resource.location.state_id,
							cityId: this.resource.location.city_id,
							sectorId: this.resource.location.sector_id,
						}
					}
				})
				.catch((res: AxiosResponse) => alert((res.data as ErrorResponse).message))
		},

		async mounted() {
			await this.$nextTick()

			this.enabledListingTypes.RENT = Object.values(this.form.listings.RENT).some(
				price => price != null,
			)
			this.enabledListingTypes.SALE = this.form.listings.SALE != null
		},
	})
</script>
