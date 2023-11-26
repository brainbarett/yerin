<template>
	<div
		class="box-border flex flex-col items-center justify-center w-full min-h-full p-6 bg-gray-100"
	>
		<div class="bg-white rounded shadow-md max-w-full w-[400px] overflow-hidden">
			<div class="relative pb-28">
				<div class="bg-gray-600 h-28"></div>
				<div
					class="absolute p-2 text-gray-600 -translate-x-1/2 -translate-y-1/2 bg-white rounded-full top-1/2 left-1/2 drop-shadow-lg"
				>
					<icon name="user-solid-circle" set="zondicons" class="w-28 h-28" />
				</div>
			</div>

			<formulate-form class="login-form" @submit="login" v-model="form" name="main">
				<h1 class="mb-6 text-2xl font-bold text-center">
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
						:validation-name="$t('routes.auth.login.form.fields.password')"
						type="password"
						validation="required"
						@keyup.enter="$formulate.submit('main')"
					/>
				</div>

				<Button
					@click="$formulate.submit('main')"
					:loading="loading"
					:disabled="loading"
					:label="$t('routes.auth.login.form.login')"
					icon="arrow-right"
					class="w-full"
				/>
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
	import Button from '@/components/Button.vue'
	import { AuthApi, LoginRequest } from '@/services/auth'
	import { ErrorResponse } from '@/services/http'
	import { AxiosResponse } from 'axios'
	import { useUiStore } from '@/stores/ui'
	import { mapActions } from 'pinia'

	export default Vue.extend({
		components: { Button },

		data() {
			return {
				loading: false as boolean,
				form: {
					email: 'admin@test.com',
					password: 'password',
				} as LoginRequest,
			}
		},

		methods: {
			async login(form: LoginRequest) {
				this.loading = true
				this.$formulate.resetValidation('main')

				await AuthApi.login(form)
					.then(() => this.$router.push('/'))
					.catch((res: AxiosResponse<ErrorResponse>) => {
						this.$formulate.handleApi(res.data, 'main')
					})

				this.loading = false
			},

			...mapActions(useUiStore, ['setLanguage']),
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
