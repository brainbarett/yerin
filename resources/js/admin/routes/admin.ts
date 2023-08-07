import { RouteConfig } from 'vue-router'
import Create from '@/views/admin/Create.vue'
import Index from '@/views/admin/Index.vue'

const routes: RouteConfig[] = [
	{
		path: '/admin-accounts',
		name: 'admin.index',
		component: Index,
	},

	{
		path: '/admin-accounts/create',
		name: 'admin.create',
		component: Create,
	},
]

export default routes
