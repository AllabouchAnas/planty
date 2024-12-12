(function ($) {
	'use strict';
	var UbeTabsHandler = function ($scope, $) {
		var $tabs = $scope.find('.collapse-tabs');
		$tabs.find('.nav-link').on('show.bs.tab', function (e) {
			var current_tabs = $(this).closest('.collapse-tabs');
			var $navItemClass = 'active';
			current_tabs.find('.ube-tabs-card-title').attr('data-toggle', 'collapse');
			current_tabs.find('.nav-item').removeClass($navItemClass);
			var $navItem = $(this).parent('.nav-item');
			$navItem.addClass($navItemClass);
			current_tabs.find('.ube-tabs-card').removeClass('active');
			current_tabs.find('> .tab-content >.ube-tab-content-container > .tab-pane > .ube-tabs-card > .collapsible').removeClass('show');
			current_tabs.find('[data-toggle="collapse"]').addClass('collapsed');
			var $tabpane = $($(this).attr('href'));
			var $collapse = $tabpane.find('.ube-tabs-card-title');
			$collapse.attr('data-toggle', 'false');
			$tabpane.find('.ube-tabs-card').addClass('active');
			$tabpane.find('> .ube-tabs-card > .ube-tabs-card-header > [data-toggle="collapse"]').removeClass('collapsed');
			$tabpane.find('> .ube-tabs-card >  .collapsible').addClass('show');
			if ($tabpane.find('.slick-slider').length > 0) {
				$tabpane.find('.slick-slider').slick('refresh');
			}

		});
		$tabs.find('.collapsible').on('show.bs.collapse', function () {
			var $navItemClass = 'active';
			$tabs.find('.ube-tabs-card-title').attr('data-toggle', 'collapse');
			$tabs.find('.tab-pane').removeClass('show active');
			$tabs.find('.nav-item').removeClass($navItemClass);
			$tabs.find('.nav-link').removeClass($navItemClass);
			$tabs.find('.ube-tabs-card').removeClass('active');
			var $parent = $(this).parents('.tab-pane');
			var $collapse = $parent.find('.ube-tabs-card-title');
			$collapse.attr('data-toggle', 'false');
			$parent.addClass('show active');
			$parent.find('.ube-tabs-card').toggleClass('active');
			$parent.parents('.collapse-tabs').find('.nav-link').removeClass('active');
			var $id = $parent.attr('id');
			var $navItem = $parent.parents('.collapse-tabs').find('[href="#' + $id + '"]').parent('.nav-item');
			$navItem.addClass($navItemClass);
			$navItem.find('.nav-link').addClass($navItemClass);
			$parent.parents('.collapse-tabs').find('[data-target="#' + $id + '"]').toggleClass('active');
			if ($parent.find('.slick-slider').length > 0) {
				$parent.find('.slick-slider').slick('refresh');
			}

		});
		$tabs.find('.collapsible').on('hide.bs.collapse', function () {
			var $id = $(this).attr('id');
			var $parent = $(this).parents('.ube-tabs');
			var $current = $parent.find('[href="#' + $id + '"]');
			$current.parents('.ube-tabs-card').removeClass('active');
		});
	};
	 window.addEventListener( 'elementor/frontend/init', () => {
		elementorFrontend.hooks.addAction('frontend/element_ready/ube-tabs.default', UbeTabsHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/ube-advanced-tabs.default', UbeTabsHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/ube-tour.default', UbeTabsHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/ube-advanced-tour.default', UbeTabsHandler);
	});

})(jQuery);