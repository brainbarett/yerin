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

export interface ErrorResponse {
	message: string
}

export interface ValidationErrorResponse extends ErrorResponse {
	errors: {
		[field: string]: string[]
	}
}
