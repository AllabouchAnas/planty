<#
view.addRenderAttribute( 'ube_image_marker_attr', 'class', 'ube-marker-wrapper' );
if ( settings.image_marker_animation== 'yes' ) {
view.addRenderAttribute( 'ube_image_marker_attr', 'class', 'ube-marker-animate-icon' );
}
if ( settings.image_marker_arrow == 'yes' ) {
view.addRenderAttribute(  'ube_image_marker_attr', 'class', 'ube-marker-tooltip-arrow' );
}
#>
<div {{{ view.getRenderAttributeString( 'ube_image_marker_attr' ) }}}>
<#
var image = {
id: settings.image.id,
url: settings.image.url,
size: settings.image_size_size,
dimension: settings.image_size_custom_dimension,
model: view.getEditModel()
};
var image_url = elementor.imagesManager.getImageUrl( image );
if(!image_url){
return;
}
var tabindex = view.getIDInt().toString().substr( 0, 3 );
var marker_tag = 'div';
#>
<img src="{{{ image_url }}}"/>
<#
if(settings.image_marker_list){
_.each( settings.image_marker_list, function( item, index ) {
var title = '';
if ( item.marker_title!=='' ) {
title += '<h4>' + item.marker_title + '</h4>';
}
if (item.marker_content!=='' ) {
title += '<p>' + item.marker_content + '</p>';
}
view.addRenderAttribute( 'marker_attr_' + index, 'title', title );

if ( item.marker_link.url ) {
marker_tag = 'a';
var target     = item.marker_link.is_external ? ' target="_blank"' : '';
var nofollow   = item.marker_link.nofollow ? ' rel="nofollow"' : '';
view.addRenderAttribute( 'marker_attr_' + index, 'href', item.marker_link.url);
view.addRenderAttribute( 'marker_attr_' + index, 'target', target );
view.addRenderAttribute( 'marker_attr_' + index, 'rel', nofollow );
}
var marker_classes = 'ube-image-pointer elementor-repeater-item-'+ item._id;
view.addRenderAttribute( 'marker_attr_'+ index, 'class', marker_classes );
var iconHTML = elementor.helpers.renderIcon( view, item.marker_icon, { 'aria-hidden': true }, 'i' , 'object' );
#>
<{{{ marker_tag }}} {{{view.getRenderAttributeString( 'marker_attr_' + index)}}}>
<div class="ube-pointer-icon">
    <#
    if ( item.type_of_marker === 'icon' ) {
    if ( item.marker_icon.value ) {
    #>
    {{{ iconHTML.value }}}
    <#}
    } else {
    #>
    {{{item.marker_text}}}
    <#
    }
    #>
</div>
</{{{ marker_tag }}}>
<# });
}
#>
</div>
