import { User } from '@/services/users'

export type Authorizable = {
	isSuperAdmin: boolean
	can: (permission: string) => boolean
}

export function makeAuthorizable(user: User): User & Authorizable {
	return {
		...user,
		isSuperAdmin: user.role.super_admin,
		can: function (permission: string) {
			return this.isSuperAdmin || this.role.permissions.includes(permission)
		},
	}
}
