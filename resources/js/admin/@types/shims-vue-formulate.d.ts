/** @see https://gist.github.com/IlCallo/cc9cacdec7d379c0fc9aa03dca14213c */
declare module '@braid/vue-formulate' {
	import { PluginObject } from 'vue'

	export interface Context {
		/** The label to display inside "add more" button on group inputs. */
		addLabel: string
		/** An object of non-prop attributes passed to the input like placeholder. */
		attributes: any
		/** Function that must be called when an input blurs. */
		blurHandler: () => void
		/** The classification of the input. */
		classification: string
		/** Boolean indicating if errors should be displayed for this field (defaults to false). */
		disableErrors: boolean
		/**
		 * Errors set via the form error handling or directly on the input itself via error or errors props.
		 * Does not include validation errors.
		 */
		errors: string[]
		/** Boolean indicates if the field has a valid value. */
		hasValue: boolean
		/** Boolean indicating if the field has a label prop, button classification is always false. */
		hasLabel: boolean
		/** Function, returns a Promise that resolves to a Boolean. */
		hasValidationErrors: () => Promise<boolean>
		/** The help prop value (help text) */
		help: string
		/** The position of the help text, before or after the element wrapper. Defaults to before. */
		helpPosition: string
		/** Function, returns a Promise that resolves to an array of validation error objects. */
		getValidationErrors: () => Promise<string[]>
		/** The id prop or an auto-generated id. */
		id: string
		/** Boolean indicating if the field has no errors at all (visible or not) */
		isValid: boolean
		/** The value of the image-behavior prop. Defaults to preview. */
		imageBehavior: string
		/** A function that returns a boolean indicating if it is a descendant of a group type. */
		isSubField: () => boolean
		/** The value of the label prop. */
		label: string
		/** The position of the label, before or after. Default is before for all except box classified inputs. Can be overridden with label-position prop. */
		labelPosition: string
		/** For a group type, this is the is the maximum number of repeatable items allowed (default is Infinity). */
		limit: number
		/** For a group type, this is the minimum number of repeatable items allowed (default is 0). */
		minimum: number
		/** The value of the current field, bound to a setter. */
		model: any
		/** The name of the field, if none is set, it auto-generates a name. */
		name: string
		/** The options prop converted to an array (when applicable). */
		options: []
		/** Function that will run validation. This is executed on every input automatically. */
		performValidation: () => Promise<any>
		/** true by default, this prevents the browser from navigating to a file when the user misses the dropzone. */
		preventWindowDrops: boolean
		/** The label to display inside "remove" button on group inputs. */
		removeLabel: string
		/** Boolean indicating if a field is repeatable or not. */
		repeatable: boolean
		/** Function identical to $emit, but should be used in custom inputs and slots to emit events from the root <FormulateInput>. */
		rootEmit: () => any
		/** Function to set (or clear) the current errors (not validation errors). */
		setErrors: () => void
		/** Boolean, true if the validation errors should be displayed. */
		showValidationErrors: boolean
		/** The type of input. */
		type: string
		/** The upload-behavior prop, live or delayed. */
		uploadBehavior: 'live' | 'delayed'
		/** Uploader function. uploader prop, axios, or uploader defined when initializing. */
		uploader: () => void
		/** The upload-url prop, or the uploadUrl defined when initializing. */
		uploadUrl: string
		/** An array of the current validation errors irregardless of their visibility. */
		validationErrors: string[]
		/**
		 * The value prop, not the current value of the field. This is the exact value passed into the value prop,
		 * usually used to set the initial value of the field.
		 */
		value: any
		/** Array of the current validation errors being displayed. */
		visibleValidationErrors: string[]
	}

	export interface ValidationEventPayload {
		name: string
		errors: string[]
		hasErrors: boolean
	}

	export interface FormulateErrors {
		inputErrors?: Record<string, string | string[]>
		formErrors?: string[]
	}

	export interface FormulateGlobalInstance {
		handle: (err: FormulateErrors, formName: string, skip?: boolean) => void | typeof Error
		reset: <V>(formName: string, initialValue?: V) => void
		resetValidation: (formName: string) => void
		setValues: <V>(formName: string, values: V) => void
		submit: (formName: string) => void
		setLocale: (locale: string) => void
		handleApi: (
			response:
				| import('@/services/http').ErrorResponse
				| import('@/services/http').ValidationErrorResponse,
			formName: string,
		) => void | typeof Error
	}

	// eslint-disable-next-line @typescript-eslint/no-empty-interface
	interface VueFormulateOptions {
		// TODO: see https://github.com/wearebraid/vue-formulate/blob/10ab31b4939323ed9d61cf810eddc676c4242bd1/src/Formulate.js#L43
	}

	const VueFormulate: PluginObject<VueFormulateOptions>
	// eslint-disable-next-line import/no-default-export
	export default VueFormulate
}
