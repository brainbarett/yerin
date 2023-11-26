const mix = require('laravel-mix')
const tailwindcss = require('tailwindcss')
const tsconfigPathsPlugin = require('tsconfig-paths-webpack-plugin')

mix.extend(
	'i18n',
	new (class {
		webpackRules() {
			return [
				{
					resourceQuery: /blockType=i18n/,
					type: 'javascript/auto',
					loader: '@intlify/vue-i18n-loader',
				},
			]
		}
	})(),
)

mix.disableNotifications()
	.browserSync('http://127.0.0.1:8000')
	.i18n()
	.ts('resources/js/admin/app.ts', 'public/admin_panel/app.js')
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
