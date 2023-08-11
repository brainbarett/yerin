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
							routerLocation: { name: 'real-estate.properties.create' },
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

<style lang="scss" scoped>
	.sidebar {
		@apply box-border flex flex-col w-56 h-screen py-6 bg-neutral-800 shrink-0;

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
			@apply ml-4 text-xs uppercase font-bold;
		}

		&__item {
			@apply mx-4 mb-1;
		}

		&__button {
			@apply box-border flex items-center w-full px-3 py-2 text-sm rounded-sm text-neutral-400;
		}

		&__button--active {
			@apply font-bold text-neutral-200;
		}

		&__button:not(&__button--active) {
			@apply duration-100 hover:bg-neutral-600 hover:text-neutral-200 hover:pl-4;
		}
	}

	#content {
		@apply relative w-screen h-screen;

		&__scroll-box {
			@apply box-border w-full h-full p-6 overflow-y-auto bg-gray-100;
		}
	}
</style>
