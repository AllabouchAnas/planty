(function ($) {
	'use strict';

	var UbeImageComparisonHandler = function ($scope, $) {
		var $image_comparison = $scope.find(".ube-image-comparison");
		var $default_option = {
			default_offset_pct: 0.5,
			orientation: 'horizontal',
			before_label: 'Before',
			after_label: 'After',
			no_overlay: false,
			move_slider_on_hover: false,
			move_with_handle_only: true,
			click_to_move: false
		};
		var options = $image_comparison.data('options');
		options = $.extend({}, $default_option, options);
		$image_comparison.twentytwenty(
			options
		);

	};
	 window.addEventListener( 'elementor/frontend/init', () => {
		elementorFrontend.hooks.addAction('frontend/element_ready/ube-comparison.default', UbeImageComparisonHandler);
	});


})(jQuery);