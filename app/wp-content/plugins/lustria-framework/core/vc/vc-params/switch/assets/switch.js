(function ($) {
	"use strict";
	vc.atts.gsf_switch = {
		init: function (param, $field) {
			$field.find('.gsf_switch_field').on('change', function(){
				var $this = $(this);
				if($this.is(':checked')) {
					$this.attr('value', 'on');
				} else {
                    $this.attr('value', '');
				}
			});
		}
	}
})(jQuery);
