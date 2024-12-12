(function ($) {
	'use strict';
	var Product_Tbas_Slider_Handler = function ($scope, $) {
		new G5_Core_Animation($scope);
		G5_Core.owlCarousel.init($scope);
		$('.gsf-pretty-tabs',$scope).gsfPrettyTabs({
			more_text : g5plus_variable.pretty_tabs_more_text
		});
	};
	$(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/lustria-product-tabs-slider.default', Product_Tbas_Slider_Handler);
	});

})(jQuery);