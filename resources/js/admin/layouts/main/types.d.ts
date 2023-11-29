import { AuthUser } from '@/stores/auth'
import { RawLocation } from 'vue-router'

type NavigationMenuItem = {
	label: string
	routerLocation: RawLocation
	icon?: string | { name: string; set?: 'outline' | 'solid' | 'zondicons' }
	active?: boolean
	show?: (user: AuthUser) => boolean
}

type NavigationMenuList = {
	label: string
	items: NavigationMenuItem[]
	show?: (user: AuthUser) => boolean
}

type NavigationMenu = NavigationMenuList[]
