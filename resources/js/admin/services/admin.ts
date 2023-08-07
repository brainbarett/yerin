import http, { Response } from './http'
import { AxiosPromise } from 'axios'

const baseUrl: string = '/admin'

export default {
	index(): AxiosPromise<Response<Admin[]>> {
		return http.get(baseUrl)
	},

	show(id: number): AxiosPromise<Response<Admin>> {
		return http.get(`${baseUrl}/${id}`)
	},

	store(data: StoreRequest): AxiosPromise<Response<Admin>> {
		return http.post(baseUrl, data)
	},
}

export type Admin = {
	id: number
	name: string
	email: string
}

export type StoreRequest = {
	name: string
	email: string
	password: string
}
