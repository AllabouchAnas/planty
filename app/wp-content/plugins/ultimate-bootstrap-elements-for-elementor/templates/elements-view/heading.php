<#
var heading_class=['ube-heading'];

var tag_html_title =  elementor.helpers.validateHTMLTag(settings.heading_title_tag);
var tag_html_sub   =  elementor.helpers.validateHTMLTag(settings.heading_sub_title_tag);

var divider_html = '';
if ( settings.heading_divider_enable !== '' ) {
divider_html   = '<div class="ube-heading-divider"></div>';
heading_class.push( 'ube-heading-divider-' + settings.heading_divider_position);
}

var title_class=['ube-heading-title'];
if ( settings.heading_title_size !== '' ) {
title_class.push( 'ube-heading-size-' + settings.heading_title_size);
}

if ( settings.heading_title_class !== '' ) {
title_class.push(settings.heading_title_class);
}

var sub_title_class=['ube-heading-sub-title'];
if ( settings.heading_sub_title_class !== '' ) {
sub_title_class.push(settings.heading_sub_title_class);
}

var description_class=['ube-heading-description'];
if ( settings.heading_description_class !== '' ) {
description_class.push(settings.heading_description_class);
}


view.addRenderAttribute( 'heading_attr', 'class', heading_class );
view.addRenderAttribute( 'title_attr', 'class',title_class );
view.addRenderAttribute( 'description_attr', 'class', description_class );
view.addRenderAttribute( 'sub_title_attr', 'class', sub_title_class);

#>
<div {{{ view.getRenderAttributeString( 'heading_attr' ) }}}>
<#
if ( settings.heading_sub_title_text !== '' ) {#>
<{{{tag_html_sub}}} {{{ view.getRenderAttributeString( 'sub_title_attr' ) }}}>
{{{settings.heading_sub_title_text}}}
</{{{tag_html_sub}}}>
<# }
if (settings.heading_divider_enable !== '' && settings.heading_divider_position === 'before' ) {#>
{{{divider_html}}}
<#}
if ( settings.heading_title !== '' ) {#>
<{{{tag_html_title}}} {{{ view.getRenderAttributeString( 'title_attr' ) }}}>
<# if ( settings.heading_title_link.url !== '' ) {
if( settings.heading_title_link.is_external){
view.addRenderAttribute( 'link_title_atrr', 'target', '_blank' );
}
if(settings.heading_title_link.nofollow){
view.addRenderAttribute( 'link_title_atrr', 'rel', 'nofollow' );
}
view.addRenderAttribute( 'link_title_atrr','href' ,settings.heading_title_link.url );#>
<a {{{ view.getRenderAttributeString( 'link_title_atrr' ) }}}>
{{{settings.heading_title}}}
</a>
<#        }else{#>
{{{settings.heading_title}}}
<#        }#>
</{{{tag_html_title}}}>
<#
}
if ( settings.heading_divider_enable !== '' && settings.heading_divider_position === 'after' ) {#>
{{{divider_html}}}
<#}
if ( settings.heading_description !== '' ) {#>
<div {{{ view.getRenderAttributeString( 'description_attr' ) }}}>
{{{settings.heading_description}}}
</div>
<#}
#>
</div>