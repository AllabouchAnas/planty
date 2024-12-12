<script type="text/html" id="tmpl-gsf-google-fonts">
    <div class="gsf-font-container" id="google_fonts" style="display: block">
        <ul class="gsf-font-categories gsf-clearfix">
            <# _.each(data.fonts.categories, function(item, index) { #>
                <# if (index == 0) {#>
                    <li class="active" data-ref="{{item.name}}"><a href="#">{{item.name}} ({{item.count}})</a></li>
                    <#} else { #>
                        <li data-ref="{{item.name}}"><a href="#">{{item.name}} ({{item.count}})</a></li>
                        <#}#>
                            <# }); #>
        </ul>
        <div class="gsf-font-items">
            <# _.each(data.fonts.items, function(item, index) { #>
                <div class="gsf-font-item" data-category="{{item.category}}" data-name="{{item.family}}" style="display: none">
                    <div class="gsf-font-item-name">{{item.family}}</div>
                    <div class="gsf-font-item-action">
                        <a href="https://www.google.com/fonts/specimen/{{item.family.replace(' ','+')}}" target="_blank"
                           title="<?php esc_attr_e('Preview font','lustria-framework'); ?>"
                           class="gsf-font-item-action-preview"><i class="fas fa-eye"></i></a>
                        <#if (item.using) {#>
                            <a href="#" class="gsf-font-item-action-add" data-type="google"
                               title="<?php esc_attr_e('Use this font','lustria-framework'); ?>"><i class="fas fa-check"></i></a>
                            <#} else {#>
                                <a href="#" class="gsf-font-item-action-add" data-type="google"
                                   title="<?php esc_attr_e('Use this font','lustria-framework'); ?>"><i class="fal fa-plus"></i></a>
                                <#}#>
                    </div>
                </div>
                <# }); #>
        </div>
    </div>
</script>