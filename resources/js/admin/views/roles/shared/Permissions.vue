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
				<div class="grid lg:grid-cols-3 sm:grid-cols-2 gap-4">
					<div
						v-for="(entity, index) in domain.entities"
						:key="index"
						class="bg-gray-100 rounded overflow-hidden"
					>
						<span class="bg-gray-200 px-4 py-2 font-medium block text-sm">{{
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
										class="h-5 w-5 cursor-pointer"
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
	import permissions from '@/permissions'

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

						features: {
							label: this.$tc('menu.features'),
							permissions: {
								[permissions.realEstate.features.read]: this.$tc(
									'routes.roles.shared.permissions.view',
								),

								[permissions.realEstate.features.write]: this.$tc(
									'routes.roles.shared.permissions.write',
								),

								[permissions.realEstate.features.delete]: this.$tc(
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