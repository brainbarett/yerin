import { Admin } from './admin'
import { http, Response } from './http'
import { AxiosPromise } from 'axios'

const baseUrl: string = '/auth'

export const AuthApi = {
	login(data: LoginRequest): AxiosPromise<Response<Admin>> {
		return http.post(`${baseUrl}/login`, data)
	},

	isAuthenticated(): AxiosPromise<Response<Admin>> {
		return http.get(`${baseUrl}/authenticated`)
	},

	logout() {
		return http.post(`${baseUrl}/logout`)
	},
}

export type LoginRequest = {
	email: string
	password: string
}
