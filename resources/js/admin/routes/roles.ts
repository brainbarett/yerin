import { RouteConfig } from 'vue-router'
import Index from '@/views/roles/Index.vue'
import Create from '@/views/roles/Create.vue'

const routes: RouteConfig[] = [
	{
		path: '/roles',
		name: 'roles.index',
		component: Index,
	},

	{
		path: '/roles/create',
		name: 'roles.create',
		component: Create,
	},
]

export default routes
