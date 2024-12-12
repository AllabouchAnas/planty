var G5Plus_PostFormat = G5Plus_PostFormat || {};
(function ($) {
    "use strict";
    G5Plus_PostFormat = {
        init : function(){
            var _that = this;
            setTimeout(function () {
                $('.editor-post-format select').trigger('change');
                $('[name="post_format"]:checked').trigger('change')
            },1000);

            $(document).on('change','.editor-post-format select',function (event) {
                _that.switch_post_format_content($(this).val());
            });

            $('[name="post_format"]').on('change',function(){
                _that.switch_post_format_content($(this).val());
            });
        },
        switch_post_format_content: function ($post_format) {
            $('#gf_format_video_embed,#gf_format_audio_embed,#gf_format_gallery_images,#gf_format_link_url').hide();
            switch ($post_format) {
                case 'video':
                    $('#gf_format_video_embed').show();
                    break;
                case 'audio':
                    $('#gf_format_audio_embed').show();
                    break;
                case 'gallery':
                    $('#gf_format_gallery_images').show();
                    break;
                case 'link':
                    $('#gf_format_link_url').show();
            }
        }
    };
    $(document).ready(function () {
        G5Plus_PostFormat.init();
    });

    $(document).on('tinymce-editor-init', function () {
        $(document).on('change','.gsf-meta-box-wrap [name*="sidebar_layout"]',function () {
            $("#content_ifr").contents().find("body").attr('data-site_layout',$(this).val());
        }).find('.gsf-meta-box-wrap [name*="sidebar_layout"]:checked').change();
    });


    $(document).on('change','.gsf-meta-box-wrap [name*="sidebar_layout"]',function () {
        $('.edit-post-layout__content').attr('data-site_layout',$(this).val());
    });

    setTimeout(function () {
        $('.gsf-meta-box-wrap [name*="sidebar_layout"]:checked').change();
    },500);




})(jQuery);