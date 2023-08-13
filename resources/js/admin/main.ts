import Vue from 'vue'

import VueRouter from 'vue-router'
Vue.use(VueRouter)

// @ts-ignore
import VIcon from 'vue-tailwind-icons'
Vue.use(VIcon)

import VueFormulate, { FormulateGlobalInstance } from '@braid/vue-formulate'
Vue.use(VueFormulate)
declare module 'vue/types/vue' {
	interface Vue {
		$formulate: FormulateGlobalInstance
	}
}

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

import router from './router'
const app = new Vue({
	el: '#app',
	render: h => h('router-view'),
	router,
	pinia,
})
