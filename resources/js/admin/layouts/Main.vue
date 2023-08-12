<template>
	<div class="flex items-center justify-start">
		<div class="sidebar">
			<div v-for="(group, index) in menu" :key="index" class="sidebar__item-group">
				<span class="sidebar__group-label">{{ group.label }}</span>

				<div class="sidebar__item" v-for="(item, index) in group.items" :key="index">
					<router-link
						:to="item.routerLocation"
						:class="{ 'sidebar__button--active': item.active }"
						class="sidebar__button"
					>
						{{ item.label }}
					</router-link>
				</div>
			</div>

			<div class="sidebar__item-group !mt-auto">
				<div class="sidebar__item">
					<button @click="logout()" type="button" class="sidebar__button">
						<icon name="logout" set="outline" class="w-5 h-5 mr-2" />
						Log out
					</button>
				</div>
			</div>
		</div>

		<div id="content">
			<div id="content__scroll-box">
				<slot></slot>
			</div>
		</div>
	</div>
</template>

<script lang="ts">
	import Vue from 'vue'
	import { RawLocation } from 'vue-router'
	import AuthApi from '@/services/auth'

	type SidebarGroup = {
		label: string
		items: SidebarItem[]
	}
	type SidebarItem = {
		label: string
		routerLocation: RawLocation
		active?: boolean
	}

	export default Vue.extend({
		data() {
			const menu: SidebarGroup[] = [
				{
					label: 'Real Estate',
					items: [
						{
							label: 'Properties',
							routerLocation: { name: 'real-estate.properties.index' },
							active: this.$route.name?.startsWith('real-estate.properties.'),
						},
					],
				},
				{
					label: 'System',
					items: [
						{
							label: 'Admin Accounts',
							routerLocation: { name: 'admin.index' },
							active: this.$route.name?.startsWith('admin.'),
						},
					],
				},
			]

			return {
				menu,
			}
		},

		methods: {
			logout() {
				AuthApi.logout()
					.then(res => this.$router.push({ name: 'auth.login' }))
					.catch(res => alert(res.message))
			},
		},
	})
</script>

<style lang="scss">
	.sidebar {
		@apply box-border flex flex-col w-56 h-screen py-6 bg-gray-200 shrink-0;

		> *:first-child {
			margin-top: 0px;
		}
		> *:last-child {
			margin-bottom: 0px;
		}

		&__item-group {
			@apply my-4;
		}

		&__item-group:first-child {
			@apply mt-0;
		}
		&__item-group:last-child {
			@apply mb-0;
		}

		&__group-label {
			@apply block mb-[6px] ml-4 text-xs font-medium text-gray-400 uppercase;
		}

		&__item {
			@apply mx-2 mb-1;
		}

		&__button {
			@apply font-medium box-border flex items-center w-full px-3 py-[6px] text-sm text-gray-600 rounded-sm;
		}

		&__button--active {
			@apply bg-gray-100;
		}

		&__button:not(&__button--active) {
			@apply duration-100 hover:bg-gray-100 hover:pl-4;
		}
	}

	#content {
		@apply relative w-screen h-screen;

		&__scroll-box {
			@apply box-border w-full h-full p-6 overflow-y-auto bg-gray-100;
		}
	}
</style>
