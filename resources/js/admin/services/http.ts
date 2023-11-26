import { i18n } from '@/app'
import axios, { AxiosError } from 'axios'

const http = axios.create({
	baseURL: '/api/admin',
	withCredentials: true,
})

http.interceptors.request.use(config => {
	config.headers!['X-Language'] = i18n.locale
	return config
})

http.interceptors.response.use(
	response => response,
	(error: AxiosError) => Promise.reject(error.response),
)

export { http }

export interface Response<TEntity = { [field: string]: any } | Array<{ [field: string]: any }>> {
	data: TEntity
}

export interface PaginationRequest {
	paginate?: 0 | 1
	page?: number
	per_page?: number
}

export interface SearchRequest {
	search?: string
}

export interface PaginatedResponse<TEntity = { [field: string]: any }> extends Response {
	data: TEntity[]

	links: {
		first: string
		last: string
		prev: string | null
		next: string | null
	}

	meta: {
		current_page: number
		from: number
		last_page: number
		path: string
		per_page: number
		to: number
		total: number
	}
}

export interface ErrorResponse {
	message: string
}

export interface ValidationErrorResponse extends ErrorResponse {
	errors: {
		[field: string]: string[]
	}
}
