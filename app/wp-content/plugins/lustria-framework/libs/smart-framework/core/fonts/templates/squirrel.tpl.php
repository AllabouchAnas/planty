<script type="text/html" id="tmpl-gsf-squirrel-fonts">
    <div class="gsf-font-container" id="squirrel_fonts">
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
                <div class="gsf-font-item" data-category="{{item.classification}}" data-name="{{item.family_name}}" style="display: none">
                    <div class="gsf-font-item-name">{{item.family_name}}</div>
                    <div class="gsf-font-item-action">
                        <a href="http://www.fontsquirrel.com/fonts/{{item.family_urlname}}" target="_blank" class="gsf-font-item-action-preview"><span class="dashicons dashicons-visibility"></span></a>
                        <a href="#" class="gsf-font-item-action-add"><span class="dashicons dashicons-plus"></span></a>
                        <a href="#" class="gsf-font-item-action-download"><span class="dashicons dashicons-download"></span></a>
                    </div>
                </div>
                <# }); #>
        </div>
    </div>
</script>