import http, { Response } from './http'
import { AxiosResponse } from 'axios'

const baseUrl: string = '/admin'

export default {
	index(): Promise<AxiosResponse<Response<Admin[]>>> {
		return http.get(baseUrl)
	},

	store(data: StoreRequest): Promise<AxiosResponse<Response<Admin>>> {
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
