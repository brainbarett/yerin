import { defineStore } from 'pinia'
import { Admin } from '@/services/admin'

export default defineStore('auth', {
	state: () => ({
		user: undefined as Admin | undefined,
	}),
	persist: true,

	actions: {
		setUser(user: Admin) {
			this.user = user
		},
	},
})
