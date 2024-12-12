/**
 * Created by thanglk on 16/10/2018.
 */
(function ($) {
    "use strict";
    var G5PlusSpace = {
        init: function() {
            var css = '';
            $('.g5plus-space').each(function(){
                var sid = $(this).data('id');
                var tablet = parseInt($(this).data('tablet'));
                var tablet_portrait = parseInt($(this).data('tablet-portrait'));
                var mobile = parseInt($(this).data('mobile'));
                var mobile_landscape = parseInt($(this).data('mobile-landscape'));
                if(!isNaN(tablet))
                {
                    css += ' @media (max-width: 1199px) { .space-'+sid+' { height:'+tablet+'px  !important;} } ';
                }
                if(!isNaN(tablet_portrait))
                {
                    css += ' @media (max-width: 991px) { .space-'+sid+' { height:'+tablet_portrait+'px  !important;} } ';
                }
                if(!isNaN(mobile_landscape))
                {
                    css += ' @media (max-width: 767px) { .space-'+sid+' { height:'+mobile_landscape+'px  !important;} } ';
                }
                if(!isNaN(mobile))
                {
                    css += ' @media (max-width: 575px) { .space-'+sid+' { height:'+mobile+'px  !important;} } ';
                }
            });
            if(css != '')
            {
                css = '<style>'+css+'</style>';
                $('head').append(css);
            }
        }
    };
    $(document).ready(G5PlusSpace.init);
})(jQuery);