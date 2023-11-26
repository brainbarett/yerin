<template>
	<div class="loading-spinner" :class="`loading-spinner--` + size">
		<div :class="colorObject"></div>
		<div :class="colorObject"></div>
		<div :class="colorObject"></div>
		<div :class="colorObject"></div>
	</div>
</template>

<script lang="ts">
	/* todo: this should be an svg with acceleration */

	import Vue, { PropType } from 'vue'

	export default Vue.extend({
		props: {
			size: {
				type: String as PropType<'xs' | 'sm' | 'base' | 'lg'>,
				default: 'base',
			},

			color: {
				type: String as PropType<'white' | 'blue' | 'black' | 'gray'>,
				default: 'white',
			},
		},

		computed: {
			colorObject(): string {
				switch (this.color) {
					case 'white':
						return '!border-t-white'

					case 'blue':
						return '!border-t-sky-700'

					case 'black':
						return '!border-t-gray-900'

					case 'gray':
						return '!border-t-gray-500'

					default:
						return 'invalid-color-object'
				}
			},
		},
	})
</script>

<style lang="scss" scoped>
	.loading-spinner {
		position: relative;
		width: 40px;
		height: 40px;

		div {
			box-sizing: border-box;
			display: block;
			position: absolute;
			width: 40px;
			height: 40px;
			border: 6px solid transparent;
			border-radius: 50%;
			animation: loading-spinner 1s cubic-bezier(0.5, 0, 0.5, 1) infinite;
			border-top-color: #fff;
		}

		div:nth-child(1) {
			animation-delay: -0.3s;
		}
		div:nth-child(2) {
			animation-delay: -0.2s;
		}
		div:nth-child(3) {
			animation-delay: -0.1s;
		}

		&--xs {
			width: 15px;
			height: 15px;

			div {
				width: 15px;
				height: 15px;
				border-width: 2px;
			}
		}

		&--sm {
			width: 20px;
			height: 20px;

			div {
				width: 20px;
				height: 20px;
				border-width: 3px;
			}
		}

		&--base {
			width: 40px;
			height: 40px;

			div {
				width: 40px;
				height: 40px;
				border-width: 6px;
			}
		}

		&--lg {
			width: 80px;
			height: 80px;

			div {
				width: 80px;
				height: 80px;
				border-width: 9px;
			}
		}
	}

	@keyframes loading-spinner {
		0% {
			transform: rotate(0deg);
		}
		100% {
			transform: rotate(360deg);
		}
	}
</style>
