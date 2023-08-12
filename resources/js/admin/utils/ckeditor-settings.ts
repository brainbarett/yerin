import ClassicEditor from '@ckeditor/ckeditor5-build-classic'

export default {
	editor: ClassicEditor,
	config: {
		// prettier-ignore
		toolbar: [
			'undo', 'redo',
			'|', 'heading',
			//'|', 'fontColor', 'fontBackgroundColor',
			'|', 'bold', 'italic', //'strikethrough', 'subscript', 'superscript',
			'|', 'link', 'blockQuote', 'insertTable',
			//'|', 'alignment',
			'|', 'bulletedList', 'numberedList', 'outdent', 'indent',
		],
	},
}
