import { User } from '@/stores/auth'
import { RawLocation } from 'vue-router'

type NavigationMenuItem = {
	label: string
	routerLocation: RawLocation
	icon?: string | { name: string; set?: 'outline' | 'solid' | 'zondicons' }
	active?: boolean
	show?: (user: User) => boolean
}

type NavigationMenuList = {
	label: string
	items: NavigationMenuItem[]
	show?: (user: User) => boolean
}

type NavigationMenu = NavigationMenuList[]
