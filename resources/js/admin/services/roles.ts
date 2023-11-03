import http, { Response } from './http'
import { AxiosPromise } from 'axios'

const baseUrl: string = '/roles'

export default {
	index(): AxiosPromise<Response<Role[]>> {
		return http.get(baseUrl)
	},

	store(data: StoreRequest): AxiosPromise<Response<Role>> {
		return http.post(baseUrl, data)
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
