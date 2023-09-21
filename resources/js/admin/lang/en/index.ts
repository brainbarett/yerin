export default {
	common: {
		language: 'Language',
		english: 'English',
		spanish: 'Spanish',
		auth: {
			login: 'Log in',
			logout: 'Log out',
		},
		form: {
			add: 'Add',
			update: 'Update',
			updating: 'Updating',
			create: 'Create',
			creating: 'Creating',
			delete: 'Delete',
			save: 'Save',
			saving: 'Saving',
			cancel: 'Cancel',
			fields: {
				name: 'Name',
				password: 'Password',
				email: 'Email',
				description: 'Description',
				images: 'Images',
			},
			'image-upload': {
				upload: 'Upload Images',
				'error-uploading': 'Error uploading {name} {error}',
			},
			'update-password': 'Change password',
			'update-password-success': 'Password update successful',
		},
		country: 'Country',
		state: 'State',
		city: 'City',
		sector: 'Sector',
		location: 'Location',
	},

	menu: {
		'admin-accounts': 'Admin Accounts',
		properties: 'Properties',
		'real-estate': 'Real Estate',
		system: 'System',
	},

	'real-estate': {
		'property-types': {
			house: 'House',
			villa: 'Villa',
			apartment: 'Apartment',
			penthouse: 'Penthouse',
		},
	},

	'data-table': {
		pagination: {
			'from-to-total': 'Showing {from} to {to} of {total} entries',
			'showing-amount-of-total': 'Showing {amount} of {total} entries',
			'showing-amount': 'Showing {amount} entries',
		},
	},

	modals: {
		'delete-resource': {
			'type-confirm-to-delete': "Please type 'confirm' to delete",
			'confirm-keyword': 'confirm',
			delete: 'DELETE',
		},
	},

	routes: {
		auth: {
			login: {
				title: 'Welcome back!',
			},
		},

		admin: {
			index: {
				title: 'Manage Admin Accounts',
				'add-admin-btn': 'Add an Admin Account',
				'error-fetching-data': 'Error fetching table data',
			},

			create: {
				title: 'Create an Admin Account',
			},

			edit: {
				title: 'Edit Admin Account',
				'error-fetching-account': 'Error fetching data',
				'error-deleting-account': "Error deleting '{name}'",
				'attempting-to-delete-account':
					'You are attempting to delete <span class="underline">{name}</span>',
				'delete-account-modal-title': 'Delete Admin Account',
			},

			shared: {
				form: {
					fields: {
						'password-confirmation': 'Password confirmation',
					},
					messages: {
						'password-successfully-updated': 'Password successfully updated',
					},
				},
			},
		},

		'real-estate': {
			properties: {
				index: {
					title: 'Manage Properties',
					'add-property-btn': 'Add a Property',
					'error-fetching-data': 'Error fetching table data',
				},

				create: {
					title: 'Create a Property',
				},

				edit: {
					title: 'Edit Property',
					'error-fetching-property': 'Error fetching data',
					'error-deleting-property': "Error deleting '{name}'",
					'attempting-to-delete-property':
						'You are attempting to delete <span class="underline">{name}</span>',
					'delete-property-modal-title': 'Delete Property',
				},

				shared: {
					available: 'Available',
					'not-available': 'Not available',
					form: {
						fields: {
							reference: 'Reference',
							'property-type': 'Type',
							availability: 'Availability',
							bedrooms: 'Bedrooms',
							'full-bathrooms': 'Full bathrooms',
							'half-bathrooms': 'Half bathrooms',
							'lot-area': 'Lot area',
							'construction-area': 'Construction area',
							'construction-year': 'Construction year',
							'sale-price': 'Sale price',
							'rent-terms': 'Rent terms',
							'rent-day': 'Day',
							'rent-week': 'Week',
							'rent-month': 'Month',
							'rent-year': 'Year',
							'rent-day-price': 'Daily rent price',
							'rent-week-price': 'Weekly rent price',
							'rent-month-price': 'Monthly rent price',
							'rent-year-price': 'Yearly rent price',
						},
						sections: {
							'basic-info': 'Basic info',
							amenities: 'Amenities',
							images: 'Images',
							listings: 'Listings',
						},
					},
				},
			},
		},
	},
}
