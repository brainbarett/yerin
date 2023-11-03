import { Admin } from '@/services/admin'

export type Authorizable = {
	isSuperAdmin: boolean
	can: (permission: string) => boolean
}

export function makeAuthorizable(user: Admin): Admin & Authorizable {
	return {
		...user,
		isSuperAdmin: user.role.super_admin,
		can: function (permission: string) {
			return this.isSuperAdmin || this.role.permissions.includes(permission)
		},
	}
}
