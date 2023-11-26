<template>
	<Modal @close="$emit('close')" :title="title">
		<div class="flex flex-col gap-4">
			<slot />

			<div class="mt-5">
				<p class="mb-1 text-sm">
					{{ $t('modals.delete-resource.type-confirm-to-delete') }}
				</p>

				<div class="relative inline-block h-[42px] w-full">
					<input
						v-model="confirmation"
						type="text"
						class="box-border w-full px-3 py-2 bg-white border border-gray-300 rounded"
						:disabled="loading"
					/>
					<button
						@click="confirm()"
						type="button"
						class="box-border absolute h-8 px-3 py-1 text-white -translate-y-1/2 bg-red-500 rounded top-1/2 right-1"
						:disabled="loading"
					>
						<loading-spinner v-if="loading" size="sm" />
						<template v-else>{{ $t('common.form.delete') }}</template>
					</button>
				</div>
			</div>
		</div>
	</Modal>
</template>

<script lang="ts">
	import Vue from 'vue'
	import Modal from './Modal.vue'

	export default Vue.extend({
		components: { Modal },

		props: {
			title: String,
			loading: {
				type: Boolean,
				default: false,
			},
		},

		data() {
			return {
				confirmation: '' as string,
			}
		},

		methods: {
			confirm() {
				if (
					this.confirmation.toLowerCase() ==
					this.$t('modals.delete-resource.confirm-keyword')
				) {
					this.$emit('confirm')
				}
			},
		},
	})
</script>
