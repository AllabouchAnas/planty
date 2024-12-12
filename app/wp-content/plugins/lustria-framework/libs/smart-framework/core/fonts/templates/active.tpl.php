<script type="text/html" id="tmpl-gsf-active-fonts">
    <div class="gsf-font-active-container" id="active_fonts" style="display: block">
        <form action="<?php echo admin_url('admin-ajax.php?action=gsf_save_active_font&_nonce=' . GSF()->helper()->getNonceValue()); ?>" method="post">
            <div class="gsf-font-active-items">
                <# _.each(data.fonts.items, function(item, index) { #>
                    <div class="gsf-font-active-item" data-name="{{item.family}}">
                        <div class="gsf-font-active-item-header">
                            <h4>{{typeof(item.name) == 'undefined' ? item.family : item.name}}</h4>
                            <a href="#" class="gsf-font-active-item-remove" title="<?php esc_attr_e('Remove font!','lustria-framework'); ?>">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                        <div class="gsf-font-active-content">
                            <div class="gsf-font-active-preview" style="font-family: {{GSF_Fonts.getFontFamily(item.family)}}">
                                <p class="gsf-font-active-preview-title">
                                    <?php esc_html_e('Welcome to font preview!','lustria-framework'); ?>
                                </p>
                                <p>​‌A​‌B​‌C​‌D​‌E​‌F​‌G​‌H​‌I​‌J​‌K​‌L​‌M​‌N​‌O​‌P​‌Q​‌R​‌S​‌T​‌U​‌V​‌W​‌X​‌Y​‌Z​‌a​‌b​‌c​‌d​‌e​‌f​‌g​‌h​‌i​‌j​‌k​‌l​‌m​‌n​‌o​‌p​‌q​‌r​‌s​‌t​‌u​‌v​‌w​‌x​‌y​‌z​‌1​‌2​‌3​‌4​‌5​‌6​‌7​‌8​‌9​‌0​‌‘​‌?​‌’​‌“​‌!​‌”​‌(​‌%​‌)​‌[​‌#​‌]​‌{​‌@​‌}​‌/​‌&​‌<​‌-​‌+​‌÷​‌×​‌=​‌>​‌®​‌©​‌$​‌€​‌£​‌¥​‌¢​‌:​‌;​‌,​‌.​‌*</p>
                            </div>
                            <input type="hidden" value="{{item.kind}}" name="font[{{index}}][kind]"/>
                            <div class="gsf-row">
                                <div class="gsf-variant">
                                    <h5><?php esc_html_e('Variants','lustria-framework'); ?></h5>
                                    <div class="gsf-clearfix">
                                        <# _.each(item.default_variants, function(v, vIndex) { #>
                                            <# if (item.variants.indexOf(v) != -1) {#>
                                                <label><input name="font[{{index}}][variants][]" type="checkbox" value="{{v}}" checked="checked" {{item.kind !='webfonts#webfont' ? 'disabled="disabled"' : ''}}/> <span>{{v}}</span></label>
                                                <#} else {#>
                                                    <label><input name="font[{{index}}][variants][]" type="checkbox" value="{{v}}" {{item.kind !='webfonts#webfont' ? 'disabled="disabled"' : ''}}/> <span>{{v}}</span></label>
                                                    <#}#>
                                                        <# }); #>
                                    </div>
                                </div>
                                <div class="gsf-subset">
                                    <h5><?php esc_html_e('Subsets','lustria-framework'); ?></h5>
                                    <div class="gsf-clearfix">
                                        <# _.each(item.default_subsets, function(v, vIndex) { #>
                                            <# if (item.subsets.indexOf(v) != -1) { #>
                                                <label><input name="font[{{index}}][subsets][]" type="checkbox" value="{{v}}" checked="checked" {{item.kind !='webfonts#webfont' ? 'disabled="disabled"' : ''}}/> <span>{{v}}</span></label>
                                                <#} else {#>
                                                    <label><input name="font[{{index}}][subsets][]" type="checkbox" value="{{v}}" {{item.kind !='webfonts#webfont' ? 'disabled="disabled"' : ''}}/> <span>{{v}}</span></label>
                                                    <#}#>
                                                        <# }); #>
                                    </div>
                                </div>
                            </div>
                            <div class="gsf-row gsf-font-selector">
                                <h5><?php esc_html_e('Selector apply:','lustria-framework'); ?></h5>
                                <input name="font[{{index}}][selector]" type="text" value="{{item.selector}}"/>
                            </div>
                        </div>
                    </div>
                    <# }); #>
            </div>
            <div class="gsf-save-active-font">
                <button class="button button-primary" type="submit"><i class="fal fa-save"></i> <?php esc_html_e('Save Changes','lustria-framework'); ?></button>

            </div>
        </form>
    </div>
</script>