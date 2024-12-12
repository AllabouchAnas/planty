(function ($) {
	"use strict";
	vc.atts.gsf_image_set = {
		init: function (param, $field) {
			var $inputField = $field.find('.gsf_image_set_field');
			$field.find('.gsf-vc-image-set-wrapper').on('click', '.gsf-vc-image-set-item',function(){
				var $this = $(this);
				if($this.hasClass('current')) {
					return false;
				}
				var value = $this.attr('data-value');
				$this.parent().children('.current').removeClass('current');
				$this.addClass('current');

				$inputField.val(value);
				$inputField.trigger('change');
			});
		}
	}
})(jQuery);
