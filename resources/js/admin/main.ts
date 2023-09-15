import Vue from 'vue'

import VueRouter from 'vue-router'
Vue.use(VueRouter)

// @ts-ignore
import VIcon from 'vue-tailwind-icons'
Vue.use(VIcon)

/** @ts-ignore */
import CKEditor from '@ckeditor/ckeditor5-vue2'
Vue.use(CKEditor)

import LoadingSpinner from '@/components/LoadingSpinner.vue'
Vue.component('loading-spinner', LoadingSpinner)

import { createPinia, PiniaVuePlugin } from 'pinia'
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'
Vue.use(PiniaVuePlugin)
const pinia = createPinia()
pinia.use(piniaPluginPersistedstate)

import VueI18n from 'vue-i18n'
import translations from '@/lang'
Vue.use(VueI18n)
export const i18n = new VueI18n({
	fallbackLocale: 'en',
	messages: translations,
})

import VueFormulate, { FormulateGlobalInstance } from '@braid/vue-formulate'
// @ts-ignore
import { es } from '@braid/vue-formulate-i18n'
Vue.use(VueFormulate, {
	plugins: [es],
})
declare module 'vue/types/vue' {
	interface Vue {
		$formulate: FormulateGlobalInstance
	}
}

import 'floating-vue/dist/style.css'
import FloatingVue from 'floating-vue'
Vue.use(FloatingVue)

import Toast from 'vue-toastification'
import 'vue-toastification/dist/index.css'
Vue.use(Toast, {
	icon: false,
	timeout: false,
	draggable: false,
	closeOnClick: false,
	closeButton: false,
	position: 'top-center',
})

import router from './router'
export default new Vue({
	el: '#app',
	render: h => h('router-view'),
	router,
	pinia,
	i18n,
})

import useUiStore from '@/stores/ui'
useUiStore().setLanguage(useUiStore().language || 'en')
