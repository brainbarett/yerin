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
			update: 'Actualizar',
			updating: 'Actualizando',
			create: 'Crear',
			creating: 'Creando',
			delete: 'Delete',
			fields: {
				name: 'Nombre',
				password: 'Contraseña',
				email: 'Correo',
			},
			images: 'Imagenes',
			'image-upload': {
				upload: 'Subir Imagenes',
				'error-uploading': 'Error al subir {name} {error}',
			},
		},
	},

	menu: {
		'admin-accounts': 'Cuentas Admin',
		properties: 'Propiedades',
		'real-estate': 'Bienes Raices',
		system: 'Sistema',
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
				welcome: 'Bienvenido!',
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
				'error-deleting-account': 'Error eliminando {name}',
				'attempting-to-delete-account': 'Estás intentando eliminar',
				'delete-account-modal-title': 'Eliminando Cuenta Admin',
			},

			shared: {
				form: {
					fields: {
						'password-confirmation': 'Confirmación de contraseña',
					},
				},
			},
		},

		'real-estate': {
			properties: {
				index: {
					title: 'Gestionar Propiedades',
					'add-property-btn': 'Añadir una Propiedad',
				},

				create: {
					title: 'Crear una Propiedad',
				},

				edit: {
					title: 'Editar Propiedad',
					'error-fetching-property': 'Error cargando data',
					'error-deleting-property': 'Error eliminando {name}',
					'attempting-to-delete-property': 'Estás intentando eliminar',
					'delete-property-modal-title': 'Eliminando Propiedad',
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
							'rent-day-price': 'Precio de renta diaria',
							'rent-week-price': 'Precio de renta semanal',
							'rent-month-price': 'Precio de renta mensual',
							'rent-year-price': 'Precio de renta anual',
						},
						sections: {
							'basic-info': 'Información basica',
							images: 'Imagenes',
							listings: 'Anuncios',
						},
					},
				},
			},
		},
	},
}
