<template>
	<div class="data-table-container">
		<div v-if="loading" class="data-table__loader">
			<loading-spinner color="black" />
		</div>

		<Searchbar v-if="searchable.length" :loading="loading" @search="searchTerm = $event" />

		<div ref="scrollableContainer" class="data-table-scroll-container">
			<table class="data-table">
				<thead>
					<tr>
						<th
							v-for="column in columns"
							:key="column.field"
							:class="column.columnClass"
						>
							{{ column.label }}
						</th>

						<th v-if="hasActions"></th>
					</tr>
				</thead>

				<tbody>
					<tr v-for="row in processedRows" :key="row.id">
						<td v-for="column in columns" :key="column.field" :class="column.rowClass">
							<slot name="row" :row="row" :field="column.field" :column="column">
								{{ row[column.field] }}
							</slot>
						</td>

						<td v-if="hasActions">
							<slot name="row-actions" :row="row" />
						</td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="data-table__pagination-container">
			<Pagination
				v-if="paginate"
				:pagination="paginationMeta"
				@jump-to-page="page = $event"
			/>

			<span v-else class="data-table__pagination-info">{{
				$t('data-table.pagination.showing-amount-of-total', {
					amount: processedRows.length,
					total: rows.length,
				})
			}}</span>
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

			hasActions: {
				type: Boolean,
				default: false,
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

		watch: {
			processedRows: function () {
				;(this.$refs.scrollableContainer as HTMLElement).scrollTo({ top: 0 })
			},
		},
	})
</script>
