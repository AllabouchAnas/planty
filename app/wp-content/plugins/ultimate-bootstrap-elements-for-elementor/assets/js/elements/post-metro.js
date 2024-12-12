(function ($) {
	'use strict';
	var UbePostMetroHandler = function ($scope, $) {
		var $content = $scope.find('.ube-entry-content');
		$scope.find('.ube-post-metro-layout-02').hover(function (e) {
			$(this).find('.ube-entry-content').slideToggle('slow', function () {
			});
			e.preventDefault();

		});

	};
	 window.addEventListener( 'elementor/frontend/init', () => {
		elementorFrontend.hooks.addAction('frontend/element_ready/ube-post-metro.default', UbePostMetroHandler);
	});

})(jQuery);

