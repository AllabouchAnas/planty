(function ($) {
		'use strict';
		var UbePostHandler = function ($scope, $) {
			var is_load = true;

			function send_ajax($args, $settings, $page, $text, $total_page, $handler, $widget_id, nonceField) {
				var obj = {};
				var $widget = $('[data-id=' + $widget_id + ']');
				var $data = {
					action: "ube_load_more",
					args: $args,
					settings: $settings,
					page: $page,
					handler: $handler,
					totalPage: $total_page,
					nonceField: nonceField
				};
				if (typeof $args == 'undefined') {
					return;
				}

				String($args).split('&').forEach(function (item, index) {
					var arr = String(item).split('=');
					obj[arr[0]] = arr[1];
				});

				if (obj.orderby === 'rand') {
					var $printed = $widget.find('.ube-posts');
					if ($printed.length) {
						var $ids = [];
						$printed.each(function (index, item) {
							var $id = $widget.find(item).data('id');
							$ids.push($id);
						});

						$data.post__not_in = $ids;
					}
				}
				$.ajax({
					url: ajaxAdminUrl.url,
					type: "post",
					data: $data,
					success: function (response) {
						var $widget = $('[data-id=' + response.data.widget_id + ']');
						var $l = $widget.find('[data-ladda="true"]').ladda();
						var $target = $widget.find(response.data.target);

						$l.ladda('stop');
						var $content = $(response.data.content);
						var $current_page = parseInt(response.data.current_page);
						if (
							$content.hasClass("no-posts-found") ||
							$content.length === 0
						) {
							if (response.data.paging === 'load_more') {
								$widget.find('.ube-load-more-button').remove();
							}
						} else {

							if (response.data.paging === 'load_more') {
								$target.append($content);
								$widget.find('.ube-load-more-button').data("page", $page);
								if ($page === parseInt($total_page)) {
									$widget.find('.ube-load-more-button').remove();
								}
							}
							if (response.data.paging === 'pagination' || response.data.paging === 'next_prev') {
								$target.html($content);
								$widget.find('.page-item.disabled').removeClass('disabled');
								var $current_paging = $widget.find('.page-item[data-page=' + $current_page + ']');
								$.each($current_paging, function () {
									if (!$(this).hasClass('prev') && !$(this).hasClass('next')) {
										$(this).addClass('active');
									}
								});

								var $prev = $widget.find('.prev');
								var $next = $widget.find('.next');
								$prev.data("page", $page - 1);
								$next.data("page", $page + 1);
								if ($current_page === 1) {
									$prev.addClass('disabled');
								}

								if (($current_page) === parseInt($total_page)) {
									$next.addClass('disabled');
								}
								$('html, body').animate({
									scrollTop: $target.offset().top - 100
								}, 500, function () {
									// Callback after animation
								});
							}
							if (response.data.filter_category !== undefined) {
								is_load = true;
								var $post_slider = $widget.find('.ube-posts-slider');
								if ($post_slider.length < 1) {
									$target.html($content);
									var $paging = $widget.find('.ube-post-list-paging');
									if ($paging.length > 0) {
										$widget.find('.ube-post-list-paging').html(response.data.pagination);
									}
								}

								$widget.find('.ube-nav-post .nav-item').removeClass('active');
								if ($widget.find('#' + $text).length > 0) {
									$widget.find('#' + $text).addClass('active');
								}
								if ($post_slider.length > 0) {
									$post_slider.slick('unslick');
									var options_default = {
										slidesToScroll: 1,
										slidesToShow: 1,
										adaptiveHeight: false,
										arrows: true,
										dots: true,
										autoplay: false,
										autoplaySpeed: 3000,
										centerMode: false,
										centerPadding: "50px",
										draggable: true,
										fade: false,
										focusOnSelect: true,
										infinite: false,
										pauseOnHover: false,
										responsive: [],
										rtl: false,
										speed: 300,
										asNavFor: '',
										vertical: false,
										prevArrow: '<div class="slick-prev" aria-label="Previous"><i class="fas fa-chevron-left"></i></div>',
										nextArrow: '<div class="slick-next" aria-label="Next"><i class="fas fa-chevron-right"></i></div>',
										customPaging: function (slider, i) {
											return $('<span></span>');
										}
									};
									$target.html($content);
									var options = $post_slider.data('slick-options');
									options = $.extend({}, options_default, options);
									$post_slider.slick(options);
								}
							}
							if ($handler === 'scroll') {
								is_load = true;
								$target.append($content);
								$widget.find('.ube-scroll-loader').data("page", $page + 1);
								if ($page === parseInt($total_page)) {
									$widget.find('.ube-scroll-loader').remove();
								}

							}
							var masonry_elem = $widget.find('.ube-posts-masonry');
							if (masonry_elem.length > 0) {
								var $isotope = masonry_elem.isotope();
								$isotope.isotope("appended", $content).isotope("layout");

								$isotope.imagesLoaded().progress(function () {
									$isotope.isotope("layout");
								});

							}

						}
					},
					error: function (response) {
						console.log(response);
					}

				});
				return false;
			}

			$(document).on("click", ".ube-load-more-button", function (e) {
				e.preventDefault();
				e.stopPropagation();
				e.stopImmediatePropagation();


				var $this = $(this),
					$text = $this.find(".button-text").html(),
					$args = $this.data("args"),
					$settings = $this.data("settings"),
					$total_page = $this.data("total-page"),
					$handler = "paging",
					$widget_id = $this.data('widget'),
					$nonce_field = $this.data('nonce'),
					$page = parseInt($this.data("page")) + 1;
				var $l = $this.ladda();
				$l.ladda('start');
				send_ajax($args, $settings, $page, $text, $total_page, $handler, $widget_id, $nonce_field);
			});
			$(document).on("click", ".ube-page-item", function (e) {
				e.preventDefault();
				e.stopPropagation();
				e.stopImmediatePropagation();

				var $this = $(this),
					$text = '',
					$args = $this.data("args"),
					$settings = $this.data("settings"),
					$handler = "paging",
					$widget_id = $this.data('widget'),
					$nonce_field = $this.data('nonce'),
					$total_page = $this.data("total-page");
				var $widget = $('[data-id=' + $widget_id + ']');

				$widget.find('.ube-post-pagination .page-item.active').removeClass('active');
				var $l = $this.find('[data-ladda="true"]').ladda();
				$l.ladda('start');
				var $page = parseInt($this.data("page"));
				send_ajax($args, $settings, $page, $text, $total_page, $handler, $widget_id, $nonce_field);
			});
			var $term = $scope.find('.ube-nav-post .nav-item');
			if ($term.length > 0) {
				$term.on('click', function (e) {
					e.preventDefault();
					e.stopPropagation();
					e.stopImmediatePropagation();

					var $this = $(this),
						$handler = $this.data("filter"),
						$text = $this.attr("id"),
						$args = $this.data("args"),
						$settings = $this.data("settings"),
						$total_page = $this.data("total-page"),
						$widget_id = $this.data('widget'),
						$nonce_field = $this.data('nonce'),
						$page = $this.data("page");
					var $l = $this.find('[data-ladda="true"]').ladda();
					$l.ladda('start');
					send_ajax($args, $settings, $page, $text, $total_page, $handler, $widget_id, $nonce_field);
				});
			}
			var $scroll_el = $scope.find('.ube-post-list-scroll');
			var scrolling = false;
			if ($scroll_el.length > 0) {
				$(window).scroll(function (event) {
					scrolling = true;
				});
				setInterval(function () {
					if (scrolling) {
						scrolling = false;
						var $this = $(window);
						var $loader = $scope.find('.ube-scroll-loader');
						var $text = '',
							$args = $loader.data("args"),
							$settings = $loader.data("settings"),
							$handler = "scroll",
							$widget_id = $loader.data('widget'),
							$nonce_field = $loader.data('nonce'),
							$total_page = $loader.data("total-page"),
							$page = $loader.data("page");

						if ($loader.length < 1) {
							return;
						}

						$loader.show();
						var is_end = $this.scrollTop() + $this.height() > $scope.find('.ube-posts').offset().top + $scope.find('.ube-posts').height();
						if (is_load === true) {
							if (is_end && parseInt($page) <= parseInt($total_page)) {
								is_load = false;
								setTimeout(function () {
									send_ajax($args, $settings, $page, $text, $total_page, $handler, $widget_id, $nonce_field)
								}, 1000);

							}
						}
						return false;
					}
				}, 300);

			}
		};
		 window.addEventListener( 'elementor/frontend/init', () => {
			elementorFrontend.hooks.addAction('frontend/element_ready/ube-post-list.default', UbePostHandler);
			elementorFrontend.hooks.addAction('frontend/element_ready/ube-post-grid.default', UbePostHandler);
			elementorFrontend.hooks.addAction('frontend/element_ready/ube-post-masonry.default', UbePostHandler);
			elementorFrontend.hooks.addAction('frontend/element_ready/ube-post-slider.default', UbePostHandler);
			elementorFrontend.hooks.addAction('frontend/element_ready/ube-post-metro.default', UbePostHandler);
		});

	}
)(jQuery);