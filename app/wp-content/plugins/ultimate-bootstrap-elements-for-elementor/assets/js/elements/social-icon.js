
(function ($) {
	'use strict';
	var UbeIconBoxHandler = function( $scope, $ ) {
		$('[data-toggle="tooltip"]').tooltip();
	};
	$( window ).on( 'elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/ube-social-icon.default', UbeIconBoxHandler );
		elementorFrontend.hooks.addAction( 'frontend/element_ready/ube-social-share.default', UbeIconBoxHandler );
	} );
})(jQuery);