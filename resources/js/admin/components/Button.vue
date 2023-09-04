<template>
	<router-link v-if="to" :to="to" class="button primary">{{ label }}</router-link>

	<button v-else type="button" @click="$emit('click')" :class="btnClass" :disabled="loading">
		{{ label }}
		<icon
			v-if="iconRight"
			:name="iconRight.name || iconRight"
			:set="iconRight.set || 'outline'"
			class="w-5 h-5 ml-2"
		/>
		<loading-spinner v-if="loading" size="xs" color="white" class="floating-spinner" />
	</button>
</template>

<script lang="ts">
	import Vue, { PropType } from 'vue'

	export default Vue.extend({
		props: {
			to: Object,
			type: {
				type: String as PropType<'primary' | 'secondary'>,
				default: 'primary',
			},
			label: String,
			loading: Boolean,
			destructive: Boolean,
			iconRight: {
				type: [String, Object] as PropType<
					string | { name: string; set: 'outline' | 'solid' | 'zondicons' }
				>,
			},
		},

		computed: {
			btnClass() {
				/** refactor */
				const obj = {
					'opacity-70': this.loading,
					destructive: this.destructive,
					button: true,
				} as any
				obj[this.type] = true

				return obj
			},
		},
	})
</script>

<style lang="scss" scoped>
	.button {
		@apply min-w-[100px] box-border px-4 py-2 text-sm text-neutral-400 rounded flex items-center justify-center relative;
	}

	.button.primary {
		@apply text-white bg-gray-900;
	}

	.button.secondary {
		@apply text-gray-900 bg-gray-100;
	}

	.button.terciary {
		@apply text-gray-900 bg-transparent;
	}

	.button.destructive {
		@apply text-red-400 bg-transparent;
	}

	.floating-spinner {
		@apply absolute -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2;
	}
</style>
