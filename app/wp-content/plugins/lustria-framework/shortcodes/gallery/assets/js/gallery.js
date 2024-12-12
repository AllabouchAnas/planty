(function ($) {
    "use strict";
    var G5PlusGallery = {
        init: function () {
            if ($.isFunction($.fn.owlCarousel)) {
                G5PlusGallery.init_carousel_3d();
            }
        },
        init_carousel_3d: function () {
            var sync1 = $('.gallery-layout-carousel-3d');
            sync1.each(function () {
                $(this).find('.owl-carousel.carousel-3d').on("click", ".owl-item", function (e) {
                    e.preventDefault();
                    if (typeof $(this).children() != 'undefined') {
                        var $index = $(this).children().attr('data-index');
                        $(this).trigger('to.owl.carousel', [$index, 300]);
                    }
                });
            })
        }

    };
    $(document).ready(G5PlusGallery.init);
})(jQuery);