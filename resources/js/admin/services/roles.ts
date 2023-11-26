import { http, Response } from './http'
import { AxiosPromise } from 'axios'

const baseUrl: string = '/roles'

export const RolesApi = {
	index(): AxiosPromise<Response<Role[]>> {
		return http.get(baseUrl)
	},

	show(id: number): AxiosPromise<Response<Role>> {
		return http.get(`${baseUrl}/${id}`)
	},

	store(data: StoreRequest): AxiosPromise<Response<Role>> {
		return http.post(baseUrl, data)
	},

	update(id: number, data: UpdateRequest): AxiosPromise<Response<Role>> {
		return http.put(`${baseUrl}/${id}`, data)
	},

	destroy(id: number) {
		return http.delete(`${baseUrl}/${id}`)
	},
}

export type Role = {
	id: number
	name: string
	permissions: string[]
	system_role: boolean
	super_admin: boolean
}

export type StoreRequest = {
	name: string
	permissions: string[] | null
}

export type UpdateRequest = StoreRequest
