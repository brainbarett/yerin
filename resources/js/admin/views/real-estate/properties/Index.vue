<template>
	<Layout vh>
		<div class="flex flex-col h-full">
			<Header :title="$t('routes.real-estate.properties.index.title')">
				<template #extra-content v-if="user.can($permissions.realEstate.properties.write)">
					<Button
						:to="{ name: 'real-estate.properties.create' }"
						:label="$t('routes.real-estate.properties.index.add-property')"
						class="ml-auto"
					/>
				</template>
			</Header>

			<DataGrid
				:api="apiForDataGrid"
				:columns="columns"
				:paginate="true"
				@error="
					fireAlert({
						title: $t('common.error-fetching-data'),
						description: $event,
						type: 'error',
					})
				"
				class="h-full mt-3 overflow-hidden"
			>
				<template #row="{ row, field }">
					<component
						v-if="field == 'name'"
						:is="
							user.can($permissions.realEstate.properties.write)
								? 'router-link'
								: 'span'
						"
						:to="{ name: 'real-estate.properties.edit', params: { id: row.id } }"
						class="flex items-center"
					>
						<div class="data-table__thumbnail-container">
							<img
								:src="
									row.images.length
										? row.images[0].sizes.small
										: '/admin_panel/images/placeholder.jpg'
								"
							/>
						</div>

						{{ row[field] }}
					</component>

					<template v-else-if="field == 'type'">
						{{ propertyTypes[row.type] }}
					</template>

					<div v-else-if="field == 'available'" class="flex justify-center">
						<span
							class="block px-2 py-1 text-xs text-center text-white rounded whitespace-nowrap"
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
	import { Layout } from '@/layouts/main'
	import Header from '@/components/Header.vue'
	import Button from '@/components/Button.vue'
	import { Column, RemoteApi } from '@/components/data-table/types'
	import { default as DataGrid } from '@/components/data-table/RemoteTable.vue'
	import { PropertiesApi, propertyTypes, Property } from '@/services/real-estate/properties'
	import { useUiStore } from '@/stores/ui'
	import { mapActions, mapState } from 'pinia'
	import { useAuthStore } from '@/stores/auth'

	export default Vue.extend({
		components: { Layout, Header, Button, DataGrid },

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
					columnClass: 'text-center',
				},
			]

			return {
				columns,
				propertyTypes: propertyTypes.reduce(
					(types, type) => ({
						...types,
						[type]: this.$t(`real-estate.property-types.${type.toLowerCase()}`),
					}),
					{},
				) as { [key in (typeof propertyTypes)[number]]: string },
			}
		},

		computed: {
			...mapState(useAuthStore, ['user']),
		},

		methods: {
			...mapActions(useUiStore, ['fireAlert']),

			apiForDataGrid(filters: Parameters<RemoteApi>[0]): ReturnType<RemoteApi> {
				return PropertiesApi.paginate(filters)
			},
		},
	})
</script>
