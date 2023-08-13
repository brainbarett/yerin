import { defineStore } from 'pinia'
import { Admin } from '@/services/admin'
import useLanguageStore from '@/stores/language'

export default defineStore('auth', {
	state: () => ({
		user: undefined as Admin | undefined,
	}),
	persist: true,

	actions: {
		setUser(user: Admin) {
			this.user = user
			useLanguageStore().setLanguage(this.user.language)
		},
	},
})
