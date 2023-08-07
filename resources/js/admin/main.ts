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

import LoadingSpinner from '@/components/LoadingSpinner.vue'
Vue.component('loading-spinner', LoadingSpinner)

import router from './router'
const app = new Vue({
	el: '#app',
	render: h => h('router-view'),
	router,
})
