const mix = require('laravel-mix')
const tailwindcss = require('tailwindcss')
const tsconfigPathsPlugin = require('tsconfig-paths-webpack-plugin')

mix.disableNotifications()
	.ts('resources/js/admin/main.ts', 'public/admin_panel/app.js')
	.vue()
	.sass('resources/sass/admin.scss', 'public/admin_panel/main.css')
	.options({
		processCssUrls: false,
		postCss: [tailwindcss('tailwind.config.js')],
	})
	.webpackConfig({
		resolve: {
			plugins: [new tsconfigPathsPlugin({ configFile: 'resources/js/admin/tsconfig.json' })],
		},
	})
