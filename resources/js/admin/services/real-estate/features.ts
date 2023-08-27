import http, { Response } from '../http'
import { AxiosPromise } from 'axios'

const baseUrl: string = '/real-estate/features'

export default {
	index(): AxiosPromise<Response<Feature[]>> {
		return http.get(baseUrl)
	},
}

export type Feature = {
	id: number
	name: string
}
