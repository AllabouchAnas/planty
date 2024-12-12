(function ($) {
	'use strict';
	var UbeOffCanvasHandler = function( $scope, $ ) {
		var $offcanvas = $scope.find('.btn-canvas'),
			$menu_id = $scope.find('.offcanvas-menu');

		$($offcanvas).on('click', function (e) {
			e.preventDefault();
			var $this = $(this);
			if ($this.hasClass('active') && $($menu_id).hasClass('show-nav')) {
				$this.removeClass('active');
				$($menu_id).removeClass('show-nav');
				$('body').removeClass('show-overlay');
			}
			else {
				$($this).removeClass('active');
				$this.addClass('active');
				$('.offcanvas-menu').removeClass('show-nav');
				$($menu_id).addClass('show-nav');
				$('body').addClass('show-overlay');
			}
		});

		$('.canvas-closebtn').on('click', function (e) {
			e.preventDefault();
			$($offcanvas).removeClass('active');
			$($menu_id).removeClass('show-nav');
			$('body').removeClass('show-overlay');
		});

		$('body').on('click', function (e) {
			var $target = e.target;
			if (!$($target).is('.btn-canvas') && !$($target).parents().is('.offcanvas-menu') && !$($target).is('.offcanvas-menu')) {
				$($offcanvas).removeClass('active');
				$('.offcanvas-menu').removeClass('show-nav');
				$('body').removeClass('show-overlay');
			}
		});

	};
	$( window ).on( 'elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/ube-offcanvas.default', UbeOffCanvasHandler );
	} );
})(jQuery);