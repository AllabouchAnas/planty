(function ($) {
	'use strict';
	var Product_Tabs_Handler = function ($scope, $) {
		new G5_Core_Animation($scope);
		$('.gsf-pretty-tabs',$scope).gsfPrettyTabs({
			more_text : g5plus_variable.pretty_tabs_more_text
		});
	};
	$(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/lustria-product-tabs.default', Product_Tabs_Handler);
	});

})(jQuery);