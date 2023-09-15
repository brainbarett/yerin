import { Language } from '@/services/admin'
import app, { i18n } from '@/main'
import { defineStore } from 'pinia'

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
	},
})
