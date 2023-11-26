<template>
	<Layout vh>
		<div class="flex flex-col h-full">
			<Header :title="$t('routes.roles.index.title')">
				<template #extra-content>
					<Button
						:to="{ name: 'roles.create' }"
						:label="$t('routes.roles.index.add-role')"
						class="ml-auto"
					/>
				</template>
			</Header>

			<DataGrid
				:loading="loading"
				:columns="columns"
				:rows="rows"
				class="h-full mt-3 overflow-hidden"
			>
				<template #row="{ row, field }">
					<router-link
						:to="{ name: 'roles.edit', params: { id: row.id } }"
						class="flex items-center"
					>
						<span
							v-if="row.super_admin"
							class="px-2 mr-2 text-xs font-bold text-yellow-600 rounded bg-amber-200"
						>
							Super Admin
						</span>

						{{ row[field] }}
					</router-link>
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
	import { Column } from '@/components/data-table/types'
	import { default as DataGrid } from '@/components/data-table/Table.vue'
	import { RolesApi, Role } from '@/services/roles'
	import { AxiosResponse } from 'axios'
	import { ErrorResponse } from '@/services/http'
	import { useUiStore } from '@/stores/ui'
	import { mapActions } from 'pinia'

	export default Vue.extend({
		components: { Layout, Header, Button, DataGrid },

		data() {
			const columns: Column<keyof Role>[] = [
				{
					label: this.$tc('common.form.fields.name'),
					field: 'name',
					searchable: true,
				},
			]

			return {
				loading: false,
				columns,
				rows: [] as Role[],
			}
		},

		methods: {
			...mapActions(useUiStore, ['fireAlert']),
		},

		created() {
			this.loading = true

			RolesApi.index()
				.then(res => (this.rows = res.data.data))
				.catch((res: AxiosResponse<ErrorResponse>) =>
					this.fireAlert({
						title: this.$tc('common.error-fetching-data'),
						description: res.data.message,
						type: 'error',
					}),
				)
				.finally(() => (this.loading = false))
		},
	})
</script>
