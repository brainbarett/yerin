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
			update: 'Update',
			updating: 'Updating',
			create: 'Create',
			creating: 'Creating',
			delete: 'Delete',
			fields: {
				name: 'Name',
				password: 'Password',
				email: 'Email',
			},
			images: 'Images',
			'image-upload': {
				upload: 'Upload Images',
				'error-uploading': 'Error uploading {name} {error}',
			},
		},
	},

	menu: {
		'admin-accounts': 'Admin Accounts',
		properties: 'Properties',
		'real-estate': 'Real Estate',
		system: 'System',
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
				welcome: 'Welcome back!',
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
				'error-fetching-account': 'Error loading resource',
				'error-deleting-account': 'Error deleting {name}',
				'attempting-to-delete-account': 'You are attempting to delete',
				'delete-account-modal-title': 'Deleting Admin Account',
			},

			shared: {
				form: {
					fields: {
						'password-confirmation': 'Password confirmation',
					},
				},
			},
		},

		'real-estate': {
			properties: {
				index: {
					title: 'Manage Properties',
					'add-property-btn': 'Add a Property',
				},

				create: {
					title: 'Create a Property',
				},

				edit: {
					title: 'Edit Property',
					'error-fetching-property': 'Error loading resource',
					'error-deleting-property': 'Error deleting {name}',
					'attempting-to-delete-property': 'You are attempting to delete',
					'delete-property-modal-title': 'Deleting Property',
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
							'rent-day-price': 'Daily rent price',
							'rent-week-price': 'Weekly rent price',
							'rent-month-price': 'Monthly rent price',
							'rent-year-price': 'Yearly rent price',
						},
						sections: {
							'basic-info': 'Basic info',
							images: 'Images',
							listings: 'Listings',
						},
					},
				},
			},
		},
	},
}
