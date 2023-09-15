import { defineStore } from 'pinia'
import { Admin } from '@/services/admin'
import useUiStore from '@/stores/ui'

export default defineStore('auth', {
	state: () => ({
		user: null as Admin | null,
	}),
	persist: true,

	actions: {
		setUser(user: Admin) {
			this.user = user
			useUiStore().setLanguage(this.user.language)
		},

		clearUser() {
			this.user = null
		},
	},
})
