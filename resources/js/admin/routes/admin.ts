import { RouteConfig } from 'vue-router'
import Create from '@/views/admin/Create.vue'
import Index from '@/views/admin/Index.vue'
import Edit from '@/views/admin/Edit.vue'

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

	{
		path: '/admin-accounts/:id',
		name: 'admin.edit',
		component: Edit,
	},
]

export default routes
