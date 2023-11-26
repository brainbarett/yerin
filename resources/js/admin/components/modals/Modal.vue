<template>
	<div
		class="box-border fixed top-0 left-0 z-10 flex items-center justify-center w-full h-full p-8"
		style="background: rgba(0, 0, 0, 0.3)"
	>
		<div
			class="box-border flex flex-col gap-4 p-4 bg-white rounded w-[700px]"
			style="max-width: calc(100% - 32px)"
		>
			<header class="flex items-center">
				<span class="font-medium">{{ title }}</span>

				<button @click="$emit('close')" type="button" class="box-border ml-auto">
					<icon name="x" set="solid" class="w-6 h-6" />
				</button>
			</header>

			<slot />
		</div>
	</div>
</template>

<script lang="ts">
	import Vue from 'vue'

	export default Vue.extend({
		props: {
			title: {
				type: String,
				default: '',
			},
		},
	})
</script>
