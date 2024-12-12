(function ($) {
	"use strict";
	vc.atts.gsf_selectize = {
		init: function (param, $field) {
			var $selectField = $field.find('[data-selectize="true"]'),
				config = {
					plugins: ['remove_button','drag_drop'],
					onChange: function() {
					}
				};

			if ($selectField.data('tags')) {
				config.create = true;
				config.persist = false;
			}

			var $select = $selectField.selectize(config);
			var control = $select[0].selectize;
			var val = $selectField.data('value');
			if (typeof (val) !== "undefined") {
				control.setValue(val);
			}

            $field.closest('[data-vc-ui-element="panel-shortcode-param"]').data('vcInitParam',true);
		},
        parse: function(param) {
            var $field = this.content().find(".wpb_vc_param_value[name=" + param.param_name + "]"),
				value = $field.val();
			if (value === null) {
				value = '';
			}
			return value;
        }

	}
})(jQuery);
