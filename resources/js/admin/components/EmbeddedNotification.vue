<template>
	<div :class="type" class="bg-white border-l-4 rounded w-full flex gap-3 shadow-sm p-3">
		<span class="box-border">
			<icon :name="icon" set="outline" class="h-6 w-6 icon" />
		</span>

		<div class="text-sm box-border">
			<h1 class="font-bold uppercase">{{ title }}</h1>
			<p>{{ description }}</p>
		</div>
	</div>
</template>

<script lang="ts">
	import Vue, { PropType } from 'vue'

	export default Vue.extend({
		props: {
			title: String,
			description: String,
			type: {
				type: String as PropType<'info' | 'warning' | 'error'>,
			},
		},

		computed: {
			icon() {
				return 'exclamation-circle'
			},
		},
	})
</script>

<style lang="scss" scoped>
	.info {
		@apply border-sky-400;

		.icon {
			@apply text-sky-400;
		}
	}
	.warning {
		@apply border-amber-400;

		.icon {
			@apply text-amber-400;
		}
	}
	.error {
		@apply border-red-400;

		.icon {
			@apply text-red-400;
		}
	}
</style>
