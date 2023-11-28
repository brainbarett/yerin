<template>
	<div>
		<div class="grid gap-4">
			<div class="flex">
				<span
					v-for="(domain, index) in features"
					:key="index"
					class="text-sm font-medium text-gray-300"
					:class="{ 'text-gray-600': index == activeFeature }"
					>{{ domain.label }}</span
				>
			</div>

			<div
				v-for="(domain, index) in features"
				:key="index"
				:class="{ hidden: index != activeFeature }"
			>
				<div class="grid gap-4 lg:grid-cols-3 sm:grid-cols-2">
					<div
						v-for="(entity, index) in domain.entities"
						:key="index"
						class="overflow-hidden bg-gray-100 rounded"
					>
						<span class="block px-4 py-2 text-sm font-medium bg-gray-200">{{
							entity.label
						}}</span>
						<ul class="flex flex-col gap-2 p-4">
							<li
								v-for="(permissionLabel, permissionKey) in entity.permissions"
								:key="permissionKey"
							>
								<label class="flex items-center gap-2 cursor-pointer"
									><input
										type="checkbox"
										class="w-5 h-5 cursor-pointer"
										@change="togglePermission(permissionKey)"
										:checked="selected.includes(permissionKey)"
									/>
									{{ permissionLabel }}</label
								>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script lang="ts">
	import Vue, { PropType } from 'vue'
	import { permissions } from '@/permissions'

	type Features = {
		[domain: string]: {
			label: string
			entities: {
				[feature: string]: {
					label: string
					permissions: {
						[permission: string]: string
					}
				}
			}
		}
	}

	export default Vue.extend({
		props: {
			selected: {
				type: Array as PropType<string[]>,
			},
		},

		data() {
			const features: Features = {
				realEstate: {
					label: this.$tc('menu.real-estate'),
					entities: {
						properties: {
							label: this.$tc('menu.properties'),
							permissions: {
								[permissions.realEstate.properties.read]: this.$tc(
									'routes.roles.shared.permissions.view',
								),

								[permissions.realEstate.properties.write]: this.$tc(
									'routes.roles.shared.permissions.write',
								),

								[permissions.realEstate.properties.delete]: this.$tc(
									'routes.roles.shared.permissions.delete',
								),
							},
						},

						amenities: {
							label: this.$tc('menu.amenities'),
							permissions: {
								[permissions.realEstate.amenities.read]: this.$tc(
									'routes.roles.shared.permissions.view',
								),

								[permissions.realEstate.amenities.write]: this.$tc(
									'routes.roles.shared.permissions.write',
								),

								[permissions.realEstate.amenities.delete]: this.$tc(
									'routes.roles.shared.permissions.delete',
								),
							},
						},
					},
				},
			}

			return {
				features,
				activeFeature: 'realEstate',
			}
		},

		methods: {
			togglePermission(permission: string) {
				this.selected.includes(permission)
					? this.$emit('remove-permission', permission)
					: this.$emit('add-permission', permission)
			},
		},
	})
</script>
