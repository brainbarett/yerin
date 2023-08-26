import { StoreRequest, UpdateRequest } from '@/services/real-estate/properties'
import { PropertyForm } from './types'

export function parseOutboundPropertyForm(data: PropertyForm): StoreRequest | UpdateRequest {
	// vue-formulate doesnt make '' = null on optional fields like listings price & rent
	const listings: StoreRequest['listings'] = {}

	if (data.listings.SALE != null && (data.listings.SALE as unknown) != '') {
		listings.SALE = data.listings.SALE
	}

	if (
		Object.values(data.listings.RENT).some(price => price != null && (price as unknown) != '')
	) {
		listings.RENT = {}

		const rentals = data.listings.RENT
		for (const [term, price] of Object.entries(rentals)) {
			if (price != null && (price as unknown) != '') {
				listings.RENT[term as keyof typeof rentals] = price
			}
		}
	}

	return {
		...data,
		available: data.available == 'true',
		listings: Object.keys(listings).length ? listings : null,
		images: data.images.map((image, i) => ({ id: image.id, order: i })),
		latitude: null,
		longitude: null,
	}
}
