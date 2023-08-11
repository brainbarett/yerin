export type Column<TField = string> = {
	field: TField
	label: string
	searchable?: boolean
}

import { PaginatedResponse } from '@/services/http'
export type PaginationMeta = Omit<PaginatedResponse['meta'], 'path'> & {
	path?: PaginatedResponse['meta']['path']
}
