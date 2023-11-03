import { RouteConfig } from 'vue-router'
import Index from '@/views/roles/Index.vue'
import Create from '@/views/roles/Create.vue'
import Edit from '@/views/roles/Edit.vue'

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

	{
		path: '/roles/:id',
		name: 'roles.edit',
		component: Edit,
	},
]

export default routes
