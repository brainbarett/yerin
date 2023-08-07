<template>
	<div class="flex items-center justify-start">
		<div class="sidebar">
			<div class="sidebar__item-group">
				<div class="sidebar__item" v-for="(item, index) in sidebarItems" :key="index">
					<router-link
						:to="item.routerLocation"
						:class="{ 'sidebar__button--active': item.active }"
						class="sidebar__button"
					>
						{{ item.label }}
					</router-link>
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

	type SidebarItem = {
		label: string
		routerLocation: RawLocation
		active?: boolean
	}

	export default Vue.extend({
		data() {
			const sidebarItems: SidebarItem[] = []

			return {
				sidebarItems,
			}
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
