import { Language } from '@/services/users'
import { app, i18n } from '@/app'
import { defineStore } from 'pinia'
import { default as AlertComponent } from '@/components/Alert.vue'

export type Alert = {
	title: string
	description?: string
	type: 'info' | 'warning' | 'error'
}

export const useUiStore = defineStore('ui', {
	state: () => ({
		language: null as Language | null,
		queuedAlerts: [] as Alert[],
	}),

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

		queueAlert(alert: Alert) {
			this.queuedAlerts.push(alert)
		},

		fireQueuedAlerts() {
			this.queuedAlerts.forEach(alert => this.fireAlert(alert))
			this.queuedAlerts = []
		},

		lockScroll(lock: boolean) {
			document.body.style.overflow = lock ? 'hidden' : 'unset'
		},
	},
})
