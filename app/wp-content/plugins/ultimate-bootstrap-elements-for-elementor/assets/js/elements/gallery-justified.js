(function ($) {
	'use strict';
	var UbeJustifiedHandler = function ($scope, $) {
		var dafault_settings = {
			rowHeight: 120,
			maxRowHeight: false,
			maxRowsCount: 0,
			sizeRangeSuffixes: {},
			lastRow: 'nojustify',
			thumbnailPath: undefined,
			captions: false,
			margins: 1,
			border: -1,
			waitThumbnailsLoad: true,
			randomize: false,
			filter: false,
			sort: false,
			rtl: false,
			selector: 'a, div:not(.spinner)',
			imgSelector: '> img, > a > img',
			extension: /.[^.]+$/,
			refreshTime: 250,
			refreshSensitivity: 0,
			rel: '',
			target: '',
			justifyThreshold: 0.75,
			cssAnimation: true,
			imagesAnimationDuration: 500,
			captionSettings: {
				animationDuration: 500,
				visibleOpacity: 0.7,
				nonVisibleOpacity: 0.0
			}


		};
		var $jutifiedWrapper = $scope.find('.ube-gallery-justified');
		var $options = $jutifiedWrapper.data('justified-settings');
		$options = $.extend({}, dafault_settings, $options);
		$jutifiedWrapper.imagesLoaded(function () {
			$jutifiedWrapper.find('.ube-gallery-justified-items').justifiedGallery($options);

		});


	};
	 window.addEventListener( 'elementor/frontend/init', () => {
		elementorFrontend.hooks.addAction('frontend/element_ready/ube-gallery-justified.default', UbeJustifiedHandler);
	});


})(jQuery);