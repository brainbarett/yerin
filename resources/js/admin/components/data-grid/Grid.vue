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
					@search="searchTerm = $event"
				/>

				<div class="data-grid__row">
					<span v-for="column in columns" :key="column.field">{{ column.label }}</span>
				</div>
			</div>

			<div ref="dataGridScrollableBody" class="data-grid__body">
				<div class="data-grid__row" v-for="row in processedRows" :key="row.id">
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
					@jump-to-page="page = $event"
				/>

				<span v-else class="data-grid__pagination-info"
					>Showing {{ processedRows.length }} of {{ rows.length }} entries</span
				>
			</div>
		</div>
	</div>
</template>

<script lang="ts">
	import Vue, { PropType } from 'vue'
	import { Column, PaginationMeta } from './types'
	import Searchbar from './Searchbar.vue'
	import Pagination from './Pagination.vue'

	export default Vue.extend({
		components: { Searchbar, Pagination },

		props: {
			columns: {
				type: Array as PropType<Column[]>,
			},

			rows: {
				type: Array as PropType<Record<string, any>[]>,
			},

			loading: {
				type: Boolean,
				default: false,
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
				searchable: this.columns
					.filter(column => column.searchable)
					.map(column => column.field),
			}
		},

		computed: {
			processedRows() {
				let processedRows: Record<string, any>[] = JSON.parse(JSON.stringify(this.rows))

				if (this.searchTerm != '') {
					processedRows = processedRows.filter(row =>
						this.searchable.some(field =>
							(row[field] as string).toLowerCase().includes(this.searchTerm),
						),
					)
				}

				if (this.paginate) {
					processedRows = processedRows.slice(
						this.paginationMeta.from - 1,
						this.paginationMeta.to,
					)
				}

				return processedRows
			},

			paginationMeta(): PaginationMeta {
				const total = this.rows.length
				const current_page = this.page
				const per_page = this.perPage
				const last_page = Math.ceil(total / per_page)
				const from = (current_page - 1) * per_page + 1
				const to = current_page == last_page ? total : current_page * per_page

				return {
					current_page,
					from,
					last_page,
					per_page,
					to,
					total,
				}
			},
		},
	})
</script>
