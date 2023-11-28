import { RouteConfig } from 'vue-router'
import Index from '@/views/real-estate/features/Index.vue'
import { User } from '@/stores/auth'
import { permissions } from '@/permissions'

const featuresRoutes: RouteConfig[] = [
	{
		path: '/real-estate/features',
		name: 'real-estate.features.index',
		component: Index,
		meta: {
			authorize: (user: User) => user.can(permissions.realEstate.features.read),
		},
	},
]

export { featuresRoutes }
