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

	update(id: number, data: UpdateRequest): AxiosPromise<Response<Admin>> {
		return http.put(`${baseUrl}/${id}`, data)
	},

	updatePassword(id: number, password: string) {
		return http.patch(`${baseUrl}/${id}`, { password })
	},

	destroy(id: number) {
		return http.delete(`${baseUrl}/${id}`)
	},
}

export type Language = 'en' | 'es'

export type Admin = {
	id: number
	name: string
	email: string
	language: Language
}

export type StoreRequest = {
	name: string
	email: string
	password: string
}

export type UpdateRequest = Omit<StoreRequest, 'password'> & { password?: string }
