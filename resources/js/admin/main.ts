import Vue from 'vue'

import VueRouter from 'vue-router'
Vue.use(VueRouter)

import router from './router'
const app = new Vue({
	el: '#app',
	render: h => h('router-view'),
	router,
})
