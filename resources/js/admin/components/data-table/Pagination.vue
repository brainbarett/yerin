<template>
	<div class="flex items-center w-full">
		<span class="data-table__pagination-info">{{
			$t('data-table.pagination.from-to-total', {
				from: pagination.from,
				to: pagination.to,
				total: pagination.total,
			})
		}}</span>

		<div class="flex gap-1">
			<div class="data-table__pagination-link">
				<button @click="jumpToPage(1)" type="button" class="!px-2">
					<icon name="chevron-double-left" set="outline" class="w-4 h-4"></icon>
				</button>
			</div>

			<div class="data-table__pagination-link">
				<button
					@click="
						jumpToPage(pagination.current_page == 1 ? 1 : pagination.current_page - 1)
					"
					type="button"
					class="!px-2"
				>
					<icon name="chevron-left" set="outline" class="w-4 h-4"></icon>
				</button>
			</div>

			<div
				v-for="page in pagination.last_page"
				:key="page"
				class="data-table__pagination-link"
			>
				<button
					@click="jumpToPage(page)"
					type="button"
					:class="{ '!bg-gray-100': pagination.current_page == page }"
				>
					{{ page }}
				</button>
			</div>

			<div class="data-table__pagination-link">
				<button
					@click="
						jumpToPage(
							pagination.current_page == pagination.last_page
								? pagination.last_page
								: pagination.current_page + 1,
						)
					"
					type="button"
					class="!px-2"
				>
					<icon name="chevron-right" set="outline" class="w-4 h-4"></icon>
				</button>
			</div>

			<div class="data-table__pagination-link">
				<button @click="jumpToPage(pagination.last_page)" type="button" class="!px-2">
					<icon name="chevron-double-right" set="outline" class="w-4 h-4"></icon>
				</button>
			</div>
		</div>
	</div>
</template>

<script lang="ts">
	import Vue, { PropType } from 'vue'
	import { PaginationMeta } from './types'

	export default Vue.extend({
		props: {
			pagination: {
				type: Object as PropType<PaginationMeta>,
			},
		},

		methods: {
			jumpToPage(page: number) {
				this.$emit('jump-to-page', page)
			},
		},
	})
</script>

<style lang="scss">
	.data-table__pagination-link {
		@apply flex items-center text-sm;

		button {
			@apply box-border flex items-center h-full px-3 py-1 bg-white border rounded;
		}
	}
</style>
