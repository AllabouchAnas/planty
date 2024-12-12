<#
if ( settings.image.url  ) {
var image = {
id: settings.image.id,
url: settings.image.url,
size: settings.image_size_size,
dimension: settings.image_size_custom_dimension,
model: view.getEditModel()
};
var image_url = elementor.imagesManager.getImageUrl( image );
if ( ! image_url ) {
return;
}


var image_tag = 'div';
if (settings.link.url!==''  ) {
image_tag = 'a';
var target    = settings.link.is_external ? ' target="_blank"' : '';
var nofollow  = settings.link.nofollow ? ' rel="nofollow"' : '';
view.addRenderAttribute( 'image_attr', 'href', settings.link.url );
if(target!==''){
view.addRenderAttribute( 'image_attr', 'target', target );
}
if(nofollow!==''){
view.addRenderAttribute( 'image_attr', 'rel', nofollow );
}
}
var image_classes=['card ube-image'];

if ( settings.hover_animation !=='' && settings.hover_animation !==undefined && settings.hover_animation !==null) {
image_classes.push ('ube-image-hover-' + settings.hover_animation);
}
if ( settings.hover_overlay_animation !=='' && settings.hover_overlay_animation !==undefined && settings.hover_overlay_animation !==null) {
image_classes.push ('ube-image-hover-' + settings.hover_overlay_animation);
}
if ( settings.hover_animation_with_caption !=='' && settings.hover_animation_with_caption !==undefined && settings.hover_animation_with_caption !==null) {
image_classes.push ('ube-image-hover-' + settings.hover_animation_with_caption);
}
image_classes.push('ube-image-caption-' + settings.caption_position);
var image_wrapper_class = ['card-img'];

view.addRenderAttribute( 'image_attr', 'class', image_classes );


view.addRenderAttribute( 'wrapper_image_attr', 'class', image_wrapper_class );
}
#>
<{{{image_tag}}} {{{ view.getRenderAttributeString( 'image_attr' ) }}} >
<div {{{ view.getRenderAttributeString( 'wrapper_image_attr' ) }}}>
<img src="{{{image_url}}}" alt="<?php esc_attr_e( 'Image', 'ube' ) ?>">
</div>

<#if ( settings.caption!='' ){#>
<div class="card-body">
    <h5 class="card-title">{{{settings.caption }}}</h5>
</div>
<# } #>
</{{{image_tag}}} >