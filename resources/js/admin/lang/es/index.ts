export default {
	common: {
		language: 'Lenguaje',
		english: 'Ingles',
		spanish: 'Español',
		auth: {
			login: 'Iniciar sesión',
			logout: 'Cerrar sesión',
		},
		form: {
			add: 'Añadir',
			update: 'Actualizar',
			updating: 'Actualizando',
			create: 'Crear',
			creating: 'Creando',
			delete: 'Delete',
			save: 'Guardar',
			saving: 'Guardando',
			cancel: 'Cancelar',
			fields: {
				name: 'Nombre',
				password: 'Contraseña',
				email: 'Correo',
				description: 'Descripción',
				images: 'Imagenes',
			},
			'image-upload': {
				upload: 'Subir Imagenes',
				'error-uploading': 'Error al subir {name} {error}',
			},
			'change-password': 'Cambiar contraseña',
		},
		country: 'Pais',
		state: 'Estado',
		city: 'Ciudad',
		sector: 'Sector',
		location: 'Ubicación',
	},

	menu: {
		'admin-accounts': 'Cuentas Admin',
		properties: 'Propiedades',
		'real-estate': 'Bienes Raices',
		system: 'Sistema',
	},

	'real-estate': {
		'property-types': {
			house: 'Casa',
			villa: 'Villa',
			apartment: 'Apartmento',
			penthouse: 'Penthouse',
		},
	},

	'data-table': {
		pagination: {
			'from-to-total': 'Enseñando del {from} al {to} de {total} entradas',
			'showing-amount-of-total': 'Enseñando {amount} de {total} entradas',
			'showing-amount': 'Enseñando {amount} entradas',
		},
	},

	modals: {
		'delete-resource': {
			'type-confirm-to-delete': "Por favor escribe 'confirmar' para eliminar",
			'confirm-keyword': 'confirmar',
			delete: 'ELIMINAR',
		},
	},

	routes: {
		auth: {
			login: {
				title: 'Bienvenid@!',
			},
		},

		admin: {
			index: {
				title: 'Gestionar Cuentas Admin',
				'add-admin-btn': 'Añadir una Cuenta Admin',
				'error-fetching-data': 'Error cargando data de la tabla',
			},

			create: {
				title: 'Crear una Cuenta Admin',
			},

			edit: {
				title: 'Editar Cuenta Admin',
				'error-fetching-account': 'Error cargando data',
				'error-deleting-account': "Error eliminando '{name}'",
				'attempting-to-delete-account':
					'Estás intentando eliminar <span class="underline">{name}</span>',
				'delete-account-modal-title': 'Eliminar Cuenta Admin',
			},

			shared: {
				form: {
					fields: {
						'password-confirmation': 'Confirmación de contraseña',
					},
				},
				messages: {
					'password-successfully-updated': 'Contraseña cambiada con éxito',
				},
			},
		},

		'real-estate': {
			properties: {
				index: {
					title: 'Gestionar Propiedades',
					'add-property-btn': 'Añadir una Propiedad',
					'error-fetching-data': 'Error cargando data de la tabla',
				},

				create: {
					title: 'Crear una Propiedad',
				},

				edit: {
					title: 'Editar Propiedad',
					'error-fetching-property': 'Error cargando data',
					'error-deleting-property': "Error eliminando '{name}'",
					'attempting-to-delete-property':
						'Estás intentando eliminar <span class="underline">{name}</span>',
					'delete-property-modal-title': 'Eliminar Propiedad',
				},

				shared: {
					available: 'Disponible',
					'not-available': 'No disponible',
					form: {
						fields: {
							reference: 'Referencia',
							'property-type': 'Tipo',
							availability: 'Disponibilidad',
							bedrooms: 'Habitaciones',
							'full-bathrooms': 'Baños completos',
							'half-bathrooms': 'Medio baños',
							'lot-area': 'Area del lote',
							'construction-area': 'Area de la construcción',
							'construction-year': 'Año de construcción',
							'sale-price': 'Precio de venta',
							'rent-terms': 'Precios de renta',
							'rent-day': 'Día',
							'rent-week': 'Semana',
							'rent-month': 'Mes',
							'rent-year': 'Año',
							'rent-day-price': 'Precio de renta diaria',
							'rent-week-price': 'Precio de renta semanal',
							'rent-month-price': 'Precio de renta mensual',
							'rent-year-price': 'Precio de renta anual',
						},
						sections: {
							'basic-info': 'Información basica',
							amenities: 'Amenidades',
							images: 'Imagenes',
							listings: 'Anuncios',
						},
					},
				},
			},
		},
	},
}
