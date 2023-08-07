<template>
	<Layout>
		<div class="flex flex-col h-full">
			<div class="flex items-center">
				<h1 class="text-xl font-medium">Admin Accounts</h1>
				<router-link :to="{ name: 'admin.create' }" class="button button--primary ml-auto"
					>Add an Admin Account</router-link
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
				:loading="loading"
				:columns="columns"
				:rows="rows"
				class="mt-3 h-full overflow-hidden"
			>
				<template #row="{ row, field }">
					<router-link
						:to="{ name: 'admin.edit', params: { id: row.id } }"
						class="flex items-center"
					>
						{{ row[field] }}
					</router-link>
				</template>
			</DataGrid>
		</div>
	</Layout>
</template>

<script lang="ts">
	import Vue from 'vue'
	import Layout from '@/layouts/Main.vue'
	import { Column } from '@/components/data-grid/types'
	import { default as DataGrid } from '@/components/data-grid/Grid.vue'
	import EmbeddedNotification from '@/components/EmbeddedNotification.vue'
	import AdminApi, { Admin } from '@/services/admin'
	import { AxiosResponse } from 'axios'
	import { ErrorResponse } from '@/services/http'
	import { RouteParams } from '@/router'

	export default Vue.extend({
		components: { Layout, DataGrid, EmbeddedNotification },

		data() {
			const columns: Column<keyof Admin>[] = [
				{
					label: 'Name',
					field: 'name',
				},
				{
					label: 'Email',
					field: 'email',
				},
			]

			return {
				loading: false,
				columns,
				rows: [] as Admin[],
				errors: [] as RouteParams['error'][],
			}
		},

		created() {
			this.loading = true

			AdminApi.index()
				.then(res => (this.rows = res.data.data))
				.catch((res: AxiosResponse) =>
					this.errors.push({
						title: 'Error fetching table data',
						description: (res.data as ErrorResponse).message,
					}),
				)
				.finally(() => (this.loading = false))

			if ('error' in (this.$route.params as RouteParams)) {
				this.errors.push((this.$route.params as RouteParams).error)
			}
		},
	})
</script>
