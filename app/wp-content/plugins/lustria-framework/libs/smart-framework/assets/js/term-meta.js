var GSF_TERM_META;
(function($) {
    "use strict";

    GSF_TERM_META = {
        init: function() {
            this.headerToggle();
        },
        headerToggle: function () {
            $(document).on('click','.gsf-taxonomy-meta-header', function () {
                $(this).toggleClass('in');
                $(this).next().slideToggle();
            });
        }
    };
    $(document).ready(function() {
        GSF_TERM_META.init();
    });
    $( document ).ajaxComplete(function( event, xhr, settings ) {
        try{
            var $respo = $.parseXML(xhr.responseText);
            //exit on error
            if ($($respo).find('wp_error').length) return;

            var $taxWrappe = $('.gsf-term-meta-wrapper');
            if ($taxWrappe.length == 0) {
                return;
            }
            var taxonomy = $taxWrappe.data('taxonomy');

            $.ajax({
                type: "GET",
                url: GSF_META_DATA.ajaxUrl,
                data: {
                    action: 'gsf_tax_meta_form',
                    taxonomy: taxonomy
                },
                success : function(res) {
                    var $container = $(res);
                    GSF.fields.initFields($container);
                    $taxWrappe.html($container);
                    $container.find('.gsf-field').trigger('gsf_check_required');
                }
            });

        }catch(err) {}
    });
})(jQuery);