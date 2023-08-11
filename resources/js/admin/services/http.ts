import axios, { AxiosError } from 'axios'

const http = axios.create({
	baseURL: '/api/admin',
	withCredentials: true,
})

http.interceptors.response.use(
	response => response,
	(error: AxiosError) => Promise.reject(error.response),
)

export default http

export interface Response<TEntity = Object | Object[]> {
	data: TEntity
}

export interface PaginatedResponse<TEntity = Object> extends Response {
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
