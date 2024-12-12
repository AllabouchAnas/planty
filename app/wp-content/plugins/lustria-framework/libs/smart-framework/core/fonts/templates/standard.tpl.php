<script type="text/html" id="tmpl-gsf-standard-fonts">
    <div class="gsf-font-container" id="standard_fonts">
        <div class="gsf-font-items">
            <# _.each(data.fonts.items, function(item, index) { #>
                <div class="gsf-font-item" data-name="{{item.family}}">
                    <div class="gsf-font-item-name">{{item.name}}</div>
                    <div class="gsf-font-item-action">
                        <#if (item.using) {#>
                            <a href="#" class="gsf-font-item-action-add" data-type="standard"
                               title="<?php esc_attr_e('Use this font','lustria-framework'); ?>"><i class="fas fa-check"></i></a>
                            <#} else {#>
                                <a href="#" class="gsf-font-item-action-add" data-type="standard"
                                   title="<?php esc_attr_e('Use this font','lustria-framework'); ?>"><i class="fal fa-plus"></i></a>
                                <#}#>
                    </div>
                </div>
                <# }); #>
        </div>
    </div>
</script>