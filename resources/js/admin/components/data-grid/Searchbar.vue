<template>
	<div class="flex justify-between items-center border-b-[1px] border-gray-200 mx-3 gap-3">
		<div class="relative py-3">
			<icon
				name="search"
				set="zondicons"
				class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-500"
			/>

			<input
				class="bg-white border border-gray-300 rounded h-9 max-w-xs text-sm pl-9 pr-6"
				type="text"
				v-model="searchTerm"
				@keyup="keyupSearch"
				@keyup.enter="search"
				:disabled="loading"
			/>

			<button
				type="button"
				v-if="searchTerm != ''"
				@click="clearSearch"
				class="h-full px-2 absolute right-0 top-0"
			>
				<icon name="x" class="w-3 h-3 text-gray-500" />
			</button>
		</div>
	</div>
</template>

<script lang="ts">
	import Vue from 'vue'

	export default Vue.extend({
		props: {
			currentSearchTerm: String,

			loading: {
				type: Boolean,
				default: false,
			},

			debounce: {
				type: Boolean,
				default: false,
			},
		},

		data() {
			return {
				searchTerm: '' as string,
				timeout: null as null | NodeJS.Timeout,
			}
		},

		methods: {
			debouncedSearch() {
				if (this.searchTerm != this.currentSearchTerm) {
					this.clearDebouncedSearch()

					this.timeout = setTimeout(() => {
						this.search()
					}, 500)
				}
			},

			clearDebouncedSearch() {
				if (this.timeout) {
					clearTimeout(this.timeout)
				}
			},

			keyupSearch() {
				this.debounce ? this.debouncedSearch() : this.search()
			},

			search() {
				this.clearDebouncedSearch()

				this.$emit('search', this.searchTerm)
			},

			clearSearch() {
				this.searchTerm = ''
				this.search()
			},
		},
	})
</script>
