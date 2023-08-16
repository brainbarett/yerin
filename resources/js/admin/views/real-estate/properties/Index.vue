<template>
	<Layout>
		<div class="flex flex-col h-full">
			<div class="flex items-center">
				<h1 class="text-xl font-medium">
					{{ $t('routes.real-estate.properties.index.title') }}
				</h1>
				<router-link
					:to="{ name: 'real-estate.properties.create' }"
					class="button button--primary ml-auto"
					>{{ $t('routes.real-estate.properties.index.add-property-btn') }}</router-link
				>
			</div>

			<EmbeddedNotification
				v-for="(error, index) in errors"
				:key="index"
				type="error"
				:title="error.title"
				:description="error.description"
				class="mt-3"
			/>

			<DataGrid
				:api="apiForDataGrid"
				:columns="columns"
				:paginate="true"
				@error="
					errors.push({
						title: $t('routes.real-estate.properties.index.error-fetching-data'),
						description: $event,
					})
				"
				class="mt-3 h-full overflow-hidden"
			>
				<template #row="{ row, field }">
					<router-link
						v-if="field == 'name'"
						:to="{ name: 'real-estate.properties.edit', params: { id: row.id } }"
						class="flex items-center"
					>
						<div class="data-grid__thumbnail-container">
							<img
								:src="
									row.images.length
										? row.images[0].sizes.small
										: '/admin_panel/images/placeholder.jpg'
								"
							/>
						</div>

						{{ row[field] }}
					</router-link>

					<template v-else-if="field == 'type'">
						{{ propertyTypes[row.type] }}
					</template>

					<div v-else-if="field == 'available'">
						<span
							class="text-xs px-2 py-1 rounded text-white"
							:class="row.available ? 'bg-blue-500' : 'bg-gray-400'"
						>
							{{
								row.available
									? $t('routes.real-estate.properties.shared.available')
									: $t('routes.real-estate.properties.shared.not-available')
							}}
						</span>
					</div>

					<template v-else>
						{{ row[field] }}
					</template>
				</template>
			</DataGrid>
		</div>
	</Layout>
</template>

<script lang="ts">
	import Vue from 'vue'
	import Layout from '@/layouts/Main.vue'
	import { Column, RemoteApi } from '@/components/data-grid/types'
	import { default as DataGrid } from '@/components/data-grid/ServerSideGrid.vue'
	import EmbeddedNotification from '@/components/EmbeddedNotification.vue'
	import PropertiesApi, { propertyTypes, Property } from '@/services/real-estate/properties'
	import { RouteParams } from '@/router'

	export default Vue.extend({
		components: { Layout, DataGrid, EmbeddedNotification },

		data() {
			const columns: Column<keyof Property>[] = [
				{
					label: this.$tc('common.form.fields.name'),
					field: 'name',
					searchable: true,
				},
				{
					label: this.$tc('routes.real-estate.properties.shared.form.fields.reference'),
					field: 'reference',
					searchable: true,
				},
				{
					label: this.$tc(
						'routes.real-estate.properties.shared.form.fields.property-type',
					),
					field: 'type',
				},
				{
					label: this.$tc(
						'routes.real-estate.properties.shared.form.fields.availability',
					),
					field: 'available',
				},
			]

			return {
				columns,
				errors: [] as RouteParams['error'][],
				propertyTypes: propertyTypes.reduce(
					(obj, type) => ({
						...obj,
						[type]: this.$t(`real-estate.property-types.${type.toLowerCase()}`),
					}),
					{},
				) as { [key in (typeof propertyTypes)[number]]: string },
			}
		},

		methods: {
			apiForDataGrid(filters: Parameters<RemoteApi>[0]): ReturnType<RemoteApi> {
				return PropertiesApi.paginate(filters)
			},
		},

		created() {
			if ('error' in (this.$route.params as RouteParams)) {
				this.errors.push((this.$route.params as RouteParams).error)
			}
		},
	})
</script>
