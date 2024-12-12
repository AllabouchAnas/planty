(function ($) {
	'use strict';
	var UbeSampleHandler = function( $scope, $ ) {
		var $text = $scope.find('.ube-sample-text');
		$text.on('click', function () {
			$(this).text('Changed Text');
		});
	};
	$( window ).on( 'elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/ube-sample.default', UbeSampleHandler );
	} );
})(jQuery);