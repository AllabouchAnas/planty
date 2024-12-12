(function ($) {
    "use strict";
    var G5_Main = window.G5_Main || {};
    window.G5_Main = G5_Main;

    var $window = $(window),
        $body = $('body'),
        isRTL = $body.hasClass('rtl'),
        deviceAgent = navigator.userAgent.toLowerCase(),
        isMobile = deviceAgent.match(/(iphone|ipod|android|iemobile)/),
        isMobileAlt = deviceAgent.match(/(iphone|ipod|ipad|android|iemobile)/),
        isAppleDevice = deviceAgent.match(/(iphone|ipod|ipad)/),
        isIEMobile = deviceAgent.match(/(iemobile)/),
        bodyHeight = 0;

    G5_Main.blog = {
        init: function () {
            this.events();
            this.readingProcess();
        },
        readingProcess: function () {
            var reading_process = $('#gsf-reading-process'),
                post_content = $('.single-post .gf-single-wrap .post-single');
            if (reading_process.length > 0 && post_content.length > 0) {
                post_content.imagesLoaded(function () {
                    var content_height = post_content.height(),
                        window_height = $window.height();
                    var percent = 0,
                        content_offset = post_content.offset().top,
                        window_offest = $window.scrollTop();

                    if (window_offest > content_offset) {
                        percent = 100 * (window_offest - content_offset) / (content_height - window_height);
                    }
                    if (percent > 100) {
                        percent = 100;
                    }
                    reading_process.css('width', percent + '%');
                    $window.scroll(function () {
                        var percent = 0,
                            content_offset = post_content.offset().top,
                            window_offest = $window.scrollTop();

                        if (window_offest > content_offset) {
                            percent = 100 * (window_offest - content_offset) / (content_height - window_height);
                        }
                        if (percent > 100) {
                            percent = 100;
                        }
                        reading_process.css('width', percent + '%');
                    });
                });
            }
        },
        events: function () {
            var _that = this;
        }
    };
    G5_Main.page = {
        init: function () {
            this.rowEqualHeight();
            this.events();
        },
        rowEqualHeight: function () {
            $('.row-equal-height').each(function () {
                var product_singular = $('.gsf-product-singular', $(this)),
                    product_info_height = $('.product-info', product_singular).outerHeight(),
                    banner = $('.gf-banner', $(this)),
                    banner_bg = $('.gf-banner-bg', banner),
                    row_left = $('.row-equal-height-left ', $(this)),
                    row_right = $('.row-equal-height-right ', $(this)),
                    vc_row = $('.vc_row', row_right),
                    vc_space = vc_row.first().siblings('.g5plus-space');

                    var row_right_height = (row_left.outerHeight() - vc_space.outerHeight())/2;
                    vc_row.css('height', row_right_height);
                if (G5_Core.util.isDesktop()) {
                    var image = $('.image-item', $('.product-singular-images', product_singular)),
                        image_height = image.outerHeight(),
                        product_height = (product_info_height + image_height);
                    banner_bg.css('padding-bottom', product_height + 'px');
                    $('.product-singular-images', product_singular).on('owlInitialized', function () {
                        image = $('.image-item', $(this));
                        image_height = image.outerHeight();
                        product_height = (product_info_height + image_height);
                        banner_bg.css('padding-bottom', product_height + 'px');
                    });
                } else {
                    banner_bg.css('padding-bottom', '');
                }
            });
        },
        events: function () {
            $(window).on('resize', function () {
                setTimeout(function () {
                    G5_Main.page.rowEqualHeight();
                }, 500);
            });
        }
    };
    G5_Main.popup = {
        init: function () {
            var login_link = $('.gsf-login-link-sign-in'),
                login_wrap = $('#gsf-popup-login-wrapper'),
                register_link = $('.gsf-login-link-sign-up'),
                register_wrap = $('#gsf-popup-register-wrapper');
            login_link.on('click', function () {
                if(login_wrap.length) {
                    login_wrap.modal();
                }
            });
            register_link.on('click', function () {
                if(register_wrap.length) {
                    register_wrap.modal();
                }
            });
            this.login_link_event();
        },
        login_link_event: function () {
            var ladda_button = null;
            $('#gsf-popup-login-form, #gsf-popup-register-form').submit(function (event) {
                ladda_button = null;
                var button = $(event.target).find('[type="submit"]'),
                    form_id = '#' + $(this).attr('id');
                if (button.hasClass('ladda-button') && button.length > 0) {
                    ladda_button = Ladda.create(button[0]);
                    ladda_button.start();
                }
                var input_data = $(form_id).serialize();
                $body.addClass('overflow-hidden');
                $body.append('<div class="processing-title"><i class="fa fa-spinner fa-spin fa-fw"></i></div>');
                $.ajax({
                    type: 'POST',
                    data: input_data,
                    url: g5plus_variable.ajax_url,
                    success: function (html) {
                        $('.processing-title').fadeOut(function () {
                            $('.processing-title').remove();
                            $body.removeClass('overflow-hidden');
                        });
                        var response_data = $.parseJSON(html);
                        if (response_data.code < 0) {
                            $('.login-message', form_id).html(response_data.message);
                        }
                        else {
                            window.location.reload();
                        }
                        if (ladda_button !== null) {
                            ladda_button.stop();
                            ladda_button.remove();
                        }
                    },
                    error: function (html) {
                        $('.processing-title').fadeOut(function () {
                            $('.processing-title').remove();
                            $body.removeClass('overflow-hidden');
                        });
                        if (ladda_button !== null) {
                            ladda_button.stop();
                            ladda_button.remove();
                        }
                    }
                });
                event.preventDefault();
                return false;
            });
        }
    };
    $(document).ready(function () {
        G5_Main.blog.init();
        G5_Main.page.init();
        G5_Main.popup.init();
    });
})
(jQuery);
