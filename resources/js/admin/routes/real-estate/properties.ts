import { RouteConfig } from 'vue-router'
import Create from '@/views/real-estate/properties/Create.vue'

const routes: RouteConfig[] = [
	{
		path: '/real-estate/properties/create',
		name: 'real-estate.properties.create',
		component: Create,
	},
]

export default routes
