var G5_Core = window.G5_Core || {},
    G5_Core_Animation = window.G5_Core_Animation || {};
(function ($) {
    "use strict";
    window.G5_Core = G5_Core;

    var $window = $(window),
        $body = $('body'),
        isLazy = $body.hasClass('gf-lazy-load'),
        isRTL = $body.hasClass('rtl'),
        deviceAgent = navigator.userAgent.toLowerCase(),
        isMobile = deviceAgent.match(/(iphone|ipod|android|iemobile)/),
        isMobileAlt = deviceAgent.match(/(iphone|ipod|ipad|android|iemobile)/),
        isAppleDevice = deviceAgent.match(/(iphone|ipod|ipad)/),
        isIEMobile = deviceAgent.match(/(iemobile)/),
        bodyHeight = 0;

    G5_Core.util = {
        init: function () {
            this.events();
            this.pageTransition();
            this.pageLoading();
            this.topDrawerToggle();
            this.backToTop();
            this.magnificPopup();
            this.tooltip();
        },
        tooltip: function () {
            if ($().tooltip && !isMobileAlt) {
                if (!$body.hasClass('woocommerce-compare-page')) {
                    $('[data-toggle="tooltip"]').each(function () {
                        var configs = {
                            container: $(this).parent()
                        };
                        if($(this).closest('.gf-tooltip-wrap').length) {
                            configs = $.extend({}, configs, $(this).closest('.gf-tooltip-wrap').data('tooltip-options'));
                        }
                        $(this).tooltip(configs);
                    });
                }

                $('.yith-wcwl-wishlistexistsbrowse > a,.yith-wcwl-add-button > a,.yith-wcwl-wishlistaddedbrowse > a,.product-actions .compare,.single-product-function .compare', '.woocommerce').each(function(){
                    var title = $(this).text().trim(),
                        configs = {
                            title: title,
                            container: $(this).parent()
                        };
                    if($(this).closest('.gf-tooltip-wrap').length) {
                        configs = $.extend({}, configs, $(this).closest('.gf-tooltip-wrap').data('tooltip-options'));
                    }
                    if(!$(this).closest('.summary-product').length) {
                        $(this).tooltip(configs);
                    }
                });
            }
        },
        events: function () {
            // Table Cell Layout
            $window.on('scroll', function () {
                var _height = $body.height();
                if (_height !== bodyHeight) {
                    bodyHeight = _height;
                    if (typeof Waypoint !== 'undefined') {
                        Waypoint.refreshAll();
                    }
                }
            });
        },
        pageTransition: function () {
            if ($body.hasClass('page-transitions')) {
                var _that = this;
                var linkElement = '.animsition-link, a[href]:not([target="_blank"]):not([href^="#"]):not([href*="javascript"]):not([href*=".jpg"]):not([href*=".jpeg"]):not([href*=".gif"]):not([href*=".png"]):not([href*=".mov"]):not([href*=".swf"]):not([href*=".mp4"]):not([href*=".flv"]):not([href*=".avi"]):not([href*=".mp3"]):not([href^="mailto:"]):not([class*="no-animation"]):not([class*="prettyPhoto"]):not([class*="add_to_wishlist"]):not([class*="add_to_cart_button"]):not([class*="compare"])';
                $(linkElement).on('click', function (event) {
                    if ($(event.target).closest($('b.x-caret', this)).length > 0 || $(event.target).closest($('b.menu-caret', this)).length > 0) {
                        event.preventDefault();
                        return;
                    }
                    event.preventDefault();
                    var $self = $(this);
                    var url = $self.attr('href');

                    // middle mouse button issue #24
                    // if(middle mouse button || command key || shift key || win control key)
                    if (event.which === 2 || event.metaKey || event.shiftKey || navigator.platform.toUpperCase().indexOf('WIN') !== -1 && event.ctrlKey) {
                        window.open(url, '_blank');
                    } else {
                        _that.fadePageOut(url);
                    }
                });
            }
        },
        pageLoading: function () {
            var that = this;
            $(window).on('load', function () {
                that.fadePageIn();
            });
        },
        fadePageIn: function () {
            if ($body.hasClass('page-loading')) {
                var preloadTime = 1000,
                    $loading = $('.site-loading');
                $loading.animate({
                    opacity: 0,
                    delay: 200
                }, preloadTime, "linear", function () {
                    $loading.css('display', 'none');
                });
            }
        },
        fadePageOut: function (link) {
            $('.site-loading').css('display', 'block').animate({
                opacity: 1,
                delay: 200
            }, 600, "linear");

            $('html,body').animate({scrollTop: '0px'}, 800);

            setTimeout(function () {
                window.location = link;
            }, 600);
        },
        topDrawerToggle: function () {
            $('.top-drawer-toggle').on('click', function (event) {
                event.preventDefault();
                var $wrap = $(this).closest('.top-drawer-wrap'),
                    $topDrawerInner = $wrap.find('.top-drawer-inner'),
                    $icon = $wrap.find('i');
                if ($topDrawerInner.is(':hidden')) {
                    $icon.attr('class', 'fa fa-minus');
                } else {
                    $icon.attr('class', 'fa fa-plus');
                }
                $topDrawerInner.slideToggle("slow");
            });
        },
        backToTop: function () {
            var $backToTop = $('.back-to-top');
            if ($backToTop.length > 0) {
                $backToTop.on('click', function (event) {
                    event.preventDefault();
                    $('html,body').animate({scrollTop: '0px'}, 800);
                });
                $window.on('scroll', function (event) {
                    var scrollPosition = $window.scrollTop(),
                        windowHeight = $window.height() / 2;
                    if (scrollPosition > windowHeight) {
                        $backToTop.addClass('in');
                    }
                    else {
                        $backToTop.removeClass('in');
                    }
                });
            }
        },
        setPushState: function (url) {
            var title = document.title;
            if (typeof(window.history.pushState) === 'function') {
                window.history.pushState(null, title, url);
            }
        },
        magnificPopup: function ($wrapper) {
            if (typeof $wrapper === 'undefined') {
                $wrapper = $body;
            }
            $('[data-magnific]', $wrapper).each(function () {
                var $this = $(this);
                var defaults = {
                    type: 'image',
                    mainClass: 'mfp-zoom-in',
                    midClick: true,
                    removalDelay: 500,
                    callbacks: {
                        beforeOpen: function () {
                            // just a hack that adds mfp-anim class to markup
                            switch (this.st.type) {
                                case 'image':
                                    this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure mfp-with-anim');
                                    break;
                                case 'iframe' :
                                    this.st.iframe.markup = this.st.iframe.markup.replace('mfp-iframe-scaler', 'mfp-iframe-scaler mfp-with-anim');
                                    break;
                            }
                        },
                        change: function () {
                            var _this = this;
                            if (this.isOpen) {
                                this.wrap.removeClass('mfp-ready');
                                setTimeout(function () {
                                    _this.wrap.addClass('mfp-ready');
                                }, 10);
                            }
                        }
                    }
                };
                var config = $.extend({}, defaults, $this.data("magnific-options"));
                if (typeof (config.galleryId) !== 'undefined') {
                    var items = [],
                        items_src = [];
                    var $imageLinks = $('[data-gallery-id="' + config.galleryId + '"]');
                    $imageLinks.each(function () {
                        var src = $(this).attr('href');
                        if (items_src.indexOf(src) < 0) {
                            items_src.push(src);
                            items.push({
                                src: src
                            });
                        }
                    });
                    config.items = items;
                    config.gallery = {
                        enabled: true
                    };
                    config.callbacks.beforeOpen = function () {
                        var index = $imageLinks.index(this.st.el);
                        if ($(this.st.el).closest('.single-product-image-thumb').length > 0) {
                            index = 0;
                        }
                        switch (this.st.type) {
                            case 'image':
                                this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure mfp-with-anim');
                                break;
                            case 'iframe' :
                                this.st.iframe.markup = this.st.iframe.markup.replace('mfp-iframe-scaler', 'mfp-iframe-scaler mfp-with-anim');
                                break;
                        }
                        if (-1 !== index) {
                            this.goTo(index);
                        }
                    };
                }
                $this.magnificPopup(config);
            });
        },
        getAdminBarOffset: function () {
            var adminBarOffset = 0,
                $adminBar = $('#wpadminbar');
            if ($adminBar.length > 0 && ($adminBar.css('position') === 'fixed')) {
                adminBarOffset = $adminBar.outerHeight();
            }
            return adminBarOffset;
        },
        getHeaderStickyOffset: function () {
            var headerStickyOffset = 0,
                $header = $('.header-sticky');
            if (($header.length > 0) && (!$header.hasClass('header-hidden'))) {
                headerStickyOffset = 80;
            }
            return headerStickyOffset;
        },
        getScrollOffset: function () {
            var scroll_offset = 0;
            scroll_offset += this.getAdminBarOffset();
            scroll_offset += this.getHeaderStickyOffset();
            if($body.hasClass('bordered') && G5_Core.util.isDesktop()) {
                scroll_offset += 30;
            }
            return scroll_offset;
        },
        isDesktop: function () {
            var responsive_breakpoint = 991;
            return window.matchMedia('(min-width: ' + (responsive_breakpoint + 1) + 'px)').matches;
        }
    };

    G5_Core.loading_content = {
        init: function () {
            this.initLoading();
        },
        initLoading: function () {
            $('[data-items-wrapper]').each(function () {
                $(this).prepend('<div class="gsf-content-loading"></div>');
            });
        },
        showLoading: function($wrapper, _data, target){
            var $container = $wrapper.find('[data-items-container]'),
                $wrapper_height = $wrapper.outerHeight(),
                $loading = $wrapper.children('.gsf-content-loading'),
                itemSelector = _data.settings['itemSelector'],
                animation = typeof _data.settings['post_animation'] !== 'undefined' ? _data.settings['post_animation'] : 'none',
                owlCarousel = $container.hasClass('owl-carousel'),
                type = ($(target).closest('[data-items-paging]').length > 0) ? 'paging' : (($(target).closest('[data-items-cate]').length > 0) ? 'cat' : (($(target).closest('[data-items-tabs]').length > 0) ? 'tab' : '')),
                loadMore = (($(target).closest('[data-items-paging]').length > 0) && ((_data.settings['post_paging'] === G5_Core.pagination_ajax.paging.loadMore) || (_data.settings['post_paging'] === G5_Core.pagination_ajax.paging.infiniteScroll)));

            if (owlCarousel
            || (type === 'cat')
            || (type === 'tab')
            || !loadMore) {
                var wrapperOffset = $wrapper.offset().top - G5_Core.util.getScrollOffset(),
                    $header = $('.header-sticky');
                if ($header.length) {
                    wrapperOffset -= 80;
                }
                var bodyTop = document.documentElement['scrollTop'] || document.body['scrollTop'],
                    delta = bodyTop - wrapperOffset,
                    scrollSpeed = Math.abs(delta) / 2;
                if (scrollSpeed < 800) scrollSpeed = 800;

                if ($(target).closest('.x-mega-sub-menu').length === 0) {
                    $('html,body').animate({scrollTop: wrapperOffset}, scrollSpeed, 'easeInOutCubic');
                }
            }

            if (!loadMore) {
                var $top = ($container.offset().top - $wrapper.offset().top);
                $loading.css('top', ($top + 100));
                $wrapper.css('height', $wrapper_height).addClass('loading');
                if (animation === 'none') {
                    $container.find(itemSelector).animate({opacity: 0}, 500, 'easeOutQuad');
                } else {
                    $container.find('.gf_animate_when_almost_visible').addClass('zoom-reverse');
                }
            } else {
                if (_data.settings['post_paging'] === G5_Core.pagination_ajax.paging.loadMore) {
                    var l = $(target).ladda();
                    l.ladda('start');
                } else {
                    $top -= 100;
                    $loading.css('top', $top);
                    $wrapper.css('height', $wrapper_height).addClass('loading');
                }
            }
        },
        hideLoading: function ($wrapper) {
            setTimeout(function () {
                $wrapper.removeClass('loading').css('height', '');
            }, 500);
        }
    };

    G5_Core.owlCarousel = {
        timeOutRefresh: null,
        init: function ($wrapper) {
            var _that = this;
            if (typeof $wrapper === 'undefined') {
                $wrapper = $body;
            }
            $('.owl-carousel:not(.manual):not(.owl-loaded):not(.owl-loading)', $wrapper).each(function () {
                var $this = $(this);
                $this.addClass('owl-loading');
                $this.imagesLoaded({background: true}, function () {
                    var defaults = {
                        items: 4,
                        nav: false,
                        navText: ['<i class="far fa-arrow-left"></i>', '<i class="far fa-arrow-right"></i>'],
                        dots: false,
                        loop: false,
                        center: false,
                        mouseDrag: true,
                        touchDrag: true,
                        pullDrag: true,
                        freeDrag: false,
                        margin: 0,
                        stagePadding: 0,
                        merge: false,
                        mergeFit: true,
                        autoWidth: false,
                        startPosition: 0,
                        rtl: isRTL,
                        lazyLoad: isLazy,
                        smartSpeed: 250,
                        fluidSpeed: false,
                        dragEndSpeed: false,
                        autoplayHoverPause: true
                    };

                    var config = $.extend({}, defaults, $this.data("owl-options"));
                    if($this.is('.gsf-slider-container')) {
                        $this.children().each(function () {
                            $(this).wrap( "<div class='gf-slider-item'></div>" );
                        })
                    }
                    $this.on('initialized.owl.carousel', function (event) {
                        var element = event.target;
                        $(element).trigger('owlInitialized');
                    });
                    $this.on('refreshed.owl.carousel,initialized.owl.carousel', function (event) {
                        setTimeout(function () {
                            if ($(event.target).hasClass('carousel-3d')) {
                                var $elementActive = $(event.target).find('.owl-item.active.center'),
                                    $owl_nav = $(event.target).find('.owl-nav:not(.disabled)'),
                                    $owl_dot = $(event.target).find('.owl-dots:not(.disabled)');
                                if ($elementActive.length) {
                                    var height = $elementActive.height() * 0.1,
                                        padding_top = height;
                                    if ($(event.target).hasClass('nav-top-right') && $owl_nav.length) {
                                        padding_top += $owl_nav.height();
                                        $owl_nav.css({
                                            'top': 0
                                        });
                                    }
                                    if ((!$owl_nav.length || !$(event.target).hasClass('nav-bottom-left') && !$(event.target).hasClass('nav-bottom-center') && !$(event.target).hasClass('nav-bottom-right')) && !$owl_dot.length) {
                                        $(event.target).css({
                                            'padding-top': padding_top,
                                            'padding-bottom': height
                                        });
                                    } else {
                                        if ($owl_nav.length && ($(event.target).hasClass('nav-bottom-left') || $(event.target).hasClass('nav-bottom-center') || $(event.target).hasClass('nav-bottom-right'))) {
                                            $owl_nav.css({
                                                'padding-top': height
                                            });
                                            $(event.target).css({
                                                'padding-top': padding_top
                                            });
                                        } else {
                                            if ($owl_dot.length) {
                                                $owl_dot.css({
                                                    'padding-top': height
                                                });
                                                $(event.target).css({
                                                    'padding-top': padding_top
                                                });
                                            }
                                        }
                                    }
                                } else {
                                    $(event.target).css({
                                        'padding-top': '',
                                        'padding-bottom': ''
                                    });
                                }
                            }
                        }, 1);
                    });
                    $this.owlCarousel(config);
                });
            });
        }
    };
    G5_Core.lazyLoad = {
        init: function ($wrapper) {
            if (typeof $wrapper === 'undefined') {
                $wrapper = $body;
            }
            $('.gf-lazy', $wrapper).each(function () {
                var $this = $(this);
                if (!$this.hasClass('owl-lazy')) {
                    var defaults = {
                        effect: "fadeIn",
                        threshold: 300,
                        event: "scroll mouseover click"
                    };
                    var config = $.extend({}, defaults, $this.data("lazyLoad-options"));
                    $this.lazyload(config);
                    if ($this.is('img')) {
                        $this.on('appear', function () {
                            var $isotope = $this.closest('.isotope');
                            if ($isotope.length) {
                                if ($isotope[0].istopoTimeout != null) {
                                    clearTimeout($isotope[0].istopoTimeout);
                                }
                                $isotope[0].istopoTimeout = setTimeout(function () {
                                    G5_Core.isotope.layout($isotope);
                                }, 1000);
                            }
                        });
                    }
                }
            });
        }
    };

    G5_Core.owlCarouselSync = {
        init: function () {
            var $gallery_wrap = $('.gallery-layout-thumbnail');
            if ($gallery_wrap.length > 0) {
                this.gallery_sync($gallery_wrap);
            }
        },
        gallery_sync: function ($gallery_wrap) {
            var slider_main = $gallery_wrap.find('.gallery-main'),
                slider_thumb = $gallery_wrap.find('.gallery-thumb');

            slider_main.owlCarousel({
                items: 1,
                nav: false,
                dots: false,
                loop: false,
                rtl: isRTL,
                lazyLoad: isLazy
            }).on('changed.owl.carousel', syncPosition);


            var defaults = {
                    items: 4,
                    nav: false,
                    dots: false,
                    rtl: isRTL,
                    lazyLoad: isLazy,
                    margin: 10,
                    responsive: {
                        992: {
                            items: 4
                        },
                        768: {
                            items: 3
                        },
                        0: {
                            items: 2
                        }
                    }
                },
                config = $.extend({}, defaults, slider_thumb.data("owl-options"));
            slider_thumb.on('initialized.owl.carousel', function (event) {
                slider_thumb.find(".owl-item").eq(0).addClass("current");
            }).owlCarousel(config);

            function syncPosition(el) {
                //if you set loop to false, you have to restore this next line
                var current = el.item.index;

                slider_thumb
                    .find(".owl-item")
                    .removeClass("current")
                    .eq(current)
                    .addClass("current");
                var onscreen = slider_thumb.find('.owl-item.active').length - 1;
                var start = slider_thumb.find('.owl-item.active').first().index();
                var end = slider_thumb.find('.owl-item.active').last().index();

                if (current > end) {
                    slider_thumb.data('owl.carousel').to(current, 100, true);
                }
                if (current < start) {
                    slider_thumb.data('owl.carousel').to(current - onscreen, 100, true);
                }
            }

            slider_thumb.on("click", ".owl-item", function (e) {
                e.preventDefault();
                if ($(this).hasClass('current')) return;
                var number = $(this).index();
                slider_main.data('owl.carousel').to(number, 300, true);
            });

            $(document).on('reset_data', function (event) {
                slider_main.data('owl.carousel').to(0, 300, true);
            });
        }
    };

    G5_Core.isotope = {
        config_default: {
            isOriginLeft: !isRTL
        },
        init: function ($wrapper) {
            if (typeof $wrapper === 'undefined') {
                $wrapper = $body;
            }
            var _that = this;
            $('.isotope', $wrapper).each(function () {
                var $this = $(this);
                $this.imagesLoaded({background: true}, function () {
                    var config = $.extend({}, _that.config_default, $this.data("isotope-options")),
                        columns_gutter = $this.attr('class').match(/gf-gutter-(\d{0,2})/),
                        gutter = 0;
                    if (columns_gutter !== null) {
                        gutter = parseInt(columns_gutter[1]);
                    }
                    if ((typeof (config.masonry) !== 'undefined')
                        && (typeof (config.masonry.columnWidth) !== 'undefined')
                        && (config.masonry.columnWidth === '.gsf-col-base')) {
                        $this.append('<article class="gsf-col-base"></article>');
                    }


                    if ((typeof (config.masonry) !== 'undefined')
                        && (typeof (config.masonry.columnWidth) !== 'undefined')
                        && (typeof (config.metro) !== 'undefined')) {
                        config = $.extend({}, config, {
                            masonry: {
                                columnWidth: _that.metro_width($this, gutter)
                            },
                            resize: false
                        });
                    }

                    $this.isotope(config);

                    $this.on('refreshed.owl.carousel,gf_process_quote_done', function (event) {
                        _that.layout($(event.currentTarget));
                    });

                    $this.on('changed.owl.carousel', function (event) {
                        if ((typeof $(event.target).data('owl.carousel') !== 'undefined') && $(event.target).data('owl.carousel').options.autoHeight) {
                            _that.layout($(event.currentTarget));
                        }
                    });
                    _that.layout($this);
                    /*if ($this.find('.owl-carousel').length) {
                     _that.layout($this);
                     }*/

                });
            });

            $window.on('resize', function () {
                $('.isotope', $wrapper).each(function () {
                    var $this = $(this),
                        config = $.extend({}, _that.config_default, $this.data("isotope-options")),
                        columns_gutter = $this.attr('class').match(/gf-gutter-(\d{0,2})/),
                        gutter = -1;
                    if (columns_gutter !== null) {
                        gutter = parseInt(columns_gutter[1]);
                    }
                    if ((typeof (config.masonry) !== 'undefined')
                        && (typeof (config.masonry.columnWidth) !== 'undefined')
                        && (typeof (config.metro) !== 'undefined')) {
                        config = $.extend({}, config, {
                            masonry: {
                                columnWidth: _that.metro_width($this, gutter)
                            },
                            resize: false
                        });
                        $this.isotope(config);
                    }

                    _that.layout($this);
                });
            });
        },
        layout: function ($target) {
            if ($target.data('isotope')) {
                $target.isotope('layout');

            }
            setTimeout(function () {
                if ($target.data('isotope')) {
                    $target.isotope('layout');

                }
            }, 500);
            setTimeout(function () {
                if ($target.data('isotope')) {
                    $target.isotope('layout');
                }
            }, 1000);
        },
        metro_width: function ($target, columns_gutter) {
            var _that = this,
                options = $target.data("isotope-options"),
                $container = $target.closest('[data-isotope-wrapper]'),
                baseColumns = 1,
                imageSizeBase = $target.data('image-size-base'),
                ratioBase = 1;
            if (imageSizeBase) {
                imageSizeBase = imageSizeBase.split('x');
                ratioBase = parseInt(imageSizeBase[1], 10) / parseInt(imageSizeBase[0], 10);
                if (isNaN(ratioBase)) {
                    ratioBase = 1;
                }
            }
            $target.find(options.itemSelector).each(function () {
                var $item = $(this),
                    multiplier_w = _that.get_multiplier_width($item),
                    columns = 1;
                if(multiplier_w != 0) {
                    columns = 60 / multiplier_w;
                }
                if (baseColumns < columns) {
                    baseColumns = columns;
                }
            });


            var baseWidth = ($container.width() - columns_gutter * (baseColumns - 1)) / baseColumns,
                baseHeight = Math.floor(baseWidth * ratioBase);
            $target.find(options.itemSelector).each(function () {
                var $item = $(this),
                    $itemInner = $item.find(' > [data-ratio]'),
                    ratio = $itemInner.data('ratio');
                if (ratio) {
                    ratio = ratio.split('x');
                    var ratioH = ratio[1],
                        height = baseHeight * ratioH + Math.ceil((ratioH - 1)) * columns_gutter,
                        $image = $itemInner.find('.entry-thumbnail-overlay');
                    $image.addClass('thumbnail-size-none').css('height', height);
                }

            });

            return options.masonry.columnWidth;
        },
        get_multiplier_width: function ($item) {
            var multiplier_w = 60;
            if ($item.is('[class]') && !$item.hasClass('gsf-col-base')) {
                var _class = $item.attr('class'),
                    multiplier_mb_w = _class.match(/col-(\d{1,2})/),
                    multiplier_xs_w = _class.match(/col-sm-(\d{1,2})/),
                    multiplier_sm_w = _class.match(/col-md-(\d{1,2})/),
                    multiplier_md_w = _class.match(/col-lg-(\d{1,2})/),
                    multiplier_lg_w = _class.match(/col-xl-(\d{1,2})/);

                if (_class.match(/col-12-5/)) {
                    multiplier_w = 12;
                } else if (multiplier_mb_w !== null) {
                    multiplier_w = multiplier_mb_w[1] * 5;
                }

                if (window.matchMedia('(min-width: 576px)').matches) {
                    if (_class.match(/col-sm-12-5/)) {
                        multiplier_w = 12;
                    } else if (multiplier_xs_w !== null) {
                        multiplier_w = multiplier_xs_w[1] * 5;
                    }
                }

                if (window.matchMedia('(min-width: 768px)').matches) {
                    if (_class.match(/col-md-12-5/)) {
                        multiplier_w = 12;
                    } else if (multiplier_sm_w !== null) {
                        multiplier_w = multiplier_sm_w[1] * 5;
                    }

                }

                if (window.matchMedia('(min-width: 992px)').matches) {
                    if (_class.match(/col-lg-12-5/)) {
                        multiplier_w = 12;
                    } else if (multiplier_md_w !== null) {
                        multiplier_w = multiplier_md_w[1] * 5;
                    }
                }

                if (window.matchMedia('(min-width: 1200px)').matches) {
                    if (_class.match(/col-xl-12-5/)) {
                        multiplier_w = 12;
                    } else if (multiplier_lg_w !== null) {
                        multiplier_w = multiplier_lg_w[1] * 5;
                    }
                }
            }
            return multiplier_w;
        }
    };

    G5_Core_Animation = function ($wrapper, delay) {
        if (typeof $wrapper !== 'undefined') {
            $wrapper = $body;
        }
        this.$wrapper = $wrapper;
        this.init(delay);
    };

    G5_Core_Animation.prototype = {
        itemQueue: [],
        delay: 100,
        queueTimer: null,
        init: function (delay) {
            var _that = this;
            _that.itemQueue = [];
            _that.queueTimer = null;
            if (typeof delay !== 'undefined') {
                _that.delay = delay;
            }
            setTimeout(function () {
                _that.registerAnimation();
            }, 200);
        },
        registerAnimation: function () {
            var _that = this;
            $('.gf_animate_when_almost_visible:not(.wpb_start_animation)', _that.$wrapper).each(function (index, el) {
                $(el).waypoint(function () {
                    var _offsetTop = $(this.element).offset().top,
                        _scrollTop = $(window).scrollTop() + G5_Core.util.getScrollOffset();
                    if (_offsetTop < _scrollTop) {
                        $(this.element).addClass('wpb_start_animation animated');
                    } else {
                        _that.itemQueue.push(this.element);
                        _that.processItemQueue();
                    }
                    this.destroy();
                }, {
                    offset: '85%'
                });
            });
        },
        processItemQueue: function () {
            var _that = this;
            if (_that.queueTimer) return; // We're already processing the queue
            _that.queueTimer = window.setInterval(function () {
                if (_that.itemQueue.length) {
                    $(_that.itemQueue.shift()).addClass('wpb_start_animation animated');
                    _that.processItemQueue();
                }
                else {
                    window.clearInterval(_that.queueTimer);
                    _that.queueTimer = null
                }
            }, _that.delay)
        }
    };

    G5_Core.search_popup = {
        init: function () {
            this.showPopup();
        },
        showPopup: function () {
            $('.search-popup-link').magnificPopup({
                type: 'inline',
                closeOnBgClick: false,
                closeBtnInside: false,
                alignTop: true,
                mainClass: 'mfp-move-from-top',
                focus: '.search-popup-field',
                midClick: true,
                removalDelay: 700
            });
        }
    };

    G5_Core.search_ajax = {
        timeOutSearch: null,
        xhrSearchAjax: null,
        init: function () {
            $('[data-search-ajax="true"]').each(function () {
                var $this = $(this),
                    $input = $this.find('[data-search-ajax-control="input"]'),
                    $result = $this.find('[data-search-ajax-control="result"]'),
                    $icon = $this.find('[data-search-ajax-control="icon"]');
                if ($input.length == 0 || $result.length == 0) return;
                $result.perfectScrollbar({
                    wheelSpeed: 0.5,
                    suppressScrollX: true
                });
                $input.on('keyup', function (event) {
                    if (event.altKey || event.ctrlKey || event.shiftKey || event.metaKey) {
                        return;
                    }
                    var keys = ["Control", "Alt", "Shift"];
                    if (keys.indexOf(event.key) != -1) return;
                    switch (event.which) {
                        case 27:	// ESC
                            $result.removeClass('in');
                            $result.html('');
                            break;
                        case 38:
                        case 40:
                        case 13:
                            break;
                        default:
                            clearTimeout(G5_Core.search_ajax.timeOutSearch);
                            G5_Core.search_ajax.timeOutSearch = setTimeout(G5_Core.search_ajax.searchAjax, 500, $this, $input, $icon, $result);
                            break;
                    }
                });
            });
        },
        searchAjax: function ($this, $input, $icon, $result) {
            var keyword = $input.val();
            if (keyword.length < 3) {
                $result.removeClass('in');
                $result.html('');
                return;
            }

            if ($icon.length > 0) {
                $icon.addClass('fa-spinner fa-spin');
                $icon.removeClass('fa-search');
            }

            if (G5_Core.search_ajax.xhrSearchAjax) {
                G5_Core.search_ajax.xhrSearchAjax.abort();
            }

            var action = $this.data('search-ajax-action'),
                nonce = $this.data('search-ajax-nonce'),
                data = {
                    action: action,
                    keyword: keyword,
                    nonce: nonce
                };

            G5_Core.search_ajax.xhrSearchAjax = $.ajax({
                type: 'POST',
                data: data,
                url: g5plus_variable.ajax_url,
                dataType: 'html',
                success: function (response) {
                    if ($icon.length > 0) {
                        $icon.removeClass('fa-spinner fa-spin');
                        $icon.addClass('fa-search');
                    }
                    $result.html(response);
                    $result.perfectScrollbar('update');
                    $result.addClass('in');
                },
                error: function (response) {
                    if (response.statusText == 'abort') {
                        return;
                    }

                    if ($icon.length > 0) {
                        $icon.removeClass('fa-spinner fa-spin');
                        $icon.addClass('fa-search');
                    }

                }
            });
        }
    };

    G5_Core.off_canvas = {
        init: function () {
            var _that = this;
            $('[data-off-canvas="true"]').each(function () {
                var $this = $(this),
                    target = $this.data('off-canvas-target'),
                    inner = $(target).children('.canvas-sidebar-inner'),
                    position = $this.data('off-canvas-position'),
                    $wrapper = $('#gf-wrapper'),
                    targetWidth = $(target).width(),
                    padding_top = $(target).css('padding-top').replace("px", ""),
                    max_height = $(window).height() - G5_Core.util.getAdminBarOffset() - padding_top;

                if('#canvas-menu-wrapper' === target) {
                    targetWidth -= 100;
                }
                $(target).addClass(position);
                inner.css('max-height', max_height).perfectScrollbar({
                    wheelSpeed: 0.5,
                    suppressScrollX: true
                });
                $(target).css('top', G5_Core.util.getAdminBarOffset());

                $this.off('click').on('click', function () {
                    $(target).removeClass('left').removeClass('right').addClass(position);
                    if ($this.hasClass('in') || $(target).hasClass('in')) {
                        $this.removeClass('in');
                        $body.removeClass('off-canvas-in');
                        $(target).removeClass('in');
                        $wrapper.css({
                            'margin-left': '',
                            'margin-right': ''
                        });
                        setTimeout(function () {
                            $body.removeClass('off-canvas-' + position);
                        }, 1000);
                    } else {
                        $body.addClass('off-canvas-' + position);
                        setTimeout(function () {
                            $this.addClass('in');
                            $body.addClass('off-canvas-in');
                            $(target).addClass('in');

                            if (!$body.hasClass('boxed') && !$body.hasClass('framed') && !$body.hasClass('bordered')) {
                                if (isRTL) {
                                    if (position === 'left') {
                                        $wrapper.css({
                                            //'margin-left': -targetWidth,
                                            'margin-right': targetWidth
                                        });
                                    } else {
                                        $wrapper.css({
                                            'margin-left': targetWidth,
                                            'margin-right': -targetWidth
                                        });
                                    }
                                } else {
                                    if (position === 'left') {
                                        $wrapper.css({
                                            'margin-left': targetWidth,
                                            'margin-right': -targetWidth
                                        });
                                    } else {
                                        $wrapper.css({
                                            'margin-left': -targetWidth,
                                            'margin-right': targetWidth
                                        });
                                    }
                                }
                            }
                        }, 100);
                    }
                });
            });

            $('.canvas-overlay, .close-canvas').off('click').on('click', function () {
                _that.closeAll();
            });

            $(window).on('resize', function () {
                $('[data-off-canvas="true"]').each(function () {
                    var $this = $(this),
                        target = $this.data('off-canvas-target'),
                        inner = $(target).children('.canvas-sidebar-inner'),
                        max_height = $(window).height() - G5_Core.util.getAdminBarOffset();
                    $(target).css({
                        'top': G5_Core.util.getAdminBarOffset()
                    });
                    inner.css('max-height', max_height);
                });
            });

            /*$(window).on('resize',function(){
             _that.closeAll();
             });*/
        },
        closeAll: function () {
            $('[data-off-canvas="true"]').each(function () {
                var $this = $(this),
                    target = $this.data('off-canvas-target'),
                    $wrapper = $('#gf-wrapper');
                if ($this.hasClass('in') || $(target).hasClass('in')) {
                    $this.removeClass('in');
                    $body.removeClass('off-canvas-in');
                    $(target).removeClass('in');
                    $wrapper.css({
                        'margin-left': '',
                        'margin-right': ''
                    });
                    setTimeout(function () {
                        $body.removeClass('off-canvas-right').removeClass('off-canvas-left');
                    }, 1000);
                }
            });
        }
    };

    G5_Core.cache = {
        cache: {},
        addCache: function (key, value, group) {
            if (typeof this.cache[group] === 'undefined') {
                this.cache[group] = {};
            }
            if (typeof this.cache[group][key] !== 'undefined') return;
            this.cache[group][key] = value;

        },
        getCache: function (key, group) {
            if ((typeof this.cache[group] !== 'undefined') && (typeof this.cache[group][key] !== 'undefined')) {
                return this.cache[group][key];
            }
            return '';
        }
    };

    G5_Core.pagination_ajax = {
        ajax: false,
        prefix: 'gf_ajax_paginate_',
        timeOutLoadPost: null,
        paging: {
            pagination: 'pagination',
            paginationAjax: 'pagination-ajax',
            loadMore: 'load-more',
            nextPrev: 'next-prev',
            infiniteScroll: 'infinite-scroll'
        },
        init: function () {
            this.addCache();
            this.events();
        },
        addCache: function () {
            var _that = this;
            $('[data-items-paging="pagination-ajax"],[data-items-paging="next-prev"],[data-items-cate]').each(function () {
                var settingId = $(this).data('id'),
                    _data = _that.getVariable(settingId);

                if (_data !== '') {
                    var $wrapper = (_data.settings['isMainQuery'] && $(this).closest('#wrapper-content').length) ? $(this).closest('#wrapper-content') : $(this).closest('[data-items-wrapper]'),
                        _html = $wrapper[0].outerHTML,
                        $currentCate = $wrapper.find('[data-items-cate] > li.active a');

                    var paged = typeof _data.query['paged'] !== 'undefined' ? _data.query['paged'] : 1,
                        cat = $currentCate.length > 0 ? parseInt($currentCate.data('id'), 10) : -1,
                        cacheKey = cat + '-' + paged;

                    if (_data.settings['isMainQuery']) {
                        cacheKey = window.location.href;
                    }

                    G5_Core.cache.addCache(cacheKey, _html, settingId);
                }
            });
        },
        events: function () {
            // pagination and load-more
            var _that = this;
            $(document).on('click', '[data-items-paging="pagination-ajax"] > a,[data-items-paging="load-more"] > a,[data-items-paging="next-prev"] > a,[data-items-paging="infinite-scroll"] > a', function (event) {
                event.preventDefault();
                var $this = $(this),
                    $pagingWrapper = $this.closest('[data-items-paging]'),
                    settingId = $pagingWrapper.data('id');
                _that.loadPosts(settingId, this);
            });

            // infinite-scroll
            if ($('[data-items-paging="infinite-scroll"]').length > 0) {
                $window.on('scroll', function (event) {
                    $('[data-items-paging="infinite-scroll"]').each(function () {
                        var $navigation = $(this);
                        if ($navigation.length === 0 || _that.ajax) return;
                        if (($window.scrollTop() + $window.height()) > $navigation.offset().top) {
                            var $this = $('> a', $navigation);
                            $this.trigger('click');
                        }
                    });
                });
            }

            // category filter
            $(document).on('click', '[data-items-cate] li:not(.dropdown) > a', function (event) {
                event.preventDefault();
                var _this = this,
                    settingId = $(this).closest('[data-items-cate]').data('id');
                _that.loadPosts(settingId, _this);
            });

            // tab filter
            $(document).on('click', '[data-items-tabs] li:not(.dropdown) > a', function (event) {
                event.preventDefault();
                var $this = $(this),
                    settingId = $this.data('id');
                _that.loadPosts(settingId, this);
            });
        },
        getVariable: function (settingId) {
            var varName = this.prefix + settingId;
            if (typeof window[varName] !== 'undefined') {
                return window[varName];
            }
            return '';
        },
        loadPosts:function(settingId,target) {
            if ( ($(target).closest('.gf-attr-filter-content').length === 0) && ($(target).hasClass('active') || $(target).hasClass('disable') || $(target).parent().hasClass('active') || $(target).hasClass('dropdown-toggle'))) return;
            var _that = G5_Core.pagination_ajax;
            if (_that.ajax) return;
            var _data = _that.getVariable(settingId);
            if (_data === '') return;
            var type = ($(target).closest('[data-items-paging]').length > 0) ? 'paging' : (($(target).closest('[data-items-cate]').length > 0) ? 'cat' : (($(target).closest('[data-items-tabs]').length > 0) ? 'tab' : '')),
                $wrapper = type === 'tab' ? $(target).closest('[data-items-wrapper]') :  $('[data-items-wrapper="'+ settingId +'"]'),
                $currentCate = $wrapper.find('[data-items-cate] > li.active a'),
                paged = 1,
                cat = $currentCate.length > 0 ? parseInt($currentCate.data('id'), 10) : -1,
                cat_slug = '',
                taxonomy = typeof _data.settings['taxonomy'] !== 'undefined' ? _data.settings['taxonomy'] : 'category';
            G5_Core.loading_content.showLoading($wrapper, _data, target);

            if (type === 'paging') {
                var pagination = typeof _data.settings['post_paging'] !== 'undefined' ? _data.settings['post_paging'] : _that.paging.pagination,
                    currentPage = _that.getCurrentPage($(target), pagination);
                paged = currentPage.paged;
                _data.settings['currentPage'] = currentPage;
                if (pagination === _that.paging.loadMore || pagination === _that.paging.infiniteScroll) {
                    _data.query['index'] = $wrapper.find(_data.settings['itemSelector']).not('.gsf-col-base').length;
                }
                if ((typeof (_data.settings.cat) !== 'undefined') && (_data.settings.cat !== '')  && ((typeof (_data.settings.current_cat) === 'undefined') || (_data.settings.current_cat === -1))) {
                    delete _data.query['gf_cat'];
                    if (_data.settings['post_type'] === 'post') {
                        delete _data.query['category_name'];
                        delete _data.query['cat'];
                    } else {
                        delete _data.query['term'];
                        delete _data.query[taxonomy];
                        delete _data.query['taxonomy'];
                        _data.query['post_type'] = _data.settings['post_type'];
                    }
                }
            } else if (type === 'cat') {
                currentPage = _that.getCurrentPage($(target), '');
                _data.settings['currentPage'] = currentPage;
                paged = 1;
                cat = parseInt($(target).data('id'), 10);
                cat_slug = $(target).data('name');

                if (cat > 0) {
                    _data.query['gf_cat'] = cat;
                    _data.settings['current_cat'] = cat;
                    delete _data.query['tax_query'];
                    delete _data.query['s'];
                    delete _data.query['search_terms_count'];
                    delete _data.query['search_terms'];

                    if (_data.settings['post_type'] === 'post') {
                        _data.query['category_name'] = cat_slug;
                        _data.query['cat'] = cat;
                    } else {
                        _data.query[taxonomy] = cat_slug;
                        _data.query['term'] = cat_slug;
                        _data.query['taxonomy'] = taxonomy;
                    }
                    delete _data.query['post_type'];


                } else {
                    delete _data.query['gf_cat'];
                    _data.settings['current_cat'] = -1;
                    if (_data.settings['post_type'] === 'post') {
                        delete _data.query['category_name'];
                        delete _data.query['cat'];
                    } else {
                        delete _data.query['term'];
                        delete _data.query[taxonomy];
                        delete _data.query['taxonomy'];
                        _data.query['post_type'] = _data.settings['post_type'];
                    }
                }
            } else {
                delete _data.query['gf_cat'];
                if (_data.settings['post_type'] === 'post') {
                    delete _data.query['category_name'];
                    delete _data.query['cat'];
                } else {
                    delete _data.query['term'];
                    delete _data.query[taxonomy];
                    delete _data.query['taxonomy'];
                    _data.query['post_type'] = _data.settings['post_type'];
                }
            }

            if (type === '') {
                currentPage = _that.getCurrentPage($(target), '');
                _data.settings['currentPage'] = currentPage;
                delete _data.settings['current_cat'];
            }


            var cacheKey = cat + '-' + paged;
            if (_data.settings['isMainQuery']) {
                cacheKey = $(target).attr('href');
            }

            var cacheData = G5_Core.cache.getCache(cacheKey, settingId);
            if (cacheData !== '') {
                _that.ajax = true;
                _that.onSuccess(cacheData, _data, target,type,$wrapper);
                _that.ajax = false;
            } else {
                var _urlRequest = g5plus_variable.ajax_url;
                if (_data.settings['isMainQuery']) {
                    _urlRequest = $(target).attr('href');
                }

                _data.action = 'pagination_ajax';
                _data.query['paged'] = paged;
                _data.settings['settingId'] = settingId;

                _that.ajax = $.ajax({
                    type: 'POST',
                    data: _data,
                    url: _urlRequest,
                    dataType: 'text',
                    success: function (response) {
                        G5_Core.cache.addCache(cacheKey, response, settingId);
                        _that.onSuccess(response, _data, target,type,$wrapper);
                        _that.ajax = false;
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        G5_Core.loading_content.hideLoading($wrapper);
                        _that.ajax = false;
                    }
                });
            }
        },
        onSuccess: function (response, _data, target, type, $wrapper) {
            var _that = this,
                $container = $wrapper.find('[data-items-container]'),
                owlCarousel = $container.hasClass('owl-carousel');
            if ((owlCarousel === true)
                || (type === 'cat')
                || (_data.settings['post_paging'] === _that.paging.paginationAjax)
                || (_data.settings['post_paging'] === _that.paging.nextPrev)
                || (type === 'tab')
            ) {
                if (type === 'cat') {
                    $wrapper.find('[data-items-cate] li').removeClass('active');
                    $(target).closest('li').addClass('active');
                    $(target).closest('.dropdown').addClass('active');
                }

                if (type === 'tab') {
                    $wrapper.find('[data-items-tabs] li').removeClass('active');
                    $(target).closest('li').addClass('active');
                    $(target).closest('.dropdown').addClass('active');
                }

                _that.updatePosts(response, _data,target,$wrapper);
            } else {
                _that.updatePosts(response, _data, target,$wrapper);
            }
        },
        updatePosts: function (response, _data, target, $wrapper) {
            var _that = this,
                $container = $wrapper.find('[data-items-container]'),
                $paging = $wrapper.find('[data-items-paging]'),
                $ajaxHTML = $(response),
                itemSelector = _data.settings['itemSelector'],
                $resultWrapper = (_data.settings['isMainQuery'] && $ajaxHTML.find('[data-archive-wrapper]').length) ? $ajaxHTML.find('[data-archive-wrapper]') : $ajaxHTML,
                $resultElements = $resultWrapper.find(itemSelector),
                $resultPaging = $resultWrapper.find('[data-items-paging]'),
                animation = (typeof _data.settings['post_animation'] !== 'undefined') ? _data.settings['post_animation'] : 'none',
                loadMore = (($(target).closest('[data-items-paging]').length > 0) && ((_data.settings['post_paging'] === G5_Core.pagination_ajax.paging.loadMore) || (_data.settings['post_paging'] === G5_Core.pagination_ajax.paging.infiniteScroll))),
                isotope = $container.hasClass('isotope'),
                owlCarousel = $container.hasClass('owl-carousel'),
                delay = 0;

                if ((animation === 'none') && (owlCarousel === false)) {
                    $resultElements.css({opacity: 0});
                }

                if (!loadMore) {
                    delay = 500;
                    if (animation === 'none') {
                        $container.find(itemSelector).animate({opacity: 0}, 500, 'easeOutQuad');
                    } else {
                        $container.find('.gf_animate_when_almost_visible').addClass('zoom-reverse');
                    }

                    if (typeof _data.settings['isMainQuery'] !== 'undefined' && _data.settings['isMainQuery'] === true) {
                        G5_Core.util.setPushState(_data.settings['currentPage'].url);
                    }
                }
                setTimeout(function(){
                    G5_Core.loading_content.hideLoading($wrapper);
                    if (!owlCarousel) {
                        if (!loadMore) {
                            $container.html($resultElements);
                        } else {
                            $container.append($resultElements);
                        }
                    }

                    if (isotope) {
                        var config = $container.data("isotope-options");
                        if (typeof(config) !== 'undefined') {
                            if (!loadMore) {
                                if ((typeof (config.masonry) !== 'undefined')
                                    && (typeof (config.masonry.columnWidth) !== 'undefined')
                                    && (config.masonry.columnWidth === '.gsf-col-base')) {
                                    $container.append('<article class="gsf-col-base"></article>');
                                }
                                $container.isotope('reloadItems').isotope();
                            } else {
                                $container.isotope('appended', $resultElements);
                            }

                            G5_Core.isotope.layout($container);
                            if ((typeof (config.masonry) !== 'undefined')
                                && (typeof (config.masonry.columnWidth) !== 'undefined')
                                && (config.masonry.columnWidth === '.gsf-col-base')) {
                                $(window).trigger('resize');
                            }
                        }
                    }

                    if (owlCarousel) {
                        var $owlCarousel = $container.data('owl.carousel'),
                            items = $owlCarousel._items,
                            position = items.length + 1,
                            duration = 300;
                        if (animation !== 'none') {
                            duration = 0;
                        }

                        if (!loadMore) {
                            for (var i = items.length - 1; i >= 0; i--) {
                                $owlCarousel.remove(i);
                            }
                            position = 0;
                        }

                        $resultElements.each(function () {
                            $owlCarousel.add($(this));
                        });
                        $owlCarousel.refresh();
                        $owlCarousel.to(position, duration);
                        if ((animation !== 'none') && (!loadMore)) {
                            new G5_Core_Animation($wrapper, 100);
                        }

                    } else {
                        if (animation === 'none') {
                            $resultElements.animate({opacity: 1}, 500, 'easeInQuad');
                        } else {
                            new G5_Core_Animation($wrapper);
                        }
                    }

                    if ($paging.length > 0) {
                        $paging.remove();
                    }
                    $wrapper.append($resultPaging);

                    $wrapper.imagesLoaded({background: true}, function () {
                        //owlCarousel
                        G5_Core.owlCarousel.init($wrapper);
                        // magnificPopup
                        G5_Core.util.magnificPopup($wrapper);
                        // lazyLoad
                        G5_Core.lazyLoad.init($wrapper);

                        $wrapper.trigger('gf_pagination_ajax_success', [_data, $ajaxHTML,target]);

                    });

                },delay);
        },
        getCurrentPage: function ($this, pagination) {
            var _that = this,
                url = $this.attr('href'),
                paged = 1;

            if (pagination === _that.paging.paginationAjax) {
                if (/[\?&amp;]paged=\d+/gi.test(url)) {
                    paged = /[\?&amp;]paged=\d+/gi.exec(url)[0];
                    paged = parseInt(/\d+/gi.exec(paged)[0], 10);
                } else if (/page\/\d+/gi.test(url)) {
                    paged = /page\/\d+/gi.exec(url)[0];
                    paged = parseInt(/\d+/gi.exec(paged)[0], 10);
                }
            } else if ((pagination === _that.paging.infiniteScroll)
                || (pagination === _that.paging.nextPrev)
                || (pagination === _that.paging.loadMore)
            ) {
                paged = parseInt($this.data('paged'), 10);
            }
            return {
                paged: paged,
                url: url
            };
        },
        updatePageTitle : function (_data, $ajaxHTML,target) {
            var loadMore = (($(target).closest('[data-items-paging]').length > 0) && ((_data.settings['post_paging'] === G5_Core.pagination_ajax.paging.loadMore) || (_data.settings['post_paging'] === G5_Core.pagination_ajax.paging.infiniteScroll))),
                $pageTitle = $('.gf-page-title');
            if (($pageTitle.length > 0 ) && !loadMore && (typeof _data.settings['isMainQuery'] !== 'undefined') && (_data.settings['isMainQuery'] === true) ) {
                var $resultPageTitle = $ajaxHTML.find('.gf-page-title');
                if ($resultPageTitle.length > 0) {
                    $pageTitle.replaceWith($resultPageTitle.prop('outerHTML'));
                    if (!$resultPageTitle.hasClass('gf-page-title-default') && "function" == typeof window.vc_js) {
                        vc_js();
                    }
                    $body.trigger('gf_pagination_ajax_before_update_page_title', [_data, $ajaxHTML,target]);
                }
            }
        },
        updateSideBar: function (_data, $ajaxHTML,target) {
            var loadMore = (($(target).closest('[data-items-paging]').length > 0) && ((_data.settings['post_paging'] === G5_Core.pagination_ajax.paging.loadMore) || (_data.settings['post_paging'] === G5_Core.pagination_ajax.paging.infiniteScroll))),
                $sidebar = $('.primary-sidebar');
            if (($sidebar.length > 0 ) && !loadMore && (typeof _data.settings['isMainQuery'] !== 'undefined') && (_data.settings['isMainQuery'] === true) ) {
                var $resultSidebar = $ajaxHTML.find('.primary-sidebar');
                if ($resultSidebar.length > 0) {
                    $sidebar.replaceWith($resultSidebar.prop('outerHTML'));
                    $body.trigger('gf_pagination_ajax_before_update_sidebar', [_data, $ajaxHTML,target]);
                }
            }
        }
    };

    G5_Core.blog = {
        init: function () {
            this.updateAjaxPosts();
            this.events();
            this.processThumbnail();
            this.singleThumbnail();
            this.alignFull();
            $(window).on('resize',function () {
                G5_Core.blog.alignFull();
            });
        },
        events: function () {
            var _that = this,
                time_out = null;
            $(window).on('resize', function () {
                if (time_out != null) {
                    clearTimeout(time_out);
                }
                time_out = setTimeout(function () {
                    _that.processThumbnail();
                }, 200);
            });
        },
        updateAjaxPosts: function () {
            var _that = this;
            $body.on('gf_pagination_ajax_success', function (event, _data,$ajaxHTML,target) {
                if (_data.settings['post_type'] === 'post') {
                    $(event.target).imagesLoaded({background: true}, function () {
                        _that.processThumbnail($(event.target));
                        $(event.target).trigger('gf_update_ajax_post', [_data,$ajaxHTML]);
                    });
                    G5_Core.pagination_ajax.updatePageTitle(_data,$ajaxHTML,target);
                    G5_Core.pagination_ajax.updateSideBar(_data,$ajaxHTML,target);

                }
            });
        },
        processThumbnail: function ($wrapper) {
            if (typeof $wrapper === 'undefined') {
                $wrapper = $body;
            }

            $('.entry-thumb-wrap', $wrapper).each(function () {
                if ($(this).width() <= 320) {
                    $(this).addClass('thumb-small');
                } else {
                    $(this).removeClass('thumb-small');
                }
            });
        },
        singleThumbnail: function () {
            if ($('body.single-post').find('.entry-thumb-single').length) {
                $('body').addClass('has-post-thumbnail');
            } else {
                $('body').addClass('no-post-thumbnail');
            }
        },
        alignFull: function () {
            var fullWidth = $(document).width(),
                marginWidth = (fullWidth - 770) / 2;
            if (G5_Core.util.isDesktop()) {
                $('body.single-post.no-sidebar:not(.used-vc) .gf-entry-content > .alignfull').css({
                    'margin-left' : - marginWidth + 'px',
                    'margin-right' : - marginWidth + 'px'
                });
            } else {
                $('body.single-post.no-sidebar:not(.used-vc) .gf-entry-content > .alignfull').css({
                    'margin-left' : '',
                    'margin-right' : ''
                });
            }


        }
    };

    G5_Core.custom_vc = {
        init: function () {
            setTimeout(this.wayPoints, 500);
        },
        wayPoints: function () {

            $(".wpb_animate_when_almost_visible:not(.wpb_start_animation)").waypoint(function () {
                $(this.element).addClass("wpb_start_animation animated");
                this.destroy();
            }, {
                offset: "85%"
            });

            $(".vc_progress_bar").waypoint(function () {
                $(this.element).find(".vc_single_bar").each(function (index) {
                    var $this = $(this),
                        bar = $this.find(".vc_bar"),
                        val = bar.data("percentage-value");
                    setTimeout(function () {
                        bar.css({
                            width: val + "%"
                        })
                    }, 200 * index)
                });
                this.destroy();
            }, {
                offset: "85%"
            });
        }
    };

    G5_Core.widget = {
        init: function () {
            this.calendar();
            this.canvas();
        },
        calendar: function () {
            $(".widget.widget_calendar table tbody td a").each(function () {
                $(this).parent().addClass('active');
            });
        },
        canvas: function () {
            var $sidebar = $('.gf-sidebar-canvas'),
                $sidebarInner = $sidebar.find('.primary-sidebar-inner');
            if ($sidebar.length === 0) return;
            var $wrapper = $('#gf-wrapper'),
                skin = $wrapper.attr('class');

            $sidebarInner.on('scroll',function () {
                $(window).trigger('scroll');
            });

            if (!G5_Core.util.isDesktop()) {
                $sidebar.css({
                    opacity: 0,
                    visibility: 'hidden'
                });
                $sidebar.addClass(skin);
                /*$sidebarInner.perfectScrollbar({
                    wheelSpeed: 0.5,
                    suppressScrollX: true
                });*/
                setTimeout(function () {
                    $sidebar.css({
                        opacity: '',
                        visibility: ''
                    });
                }, 1000);

            }
            $(window).on('resize', function () {
                if (G5_Core.util.isDesktop()) {
                    $sidebar.removeClass(skin);
                    //$sidebarInner.perfectScrollbar('destroy');
                } else {
                    $sidebar.css({
                        opacity: 0,
                        visibility: 'hidden'
                    });
                    $sidebar.addClass(skin);
                    /*$sidebarInner.perfectScrollbar({
                        wheelSpeed: 0.5,
                        suppressScrollX: true
                    });*/
                    setTimeout(function () {
                        $sidebar.css({
                            opacity: '',
                            visibility: ''
                        });
                    }, 1000);
                }
            });

            $('.gf-sidebar-toggle').on('click', function () {
                $(this).closest('.gf-sidebar-canvas').toggleClass('in');
            });
        }
    };

    G5_Core.sticky = {
        init: function () {
            this.initSticky();
            setTimeout(function () {
                G5_Core.sticky.initSticky();
            }, 1000);
            this.responsive();
        },
        initSticky: function ($wrapper) {
            if (!$.fn.hcSticky) {
                return;
            }

            if (typeof $wrapper === 'undefined') {
                $wrapper = $body;
            }

            var _top = G5_Core.util.getScrollOffset();
            var defaults = {
                top: _top
            };
            if($body.hasClass('bordered') && G5_Core.util.isDesktop()) {
                defaults = {
                    top: _top,
                    bottom: 30
                };
            }
            if (G5_Core.util.isDesktop()) {
                $('.gf-sticky', $wrapper).each(function () {
                    var $this = $(this);
                    if ($this.data('hcSticky')) {
                        $this.hcSticky('reinit');
                    } else {
                        var config = $.extend({}, defaults, $this.data("sticky-options"));
                        $this.hcSticky(config);
                    }
                });
            }
        },
        responsive: function () {
            $body.on('resized.hcSticky', function (event, target) {
                var $this = $(target);
                if (!G5_Core.util.isDesktop()) {
                    if ($this.data('hcSticky')) {
                        $this.hcSticky('destroy');
                    }
                    $this.removeAttr('style');
                }
            });
        }
    };

    G5_Core.header = {
        init: function () {
            this.events();
            this.sticky();
            this.retinaLogo();
            this.adminBar();
            this.vertical();
            this.navSpacing();
            setTimeout(function () {
                G5_Core.header.navSpacing();
            }, 500)
        },
        events: function () {
            var _that = this,
                nav_time_out = null,
                popup_canvas_menu = $('#popup-canvas-menu');
            if(popup_canvas_menu.length) {
                popup_canvas_menu.find('a[href="#"]').on('click', function (e) {
                   e.preventDefault();
                });
                popup_canvas_menu.off('click').on('click', '#main-menu > .menu-item-has-children > a', function (e) {
                    e.preventDefault();
                    if($(this).closest('.menu-item-has-children').find('.sub-menu-active').length === 0) {
                        popup_canvas_menu.find('.sub-menu-active').removeClass('sub-menu-active').slideUp('300');
                    }
                    $(this).parent().find('.sub-menu').addClass('sub-menu-active').slideToggle('500', function () {
                        popup_canvas_menu.find('.primary-menu').perfectScrollbar('update');
                    });
                });
                $(document).on('keyup', function (event) {
                    if (event.keyCode === 27) {
                        popup_canvas_menu.removeClass('show');
                        popup_canvas_menu.find('.sub-menu').slideUp('500');
                    }
                });
            }
            $window.on('resize', function () {
                if (nav_time_out !== null) {
                    clearTimeout(nav_time_out);
                }
                nav_time_out = setTimeout(function () {
                    _that.navSpacing();
                }, 100);
                _that.adminBar();
                $('.header-sticky').each(function () {
                    var $this = $(this);
                    if ($body.hasClass('bordered') && _that.isDesktop()) {
                        $this.css('width', $body.width() - 120);
                    }
                });
            });
            $('.gf-menu-canvas').magnificPopup({
                type: 'inline',
                closeOnBgClick: false,
                closeBtnInside: false,
                alignTop: true,
                mainClass: 'mfp-move-from-top gsf-menu-popup',
                midClick: true,
                removalDelay: 700
            });
        },
        isDesktop: function () {
            var responsive_breakpoint = 991,
                $header = $('header.main-header');
            if ($header.length) {
                responsive_breakpoint = parseInt($header.data('responsive-breakpoint'), 10);
            }
            return window.matchMedia('(min-width: ' + (responsive_breakpoint + 1) + 'px)').matches;
        },
        navSpacing: function () {
            var _that = this;
            var $header = $('header.main-header');
            if ($header.length === 0) return;
            var arrConfig = {
                'header-1': {
                    'header.main-header .main-menu': '>li'
                },
                'header-2': {
                    'header.main-header .main-menu': '>li'
                },
                'header-3': {
                    'header.main-header .main-menu': '>li'
                },
                'header-4': {
                    'header.main-header .main-menu': '>li'
                },
                'header-5': {
                    'header.main-header .main-menu': '>li'
                },
                'header-6': {
                    'header.main-header .main-menu': '>li'
                },
            };

            var layout = $header.data('layout');
            if (typeof arrConfig[layout] === 'undefined') return;

            var totalWidth = 0,
                containerWidth = 0,
                itemCount = 0,
                newSpacing = 0,
                navSpacing = $header.data('navigation');
            if (!navSpacing) {
                navSpacing = 30;
            }

            for (var container in arrConfig[layout]) {
                $(container).each(function () {
                    containerWidth = $(this).width() - 1;
                    totalWidth = 0;
                    itemCount = 0;

                    if (isRTL) {
                        $(arrConfig[layout][container], this).css('margin-right', '');
                    } else {
                        $(arrConfig[layout][container], this).css('margin-left', '');
                    }

                    $(arrConfig[layout][container], this).each(function () {
                        totalWidth += $(this).width();
                        itemCount++;
                    });

                    if (itemCount > 1) {
                        itemCount--;
                        if (totalWidth + itemCount * navSpacing > containerWidth) {
                            newSpacing = Math.floor((containerWidth - totalWidth) / itemCount);
                            if (newSpacing < 10) {
                                newSpacing = 10;
                            }

                            if (isRTL) {
                                $(arrConfig[layout][container], this).not(':first').css('margin-right', newSpacing + 'px');
                            } else {
                                $(arrConfig[layout][container], this).not(':first').css('margin-left', newSpacing + 'px');
                            }
                        }
                    }
                });
            }
        },
        sticky: function () {
            var _that = this;
            $('.header-sticky').each(function () {
                var $this = $(this),
                    $header = $this.closest('header'),
                    $menu = $header.find('.primary-menu');
                if ($(document).outerHeight() - $this.outerHeight() <= $window.outerHeight()) {
                    return;
                }
                $this.wrap("<div class='header-sticky-wrapper'></div>");
                var $stickyWrapper = $this.closest('.header-sticky-wrapper');

                $this.on('affix.bs.affix', function () {
                    var _top = G5_Core.util.getAdminBarOffset();
                    if ($body.hasClass('bordered') && _that.isDesktop()) {
                        _top += 30;
                        $this.css('width', $body.width() - 60);
                    }
                    $this.css('top', _top);
                    if ($stickyWrapper.length) {
                        $stickyWrapper.addClass('affix-wrap');
                    }
                    $(window).trigger('x-menu-change');
                });

                $this.on('affix-top.bs.affix', function () {
                    $this.css('top', '');
                    $this.css('width', '');
                    if ($stickyWrapper.length) {
                        $stickyWrapper.removeClass('affix-wrap');
                    }
                    $(window).trigger('x-menu-change');
                });

                $this.affix({
                    offset: {
                        top: function () {
                            var _top = 1,
                                $topBar = $header.find('.top-bar'),
                                $adminBar = $('#wpadminbar'),
                                $header_above = $header.find('.header-above');

                            _top += $header.offset().top;

                            if ($adminBar.length && ($adminBar.css('position') == 'absolute')) {
                                _top += $adminBar.outerHeight();
                            }

                            if ($header.hasClass('mobile-header')) {
                                $topBar = $header.find('.mobile-top-bar');
                            }

                            if ($topBar.length) {
                                _top += $topBar.outerHeight();
                            }

                            if ($header_above.length) {
                                _top += $header_above.outerHeight();
                            }
                            return _top;
                        }
                    }
                });
            });

            var scrollOffset = 0;
            $(window).scroll(function () {
                var currentScrollOffset = $(this).scrollTop();
                if (scrollOffset > currentScrollOffset) {
                    $('.header-sticky').each(function () {
                        if ($(this).find('.menu-one-page').length === 0 && $(this).closest('[data-sticky-type="scroll_up"]').length > 0) {
                            if ($(this).hasClass('header-hidden')) {
                                $(this).removeClass('header-hidden');
                            }
                        }
                    });
                } else {
                    // down
                    $('.header-sticky').each(function () {
                        if ($(this).find('.menu-one-page').length === 0 && $(this).closest('[data-sticky-type="scroll_up"]').length > 0) {
                            var $wrapper = $(this).closest('.header-sticky-wrapper');
                            if ($wrapper.length && (currentScrollOffset > ($wrapper.offset().top + $(this).outerHeight())) && !$(this).hasClass('header-hidden')) {
                                $(this).addClass('header-hidden');
                            }
                        }
                    });
                }
                scrollOffset = currentScrollOffset;
            });
        },
        retinaLogo: function () {
            if (window.matchMedia('only screen and (min--moz-device-pixel-ratio: 1.5)').matches
                || window.matchMedia('only screen and (-o-min-device-pixel-ratio: 3/2)').matches
                || window.matchMedia('only screen and (-webkit-min-device-pixel-ratio: 1.5)').matches
                || window.matchMedia('only screen and (min-device-pixel-ratio: 1.5)').matches) {
                $('img[data-retina]').each(function () {
                    $(this).attr('src', $(this).attr('data-retina'));
                });
            }
        },
        adminBar: function () {
            var $adminBar = $('#wpadminbar');
            if (window.matchMedia('(max-width: 600px)').matches) {
                $adminBar.css('top', '-46px');
            }
            else {
                $adminBar.css('top', '');
            }
        },
        vertical: function () {
            var $header = $('.main-header.header-vertical');
            if ($header.length === 0) return;
            $header.css('top', G5_Core.util.getAdminBarOffset());


            var $headerAbove = $header.find('.header-above'),
                $menu = $header.find('.primary-menu'),
                $headerCustomize = $header.find('.header-customize'),
                menuHeight = $header.height();
            if ($headerAbove.length) {
                menuHeight -= $headerAbove.outerHeight();
            }

            if ($headerCustomize.length) {
                menuHeight -= $headerCustomize.outerHeight();
            }
            $menu.css('max-height', menuHeight);
            $menu.perfectScrollbar({
                wheelSpeed: 0.5,
                suppressScrollX: true
            });

            $menu.on('gf_menu_vertical_clicked', function () {
                setTimeout(function () {
                    $menu.perfectScrollbar('update');
                }, 500);
            });


            $(window).on('resize', function () {
                $header.css('top', G5_Core.util.getAdminBarOffset());

                menuHeight = $header.height();
                if ($headerAbove.length) {
                    menuHeight -= $headerAbove.outerHeight();
                }

                if ($headerCustomize.length) {
                    menuHeight -= $headerCustomize.outerHeight();
                }
                $menu.css('max-height', menuHeight);
                $menu.perfectScrollbar('update');
            });

        }
    };

    G5_Core.menu = {
        init: function () {
            this.mega();
            this.onePage();
            this.menuCaret();
            this.vertical();
        },
        menuCaret: function () {
            $('.gf-menu-vertical,.main-menu').each(function () {
                $('li > a', $(this)).each(function () {
                    var $this = $(this);
                    if ($('> ul', $this.parent()).length) {
                        $this.append('<b class="menu-caret"></b>');
                    }
                });
            });
        },
        vertical: function () {
            $('.gf-menu-vertical:not(.x-nav-menu) li').on('click', function (event) {
                if ($('> ul', this).length == 0) {
                    return;
                }
                if ($(event.target).closest($('> ul', this)).length > 0) {
                    return;
                }

                if ($(event.target).closest($('> a > span', this)).length > 0) {
                    var baseUri = '';
                    if ((typeof (event.target) != "undefined") && (event.target != null) && (typeof (event.target.baseURI) != "undefined") && (event.target.baseURI != null)) {
                        var arrBaseUri = event.target.baseURI.split('#');
                        if (arrBaseUri.length > 0) {
                            baseUri = arrBaseUri[0];
                        }

                        var $aClicked = $('> a', this);
                        if ($aClicked.length > 0) {
                            var clickUrl = $aClicked.attr('href');
                            if (clickUrl != '#') {
                                if ((typeof (clickUrl) != "undefined") && (clickUrl != null)) {
                                    clickUrl = clickUrl.split('#')[0];
                                }
                                if (baseUri != clickUrl) {
                                    return;
                                }
                            }

                        }
                    }
                }
                event.preventDefault();
                $(this).toggleClass('menu-open');
                $('> ul', this).slideToggle();
                $(this).trigger('gf_menu_vertical_clicked');
            });
        },
        mega: function () {
            $('.x-nav-menu > li a').on('mouseenter mouseleave',function () {
                var $mega = $(this).next('ul').find('.x-mega-sub-menu');
                if ($mega.length) {
                    new G5_Core_Animation($mega);
                }
            });
        },
        onePage: function () {
            if (typeof ($().onePageNav) === 'function') {
                $('.menu-one-page').onePageNav({
                    currentClass: 'menu-current',
                    changeHash: false,
                    scrollSpeed: 750,
                    scrollThreshold: 0,
                    filter: '',
                    easing: 'swing'
                });
            }
        }
    };

    G5_Core.footer = {
        init: function () {
            this.events();
            this.footerFixed();
        },
        events: function () {
            $window.on('resize', this.footerFixed);
        },
        footerFixed: function () {
            if (window.matchMedia('(max-width: 768px)').matches) {
                $body.css('margin-bottom', '');
            }
            else {
                setTimeout(function () {
                    var $footer = $('footer.main-footer-wrapper');
                    if ($footer.hasClass('footer-fixed')) {
                        var headerSticky = $('header.main-header .sticky-wrapper').length > 0 ? 55 : 0,
                            $adminBar = $('#wpadminbar'),
                            $adminBarHeight = $adminBar.length > 0 ? $adminBar.outerHeight() : 0;
                        if (($window.height() >= ($footer.outerHeight() + headerSticky + $adminBarHeight))) {
                            if ($('body.bordered').length > 0) {
                                $body.css('margin-bottom', ($footer.outerHeight() + 60) + 'px');
                            }
                            else {
                                $body.css('margin-bottom', ($footer.outerHeight()) + 'px');
                            }
                            $footer.removeClass('static');
                        } else {
                            $body.css('margin-bottom', '');
                            $footer.addClass('static');
                        }
                    }
                }, 100);
            }
        }
    };

    $(document).ready(function () {
        G5_Core.util.init();
        G5_Core.loading_content.init();
        G5_Core.sticky.init();
        G5_Core.lazyLoad.init();
        G5_Core.isotope.init();
        G5_Core.owlCarousel.init();
        G5_Core.owlCarouselSync.init();
        G5_Core.search_popup.init();
        G5_Core.search_ajax.init();
        G5_Core.off_canvas.init();
        G5_Core.blog.init();
        G5_Core.widget.init();
        G5_Core.pagination_ajax.init();
        G5_Core.custom_vc.init();
        new G5_Core_Animation();
        G5_Core.header.init();
        G5_Core.menu.init();
        G5_Core.footer.init();
    });

})(jQuery);
