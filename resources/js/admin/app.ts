import Vue from 'vue'
// @ts-ignore
import VIcon from 'vue-tailwind-icons'
/** @ts-ignore */
import CKEditor from '@ckeditor/ckeditor5-vue2'
import LoadingSpinner from '@/components/LoadingSpinner.vue'
import 'floating-vue/dist/style.css'
import FloatingVue from 'floating-vue'
import Toast from 'vue-toastification'
import 'vue-toastification/dist/index.css'
import { createPinia, PiniaVuePlugin } from 'pinia'
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'
import VueRouter from 'vue-router'
import VueI18n from 'vue-i18n'
import { translations } from '@/lang'
import VueFormulate, { FormulateGlobalInstance } from '@braid/vue-formulate'
// @ts-ignore
import { es } from '@braid/vue-formulate-i18n'
import { formulateHandleApiPlugin } from './utils/formulate-handle-api'
import { permissions } from './permissions'
import { router } from './router'
import { useUiStore } from '@/stores/ui'

/* augmentation can only be declared here @see https://github.com/vuejs/vue/issues/12642 */
declare module 'vue/types/vue' {
	interface Vue {
		$formulate: FormulateGlobalInstance
	}
}

Vue.component('loading-spinner', LoadingSpinner)

Vue.use(VIcon)
Vue.use(CKEditor)
Vue.use(FloatingVue)
Vue.use(Toast, {
	icon: false,
	draggable: false,
	closeOnClick: false,
	closeButton: false,
	position: 'top-center',
})
Vue.use(PiniaVuePlugin)
Vue.use(VueRouter)
Vue.use(VueI18n)
Vue.use(VueFormulate, {
	plugins: [es, formulateHandleApiPlugin],
	validationNameStrategy: ['validationName', 'label', 'name', 'type'],
})

const pinia = createPinia()
pinia.use(piniaPluginPersistedstate)

Vue.prototype.$permissions = permissions

export const i18n = new VueI18n({
	fallbackLocale: 'en',
	messages: translations,
})

useUiStore().setLanguage(useUiStore().language || 'en')

export const app = new Vue({
	el: '#app',
	render: h => h('router-view'),
	router,
	pinia,
	i18n,
})
