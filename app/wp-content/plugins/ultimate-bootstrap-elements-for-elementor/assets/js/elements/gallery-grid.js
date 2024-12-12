(function ($) {
	'use strict';
	var UbeGalleryHandler = function ($scope, $) {
		var imageHoverEls = $scope.find('.ube-gallery-caption-hover').find('.card');
		if (imageHoverEls.length > 0) {
			$.each(imageHoverEls, function () {
				$(this).mouseenter(function () {
					UBE.animation.doAnimations($(this).find('[data-animation]'), false);
				});
			});
		}
	};
	 window.addEventListener( 'elementor/frontend/init', () => {
		elementorFrontend.hooks.addAction('frontend/element_ready/ube-gallery-grid.default', UbeGalleryHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/ube-gallery-masonry.default', UbeGalleryHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/ube-gallery-justified.default', UbeGalleryHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/ube-gallery-metro.default', UbeGalleryHandler);
	});


})(jQuery);