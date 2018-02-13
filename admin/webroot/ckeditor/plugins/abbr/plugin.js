CKEDITOR.plugins.add('abbr', {
	icons: 'abbr',
	init: function(editor) {
		editor.addCommand('abbr', new CKEDITOR.dialogCommand('abbrDialog'));
		editor.ui.addButton('Abbr', {
			label: 'Insert Abbreviation',
			command: 'abbr',
			toolbar: 'insert'
		});
	}
})
config.extraPlugins = 'abbr';