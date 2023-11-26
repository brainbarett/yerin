import { http, Response } from './http'
import { AxiosPromise } from 'axios'

const baseUrl: string = '/geo-locations'

export const GeoLocationsApi = {
	index(): AxiosPromise<Response<GeoLocations>> {
		return http.get(baseUrl)
	},
}

export type Country = {
	id: number
	name: string
}

export type State = {
	id: number
	name: string
	country_id: number
}

export type City = {
	id: number
	name: string
	state_id: number
}

export type Sector = {
	id: number
	name: string
	city_id: number
}

export type GeoLocations = {
	countries: Country[]
	states: State[]
	cities: City[]
	sectors: Sector[]
}
