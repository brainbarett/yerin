<template>
	<div class="flex flex-col md:flex-row md:items-start relative">
		<div class="md:hidden sticky top-0 flex items-center h-12 bg-gray-900 w-full px-3 z-50">
			<button type="button" class="flex items-center text-white" @click="toggleSidebar()">
				<icon name="menu" set="outline" class="w-5 h-5 mr-2" />
				Menu
			</button>
		</div>

		<div
			class="md:block md:sticky md:top-0 md:h-screen"
			:class="
				showSidebar
					? 'flex w-screen h-[calc(100%-48px)] fixed top-12 z-50 left-0'
					: 'hidden'
			"
		>
			<div class="sidebar">
				<div v-for="(group, index) in menu" :key="index" class="sidebar__item-group">
					<span class="sidebar__group-label">{{ group.label }}</span>

					<div class="sidebar__item" v-for="(item, index) in group.items" :key="index">
						<router-link
							:to="item.routerLocation"
							:class="{ 'sidebar__button--active': item.active }"
							class="sidebar__button"
						>
							<icon
								v-if="item.icon"
								:name="item.icon.name || item.icon"
								:set="item.icon.set || 'outline'"
								class="w-5 h-5 mr-2"
							/>
							{{ item.label }}
						</router-link>
					</div>
				</div>

				<div class="sidebar__item-group !mt-auto">
					<div class="sidebar__item">
						<button @click="logout()" type="button" class="sidebar__button">
							<icon name="logout" set="outline" class="w-5 h-5 mr-2" />
							{{ $t('common.auth.logout') }}
						</button>
					</div>

					<div class="sidebar__item border-t border-gray-300">
						<div
							class="font-medium box-border flex items-center px-3 py-[6px] pt-3 text-sm text-gray-600"
						>
							<icon name="user-solid-circle" set="zondicons" class="w-5 h-5 mr-2" />
							{{ user.name }}
						</div>
					</div>
				</div>
			</div>

			<div
				v-if="showSidebar"
				style="background: rgba(0, 0, 0, 0.3)"
				class="md:hidden w-full"
			></div>
		</div>

		<div id="content">
			<slot />
		</div>
	</div>
</template>

<script lang="ts">
	import Vue from 'vue'
	import { RawLocation } from 'vue-router'
	import AuthApi from '@/services/auth'
	import useAuthStore from '@/stores/auth'
	import { mapState } from 'pinia'

	type SidebarGroup = {
		label: string
		items: SidebarItem[]
	}
	type SidebarItem = {
		label: string
		routerLocation: RawLocation
		icon?: string | { name: string; set?: 'outline' | 'solid' | 'zondicons' }
		active?: boolean
	}

	export default Vue.extend({
		data() {
			const menu: SidebarGroup[] = [
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

		computed: {
			...mapState(useAuthStore, ['user']),
		},

		methods: {
			logout() {
				AuthApi.logout()
					.then(res => this.$router.push({ name: 'auth.login' }))
					.catch(res => alert(res.message))
			},

			toggleSidebar() {
				this.showSidebar = !this.showSidebar
				document.body.style.overflow = this.showSidebar ? 'hidden' : 'unset'
			},
		},
	})
</script>

<style lang="scss">
	.sidebar {
		@apply box-border flex flex-col w-56 h-full py-6 bg-gray-200 shrink-0;

		> *:first-child {
			margin-top: 0px;
		}
		> *:last-child {
			margin-bottom: 0px;
		}

		&__item-group {
			@apply my-4;
		}

		&__group-label {
			@apply block mb-[6px] ml-4 text-xs font-medium text-gray-400 uppercase;
		}

		&__item {
			@apply mx-2 mb-1;
		}

		&__button {
			@apply font-medium box-border flex items-center w-full px-3 py-[6px] text-sm text-gray-500 rounded-sm;
		}

		&__button--active {
			@apply text-gray-600 bg-gray-100;
		}

		&__button:not(&__button--active) {
			@apply duration-100 hover:bg-gray-100 hover:text-gray-600 hover:pl-4;
		}
	}

	#content {
		@apply box-border relative w-full min-h-[100dvh] p-6 overflow-y-auto bg-gray-100;
	}
</style>
