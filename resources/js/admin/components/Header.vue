<template>
	<div class="flex items-center">
		<router-link v-if="back" :to="back" class="self-start p-1 mr-2 bg-white rounded shadow">
			<icon name="chevron-left" class="w-6 h-6" />
		</router-link>

		<h1 class="text-xl font-medium">{{ title }}</h1>

		<slot name="extra-content" />
	</div>
</template>

<script lang="ts">
	import Vue from 'vue'
	export default Vue.extend({
		props: {
			title: String,
			back: Object,
		},
	})
</script>
