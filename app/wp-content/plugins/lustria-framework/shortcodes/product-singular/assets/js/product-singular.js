(function ($) {
    "use strict";
    var G5PlusPortfoliosIndex = {
        init: function () {
            G5PlusPortfoliosIndex.events();
        },
        events: function () {
            $('.gsf-portfolio-singular').each(function () {
                var owl_carousel = $('.portfolio-singular-wrap.owl-carousel', $(this)),
                    portfolio_index = $('.portfolio-index-wrap', $(this));
                owl_carousel.on('changed.owl.carousel', function(el) {
                    var item = $('[data-item-index="' + el.item.index + '"]', portfolio_index);
                    portfolio_index.find('.active').removeClass('active');
                    item.addClass('active');
                });
                $('.index-item', portfolio_index).on('click', function (event) {
                    event.preventDefault();
                    if ($(this).hasClass('active')) return;
                    var index = $(this).data('item-index');
                    owl_carousel.data('owl.carousel').to(index, 300,true);
                });
            });
        }
    };
    $(document).ready(function() {
        G5PlusPortfoliosIndex.init()
    });
})(jQuery);