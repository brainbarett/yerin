// eslint-disable-next-line import/no-default-export
export default {
	common: {
		language: 'Language',
		english: 'English',
		spanish: 'Spanish',
		unauthorized: 'Unauthorized',
		'error-fetching-data': 'Error fetching data',
		'error-deleting-resource': "Error deleting '{name}'",
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
			'upload-image': 'Upload Images',
			fields: {
				name: 'Name',
				email: 'Email',
				description: 'Description',
				images: 'Images',
			},
			messages: {
				'error-uploading-image': "Error uploading '{name}' {error}",
			},
		},
		country: 'Country',
		state: 'State',
		city: 'City',
		sector: 'Sector',
		location: 'Location',
	},

	menu: {
		users: 'Users',
		properties: 'Properties',
		'real-estate': 'Real Estate',
		system: 'System',
		roles: 'Roles',
		amenities: 'Amenities',
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
			'attempting-to-delete-resource':
				'You are attempting to delete <span class="underline">{name}</span>',
			'type-confirm-to-delete': "Please type 'confirm' to delete",
			'confirm-keyword': 'confirm',
		},
	},

	routes: {
		auth: {
			login: {
				title: 'Welcome back!',
				form: {
					fields: {
						password: 'Password',
					},
					login: 'Log in',
					logout: 'Log out',
				},
			},

			profile: {
				title: 'My Account',
				'account-info': 'Account Info',
				form: {
					'update-password': 'Change password',
					fields: {
						'old-password': 'Current password',
						'new-password': 'New password',
						'new-password-confirmation': 'New password confirmation',
					},
					messages: {
						'update-password-success': 'Password update successful',
						'update-account-success': 'Account info update successful',
					},
				},
			},
		},

		users: {
			index: {
				title: 'Manage Users',
				'add-user': 'Add a User',
			},

			create: {
				title: 'Create a User',
			},

			edit: {
				title: 'Edit User',
				'delete-user-modal-title': 'Delete User',
			},

			shared: {
				form: {
					'update-password': 'Change password',
					fields: {
						password: 'Password',
						'password-confirmation': 'Password confirmation',
						'new-password': 'New password',
						'new-password-confirmation': 'New password confirmation',
						role: 'Role',
					},
					messages: {
						'update-password-success': 'Password update successful',
					},
				},
			},
		},

		roles: {
			index: {
				title: 'Manage Roles and Permissions',
				'add-role': 'Add a Role',
			},

			create: {
				title: 'Create a Role',
			},

			edit: {
				title: 'Edit Role',
				'delete-role-modal-title': 'Delete Role',
			},

			shared: {
				permissions: {
					view: 'View',
					write: 'Write',
					delete: 'Delete',
				},
				form: {
					fields: {
						permissions: 'Permissions',
					},
				},
			},
		},

		'real-estate': {
			properties: {
				index: {
					title: 'Manage Properties',
					'add-property': 'Add a Property',
				},

				create: {
					title: 'Create a Property',
				},

				edit: {
					title: 'Edit Property',
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

			amenities: {
				index: {
					title: 'Manage Amenities',
					'add-amenity': 'Add Amenity',
					'delete-amenity-modal-title': 'Delete Amenity',
					'create-amenity-success': 'Amenity successfully created',
					'update-amenity-success': 'Amenity successfully updated',
					'destroy-amenity-success': 'Amenity successfully deleted',
				},
			},
		},
	},
}
