(function ($) {
	"use strict";
	vc.atts.gsf_responsive = {
		init: function (param, $field) {
			var $inputField = $field.find('.gsf_responsive_field');
			$field.find('.gsf-vc-responsive-field').on('change',function(){
				var value = '';
				$field.find('.gsf-vc-responsive-field').each(function(){
					if ($(this).is(':checked')) {
						if (value === '') {
							value += $(this).attr('name');
						} else  {
							value += ' ' + $(this).attr('name');
						}
					}
				});
				$inputField.val(value);
			});
		}

	}
})(jQuery);
