import { defineStore } from 'pinia'
import { Admin } from '@/services/admin'
import { useUiStore } from '@/stores/ui'
import { Authorizable, makeAuthorizable } from '@/utils/authorization'

export type User = Admin & Authorizable

export const useAuthStore = defineStore('auth', {
	state: () => ({
		user: null as User | null,
	}),
	persist: true,

	actions: {
		setUser(admin: Admin) {
			this.user = makeAuthorizable(admin)
			useUiStore().setLanguage(this.user.language)
		},

		clearUser() {
			this.user = null
		},
	},
})
