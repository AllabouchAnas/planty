<script type="text/html" id="tmpl-gsf-custom-fonts">
    <div class="gsf-font-container" id="custom_fonts">
        <div id="gsf-custom-font-popup" class="mfp-with-anim mfp-hide">
            <header>
                <h4><?php esc_html_e('Add Custom Font','lustria-framework'); ?></h4>
            </header>
            <form action="<?php echo admin_url('admin-ajax.php?action=gsf_upload_fonts&_nonce=' . GSF()->helper()->getNonceValue()); ?>" method="post" enctype="multipart/form-data">
                <div>
                    <label><?php esc_html_e('Font name:','lustria-framework'); ?></label>
                    <input type="text" name="name" required=""/>
                </div>
                <div>
                    <label><?php esc_html_e('Fonts files (zip):','lustria-framework'); ?></label>
                    <input type="file" name="file_font" required="" accept="application/zip"/>
                    <p><?php esc_html_e('File zip contains stylesheet.css and font files (accept: .woff, .eot, .svg, .ttf)','lustria-framework'); ?></p>
                </div>
                <div>
                    <button type="submit" class="button button-primary"><i class="fal fa-plus"></i> <?php esc_html_e('Add Custom Font','lustria-framework'); ?></button>
                </div>
            </form>
        </div>
        <div class="gsf-font-items">
            <# _.each(data.fonts.items, function(item, index) { #>
                <div class="gsf-font-item" data-name="{{item.family}}">
                    <div class="gsf-font-item-name">{{item.name}}</div>
                    <div class="gsf-font-item-action">
                        <a href="#" class="gsf-font-item-action-delete" title="<?php esc_attr_e('Delete custom font','lustria-framework'); ?>"><i class="fas fa-times"></i></a>
                        <#if (item.using) {#>
                            <a href="#" class="gsf-font-item-action-add" data-type="custom"
                               title="<?php esc_attr_e('Use this font','lustria-framework'); ?>"><i class="fas fa-check"></i></a>
                            <#} else {#>
                                <a href="#" class="gsf-font-item-action-add" data-type="custom"
                                   title="<?php esc_attr_e('Use this font','lustria-framework'); ?>"><i class="fal fa-plus"></i></a>
                                <#}#>
                    </div>
                </div>
                <# }); #>
        </div>
        <div class="gsf-add-custom-font">
            <button class="button button-primary" type="button"><i class="fal fa-plus"></i> <?php esc_html_e('Add Custom Fonts','lustria-framework'); ?></button>
        </div>
    </div>
</script>