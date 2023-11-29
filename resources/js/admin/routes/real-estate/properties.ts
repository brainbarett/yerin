import { RouteConfig } from 'vue-router'
import Index from '@/views/real-estate/properties/Index.vue'
import Create from '@/views/real-estate/properties/Create.vue'
import Edit from '@/views/real-estate/properties/Edit.vue'
import { AuthUser } from '@/stores/auth'
import { permissions } from '@/permissions'

const propertiesRoutes: RouteConfig[] = [
	{
		path: '/real-estate/properties',
		name: 'real-estate.properties.index',
		component: Index,
		meta: {
			authorize: (user: AuthUser) => user.can(permissions.realEstate.properties.read),
		},
	},
	{
		path: '/real-estate/properties/create',
		name: 'real-estate.properties.create',
		component: Create,
		meta: {
			authorize: (user: AuthUser) => user.can(permissions.realEstate.properties.write),
		},
	},
	{
		path: '/real-estate/properties/:id',
		name: 'real-estate.properties.edit',
		component: Edit,
		meta: {
			authorize: (user: AuthUser) => user.can(permissions.realEstate.properties.write),
		},
	},
]

export { propertiesRoutes }
