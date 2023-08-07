import { Admin } from './admin'
import http, { Response } from './http'
import { AxiosResponse } from 'axios'

const baseUrl: string = '/auth'

export default {
	login(data: LoginRequest): Promise<AxiosResponse<Response<Admin>>> {
		return http.post(`${baseUrl}/login`, data)
	},

	isAuthenticated(): Promise<AxiosResponse<Response<Admin>>> {
		return http.get(`${baseUrl}/authenticated`)
	},
}

export type LoginRequest = {
	email: string
	password: string
}
