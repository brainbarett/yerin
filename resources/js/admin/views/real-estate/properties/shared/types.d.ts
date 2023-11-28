import { Image } from '@/services/images'
import { StoreRequest, rentTerms } from '@/services/real-estate/properties'

type StringBoolean = 'true' | 'false'

export type PropertyForm = Omit<StoreRequest, 'available' | 'listings' | 'images'> & {
	description: string | null
	available: StringBoolean
	images: Image[]
	listings: {
		SALE: number | null
		RENT: Record<(typeof rentTerms)[number], number | null>
	}
	amenities: number[]
}
