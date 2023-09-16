<template>
	<router-link v-if="to" :to="to" :class="classObject">{{ label }}</router-link>

	<button v-else type="button" @click="$emit('click')" :class="classObject" :disabled="disabled">
		{{ label }}
		<icon
			v-if="icon"
			:name="icon.name || icon"
			:set="icon.set || 'outline'"
			class="w-5 h-5 ml-2"
		/>
		<loading-spinner v-if="loading" size="xs" color="gray" class="floating-spinner" />
	</button>
</template>

<script lang="ts">
	import Vue, { PropType } from 'vue'

	export default Vue.extend({
		props: {
			to: Object,
			category: {
				type: String as PropType<'primary' | 'secondary' | 'tertiary'>,
				default: 'primary',
			},
			variant: {
				type: String as PropType<'confirm' | 'danger'>,
				default: 'confirm',
			},
			label: String,
			loading: Boolean,
			disabled: Boolean,
			icon: {
				type: [String, Object] as PropType<
					string | { name: string; set: 'outline' | 'solid' | 'zondicons' }
				>,
			},
		},

		computed: {
			classObject() {
				return this.loading || this.disabled
					? ['button', 'unusable']
					: [
							'button',
							this.category,
							this.variant,
							{ loading: this.loading },
							{ disabled: this.disabled },
					  ]
			},
		},
	})
</script>

<style lang="scss" scoped>
	.button {
		@apply min-w-[100px] box-border px-4 py-2 text-sm rounded flex items-center justify-center relative border border-transparent;
	}

	.confirm.primary {
		@apply text-white bg-gray-900;
	}
	.confirm.secondary {
		@apply text-gray-900 bg-gray-200;
	}
	.confirm.tertiary {
		@apply text-gray-900 bg-transparent;
	}

	.danger.primary {
		@apply text-white bg-rose-600;
	}
	.danger.secondary {
		@apply bg-transparent border text-rose-600 border-rose-600;
	}
	.danger.tertiary {
		@apply bg-transparent text-rose-600;
	}

	.unusable {
		@apply text-gray-500 bg-gray-100 border-gray-300;
	}

	.floating-spinner {
		@apply absolute -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2;
	}
</style>
