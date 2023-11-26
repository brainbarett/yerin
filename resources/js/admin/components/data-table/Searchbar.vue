<template>
	<div class="flex justify-between items-center border-b-[1px] border-gray-200 mx-3 gap-3">
		<div class="relative py-3">
			<icon
				name="search"
				set="zondicons"
				class="absolute w-4 h-4 text-gray-500 -translate-y-1/2 left-3 top-1/2"
			/>

			<input
				class="max-w-xs pr-6 text-sm bg-white border border-gray-300 rounded h-9 pl-9"
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
				class="absolute top-0 right-0 h-full px-2"
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
