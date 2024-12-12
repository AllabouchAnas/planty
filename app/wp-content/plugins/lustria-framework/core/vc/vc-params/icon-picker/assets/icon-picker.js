(function ($) {
	"use strict";

	vc.atts.gsf_icon_picker = {
		init: function (param, $field) {
			var $iconField = $field.find('.gsf_icon_picker_field');

			$field.find('.gsf-add-icon').on('click',function() {
				GSF_ICON_POPUP.open($iconField.val(), function(icon) {
					$iconField.val(icon);
					$field.find('.selected-icon > i').attr('class',icon);
                    $field.find('.gsf-remove-icon').show();
                    $iconField.trigger('change');
				});
			});

            $field.find('.gsf-remove-icon').on('click',function() {
                $iconField.val('');
                $field.find('.selected-icon > i').attr('class','');
                $(this).hide();
                $iconField.trigger('change');
            });
		}
	}
})(jQuery);