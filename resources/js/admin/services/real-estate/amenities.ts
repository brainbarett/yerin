import { http, Response } from '../http'
import { AxiosPromise } from 'axios'

const baseUrl: string = '/real-estate/amenities'

export const AmenitiesApi = {
	index(): AxiosPromise<Response<Amenity[]>> {
		return http.get(baseUrl)
	},

	store(data: StoreRequest) {
		return http.post(baseUrl, data)
	},

	update(id: number, data: UpdateRequest) {
		return http.put(`${baseUrl}/${id}`, data)
	},

	destroy(id: number) {
		return http.delete(`${baseUrl}/${id}`)
	},
}

export type Amenity = {
	id: number
	name: string
}

export type StoreRequest = {
	name: string
}
export type UpdateRequest = StoreRequest
