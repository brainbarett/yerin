import VueRouter from 'vue-router'
import AuthApi from '@/services/auth'
import Dashboard from '@/views/Dashboard.vue'
import Login from '@/views/auth/Login.vue'
import admin from '@/routes/admin'
import realEstate from '@/routes/real-estate'
import useAuthStore from '@/stores/auth'

const router = new VueRouter({
	mode: 'history',
	base: 'admin',
	routes: [
		{
			path: '/login',
			name: 'auth.login',
			component: Login,
		},

		{
			path: '/',
			component: Dashboard,
		},

		...admin,
		...realEstate,
	],
})

router.beforeEach((to, from, next) => {
	if (to.name == 'auth.login') {
		AuthApi.isAuthenticated()
			.then(res => next('/'))
			.catch(res => next())
	} else {
		AuthApi.isAuthenticated()
			.then(res => {
				useAuthStore().setUser(res.data.data)
				next()
			})
			.catch(res => next({ name: 'auth.login' }))
	}
})

export default router

export type RouteParams = {
	error?: { title: string; description: string }
}
