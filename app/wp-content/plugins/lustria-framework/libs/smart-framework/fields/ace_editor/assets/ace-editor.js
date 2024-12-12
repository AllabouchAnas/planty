/**
 * ace-editor field script
 *
 * @package field
 * @version 1.0
 * @author  g5plus
 */

var GSF_Ace_editorClass = function($container) {
	this.$container = $container;
};
(function($) {
	"use strict";

	/**
	 * Define class field prototype
	 */
	GSF_Ace_editorClass.prototype = {
		init: function() {
			this.$fieldText = this.$container.find('textarea');
			this.$editorField = this.$container.find('.gsf-ace-editor');
			var params = this.$fieldText.data('options'),
				mode = this.$fieldText.data('mode'),
				theme = this.$fieldText.data('theme');
			this.editor = ace.edit(this.$editorField.attr('id'));
			this.$editorField.attr('id', '');
			if (mode != '') {
				this.editor.session.setMode('ace/mode/' + mode);
			}
			if (theme != '') {
				this.editor.setTheme('ace/theme/' + theme);
			}

			this.editor.setAutoScrollEditorIntoView(true);
			this.editor.setOptions(params);
			var self = this;
			this.editor.on('change', function (event) {
				self.$fieldText.val(self.editor.getSession().getValue());

				var $field = self.$container.closest('.gsf-field');
				$field.find('[data-field-control]').trigger('gsf_field_control_changed');
			});
		},
		getValue: function() {
			return this.$container.find('[data-field-control]').val();
		}
	};
})(jQuery);