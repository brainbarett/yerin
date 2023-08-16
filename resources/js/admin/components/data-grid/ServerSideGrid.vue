<template>
	<div class="data-grid-container">
		<div class="data-grid">
			<div v-if="loading" class="data-grid__loader">
				<loading-spinner size="m" color="blue" />
			</div>

			<div class="data-grid__header">
				<Searchbar
					v-if="searchable.length"
					:loading="loading"
					:debounce="true"
					:currentSearchTerm="searchTerm"
					@search="search($event)"
				/>

				<div class="data-grid__row">
					<span v-for="column in columns" :key="column.field">{{ column.label }}</span>
				</div>
			</div>

			<div ref="dataGridScrollableBody" class="data-grid__body">
				<div class="data-grid__row" v-for="row in rows" :key="row.id">
					<div v-for="column in columns" :key="column.field">
						<slot name="row" :row="row" :field="column.field" :column="column">
							{{ row[column.field] }}
						</slot>
					</div>
				</div>
			</div>

			<div class="data-grid__footer">
				<Pagination
					v-if="paginate"
					:pagination="paginationMeta"
					@jump-to-page="jumpToPage($event)"
				/>

				<span v-else class="data-grid__pagination-info">{{
					$t('data-table.pagination.showing-amount', {
						amount: rows.length,
					})
				}}</span>
			</div>
		</div>
	</div>
</template>

<script lang="ts">
	import Vue, { PropType } from 'vue'
	import { Column, PaginationMeta, RemoteApi } from './types'
	import Searchbar from './Searchbar.vue'
	import Pagination from './Pagination.vue'
	import { ErrorResponse, PaginatedResponse } from '@/services/http'
	import { AxiosResponse } from 'axios'

	export default Vue.extend({
		components: { Searchbar, Pagination },

		props: {
			api: {
				type: Function as PropType<RemoteApi>,
			},

			columns: {
				type: Array as PropType<Column[]>,
			},

			paginate: {
				type: Boolean,
				default: false,
			},

			perPage: {
				type: Number,
				default: 25,
			},
		},

		data() {
			return {
				searchTerm: '' as string,
				page: 1,
				rows: [] as Object[],
				searchable: this.columns
					.filter(column => column.searchable)
					.map(column => column.field),
				loading: false as boolean,
				paginationMeta: {} as PaginationMeta,
			}
		},

		methods: {
			async fetchRows() {
				this.loading = true

				const filters: Parameters<RemoteApi>[0] = {
					search: this.searchTerm,
					paginate: this.paginate ? 1 : 0,
					per_page: this.perPage,
				}

				if (this.paginate) {
					filters.page = this.page
				}

				this.api(filters)
					.then(res => {
						this.rows = res.data.data

						if (this.paginate) {
							this.paginationMeta = (res.data as PaginatedResponse).meta
						}
					})
					.catch((res: AxiosResponse) =>
						this.$emit('error', (res.data as ErrorResponse).message),
					)
					.finally(() => (this.loading = false))
			},

			search(string: string) {
				this.searchTerm = string
				this.page = 1

				this.fetchRows()
			},

			jumpToPage(page: number) {
				this.page = page

				this.fetchRows()
			},
		},

		created() {
			this.fetchRows()
		},
	})
</script>
