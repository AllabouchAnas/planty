(function ($) {
	'use strict';
	var UbeMasonryHandler = function ($scope, $) {
		var masonry_elem = $scope.find('.ube-gallery-masonry').eq(0);
		masonry_elem.imagesLoaded(function () {
			// init Isotope
			setTimeout(function () {
				var $grid = $('.ube-masonry-grid').isotope({
					itemSelector: '.ube-gallery-item',
					percentPosition: true,
					transitionDuration: 1500,
					masonry: {
						columnWidth: '.ube-gallery-item',
					}
				});
			}, 500);

		});

	};
	 window.addEventListener( 'elementor/frontend/init', () => {
		elementorFrontend.hooks.addAction('frontend/element_ready/ube-gallery-masonry.default', UbeMasonryHandler);
	});


})(jQuery);