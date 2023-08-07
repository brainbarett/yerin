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
				v-if="error"
				type="error"
				title="Error fetching data"
				:description="error"
				class="mt-3"
			/>

			<DataGrid
				:loading="loading"
				:columns="columns"
				:rows="rows"
				class="mt-3 h-full overflow-hidden"
			/>
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
				error: null as null | string,
			}
		},

		created() {
			this.loading = true

			AdminApi.index()
				.then(res => (this.rows = res.data.data))
				.catch((res: AxiosResponse) => (this.error = (res.data as ErrorResponse).message))
				.finally(() => (this.loading = false))
		},
	})
</script>
