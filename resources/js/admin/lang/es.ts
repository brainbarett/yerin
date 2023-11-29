// eslint-disable-next-line import/no-default-export
export default {
	common: {
		language: 'Lenguaje',
		english: 'Ingles',
		spanish: 'Español',
		unauthorized: 'Acción no autorizada',
		'error-fetching-data': 'Error cargando data',
		'error-deleting-resource': "Error eliminando '{name}'",
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
			'upload-image': 'Subir Imagenes',
			fields: {
				name: 'Nombre',
				email: 'Correo',
				description: 'Descripción',
				images: 'Imagenes',
			},
			messages: {
				'error-uploading-image': "Error al subir '{name}' {error}",
			},
		},
		country: 'Pais',
		state: 'Estado',
		city: 'Ciudad',
		sector: 'Sector',
		location: 'Ubicación',
	},

	menu: {
		users: 'Usuarios',
		properties: 'Propiedades',
		'real-estate': 'Bienes Raices',
		system: 'Sistema',
		roles: 'Roles',
		amenities: 'Amenidades',
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
			'attempting-to-delete-resource':
				'Estás intentando eliminar <span class="underline">{name}</span>',
			'type-confirm-to-delete': "Por favor escribe 'confirmar' para eliminar",
			'confirm-keyword': 'confirmar',
		},
	},

	routes: {
		auth: {
			login: {
				title: 'Bienvenid@!',
				form: {
					fields: {
						password: 'Contraseña',
					},
					login: 'Iniciar sesión',
					logout: 'Cerrar sesión',
				},
			},

			profile: {
				title: 'Mi Cuenta',
				'account-info': 'Información',
				form: {
					'update-password': 'Cambiar contraseña',
					fields: {
						'old-password': 'Contraseña actual',
						'new-password': 'Nueva contraseña',
						'new-password-confirmation': 'Confirmación de contraseña',
					},
					messages: {
						'update-password-success': 'Contraseña cambiada con éxito',
						'update-account-success': 'Cuenta actualizada con éxito',
					},
				},
			},
		},

		users: {
			index: {
				title: 'Gestionar Usuarios',
				'add-user': 'Añadir Usuario',
			},

			create: {
				title: 'Crear Usuario',
			},

			edit: {
				title: 'Editar Usuario',
				'delete-user-modal-title': 'Eliminar Usuario',
			},

			shared: {
				form: {
					'update-password': 'Cambiar contraseña',
					fields: {
						password: 'Contraseña',
						'password-confirmation': 'Confirmación de contraseña',
						'new-password': 'Contraseña nueva',
						'new-password-confirmation': 'Confirmación de contraseña',
						role: 'Rol',
					},
				},
				messages: {
					'update-password-success': 'Contraseña cambiada con éxito',
				},
			},
		},

		roles: {
			index: {
				title: 'Gestionar Roles y Permisos',
				'add-role': 'Añadir Rol',
			},

			create: {
				title: 'Crear Rol',
			},

			edit: {
				title: 'Editar Rol',
				'delete-role-modal-title': 'Eliminar Rol',
			},

			shared: {
				permissions: {
					view: 'Ver',
					write: 'Escribir',
					delete: 'Eliminar',
				},
				form: {
					fields: {
						permissions: 'Permisos',
					},
				},
			},
		},

		'real-estate': {
			properties: {
				index: {
					title: 'Gestionar Propiedades',
					'add-property': 'Añadir Propiedad',
				},

				create: {
					title: 'Crear Propiedad',
				},

				edit: {
					title: 'Editar Propiedad',
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

			amenities: {
				index: {
					title: 'Gestionar Amenidades',
					'add-amenity': 'Añadir Amenidad',
					'delete-amenity-modal-title': 'Eliminar Amenidad',
					'create-amenity-success': 'Amenidad creada con éxito',
					'update-amenity-success': 'Amenidad actualizada con éxito',
					'destroy-amenity-success': 'Amenidad eliminada con éxito',
				},
			},
		},
	},
}
