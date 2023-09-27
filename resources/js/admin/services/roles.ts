import http, { Response } from './http'
import { AxiosPromise } from 'axios'

const baseUrl: string = '/roles'

export default {
	index(): AxiosPromise<Response<Role[]>> {
		return http.get(baseUrl)
	},
}

export type Role = {
	id: number
	name: string
	permissions: { [key: string]: { id: number; name: string } }
	system_role: boolean
	super_admin: boolean
}
