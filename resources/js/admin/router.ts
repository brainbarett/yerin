import VueRouter from 'vue-router'
import AuthApi from '@/services/auth'
import Dashboard from '@/views/Dashboard.vue'
import Login from '@/views/auth/Login.vue'
import admin from '@/routes/admin'
import roles from '@/routes/roles'
import realEstate from '@/routes/real-estate'
import useAuthStore from '@/stores/auth'
import useUiStore from '@/stores/ui'
import { i18n } from '@/main'

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
		...roles,
		...realEstate,
	],
})

// consider using middleware
router.beforeEach(async (to, from, next) => {
	const authStore = useAuthStore()
	const uiStore = useUiStore()

	await AuthApi.isAuthenticated()
		.then(res => {
			authStore.setUser(res.data.data)
		})
		.catch(() => {
			authStore.clearUser()
		})

	uiStore.clearAlerts()
	uiStore.fireQueuedAlerts()

	if (!authStore.user && to.name != 'auth.login') {
		return next({ name: 'auth.login' })
	}

	if (authStore.user && to.name == 'auth.login') {
		return next('/')
	}

	if (to.meta && Object.hasOwn(to.meta, 'authorize')) {
		if (!to.meta!.authorize(authStore.user)) {
			uiStore.queueAlert({ title: i18n.tc('common.auth.unauthorized'), type: 'warning' })
			return next('/')
		}
	}

	return next()
})

export default router
