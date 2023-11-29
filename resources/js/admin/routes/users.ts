import { RouteConfig } from 'vue-router'
import Create from '@/views/users/Create.vue'
import Index from '@/views/users/Index.vue'
import Edit from '@/views/users/Edit.vue'
import { AuthUser } from '@/stores/auth'

const usersRoutes: RouteConfig[] = [
	{
		path: '/users',
		name: 'users.index',
		component: Index,
		meta: {
			authorize: (user: AuthUser) => user.isSuperAdmin,
		},
	},

	{
		path: '/users/create',
		name: 'users.create',
		component: Create,
		meta: {
			authorize: (user: AuthUser) => user.isSuperAdmin,
		},
	},

	{
		path: '/users/:id',
		name: 'users.edit',
		component: Edit,
		meta: {
			authorize: (user: AuthUser) => user.isSuperAdmin,
		},
	},
]

export { usersRoutes }
