<template>
	<div>
		<label class="input-label">{{ label || $t('common.form.fields.images') }}</label>

		<div class="box-border w-full p-2 bg-gray-200 rounded">
			<input
				ref="fileUploadInput"
				type="file"
				accept=".jpg,.jpeg,.png"
				class="hidden"
				@change="upload($event.target.files)"
				multiple
			/>

			<button
				@click="$refs.fileUploadInput.click()"
				type="button"
				class="block w-full p-2 text-sm font-medium text-center uppercase bg-gray-100 border border-gray-400 border-dashed rounded cursor-pointer"
			>
				{{ $t('common.form.upload-image') }}
			</button>

			<div v-if="pendingUploads.length" class="gallery">
				<div
					v-for="(pendingOrFailed, index) in pendingUploads"
					:key="index"
					class="gallery-item"
				>
					<template v-if="pendingOrFailed.failedReason">
						<button
							@click="pendingUploads.splice(index, 1)"
							type="button"
							class="gallery-item__remove-btn absolute top-2 right-2 z-[2]"
						>
							<icon name="x" set="solid" />
						</button>

						<div class="box-border w-full p-4 gallery-item__container">
							<icon
								name="exclamation-solid"
								set="zondicons"
								class="w-6 h-6 mx-auto mb-2 text-amber-400"
							/>
							<p class="m-0 text-sm text-center text-amber-400">
								{{ pendingOrFailed.failedReason }}
							</p>
						</div>
					</template>

					<div v-else class="gallery-item__container">
						<loading-spinner color="black" />
					</div>
				</div>
			</div>

			<Draggable :list="images" v-if="images.length" class="gallery">
				<div v-for="(image, index) in images" :key="image.id" class="gallery-item">
					<div
						class="absolute top-0 left-0 p-2 z-[2] flex items-center justify-between gap-3 w-full"
					>
						<span class="gallery-item__filename">{{ image.filename }}</span>

						<button
							@click="remove(index)"
							type="button"
							class="gallery-item__remove-btn"
						>
							<icon name="trash" set="solid" />
						</button>
					</div>

					<img :src="image.sizes.small" class="cursor-pointer gallery-item__container" />
				</div>
			</Draggable>
		</div>
	</div>
</template>

<script lang="ts">
	import { ErrorResponse, ValidationErrorResponse } from '@/services/http'
	import { ImagesApi, Image } from '@/services/images'
	import { AxiosResponse } from 'axios'
	import Vue, { PropType } from 'vue'
	import Draggable from 'vuedraggable'

	type PendingUpload = {
		tempId: string
		failedReason?: string | null
		promise?: Promise<void>
	}

	export default Vue.extend({
		components: {
			Draggable, // alternative to draggable https://alfred-skyblue.github.io/vue-draggable-plus/en/
		},

		props: {
			label: String,

			images: {
				type: Array as PropType<Image[]>,
			},
		},

		data() {
			return {
				pendingUploads: [] as PendingUpload[],
			}
		},

		methods: {
			upload(files: FileList) {
				if (files.length > 0) {
					for (let i = 0; i < files.length; i++) {
						const image = files[i]

						const pendingUpload: PendingUpload = {
							tempId: Math.random().toString(16).slice(2),
							failedReason: null,
						}

						pendingUpload.promise = ImagesApi.upload(image)
							.then(res => {
								this.pendingUploads.splice(
									this.pendingUploads.findIndex(
										element => element.tempId === pendingUpload.tempId,
									),
									1,
								)

								this.images.push(res.data.data)
							})
							.catch((res: AxiosResponse<ErrorResponse>) => {
								const errorMessage =
									res.status == 422 //how2 automate this with TS
										? (res.data as ValidationErrorResponse).errors.file[0]
										: res.data.message

								pendingUpload.failedReason = <string>this.$t(
									'common.form.messages.error-uploading-image',
									{
										name: image.name,
										error: errorMessage,
									},
								)
							})

						this.pendingUploads.unshift(pendingUpload)
					}
				}
			},

			remove(index: number) {
				this.images.splice(index, 1)
			},
		},
	})
</script>

<style lang="scss" scoped>
	.gallery {
		@apply grid items-start gap-2 mt-2 md:grid-cols-2 lg:grid-cols-4;
	}

	.gallery-item {
		@apply bg-gray-100 rounded box-border relative w-full pt-[100%] overflow-hidden;

		&__remove-btn {
			@apply w-5 h-5 rounded bg-gray-50;
		}

		&__filename {
			@apply w-full overflow-hidden text-xs whitespace-nowrap text-ellipsis;
		}

		&__container {
			@apply block absolute top-1/2 -translate-y-1/2 left-1/2 -translate-x-1/2 z-[1];
		}
	}
</style>
