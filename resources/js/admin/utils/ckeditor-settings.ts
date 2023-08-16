import ClassicEditor from '@ckeditor/ckeditor5-build-classic'
import '@ckeditor/ckeditor5-build-classic/build/translations/es'

export default {
	editor: ClassicEditor,
	config: {
		// prettier-ignore
		toolbar: [
			'heading',
			//'|', 'fontColor', 'fontBackgroundColor',
			'|', 'bold', 'italic', //'strikethrough', 'subscript', 'superscript',
			'|', 'link', 'blockQuote', 'insertTable',
			//'|', 'alignment',
			'|', 'bulletedList', 'numberedList', 'outdent', 'indent',
		],
	} as any,
}
