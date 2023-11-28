import { RouteConfig } from 'vue-router'
import Index from '@/views/real-estate/amenities/Index.vue'
import { User } from '@/stores/auth'
import { permissions } from '@/permissions'

const amenitiesRoutes: RouteConfig[] = [
	{
		path: '/real-estate/amenities',
		name: 'real-estate.amenities.index',
		component: Index,
		meta: {
			authorize: (user: User) => user.can(permissions.realEstate.amenities.read),
		},
	},
]

export { amenitiesRoutes }
