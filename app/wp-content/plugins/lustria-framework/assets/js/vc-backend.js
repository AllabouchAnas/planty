var G5Plus_VC = G5Plus_VC || {};
(function ($) {
    "use strict";
    G5Plus_VC = {
        init : function(){
           this.template_tab();
        },
        template_tab : function () {
            $('.gsf-templates-cat-wrap li','.vc_panel-tabs').on('click',function(event) {
                event.preventDefault();
                var $this = $(this),
                    filter = $this.data('filter');
                if ($this.hasClass('active')) return;
                $('.gsf-templates-cat-wrap li','.vc_panel-tabs').removeClass('active');
                $this.addClass('active');
                $(filter,'.gsf-templates-wrap').removeClass('hidden');
                $('.gsf-template-item:not('+ filter+')','.gsf-templates-wrap').addClass('hidden');
            });


            $('.gsf-templates-cat-wrap li','.vc_panel-tabs').each(function () {
                var $this = $(this),
                    filter = $this.data('filter'),
                    count = $(filter,'.gsf-templates-wrap').length;
                if (filter === '*') {
                    count = $('.gsf-template-item').length;
                }
                $this.append('<span class="gsf-template-count">'+ count +'</span>');
            });
        }
    };
    $(document).ready(function () {
        G5Plus_VC.init();
    });
})(jQuery);
