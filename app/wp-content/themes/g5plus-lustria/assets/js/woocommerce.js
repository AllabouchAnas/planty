var G5_Woocommerce = window.G5_Woocommerce || {};
(function ($) {
    "use strict";
    window.G5_Woocommerce = G5_Woocommerce;

    var $body = $('body'),
        isLazy = $body.hasClass('gf-lazy-load'),
        isRTL = $body.hasClass('rtl'),
        isAjx = false;

    G5_Woocommerce = {
        init: function () {
            this.productCatalogFilter();
            this.initFilterAjax();
            this.updateAjaxSuccess();
            this.initFilterBellow();
            this.addToWishlist();
            this.addToCart();
            this.quickView();
            this.saleCountdown();

            $body.on('wc-product-gallery-after-init', function (event, target, wc_single_product_params) {
                G5_Woocommerce.singleProductImage($(target));
            });

            this.addCartQuantity();
            this.initSingleVideo();
            setTimeout(function () {
                G5_Woocommerce.setCartScrollBar();
            }, 500);
            this.events();
            $('select.country_to_state, input.country_to_state').trigger('change');
        },
        updateAjaxSuccess: function () {
            var _that = this;
            $body.on('gf_pagination_ajax_success', function (event, _data,$ajaxHTML,target) {
                if (_data.settings['post_type'] === 'product') {
                    G5_Core.pagination_ajax.updatePageTitle(_data,$ajaxHTML,target);
                    G5_Core.pagination_ajax.updateSideBar(_data,$ajaxHTML,target);
                    _that.updateAboveCustomize(_data,$ajaxHTML,target);
                    G5_Core.util.tooltip();
                    G5_Woocommerce.saleCountdown();
                    $body.trigger('gf_woocommerce_ajax_success', [_data, $ajaxHTML,target]);
                }
            });


            $body.on('gf_pagination_ajax_before_update_sidebar',function (event, _data,$ajaxHTML,target) {
                if (_data.settings['post_type'] === 'product') {
                    _that.initWidgetAjaxSuccess();
                }
            });
        },
        initFilterAjax: function() {
            $(document).on('click', '.clear-filter-wrap a, .gf-price-filter a, .gf-product-sorting a, .gf-attr-filter-content a, .gf-product-category-filter a, .product-categories a,.wc-block-product-categories a,.woocommerce-widget-layered-nav a', function (event) {
                var $wrapper = $('.gsf-product-wrap [data-archive-wrapper]');
                if ($wrapper.length > 0) {
                    event.preventDefault();
                    var settingId = $wrapper.data('items-wrapper');
                    G5_Core.pagination_ajax.loadPosts(settingId,this);
                }
            });

        },
        initFilterBellow: function() {
            var primary_content = $('#primary-content'),
                catalog_filter = $('.gsf-catalog-filter');
            if(catalog_filter.length) {
                catalog_filter.detach().insertBefore(primary_content);
                catalog_filter.removeAttr('hidden');
            }
            $(document).off('click','.gf-filter-bellow').on('click', '.gf-filter-bellow', function () {
                $('#gf-filter-content').slideToggle('500');
            });
        },
        updateAboveCustomize: function (_data,$ajaxHTML,target) {
            var loadMore = (($(target).closest('[data-items-paging]').length > 0) && ((_data.settings['post_paging'] === G5_Core.pagination_ajax.paging.loadMore) || (_data.settings['post_paging'] === G5_Core.pagination_ajax.paging.infiniteScroll))),
                $aboveCustomize = $('.gsf-catalog-filter');
            if (($aboveCustomize.length > 0 ) && !loadMore && (typeof _data.settings['isMainQuery'] !== 'undefined') && (_data.settings['isMainQuery'] === true) ) {
                var $resultAboveCustomize = $ajaxHTML.find('.gsf-catalog-filter');
                if ($resultAboveCustomize.length > 0) {
                    $aboveCustomize.replaceWith($resultAboveCustomize.removeAttr('hidden').prop('outerHTML'));
                    $( '.woocommerce-ordering' ).off('change').on( 'change', 'select.orderby', function() {
                        $( this ).closest( 'form' ).submit();
                    });

                    $('.gsf-pretty-tabs').each(function () {
                        $(this).gsfPrettyTabs();
                    });


                }
            }
        },
        initWidgetAjaxSuccess: function () {
            this.initPriceFilter();
        },
        initPriceFilter: function() {
            if (typeof $().slider === 'undefined') return;

            $( 'input#min_price, input#max_price' ).hide();
            $( '.price_slider, .price_label' ).show();

            var min_price = $( '.price_slider_amount #min_price' ).data( 'min' ),
                max_price = $( '.price_slider_amount #max_price' ).data( 'max' ),
                current_min_price = $( '.price_slider_amount #min_price' ).val(),
                current_max_price = $( '.price_slider_amount #max_price' ).val();

            $( '.price_slider:not(.ui-slider)' ).slider({
                range: true,
                animate: true,
                min: min_price,
                max: max_price,
                values: [ current_min_price, current_max_price ],
                create: function() {

                    $( '.price_slider_amount #min_price' ).val( current_min_price );
                    $( '.price_slider_amount #max_price' ).val( current_max_price );

                    $( document.body ).trigger( 'price_slider_create', [ current_min_price, current_max_price ] );
                },
                slide: function( event, ui ) {

                    $( 'input#min_price' ).val( ui.values[0] );
                    $( 'input#max_price' ).val( ui.values[1] );

                    $( document.body ).trigger( 'price_slider_slide', [ ui.values[0], ui.values[1] ] );
                },
                change: function( event, ui ) {

                    $( document.body ).trigger( 'price_slider_change', [ ui.values[0], ui.values[1] ] );
                }
            });
        },
        addToWishlist: function () {
            $(document).on('click', '.add_to_wishlist', function () {
                var button = $(this),
                    buttonWrap = button.parent().parent();

                if (!buttonWrap.parent().hasClass('single-product-function')) {
                    button.addClass("added-spinner");
                    var productWrap = buttonWrap.parent().parent().parent().parent();
                    if (typeof(productWrap) === 'undefined') {
                        return;
                    }
                    productWrap.addClass('active');
                }
            });

            $body.on("added_to_wishlist", function (event, fragments, cart_hash, $thisbutton) {
                var button = $('.added-spinner.add_to_wishlist'),
                    buttonWrap = button.parent().parent();
                if (!buttonWrap.parent().hasClass('single-product-function')) {
                    var productWrap = buttonWrap.parent().parent().parent().parent();
                    if (typeof(productWrap) === 'undefined') {
                        return;
                    }
                    setTimeout(function () {
                        productWrap.removeClass('active');
                        button.removeClass('added-spinner');
                    }, 700);
                }
            });

            $body.on('added_to_wishlist', function (t, el_wrap) {
                $('.customize-wishlist').each(function (){
                    var $total = $(this).find('span');
                    if ($total.length) {
                        var total = parseInt($total.text());
                        total = total + 1;
                        $total.text(total);
                    }
                });
            });

            $body.on('removed_from_wishlist', function (t, el_wrap) {
                $('.customize-wishlist').each(function (){
                    var $total = $(this).find('span');
                    if ($total.length) {
                        var total = parseInt($total.text());
                        total = total - 1;
                        if (total < 0) {
                            total = 0;
                        }
                        $total.text(total);
                    }
                });
            });

        },
        addToCart: function () {
            $(document).on('click', '.add_to_cart_button', function () {
                var button = $(this);
                if (button.hasClass('ajax_add_to_cart')) {
                    var productWrap = button.closest('.product-item-wrap');
                    if (typeof(productWrap) === 'undefined') {
                        return;
                    }
                    productWrap.addClass('active');
                }
            });

            $body.on('wc_cart_button_updated', function (event, $button) {
                var header_sticky = $('.header-sticky-wrapper .header-sticky'),
                    mini_cart = $('.item-shopping-cart', header_sticky);
                var is_single_product = $button.hasClass('single_add_to_cart_button');

                if (is_single_product) return;

                var buttonWrap = $button.parent(),
                    buttonViewCart = buttonWrap.find('.added_to_cart'),
                    addedTitle = buttonViewCart.text(),
                    productWrap = buttonWrap.closest('.product-item-inner');

                if(!$button.closest('.gf-product-swatched').length) {
                    $button.remove();
                }
                if (buttonWrap.data('toggle')) {
                    buttonViewCart.html('<i class="fa fa-check"></i> ' + addedTitle);
                    setTimeout(function () {
                        buttonWrap.tooltip('hide').attr('title', addedTitle).tooltip('_fixTitle');
                    }, 500);
                }
                setTimeout(function () {
                    G5_Woocommerce.setCartScrollBar(function () {
                        if (mini_cart.length > 0) {
                            var timeOut = 0;
                            if (header_sticky.hasClass('header-hidden')) {
                                header_sticky.removeClass('header-hidden');
                                timeOut = 500;
                            }
                            setTimeout(function () {
                                mini_cart.addClass('show-cart');
                                setTimeout(function () {
                                    mini_cart.removeClass('show-cart');
                                }, 2000)
                            }, timeOut);
                        }
                    });
                }, 10);
                setTimeout(function () {
                    productWrap.removeClass('active');
                }, 700);
            });

            $body.on('removed_from_cart', function () {
                setTimeout(function () {
                    G5_Woocommerce.setCartScrollBar();
                    $(document.body).trigger( 'update_checkout' );
                    var update_cart = $('[name="update_cart"]');
                    if(update_cart.length) {
                        update_cart.removeAttr('disabled').trigger('click');
                    }
                }, 10);
            });
        },
        setCartScrollBar: function (callback) {
            $('.cart_list.product_list_widget').perfectScrollbar({
                wheelSpeed: 0.5,
                suppressScrollX: true
            });
            if (callback) {
                callback();
            }
        },
        quickView: function() {
            var is_click_quick_view = false;
            $(document).on('click', '.product-quick-view', function (event) {
                event.preventDefault();
                if (is_click_quick_view) return;
                is_click_quick_view = true;
                var $this = $(this),
                    product_id = $this.data('product_id'),
                    popupWrapper = '#popup-product-quick-view-wrapper',
                    $icon = $this.find('i'),
                    iconClass = $icon.attr('class'),
                    productWrap = $this.closest('.product-item-wrap'),
                    button = $this;
                productWrap.addClass('active');
                button.addClass('active');
                $icon.attr('class', 'fal fa-spinner fa-spin');
                    $.ajax({
                        url: g5plus_variable.ajax_url,
                        data: {
                            action: 'product_quick_view',
                            id: product_id
                        },
                        success: function (html) {
                            productWrap.removeClass('active');
                            button.removeClass('active');
                            $icon.attr('class', iconClass);
                            var modal_body = $('.modal-body', popupWrapper);

                            if ($(popupWrapper).length) {
                                $(popupWrapper).remove();
                            }
                            $body.append(html);
                            var $productImageWrap = $('.quick-view-product-image', popupWrapper);
                            if (typeof $.fn.wc_variation_form !== 'undefined') {
                                var form_variation = $(popupWrapper).find('.variations_form');
                                var form_variation_select = $(popupWrapper).find('.variations_form .variations select');
                                form_variation.wc_variation_form();
                                form_variation.trigger('check_variations');
                                form_variation_select.change();
                            }
                            $(popupWrapper).modal();

                            if( typeof $.fn.wc_product_gallery !== 'undefined' ) {
                                setTimeout(function () {
                                    $('.woocommerce-product-gallery', $productImageWrap).wc_product_gallery();
                                    G5_Woocommerce.singleProductImage($productImageWrap);
                                    G5_Woocommerce.initSingleVideo();
                                }, 200);
                            }
                            G5_Core.util.tooltip();
                            G5_Woocommerce.saleCountdown();

                            G5_Core.util.magnificPopup($productImageWrap);

                            $body.trigger('gf_quick_view_success');

                            G5_Woocommerce.addCartQuantity();
                            is_click_quick_view = false;

                        },
                        error: function () {
                            is_click_quick_view = false;
                        }
                    });


            });
        },
        saleCountdown: function () {
            $('.product-deal-countdown').each(function () {
                var date_end = $(this).data('date-end');
                var $this = $(this);
                $this.countdown(date_end, function (event) {
                    count_down_callback(event, $this);
                }).on('update.countdown', function (event) {
                    count_down_callback(event, $this);
                });
            });

            function count_down_callback(event, $this) {
                var seconds = parseInt(event.offset.seconds);
                var minutes = parseInt(event.offset.minutes);
                var hours = parseInt(event.offset.hours);
                var days = parseInt(event.offset.totalDays);

                if (days < 10) days = '0' + days;
                if (hours < 10) hours = '0' + hours;
                if (minutes < 10) minutes = '0' + minutes;
                if (seconds < 10) seconds = '0' + seconds;


                $('.countdown-day', $this).text(days);
                $('.countdown-hours', $this).text(hours);
                $('.countdown-minutes', $this).text(minutes);
                $('.countdown-seconds', $this).text(seconds);
            }

            G5_Woocommerce.saleCountdownWidth();
        },

        saleCountdownWidth: function () {
            $('.product-deal-countdown').each(function () {
                if (!$(this).parents().hasClass('gsf-product-deal')) {
                    var innerWidth = 0;
                    $(this).removeClass('small');
                    $('.countdown-section', $(this)).each(function () {
                        innerWidth += $(this).outerWidth() + parseInt($(this).css('margin-right').replace("px", ''), 10);
                    });
                    if (innerWidth > $(this).outerWidth()) {
                        $(this).addClass('small');


                    }
                } else {
                    var innerHeight = 0;
                    $(this).removeClass('small');
                    $('.countdown-section', $(this)).each(function () {
                        innerHeight += $(this).innerHeight() + parseInt($(this).css('margin-top').replace("px", ''), 10);
                    });
                    if (innerHeight > $(this).outerHeight()) {
                        $(this).addClass('small');
                    }
                }
            });
        },
        singleProductImage: function ($productImageWrap) {
            var slider_thumb = $productImageWrap.find('.flex-control-thumbs'),
                items_show = 4,
                items_show_md = 3,
                items_show_sm = 4,
                items_show_xs = 4,
                items_show_mb = 4;
            if(slider_thumb.length) {
                slider_thumb.attr('hidden', 'hidden');
                if (slider_thumb.closest('.quick-view-product-image').length !== 0) {
                    items_show = 3;
                }
                if (slider_thumb.closest('.product-single-layout-01').length) {
                    slider_thumb.on('initialized.owl.carousel', function (event) {
                        setTimeout(function () {
                            slider_thumb.removeAttr('hidden');
                        }, 500);
                    }).addClass('owl-carousel owl-theme').owlCarousel({
                        nav: false,
                        dots: false,
                        rtl: isRTL,
                        lazyLoad: isLazy,
                        margin: 10,
                        responsive: {
                            1200 : {
                                items : items_show
                            },
                            992 : {
                                items : items_show_md
                            },
                            768 : {
                                items : items_show_sm
                            },
                            576 : {
                                items : items_show_xs
                            },
                            0 : {
                                items : items_show_mb
                            }

                        }
                    });
                } else {
                    slider_thumb.removeAttr('hidden');
                    if ($body.hasClass('no-sidebar')) {
                        items_show = 6;
                    }
                    slider_thumb.slick({
                        swipeToSlide: true,
                        infinite: false,
                        slidesToShow: items_show,
                        slidesToScroll: 2,
                        speed: 400,
                        arrows: false,
                        vertical: true,
                        verticalSwiping: true,
                        rtl: isRTL,
                        responsive: [
                            {
                                breakpoint: 1400,
                                settings: {
                                    slidesToShow: items_show,
                                    vertical: false,
                                    verticalSwiping: false
                                }
                            },
                            {
                                breakpoint: 992,
                                settings: {
                                    slidesToShow: items_show_md,
                                    vertical: false,
                                    verticalSwiping: false
                                }
                            },
                            {
                                breakpoint: 768,
                                settings: {
                                    slidesToShow: items_show_sm,
                                    vertical: false,
                                    verticalSwiping: false
                                }
                            },
                            {
                                breakpoint: 576,
                                settings: {
                                    slidesToShow: items_show_xs,
                                    vertical: false,
                                    verticalSwiping: false
                                }
                            },
                            {
                                breakpoint: 320,
                                settings: {
                                    slidesToShow: items_show_mb,
                                    vertical: false,
                                    verticalSwiping: false
                                }
                            }
                        ]
                    });
                }
            }
        },
        addCartQuantity: function () {
            $(document).off('click', '.quantity .btn-number').on('click', '.quantity .btn-number', function (event) {
                event.preventDefault();
                var type = $(this).data('type'),
                    input = $('input', $(this).parent()),
                    current_value = parseFloat(input.val()),
                    max = parseFloat(input.attr('max')),
                    min = parseFloat(input.attr('min')),
                    step = parseFloat(input.attr('step')),
                    stepLength = 0;
                if (input.attr('step').indexOf('.') > 0) {
                    stepLength = input.attr('step').split('.')[1].length;
                }

                if (isNaN(max)) {
                    max = -1;
                }
                if (isNaN(min)) {
                    min = 0;
                }
                if (isNaN(step)) {
                    step = 1;
                    stepLength = 0;
                }

                if (!isNaN(current_value)) {
                    if (type == 'minus') {
                        if (current_value > min) {
                            current_value = (current_value - step).toFixed(stepLength);
                            input.val(current_value).change();
                        }

                        if (parseFloat(input.val()) <= min) {
                            input.val(min).change();
                            $(this).attr('disabled', true);
                        }
                    }

                    if (type == 'plus') {
                        if ((max === -1) || (current_value < max)) {
                            current_value = (current_value + step).toFixed(stepLength);
                            input.val(current_value).change();
                        }
                        if ((max !== -1) && (parseFloat(input.val()) >= max)) {
                            input.val(max).change();
                            $(this).attr('disabled', true);
                        }
                    }
                } else {
                    input.val(min);
                }
            });


            $('input', '.quantity').on('focusin', function () {
                $(this).data('oldValue', $(this).val());
            });

            $('input', '.quantity').on('change', function () {
                var input = $(this),
                    max = parseFloat(input.attr('max')),
                    min = parseFloat(input.attr('min')),
                    current_value = parseFloat(input.val()),
                    step = parseFloat(input.attr('step'));

                if (isNaN(max)) {
                    max = -1;
                }
                if (isNaN(min)) {
                    min = 0;
                }

                if (isNaN(step)) {
                    step = 1;
                }


                var btn_add_to_cart = $('.add_to_cart_button', $(this).parent().parent().parent());
                if (current_value >= min) {
                    $(".btn-number[data-type='minus']", $(this).parent()).removeAttr('disabled');
                    if (typeof(btn_add_to_cart) != 'undefined') {
                        btn_add_to_cart.attr('data-quantity', current_value);
                    }

                } else {
                    alert('Sorry, the minimum value was reached');
                    $(this).val($(this).data('oldValue'));

                    if (typeof(btn_add_to_cart) != 'undefined') {
                        btn_add_to_cart.attr('data-quantity', $(this).data('oldValue'));
                    }
                }

                if ((max === -1) || (current_value <= max)) {
                    $(".btn-number[data-type='plus']", $(this).parent()).removeAttr('disabled');
                    if (typeof(btn_add_to_cart) != 'undefined') {
                        btn_add_to_cart.attr('data-quantity', current_value);
                    }
                } else {
                    alert('Sorry, the maximum value was reached');
                    $(this).val($(this).data('oldValue'));
                    if (typeof(btn_add_to_cart) != 'undefined') {
                        btn_add_to_cart.attr('data-quantity', $(this).data('oldValue'));
                    }
                }

            });
        },
        initSingleVideo: function () {
            var $product_video = $('.product-gallery__video'),
                $product_gallery = $('.woocommerce-product-gallery');
            if ($product_video.length && $product_gallery.length) {
                $product_video = $product_video.detach();
                $product_gallery.prepend($product_video);
                $product_video.removeAttr('hidden');
            }
        },
        productCatalogFilter: function () {
            $('.gsf-catalog-filter').each(function () {
                var $cat_filter = $(this).find('.gsf-catalog-filter-cat-filter');
                if ($cat_filter.length !== 0) {
                    $cat_filter.closest('.gsf-catalog-filter-item').css('flex', '1 0 0%').siblings().css('flex', '');
                    setTimeout(function () {
                        $body.find('.gsf-pretty-tabs').gsfPrettyTabs();
                    },10)
                }
            })
        },
        events: function () {
            var time_out = null;
            $(window).on('resize', function () {
                G5_Woocommerce.saleCountdown();
            });
        }
    };

    $(document).ready(function () {
        G5_Woocommerce.init();
    });
})(jQuery);
