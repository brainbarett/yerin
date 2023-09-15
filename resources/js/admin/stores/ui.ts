import { Language } from '@/services/admin'
import app, { i18n } from '@/main'
import { defineStore } from 'pinia'
import { default as AlertComponent } from '@/components/Alert.vue'

export type Alert = {
	title: string
	description?: string
	type: 'info' | 'warning' | 'error'
}

export default defineStore('ui', {
	state: () => ({
		language: null as Language | null,
	}),
	persist: true,

	actions: {
		setLanguage(language: Language) {
			this.language = language
			i18n.locale = this.language
			app.$formulate.setLocale(language)
		},

		fireAlert(alert: Alert) {
			app.$toast({
				component: AlertComponent,
				props: alert,
			})
		},

		clearAlerts() {
			app.$toast.clear()
		},
	},
})
