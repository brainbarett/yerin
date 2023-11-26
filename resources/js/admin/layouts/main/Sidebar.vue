<template>
	<div class="md:block md:h-screen">
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
						{{ $t('routes.auth.login.form.logout') }}
					</button>
				</div>

				<div class="sidebar__item border-t border-gray-300">
					<router-link
						:to="{ name: 'auth.profile' }"
						class="font-medium box-border flex items-center px-3 py-[6px] pt-3 text-sm text-gray-600"
					>
						<icon name="user-solid-circle" set="zondicons" class="w-5 h-5 mr-2" />
						{{ user.name }}
					</router-link>
				</div>
			</div>
		</div>

		<div style="background: rgba(0, 0, 0, 0.3)" class="md:hidden w-full"></div>
	</div>
</template>

<script lang="ts">
	import Vue from 'vue'
	import { PropType } from 'vue/types/v3-component-props'
	import { NavigationMenu } from './types'
	import { useAuthStore } from '@/stores/auth'
	import { mapActions, mapState } from 'pinia'
	import { AuthApi } from '@/services/auth'
	import { useUiStore } from '@/stores/ui'
	import { AxiosResponse } from 'axios'
	import { ErrorResponse } from '@/services/http'

	export default Vue.extend({
		props: {
			menu: {
				type: Array as PropType<NavigationMenu[]>,
			},
		},

		computed: {
			...mapState(useAuthStore, ['user']),
		},

		methods: {
			...mapActions(useUiStore, ['fireAlert']),

			logout() {
				AuthApi.logout()
					.then(() => this.$router.push({ name: 'auth.login' }))
					.catch((res: AxiosResponse<ErrorResponse>) =>
						this.fireAlert({
							title: res.data.message,
							type: 'error',
						}),
					)
			},
		},
	})
</script>

<style lang="scss" scoped>
	.sidebar {
		@apply box-border flex flex-col w-56 h-full py-3 bg-gray-200 md:py-6 shrink-0;

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
</style>
