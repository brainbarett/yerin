import ClassicEditor from '@ckeditor/ckeditor5-build-classic'
import '@ckeditor/ckeditor5-build-classic/build/translations/es'

export const CKEditorSettings = {
	editor: ClassicEditor,
	config: {
		// prettier-ignore
		toolbar: {
			items: [
				'heading',
				//'|', 'fontColor', 'fontBackgroundColor',
				'|', 'bold', 'italic', //'strikethrough', 'subscript', 'superscript',
				'|', 'link', 'blockQuote', 'insertTable',
				//'|', 'alignment',
				'|', 'bulletedList', 'numberedList', 'outdent', 'indent',
			],
			
			shouldNotGroupWhenFull: true,
		},
	} as any,
}
