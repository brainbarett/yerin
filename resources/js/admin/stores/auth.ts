import { defineStore } from 'pinia'
import { Admin } from '@/services/admin'
import useUiStore from '@/stores/ui'

export default defineStore('auth', {
	state: () => ({
		user: undefined as Admin | undefined,
	}),
	persist: true,

	actions: {
		setUser(user: Admin) {
			this.user = user
			useUiStore().setLanguage(this.user.language)
		},
	},
})
