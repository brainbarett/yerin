<template>
	<div
		class="box-border flex flex-col items-center justify-center w-full h-full p-6 bg-slate-100"
	>
		<div class="bg-white rounded shadow-md max-w-full w-[400px] overflow-hidden">
			<div class="pb-28 relative">
				<div class="h-28 bg-gray-600"></div>
				<div
					class="absolute top-1/2 -translate-y-1/2 left-1/2 -translate-x-1/2 bg-white rounded-full p-2 drop-shadow-lg"
				>
					<icon name="user-solid-circle" set="zondicons" class="w-28 h-28" />
				</div>
			</div>

			<formulate-form class="login-form" @submit="login" v-model="form" name="main">
				<h1 class="text-center text-2xl font-bold mb-6">
					{{ $t('routes.auth.login.title') }}
				</h1>

				<div class="login-form__input-container">
					<icon name="at-symbol" set="outline" class="login-form__input-icon" />
					<formulate-input
						name="email"
						:validation-name="$t('common.form.fields.email')"
						type="email"
						placeholder="email@hello.com"
						validation="required|email"
						@keyup.enter="$formulate.submit('main')"
					/>
				</div>

				<div class="login-form__input-container">
					<icon name="lock-closed" set="outline" class="login-form__input-icon" />
					<formulate-input
						name="password"
						:validation-name="$t('common.form.fields.password')"
						type="password"
						validation="required"
						@keyup.enter="$formulate.submit('main')"
					/>
				</div>

				<button
					@click="$formulate.submit('main')"
					type="button"
					class="relative flex items-center justify-center w-full p-2 text-white uppercase rounded bg-gray-900"
					:class="{ 'opacity-70': loading }"
					:disabled="loading"
				>
					{{ $t('common.auth.login') }}
					<loading-spinner v-if="loading" size="xs" color="white" class="ml-3" />
					<icon v-else name="arrow-right" set="outline" class="w-5 h-5 ml-2" />
				</button>

				<formulate-errors class="mt-2 text-center" />
			</formulate-form>
		</div>

		<div class="mt-2">
			<button type="button" @click="setLanguage('en')">English</button>
			<span>|</span>
			<button type="button" @click="setLanguage('es')">Español</button>
		</div>
	</div>
</template>

<script lang="ts">
	import Vue from 'vue'
	import AuthApi, { LoginRequest } from '@/services/auth'
	import { ErrorResponse, ValidationErrorResponse } from '@/services/http'
	import { AxiosResponse } from 'axios'
	import useLanguageStore from '@/stores/language'
	import { mapActions } from 'pinia'

	export default Vue.extend({
		data() {
			return {
				loading: false as Boolean,
				form: {} as LoginRequest,
			}
		},

		methods: {
			async login(form: LoginRequest) {
				this.loading = true
				this.$formulate.resetValidation('main')

				await AuthApi.login(form)
					.then(res => this.$router.push('/'))
					.catch((res: AxiosResponse) => {
						let inputErrors = {}

						if (res.status == 422) {
							inputErrors = (res.data as ValidationErrorResponse).errors
						}

						this.$formulate.handle(
							{
								formErrors: [(res.data as ErrorResponse).message],
								inputErrors,
							},
							'main',
						)
					})

				this.loading = false
			},

			...mapActions(useLanguageStore, ['setLanguage']),
		},
	})
</script>

<style lang="scss">
	.login-form {
		@apply box-border p-6 pt-0 -mt-5;

		&__input-container {
			@apply relative mb-4;
		}

		&__input-icon {
			@apply absolute w-5 h-5 text-gray-400 left-3 top-3;
		}

		input {
			@apply h-[unset] pl-10 text-base #{!important};
		}
	}
</style>
