<template>
	<div :class="type" class="flex w-full gap-3 p-3 bg-white border-l-4 rounded">
		<span class="box-border">
			<icon :name="icon" set="outline" class="w-6 h-6 icon" />
		</span>

		<div class="box-border text-sm" :class="{ 'flex items-center': !description }">
			<h1 class="font-bold uppercase">{{ title }}</h1>
			<p v-if="description">{{ description }}</p>
		</div>

		<button
			@click="$emit('close-toast')"
			type="button"
			class="self-start ml-auto cursor-pointer"
		>
			<icon name="x" set="solid" class="w-4 h-4" />
		</button>
	</div>
</template>

<script lang="ts">
	import Vue, { PropType } from 'vue'
	import { Alert } from '@/stores/ui'

	export default Vue.extend({
		props: {
			title: String,
			description: String,
			type: {
				type: String as PropType<Alert['type']>,
			},
		},

		computed: {
			icon() {
				return 'exclamation-circle'
			},
		},
	})
</script>

<style lang="scss">
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

	.Vue-Toastification__container {
		color: inherit;
		@apply z-40;
	}

	.Vue-Toastification__container.top-center {
		@apply top-14 md:top-5;
	}

	.Vue-Toastification__toast {
		background: unset;
		color: inherit;
		font-family: inherit;
		box-shadow: unset;
		padding: unset;

		@apply shadow;
	}
</style>
