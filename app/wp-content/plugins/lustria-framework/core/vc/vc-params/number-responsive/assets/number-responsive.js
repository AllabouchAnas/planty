(function ($) {
	"use strict";
	vc.atts.gsf_number_responsive = {
		init: function (param, $field) {
			var $inputField = $field.find('.gsf_number_responsive_field');
			$field.find('.gsf-vc-number-responsive-field').on('change',function(){
				var value = '';
				$field.find('.gsf-vc-number-responsive-field').each(function(){
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
