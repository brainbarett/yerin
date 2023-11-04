import { RouteConfig } from 'vue-router'
import Create from '@/views/admin/Create.vue'
import Index from '@/views/admin/Index.vue'
import Edit from '@/views/admin/Edit.vue'
import { User } from '@/stores/auth'

const routes: RouteConfig[] = [
	{
		path: '/admin-accounts',
		name: 'admin.index',
		component: Index,
		meta: {
			authorize: (user: User) => user.isSuperAdmin,
		},
	},

	{
		path: '/admin-accounts/create',
		name: 'admin.create',
		component: Create,
		meta: {
			authorize: (user: User) => user.isSuperAdmin,
		},
	},

	{
		path: '/admin-accounts/:id',
		name: 'admin.edit',
		component: Edit,
		meta: {
			authorize: (user: User) => user.isSuperAdmin,
		},
	},
]

export default routes
