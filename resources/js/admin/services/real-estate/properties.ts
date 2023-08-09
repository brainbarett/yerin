import http, { Response } from '../http'
import { AxiosPromise } from 'axios'
import { Image } from '../images'

const baseUrl: string = '/real-estate/properties'

export default {
	store(data: StoreRequest): AxiosPromise<Response<Property>> {
		return http.post(baseUrl, data)
	},
}

export const propertyTypes = [
	{ label: 'House', value: 'HOUSE' },
	{ label: 'Villa', value: 'VILLA' },
	{ label: 'Apartment', value: 'APARTMENT' },
	{ label: 'Penthouse', value: 'PENTHOUSE' },
] as const

export const rentTerms = ['DAY', 'WEEK', 'MONTH', 'YEAR'] as const

export type Property = {
	id: number
	type: (typeof propertyTypes)[number]['value']
	reference: string
	name: string
	description: string | null
	available: boolean

	bedrooms: number | null
	full_bathrooms: number | null
	half_bathrooms: number | null

	lot_area: number | null
	construction_area: number | null

	construction_year: string | null
	created_at: string
	updated_at: string

	listings: {
		SALE: number | null
		RENT: Record<(typeof rentTerms)[number], number | null>
	}

	images: Array<Image & { order: number }>
}

export type StoreRequest = Omit<
	Property,
	'id' | 'listings' | 'images' | 'created_at' | 'updated_at'
> & {
	images: { id: number; order: number }
	listings?: {
		SALE?: number
		RENT?: Partial<Record<(typeof rentTerms)[number], number>>
	} | null
}
