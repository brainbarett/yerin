<template>
	<Layout :vh="true">
		<div class="flex flex-col h-full">
			<Header :title="$t('routes.admin.index.title')">
				<template #extra-content>
					<Button
						:to="{ name: 'admin.create' }"
						:label="$t('routes.admin.index.add-admin-btn')"
						class="ml-auto"
					/>
				</template>
			</Header>

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
	import Header from '@/components/Header.vue'
	import Button from '@/components/Button.vue'
	import { Column } from '@/components/data-table/types'
	import { default as DataGrid } from '@/components/data-table/Table.vue'
	import EmbeddedNotification from '@/components/EmbeddedNotification.vue'
	import AdminApi, { Admin } from '@/services/admin'
	import { AxiosResponse } from 'axios'
	import { ErrorResponse } from '@/services/http'
	import { RouteParams } from '@/router'

	export default Vue.extend({
		components: { Layout, Header, Button, DataGrid, EmbeddedNotification },

		data() {
			const columns: Column<keyof Admin>[] = [
				{
					label: this.$tc('common.form.fields.name'),
					field: 'name',
					searchable: true,
				},
				{
					label: this.$tc('common.form.fields.email'),
					field: 'email',
					searchable: true,
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
						title: this.$tc('routes.admin.index.error-fetching-data'),
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
