import { ErrorResponse, ValidationErrorResponse } from '@/services/http'
import { FormulateErrors } from '@braid/vue-formulate'

export function formulateHandleApiPlugin(instance: any) {
	instance.handleApi = function (
		response: ErrorResponse | ValidationErrorResponse,
		formName: string,
	): void | typeof Error {
		const errors: FormulateErrors = {
			formErrors: [response.message],
		}

		if (Object.hasOwn(response, 'errors')) {
			errors.inputErrors = (response as ValidationErrorResponse).errors
		}

		instance.handle(errors, formName)
	}
}
