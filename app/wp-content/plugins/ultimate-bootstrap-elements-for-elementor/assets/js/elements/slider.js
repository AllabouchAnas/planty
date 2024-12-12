(function ($) {
    'use strict';
    var ube_slider_options_default = {
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

    var UbeSliderHandler = function ($scope, $) {
        var $slider_wrapper = $scope.find('.ube-slider');

        $slider_wrapper.each(function () {
            var $this = $(this);
            if (!$this.hasClass('slick-initialized')) {
                var options = $this.data('slick-options');
                options = $.extend({}, ube_slider_options_default, options);
                $this.on('init', function (e, slick) {
                    ube_slider_animation($this);
                });
                $this.on('beforeChange', function (e, slick, currentSlide, nextSlide) {

                    slick.beforeSlide = currentSlide;
                    if (currentSlide !== nextSlide) {
                        $(slick.$slides[currentSlide]).find('.animated').each(function () {
                            var $settings = $(this).data('settings');
                            var $animation = $settings._animation;
                            if ($(this).hasClass('elementor-column')) {
                                $animation = $settings.animation;
                            }
                            $(this).removeClass($animation).removeClass('animated').addClass('elementor-invisible');
                        });
                        $(slick.$slides[nextSlide]).find('.animated').each(function () {
                            var $settings = $(this).data('settings');
                            var $animation = $settings._animation;
                            if ($(this).hasClass('elementor-column')) {
                                $animation = $settings.animation;
                            }
                            $(this).removeClass($animation).removeClass('animated').addClass('elementor-invisible');
                        });
                        $(this).find('.slick-slide').find('.ube-slider-background-wrapper').removeAttr('style');
                    }

                });
                $this.on('afterChange', function (event, slick, currentSlide) {
                    if (slick.beforeSlide !== currentSlide) {
                        ube_slider_animation($this);
                        var $current = $(slick.$slides[currentSlide]);
                        $current.find('.elementor-invisible ').each(function () {
                            var $settings = $(this).data('settings'),
                                $animation = $settings._animation,
                                $animationDelay = $settings._animation_delay;
                            if ($(this).hasClass('elementor-column')) {
                                $animation = $settings.animation;
                                $animationDelay = $settings.animation_delay;
                            }
                            if ($.isNumeric($animationDelay)) {
                                setTimeout(() => {
                                    $(this).addClass($animation).addClass('animated').removeClass('elementor-invisible');
                                }, $animationDelay);
                            } else {
                                $(this).addClass($animation).addClass('animated').removeClass('elementor-invisible')
                            }

                        });
                    }
                });
                if ($(this).find('.ube-slider-box').data('thumb') !== undefined && $(this).find('.ube-slider-box').data('thumb') !== '') {
                    options.customPaging = function (slider, i) {
                        var $thumb_url = $(slider.$slides[i]).find('.ube-slider-box').data('thumb');
                        return '<button style="' + $thumb_url + '"></button>';
                    }
                }

                ube_slider_syn(options);
                $this.slick(options);
                $this.on('setPosition', function (event, slick) {
                    var max_height = 0;
                    slick.$slides.each(function () {
                        var $slide = $(this);
                        if ($slide.hasClass('slick-active')) {
                            if (slick.options.adaptiveHeight && (slick.options.slidesToShow > 1) && (slick.options.vertical === false)) {
                                if (max_height < $slide.outerHeight()) {
                                    max_height = $slide.outerHeight();
                                }
                            }
                        }
                    });
                    if (max_height !== 0) {
                        $this.find('> .slick-list').animate({
                            height: max_height
                        }, 500);
                    }
                });

            }

        });
    };

    var UbeAdvancedSliderHandler = function ($scope, $) {
        var $slider_wrapper = $scope.find('.ube-advanced-slider');
        $slider_wrapper.each(function () {
            var $this = $(this);
            var options = $this.data('slick-options');
            options = $.extend({}, ube_slider_options_default, options);
            var $slick = $this.find('.elementor-section-wrap').first();
            if ($slick.length === 0) {
                $slick = $this.find('.elementor-widget-container > .elementor').first();
            }
            $slick.addClass('slick-slider manual');
            if (!$slick.hasClass('slick-initialized')) {
                ube_slider_syn(options);
                $slick.slick(options);
                $slick.on('setPosition', function (event, slick) {
                    var max_height = 0;
                    slick.$slides.each(function () {
                        var $slide = $(this);
                        if ($slide.hasClass('slick-active')) {
                            if (slick.options.adaptiveHeight && (slick.options.slidesToShow > 1) && (slick.options.vertical === false)) {
                                if (max_height < $slide.outerHeight()) {
                                    max_height = $slide.outerHeight();
                                }
                            }
                        }
                    });
                    if (max_height !== 0) {
                        $this.find('> .slick-list').animate({
                            height: max_height
                        }, 500);
                    }
                });

            }
            //syncing_slider($this, options, ube_slider_options_default);
        });

    };
    var UbeSliderContainerHandler = function ($scope, $) {
        var $slider_wrapper = $scope.find('.ube-slider');
        $slider_wrapper.each(function () {
            var $this = $(this);
            var options = $this.data('slick-options');
            options = $.extend({}, ube_slider_options_default, options);
            if (!$this.hasClass('slick-initialized')) {
                ube_slider_syn(options);
                $this.slick(options);
                $this.on('setPosition', function (event, slick) {
                    var max_height = 0;
                    slick.$slides.each(function () {
                        var $slide = $(this);
                        if ($slide.hasClass('slick-active')) {
                            if (slick.options.adaptiveHeight && (slick.options.slidesToShow > 1) && (slick.options.vertical === false)) {
                                if (max_height < $slide.outerHeight()) {
                                    max_height = $slide.outerHeight();
                                }
                            }
                        }
                    });
                    if (max_height !== 0) {
                        $this.find('> .slick-list').animate({
                            height: max_height
                        }, 500);
                    }
                });

            }
        });

    };

    function ube_slider_animation(slider) {
        if (slider.hasClass('ube-sliders-background-kern-burns-zoom-out')) {
            slider.find('.slick-current').find('.ube-slider-background-wrapper').css({
                'transform': 'scale(1.35)',
                '-webkit-transform': 'scale(1.35)',
                'transition': 'transform 11s cubic-bezier(0.1, 0.2, .7, 1)',
                '-webkit-transition': 'transform 11s cubic-bezier(0.1, 0.2, .7, 1)'
            });
        } else if (slider.hasClass('ube-sliders-background-kern-burns-zoom-in')) {
            slider.find('.slick-current').find('.ube-slider-background-wrapper').css({
                '-webkit-transform': 'scale(1)',
                'transform': 'scale(1)',
                'transition': 'transform 11s cubic-bezier(0.1, 0.2, .7, 1)',
                '-webkit-transition': 'transform 11s cubic-bezier(0.1, 0.2, .7, 1)'
            });
        }
        if (slider.hasClass('ube-sliders-swipe-swirl-left')) {
            $slider = slider.find('.slick-slide');
            $.each($slider, function () {
                $(this).find('.ube-slide-bg').css({
                    'transform': 'scale(2) rotate(10deg)',
                    '-webkit-transform': 'scale(2) rotate(10deg)',
                    'transition': 'all 2000ms ease 0s',
                    '-webkit-transition': 'all 2000ms ease 0s'
                });
                if ($(this).hasClass('slick-current')) {
                    $(this).find('.ube-slide-bg').css({
                        'transform': 'scale(1) rotate(0)',
                    });
                }
            });

        }
        if (slider.hasClass('ube-sliders-swipe-swirl-right')) {
            $slider = slider.find('.slick-slide');
            $.each($slider, function () {

                if ($(this).hasClass('slick-current')) {
                    $(this).find('.ube-slide-bg').css({
                        '-webkit-transform': 'scale(1) rotate(0)',
                        'transform': 'scale(1) rotate(0)',
                    });
                } else {
                    $(this).find('.ube-slide-bg').css({
                        'transform': 'scale(2) rotate(-10deg)',
                        '-webkit-transform': 'scale(2) rotate(-10deg)',
                        'transition': 'all 2000ms ease 0s',
                        '-webkit-transition': 'all 2000ms ease 0s'
                    });
                }
            });

        }
        if (slider.hasClass('ube-sliders-swipe-burn')) {
            var $slider = slider.find('.slick-slide');
            $.each($slider, function () {
                $(this).css({
                    'filter': 'contrast(1000%) saturate(1000%)',
                    '-webkit-filter': 'contrast(1000%) saturate(1000%)',
                    'opacity': '0',
                    'transition': 'all 1000ms ease 0s',
                    '-webkit-transition': 'all 1000ms ease 0s'
                });
                if ($(this).hasClass('slick-current')) {
                    $(this).css({
                        'filter': 'contrast(100%) saturate(100%)',
                        '-webkit-filter': 'contrast(100%) saturate(100%)',
                        'opacity': '1',
                    });
                }
            });

        }
        if (slider.hasClass('ube-sliders-swipe-blur')) {
            $slider = slider.find('.slick-slide');
            $.each($slider, function () {
                $(this).css({
                    'filter': 'blur(32px)',
                    '-webkit-filter': 'blur(32px)',
                    'opacity': '0',
                    'transition': 'all 1000ms ease 0s',
                    '-webkit-transition': 'all 1000ms ease 0s'
                });
                if ($(this).hasClass('slick-current')) {
                    $(this).css({
                        'filter': 'blur(0)',
                        '-webkit-filter': 'blur(0)',
                        'opacity': '1',
                    });
                }
            });

        }
        if (slider.hasClass('ube-sliders-swipe-flash')) {
            $slider = slider.find('.slick-slide');
            $.each($slider, function () {
                $(this).css({
                    'filter': 'brightness(25)',
                    '-webkit-filter': 'brightness(25)',
                    'opacity': '0',
                    'transition': 'all 1000ms ease 0s',
                    '-webkit-transition': 'all 1000ms ease 0s',
                });
                if ($(this).hasClass('slick-current')) {
                    $(this).css({
                        'filter': 'brightness(1)',
                        '-webkit-filter': 'brightness(1)',
                        'opacity': '1',
                    });
                }
            });
        }
        slider.find('.slick-current').find('.ube-slide-background-kern-burns-zoom-out').find('.ube-slider-background-wrapper').css({
            'transform': 'scale(1.35)',
            '-webkit-transform': 'scale(1.35)',
            'transition': 'transform 11s cubic-bezier(0.1, 0.2, .7, 1)',
            '-webkit-transition': 'transform 11s cubic-bezier(0.1, 0.2, .7, 1)'
        });
        slider.find('.slick-current').find('.ube-slide-background-kern-burns-zoom-in').find('.ube-slider-background-wrapper').css({
            'transform': 'scale(1)',
            '-webkit-transform': 'scale(1)',
            'transition': 'transform 11s cubic-bezier(0.1, 0.2, .7, 1)',
            '-webkit-transition': 'transform 11s cubic-bezier(0.1, 0.2, .7, 1)'
        });
    }

    function ube_slider_syn(options) {
        if ((typeof (options.asNavFor) !== 'undefined') && (options.asNavFor !== '')) {
            if (!$(options.asNavFor).hasClass('slick-slider')) {
                if ($(options.asNavFor).hasClass('elementor-widget-ube-slider') || $(options.asNavFor).hasClass('elementor-widget-ube-slider-container')) {
                    options.asNavFor += ' > div > [data-slick-options]';
                } else if ($(options.asNavFor).hasClass('elementor-widget-ube-advanced-slider')) {
                    options.asNavFor += ' > div > [data-slick-options] > div > div > div > div > .slick-slider';
                } else {
                    options.asNavFor = null;
                }
            }
        }
    }

    window.addEventListener( 'elementor/frontend/init', () => {
        elementorFrontend.hooks.addAction('frontend/element_ready/ube-slider.default', UbeSliderHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/ube-advanced-slider.default', UbeAdvancedSliderHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/ube-slider-container.default', UbeSliderContainerHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/ube-advanced-client-logo.default', UbeSliderHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/ube-advanced-testimonial.default', UbeSliderHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/ube-advanced-team-member.default', UbeSliderHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/ube-instagram.default', UbeSliderHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/ube-advanced-icon-box.default', UbeSliderHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/ube-advanced-image-box.default', UbeSliderHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/ube-post-slider.default', UbeSliderHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/ube-facebook-feed.default', UbeSliderHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/ube-twitter-feed.default', UbeSliderHandler);
    });
})(jQuery);