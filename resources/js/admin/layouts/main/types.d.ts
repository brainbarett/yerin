import { RawLocation } from 'vue-router'

type NavigationMenuItem = {
	label: string
	routerLocation: RawLocation
	icon?: string | { name: string; set?: 'outline' | 'solid' | 'zondicons' }
	active?: boolean
}

type NavigationMenuList = {
	label: string
	items: NavigationMenuItem[]
}

type NavigationMenu = NavigationMenuList[]
