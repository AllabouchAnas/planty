var GSF_USER_META;
(function($) {
	"use strict";

	GSF_USER_META = {
		init: function() {
			this.headerToggle();
		},
		headerToggle: function () {
			$(document).on('click','.gsf-user-meta-header', function () {
				$(this).toggleClass('in');
				$(this).next().slideToggle();
			});
		}
	};
	$(document).ready(function() {
		GSF_USER_META.init();
	});
})(jQuery);