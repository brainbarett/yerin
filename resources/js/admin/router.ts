import VueRouter from 'vue-router'
import Dashboard from '@/views/Dashboard.vue'

const router = new VueRouter({
	mode: 'history',
	base: 'admin',
	routes: [
		{
			path: '/',
			component: Dashboard,
		},
	],
})

export default router
