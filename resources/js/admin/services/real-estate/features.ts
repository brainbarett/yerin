import { http, Response } from '../http'
import { AxiosPromise } from 'axios'

const baseUrl: string = '/real-estate/features'

export const FeaturesApi = {
	index(): AxiosPromise<Response<Feature[]>> {
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

export type Feature = {
	id: number
	name: string
}

export type StoreRequest = {
	name: string
}
export type UpdateRequest = StoreRequest
