import { PaginatedResponse, PaginationRequest, Response, SearchRequest } from '@/services/http'
import { AxiosPromise } from 'axios'

export type Column<TField = string> = {
	field: TField
	label: string
	searchable?: boolean
	columnClass?: string
	rowClass?: string
}

export type PaginationMeta = Omit<PaginatedResponse['meta'], 'path'> & {
	path?: PaginatedResponse['meta']['path']
}

export type RemoteApi = (
	filters: PaginationRequest & SearchRequest,
) => AxiosPromise<Response<Array<{ [field: string]: any }>> | PaginatedResponse>
