import { RouteConfig } from 'vue-router'
import Index from '@/views/roles/Index.vue'

const routes: RouteConfig[] = [
	{
		path: '/roles',
		name: 'roles.index',
		component: Index,
	},
]

export default routes
