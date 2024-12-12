(function ($) {
	"use strict";
	vc.atts.gsf_number_and_unit = {
		init: function (param, $field) {
			var $inputField = $field.find('.gsf_number_and_unit_field');
			$field.find('.gsf-vc-number-and-unit-field').on('change',function(){
				var value = '';
				$field.find('.gsf-vc-number-and-unit-field').each(function(){
                    if (value === '') {
                        value += $(this).val();
                    } else  {
                        value += '|' + $(this).val();
                    }
				});
				$inputField.val(value);
			});
		}

	}
})(jQuery);
