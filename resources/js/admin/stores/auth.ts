import { defineStore } from 'pinia'
import { User } from '@/services/users'
import { useUiStore } from '@/stores/ui'
import { Authorizable, makeAuthorizable } from '@/utils/authorization'

export type AuthUser = User & Authorizable

export const useAuthStore = defineStore('auth', {
	state: () => ({
		user: null as AuthUser | null,
	}),
	persist: true,

	actions: {
		setUser(user: User) {
			this.user = makeAuthorizable(user)
			useUiStore().setLanguage(this.user.language)
		},

		clearUser() {
			this.user = null
		},
	},
})
