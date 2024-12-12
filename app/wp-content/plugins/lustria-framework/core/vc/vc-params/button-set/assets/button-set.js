(function ($) {
	"use strict";
	vc.atts.gsf_button_set = {
		init: function (param, $field) {
			var $inputField = $field.find('.gsf_button_set_field');
			$field.find('.gsf-field-button_set-field').on('change',function(){
				var value = '';
				$field.find('.gsf-field-button_set-field').each(function(){
					if ($(this).is(':checked')) {
						if (value === '') {
							value += $(this).val();
						} else  {
							value += ',' + $(this).val();
						}
					}
				});
				$inputField.val(value);
				$inputField.trigger('change');
			});
		}
	}
})(jQuery);
