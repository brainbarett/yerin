import { http, Response } from './http'
import { AxiosPromise } from 'axios'
import { Role } from './roles'

const baseUrl: string = '/users'

export const UsersApi = {
	index(): AxiosPromise<Response<User[]>> {
		return http.get(baseUrl)
	},

	show(id: number): AxiosPromise<Response<User>> {
		return http.get(`${baseUrl}/${id}`)
	},

	store(data: StoreRequest): AxiosPromise<Response<User>> {
		return http.post(baseUrl, data)
	},

	update(id: number, data: UpdateRequest): AxiosPromise<Response<User>> {
		return http.put(`${baseUrl}/${id}`, data)
	},

	updatePassword(id: number, data: { old_password?: string; password: string }) {
		return http.patch(`${baseUrl}/${id}`, data)
	},

	destroy(id: number) {
		return http.delete(`${baseUrl}/${id}`)
	},
}

export type Language = 'en' | 'es'

export type User = {
	id: number
	name: string
	email: string
	language: Language
	role: Role
}

export type StoreRequest = {
	name: string
	email: string
	password: string
	role: number | null
}

export type UpdateRequest = Omit<StoreRequest, 'password' | 'role'> & {
	role?: number | null
}
