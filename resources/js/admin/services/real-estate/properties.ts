import { http, Response, PaginatedResponse, PaginationRequest, SearchRequest } from '../http'
import { AxiosPromise } from 'axios'
import { Image } from '../images'
import { Amenity } from './amenities'

const baseUrl: string = '/real-estate/properties'

export const PropertiesApi = {
	index<TResponse = Response<Property[]>>(filters: IndexRequest): AxiosPromise<TResponse> {
		const query = new URLSearchParams()

		Object.entries(filters).map(([key, value]) => query.set(key, value.toString()))

		return http.get(`${baseUrl}?${query}`)
	},

	paginate(filters: PaginateRequest): AxiosPromise<PaginatedResponse<Property>> {
		filters.paginate = 1
		filters.page = filters.page || 1

		return this.index(filters)
	},

	show(id: number): AxiosPromise<Response<Property>> {
		return http.get(`${baseUrl}/${id}`)
	},

	store(data: StoreRequest): AxiosPromise<Response<Property>> {
		return http.post(baseUrl, data)
	},

	update(id: number, data: UpdateRequest): AxiosPromise<Response<Property>> {
		return http.put(`${baseUrl}/${id}`, data)
	},

	destroy(id: number) {
		return http.delete(`${baseUrl}/${id}`)
	},
}

export const propertyTypes = ['HOUSE', 'VILLA', 'APARTMENT', 'PENTHOUSE'] as const

export const rentTerms = ['DAY', 'WEEK', 'MONTH', 'YEAR'] as const

export type Property = {
	id: number
	type: (typeof propertyTypes)[number]
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

	latitude: number
	longitude: number
	location: {
		sector_id: number
		city_id: number
		state_id: number
		country_id: number
	}

	amenities: Amenity[]

	listings: {
		SALE: number | null
		RENT: Record<(typeof rentTerms)[number], number | null>
	}

	images: Array<Image & { order: number }>
}

export interface PaginateRequest extends PaginationRequest, SearchRequest {}
export interface IndexRequest extends PaginateRequest {}

export type StoreRequest = Omit<
	Property,
	| 'id'
	| 'listings'
	| 'images'
	| 'created_at'
	| 'updated_at'
	| 'latitude'
	| 'longitude'
	| 'location'
	| 'amenities'
> & {
	latitude: number | null
	longitude: number | null
	location_id: number
	amenities: number[]
	images: Array<{ id: number; order: number }>
	listings: {
		SALE?: number
		RENT?: Partial<Record<(typeof rentTerms)[number], number>>
	} | null
}

export type UpdateRequest = StoreRequest
