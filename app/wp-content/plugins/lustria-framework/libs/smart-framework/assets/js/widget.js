var GSF_WIDGET;
(function($) {
	"use strict";

	GSF_WIDGET = {
		init: function() {
			this.widgetUpdate();
			$(document).on('widget-added widget-updated', GSF_WIDGET.widgetUpdate);

		},
		widgetUpdate: function (event, $widget) {
			if ($widget == null) {
				return;
			}
			GSF.fields.initFields($widget.find('.gsf-meta-box-wrap'));
			$widget.find('.gsf-field').trigger('gsf_check_required');
			$widget.find('.gsf-field').trigger('gsf_check_preset');
		}
	};
	$(document).ready(function() {
		GSF_WIDGET.init();
	});
})(jQuery);