import { RouteConfig } from 'vue-router'
import Create from '@/views/admin/Create.vue'

const routes: RouteConfig[] = [
	{
		path: '/admin-accounts/create',
		name: 'admin.create',
		component: Create,
	},
]

export default routes
