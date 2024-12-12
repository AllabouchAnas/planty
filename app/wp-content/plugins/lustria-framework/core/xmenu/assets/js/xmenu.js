(function($) {
	"use strict";

	var GF_XMENU = {
		_timeOutHoverMenu: [],
		_timeOutHoverOutMenu: [],
		_timeOutDuration: 100,

		init: function () {
			this.menuHover();
            this.onChangeSubmenuSize();
			this.megaMenuActive();
            $(window).trigger('x-menu-change');
		},

		isMobile: function() {
			var responsiveBreakpoint = 991;
			var $body = $('body');
			if ((typeof ($body.data('responsive-breakpoint')) != "undefined")
				&& !isNaN(parseInt($body.data('responsive-breakpoint'), 10)) ) {
				responsiveBreakpoint = parseInt($body.data('responsive-breakpoint'), 10);
			}

			return window.matchMedia('(max-width: ' + (responsiveBreakpoint)  + 'px)').matches;
		},
		menuHover: function() {
			var that = this;
			$('.x-nav-menu li.menu-item').each(function() {
				var $this = $(this),
					currentLiHoverId = 0;


				$this.hover(function() {
					if (that.isMobile()) {
						return;
					}
					var $this = $(this),
						currentMenuId = $this.prop('id'),
						currentTransition = $this.data('transition');

					currentLiHoverId = currentMenuId;

					if (typeof (that._timeOutHoverMenu[currentMenuId]) != "undefined") {
						clearTimeout(that._timeOutHoverMenu[currentMenuId]);
					}
					that._timeOutHoverMenu[currentMenuId] = setTimeout(function() {
						$this.addClass('x-active');
					}, that._timeOutDuration);
				}, function() {
					if (that.isMobile()) {
						return;
					}
					var $this = $(this),
						currentMenuId = $this.prop('id'),
						currentTransition = $this.data('transition');

					clearTimeout(that._timeOutHoverMenu[currentMenuId]);

					if (currentTransition != null) {
						currentLiHoverId = 0;

						that._timeOutHoverOutMenu[currentMenuId] = setTimeout(function() {
							if (currentLiHoverId === currentMenuId) {
								return;
							}

							$this.find(' > ul.sub-menu').addClass(currentTransition + '-out');

							setTimeout(function() {
								$this.removeClass('x-active');
								$this.find(' > ul.sub-menu').removeClass(currentTransition + '-out');
							}, 300);

						}, that._timeOutDuration);
					}
					else {
						$this.removeClass('x-active');
					}
				});
			});
		},
		subMenuSize: function() {
			var that = this;
			if (that.isMobile()) {
				$('.x-nav-menu li.menu-item > ul.sub-menu').each(function() {
					var $this = $(this),
						$parent = $this.parent();
					if ($parent.hasClass('x-submenu-width-fullwidth') || $parent.hasClass('x-submenu-width-container')) {
						$this.css({
							width: '',
							left: ''
						});
					}
				});
			}
			else {
				$('.x-nav-menu li.menu-item > ul.sub-menu').each(function() {
					var $this = $(this),
						$parent = $this.parent(),
						$container,
						subMenuWidth,
						liLeft;
					if ($parent.hasClass('x-submenu-width-fullwidth')) {
						subMenuWidth = $(window).width();
						liLeft = -$parent.offset().left;
					} else if ($parent.hasClass('x-submenu-width-container')) {
						$container = $('.x-nav-menu-container');
						if ($container.length) {
							subMenuWidth = $container.width();
						}
						else {
							subMenuWidth = 1200;
							if ($(window).width() < subMenuWidth) {
								subMenuWidth = $(window).width();
							}
						}

						liLeft = -$parent.offset().left + (($(window).width() - subMenuWidth)/2);
					}
					$this.css({
						width: subMenuWidth + 'px',
						left: liLeft + 'px'
					});
				});
			}
		},
		megaMenuActive: function() {
			var currentUrl = window.location.href;
			if (currentUrl.substr(currentUrl.length -1) === '/') {
				currentUrl = currentUrl.substr(0,currentUrl.length -1);
			}

			$('.x-mega-sub-menu a').each(function(){
				var url = $(this).attr('href');
				if (url.substr(url.length -1) === '/') {
					url = url.substr(0,url.length -1);
				}
				if (url == currentUrl) {
					$(this).parent().addClass('current-menu-item');
					var $parent = $(this).closest('.sub-menu');
					if ($parent.length) {
						$parent.parent().addClass('current-menu-parent');
						var $ancestor = $parent.parent().closest('.sub-menu');
						if ($ancestor.length) {
							$ancestor.parent().addClass('current-menu-ancestor');
						}
					}
				}
			});
		},
		menuPosition: function () {
			var that = this;
			if (!that.isMobile()) {
				$('.x-nav-menu > li.menu-item > .x-submenu-custom-width').each(function() {
					var $this = $(this),
						$parent = $this.parent(),
						$container = $('.x-nav-menu-container'),
						subMenuWidth = $this.outerWidth(),
						containerWidth = 0,
						liLeft,
						containerLeft,
						position = 'right';

					if ($container.length) {
						containerWidth = $container.width();
						containerLeft = ($(window).width() - containerWidth) / 2;
					}
					else {
						containerWidth = $(window).width() - 30;
						containerLeft = 15;
					}

					if ($parent.hasClass('x-submenu-position-left')) {
						position = 'left';
					}

					if (!$parent.hasClass('x-submenu-width-fullwidth') && !$parent.hasClass('x-submenu-width-container')) {
						if (position === 'right') {
							if ($parent.offset().left + subMenuWidth > containerLeft + containerWidth) {
								liLeft = containerLeft + containerWidth  - ($parent.offset().left + subMenuWidth);
								$this.css('left', liLeft + 'px');
							}
						}
						else {
							if ($parent.offset().left + $parent.width() < subMenuWidth) {
								liLeft = subMenuWidth  - ($parent.offset().left + subMenuWidth) + 15;
								$this.css('left', $parent.width() + liLeft + 'px');
							}
						}
					}
				});
			} else {
				$('.x-nav-menu > li.menu-item > .x-submenu-custom-width').each(function() {
					var $this = $(this);
					$this.css({
						left: ''
					});
				});
			}

		},
        onChangeSubmenuSize: function () {
            $(window).on('x-menu-change',function () {
                GF_XMENU.timeOutSubmenuSize(0);
            });
        },
        timeOutSubmenuSize: function (count) {
            if (count < 5) {
                GF_XMENU.subMenuSize();
                GF_XMENU.menuPosition();
                setTimeout(function () {
                    GF_XMENU.timeOutSubmenuSize(count + 1);
                },100)
            }
        }
	};

	$(document).ready(function() {
		GF_XMENU.init();
	});
	$(window).resize(function () {
        $(window).trigger('x-menu-change');
	});
})(jQuery);