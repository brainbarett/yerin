import { RouteConfig } from 'vue-router'
import Index from '@/views/real-estate/properties/Index.vue'
import Create from '@/views/real-estate/properties/Create.vue'
import Edit from '@/views/real-estate/properties/Edit.vue'

const routes: RouteConfig[] = [
	{
		path: '/real-estate/properties',
		name: 'real-estate.properties.index',
		component: Index,
	},
	{
		path: '/real-estate/properties/create',
		name: 'real-estate.properties.create',
		component: Create,
	},
	{
		path: '/real-estate/properties/:id',
		name: 'real-estate.properties.edit',
		component: Edit,
	},
]

export default routes
