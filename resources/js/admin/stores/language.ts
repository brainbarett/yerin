import { Language } from '@/services/admin'
import app, { i18n } from '@/main'
import { defineStore } from 'pinia'

export default defineStore('language', {
	state: () => ({
		language: undefined as Language | undefined,
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
