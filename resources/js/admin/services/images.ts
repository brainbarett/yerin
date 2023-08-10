import http, { Response } from './http'
import { AxiosPromise } from 'axios'

const baseUrl: string = '/real-estate/properties'

export default {
	upload(data: UploadRequest): AxiosPromise<Response<Image>> {
		return http.post(baseUrl, data)
	},
}

export type Image = {
	id: number
	filename: string
	sizes: {
		[size in 'small' | 'medium' | 'large']: string
	}
}

export type UploadRequest = {
	file: any
}
