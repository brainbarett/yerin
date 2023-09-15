<template>
	<div class="sticky top-0 z-50">
		<div class="md:hidden flex items-center h-12 bg-gray-900 w-full px-3">
			<button type="button" class="flex items-center text-white" @click="toggleSidebar()">
				<icon name="menu" set="outline" class="w-5 h-5 mr-2" />
				Menu
			</button>
		</div>

		<Sidebar
			:menu="menu"
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
	import { mapActions } from 'pinia'
	import useUiStore from '@/stores/ui'

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
						},
					],
				},
				{
					label: this.$tc('menu.system'),
					items: [
						{
							label: this.$tc('menu.admin-accounts'),
							routerLocation: { name: 'admin.index' },
							icon: 'user-group',
							active: this.$route.name?.startsWith('admin.'),
						},
					],
				},
			]

			return {
				menu,
				showSidebar: false,
			}
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
