/**
 * Created by thanglk on 16/10/2018.
 */
(function ($) {
    "use strict";
    var G5Plus_Testimonials = {
        init: function() {
            var css = '';
            $('.gsf-testimonials').each(function(){
                var $body = $('body'),
                    $wrap = $(this),
                    tes_avatar = $wrap.find('.testimonial-avatar-wrap'),
                    tes_content = $wrap.find('.testimonial-content-wrap'),
                    isRTL = $body.hasClass('rtl'),
                    isLazy = $body.hasClass('gf-lazy-load');
                if(!tes_avatar.length) {
                    tes_content.owlCarousel({
                        items: 1,
                        nav: true,
                        dots: false,
                        loop: false,
                        rtl: isRTL,
                        autoHeight: true,
                        lazyLoad: isLazy,
                        navText: ['<i class="fal fa-angle-left"></i>', '<i class="fal fa-angle-right"></i>']
                    });
                    return false;
                }
                tes_avatar.attr('hidden', 'hidden');
                tes_avatar.on('initialized.owl.carousel', function (event) {
                    tes_avatar.find(".owl-item").eq(0).addClass("current");
                    setTimeout(function () {
                        tes_avatar.removeAttr('hidden');
                    }, 1000);
                }).owlCarousel({
                    items: 1,
                    nav: false,
                    dots: false,
                    loop: false,
                    rtl: isRTL,
                    autoHeight: true,
                    lazyLoad: isLazy
                }).on('changed.owl.carousel', syncPosition2);
                var configs = tes_content.data('owl-options');
                configs['navText'] = ['<i class="fal fa-angle-left"></i>', '<i class="fal fa-angle-right"></i>'];
                tes_content.on('initialized.owl.carousel', function (event) {
                    tes_content.find(".owl-item").eq(0).addClass("current");
                }).owlCarousel(configs).on('changed.owl.carousel', syncPosition);
                function syncPosition2(el){
                    var current = el.item.index;
                    tes_content.data('owl.carousel').to(current, 200, true);
                }

                function syncPosition(el) {
                    var number = el.item.index;
                    tes_avatar.data('owl.carousel').to(number, 200, true);
                }
                $(document).on('reset_data',function(event){
                    tes_avatar.data('owl.carousel').to(0, 200, true);
                });
            });
        }
    };
    $(document).ready(G5Plus_Testimonials.init);
})(jQuery);