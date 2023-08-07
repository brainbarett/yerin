<template>
	<div class="bg-white drop-shadow rounded">
		<div class="data-grid">
			<div
				v-if="loading"
				class="absolute top-0 w-full h-full flex items-center justify-center bg-gray-600 bg-opacity-25 z-50"
			>
				<loading-spinner size="m" color="blue" />
			</div>

			<div class="data-grid__header">
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
		</div>
	</div>
</template>

<script lang="ts">
	import Vue, { PropType } from 'vue'
	import { Column } from './types'

	export default Vue.extend({
		props: {
			columns: {
				type: Array as PropType<Column[]>,
			},

			rows: {
				type: Array as PropType<Object[]>,
			},

			loading: {
				type: Boolean,
				default: false,
			},
		},
	})
</script>

<style lang="scss">
	.data-grid {
		@apply flex flex-col w-full h-full overflow-hidden;

		.data-grid__header {
			@apply sticky top-0 bg-white border-b-2 border-gray-200 shadow-sm;

			.data-grid__row {
				> * {
					@apply font-medium;
				}
			}
		}

		.data-grid__body {
			@apply h-full overflow-y-auto;

			.data-grid__row {
				@apply hover:bg-[#f9f9f9] border-b border-gray-200;
			}

			.data-grid__row:last-child {
				@apply border-b-0;
			}
		}

		.data-grid__row {
			@apply grid grid-flow-col auto-cols-fr;

			> * {
				@apply flex items-center p-3 text-sm text-left;
			}
		}
	}
</style>
