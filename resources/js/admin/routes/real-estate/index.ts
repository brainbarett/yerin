import { propertiesRoutes } from './properties'
import { amenitiesRoutes } from './amenities'

export const realEstateRoutes = [...propertiesRoutes, ...amenitiesRoutes]
