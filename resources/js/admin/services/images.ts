import { http, Response } from './http'
import { AxiosPromise } from 'axios'

const baseUrl: string = '/images'

export const ImagesApi = {
	upload(file: File): AxiosPromise<Response<Image>> {
		const data = new FormData()
		data.append('file', file)

		return http.post(baseUrl, data)
	},

	destroy(id: number) {
		return http.delete(`${baseUrl}/${id}`)
	},
}

export type Image = {
	id: number
	filename: string
	sizes: {
		[size in 'small' | 'medium' | 'large']: string
	}
}
