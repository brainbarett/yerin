import VueRouter from 'vue-router'
import Dashboard from '@/views/Dashboard.vue'
import admin from '@/routes/admin'

const router = new VueRouter({
	mode: 'history',
	base: 'admin',
	routes: [
		{
			path: '/',
			component: Dashboard,
		},

		...admin,
	],
})

export default router
