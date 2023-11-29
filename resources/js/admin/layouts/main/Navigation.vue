<template>
	<div class="sticky top-0 z-50 md:z-0">
		<div class="flex items-center w-full h-12 px-3 bg-gray-900 md:hidden">
			<button type="button" class="flex items-center text-white" @click="toggleSidebar()">
				<icon name="menu" set="outline" class="w-5 h-5 mr-2" />
				Menu
			</button>
		</div>

		<Sidebar
			:menu="authorizedMenu"
			:class="
				showSidebar
					? 'flex w-screen h-[calc(100dvh-48px)] fixed top-12 z-50 left-0'
					: 'hidden'
			"
		/>
	</div>
</template>

<script lang="ts">
	import Vue from 'vue'
	import Sidebar from './Sidebar.vue'
	import { NavigationMenu } from './types'
	import { mapActions, mapState } from 'pinia'
	import { useUiStore } from '@/stores/ui'
	import { useAuthStore } from '@/stores/auth'
	import { permissions } from '@/permissions'

	export default Vue.extend({
		components: { Sidebar },

		data() {
			const menu: NavigationMenu = [
				{
					label: this.$tc('menu.real-estate'),
					items: [
						{
							label: this.$tc('menu.properties'),
							routerLocation: { name: 'real-estate.properties.index' },
							icon: 'home',
							active: this.$route.name?.startsWith('real-estate.properties.'),
							show: user => user.can(permissions.realEstate.properties.read),
						},
						{
							label: this.$tc('menu.amenities'),
							routerLocation: { name: 'real-estate.amenities.index' },
							icon: 'star',
							active: this.$route.name?.startsWith('real-estate.amenities.'),
							show: user => user.can(permissions.realEstate.amenities.read),
						},
					],
				},
				{
					label: this.$tc('menu.system'),
					show: user => user.isSuperAdmin,
					items: [
						{
							label: this.$tc('menu.users'),
							routerLocation: { name: 'users.index' },
							icon: 'user-group',
							active: this.$route.name?.startsWith('users.'),
						},
						{
							label: this.$tc('menu.roles'),
							routerLocation: { name: 'roles.index' },
							icon: 'key',
							active: this.$route.name?.startsWith('roles.'),
						},
					],
				},
			]

			return {
				menu,
				showSidebar: false,
			}
		},

		computed: {
			...mapState(useAuthStore, ['user']),

			authorizedMenu() {
				const authorizedMenu: NavigationMenu = []

				this.menu.forEach(group => {
					if (!group.show || group.show(this.user!)) {
						const items = group.items.filter(item => {
							return item.show ? item.show(this.user!) : true
						})

						if (items.length) {
							authorizedMenu.push({ ...group, items })
						}
					}
				})

				return authorizedMenu
			},
		},

		methods: {
			...mapActions(useUiStore, ['lockScroll']),

			toggleSidebar() {
				this.showSidebar = !this.showSidebar
				this.lockScroll(this.showSidebar)
			},
		},

		mounted() {
			this.lockScroll(false)
		},
	})
</script>
