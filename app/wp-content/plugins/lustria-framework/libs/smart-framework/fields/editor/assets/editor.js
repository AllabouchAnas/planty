/**
 * editor field script
 *
 * @package field
 * @version 1.0
 * @author  g5plus
 */

/**
 * Define class field
 */
var GSF_EditorClass = function($container) {
	this.$container = $container;
};

(function($) {
	"use strict";

	/**
	 * Define class field prototype
	 */
	GSF_EditorClass.prototype = {
		init: function() {
			this.initNotExistEditor();
		},
		initNotExistEditor: function () {
			if (this.$container.find('.mce-tinymce').length == 0) {
				var $txt = this.$container.find('.wp-editor-area'),
					id = $txt.attr('id');
				if (typeof (tinyMCEPreInit) == "undefined") {
					return;
				}

				if (id in tinyMCEPreInit.mceInit) {
					try  {
						var newMceInit = JSON.parse(JSON.stringify(tinyMCEPreInit.mceInit[id]));
						tinymce.execCommand('mceRemoveEditor', false, id);
						tinymce.init(newMceInit);
					}
					catch (ex) {
					}

				}
				if (id in tinyMCEPreInit.qtInit) {
					var newQtInit = JSON.parse(JSON.stringify(tinyMCEPreInit.qtInit[id]));
					quicktags({id: id, buttons: newQtInit['buttons']});
					QTags._buttonsInit();
				}
			}
		},
		getValue: function () {
			return this.$container.find('[data-field-control]').val();
		}
	};

	var GSF_EditorObject = {
		cloneItem: function($container) {
			/**
			 * Replace Id, name, data-wp-editor-id
			 */
			var $editorTextArea = $container.find('.wp-editor-area'),
				textarea_name = $editorTextArea.attr('name'),
				id = textarea_name.replace(/[\[\]]/g, '__') + '__editor',
				oldId = $editorTextArea.attr('id');

			/**
			 * Wrapper div and media buttons
			 */
			$container.find('.wp-editor-wrap').attr('id', 'wp-' + id + '-wrap')
				.removeClass('html-active').addClass('tmce-active') // Active the visual mode by default
				.find('.wp-editor-tools').attr('id', 'wp-' + id + '-editor-tools')
				.find('.wp-media-buttons').attr('id', 'wp-' + id + '-media-buttons')
				.find('.insert-media').data('editor', id);

			/**
			 * Editor tabs
			 */
			$container.find('.switch-tmce')
				.attr('id', id + '-tmce')
				.data('wp-editor-id', id).attr('data-wp-editor-id', id).end()
				.find('.switch-html')
				.attr('id', id + '-html')
				.data('wp-editor-id', id).attr('data-wp-editor-id', id);

			/**
			 * Quick tags
			 */
			$container.find('.wp-editor-container').attr('id', 'wp-' + id + '-editor-container')
				.find('.quicktags-toolbar').attr('id', 'qt_' + id + '_toolbar').html('');

			/**
			 * Text area
			 */
			$container.find('.wp-editor-container').find('.wp-editor-area')
				.attr('id', id)
				.val('');


			//init tinymce
			if (oldId in tinyMCEPreInit.mceInit) {
				var newMceInit = JSON.parse(JSON.stringify(tinyMCEPreInit.mceInit[oldId]));

				newMceInit['body_class'] = newMceInit['body_class'].replace(oldId, id);
				newMceInit['selector'] = newMceInit['selector'].replace(oldId, id);
				tinyMCEPreInit.mceInit[id] = newMceInit;
				tinymce.execCommand('mceRemoveEditor', false, id);
				tinymce.init(newMceInit);
			}
			if (oldId in tinyMCEPreInit.qtInit) {
				var newQtInit = JSON.parse(JSON.stringify(tinyMCEPreInit.qtInit[oldId]));
				quicktags({id: id, buttons: newQtInit['buttons']});
				QTags._buttonsInit();
			}
		},
		onChange: function (i) {
			if (tinymce.editors[i].isChangeEvent == null) {
				tinymce.editors[i].isChangeEvent = true;
				tinymce.editors[i].on('change', function (e) {
					if (e.lastLevel != null) {
						this.save();
						$(this.container).closest('.gsf-field-content-inner').find('.wp-editor-area').trigger('gsf_field_control_changed');
					}
				});
			}

		},
		onChangeEditor: function() {
			setTimeout(
				function() {
					if (typeof(tinymce) !== 'undefined') {
						for ( var i = 0; i < tinymce.editors.length; i++ ) {
							GSF_EditorObject.onChange(i);
						}
					}
				}, 1000
			);
		}
	}

	$(document).on('gsf_add_clone_field', function(event) {
		var $container = $(event.target);
		if ($container.find('.gsf-field-editor-inner').length > 0) {
			GSF_EditorObject.cloneItem($(event.target));
			GSF_EditorObject.onChangeEditor();
		}
	});
	$(document).ready(function () {
		GSF_EditorObject.onChangeEditor();
	});

})(jQuery);