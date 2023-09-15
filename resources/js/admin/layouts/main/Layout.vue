<template>
	<div class="flex flex-col md:flex-row md:items-start relative">
		<Navigation />

		<div
			id="content"
			class="box-border relative w-full min-h-[100dvh] p-3 md:p-6 bg-gray-100"
			:class="{ 'h-[calc(100vh-24px)] md:h-[calc(100vh-48px)]': vh }"
		>
			<slot />
		</div>
	</div>
</template>

<script lang="ts">
	import Vue from 'vue'
	import Navigation from './Navigation.vue'

	export default Vue.extend({
		components: { Navigation },

		props: {
			vh: {
				type: Boolean,
				default: false,
			},
		},
	})
</script>
