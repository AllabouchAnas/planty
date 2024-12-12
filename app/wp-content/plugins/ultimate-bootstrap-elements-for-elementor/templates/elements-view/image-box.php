<#
var wrapper_classes = [
	'ube-image-box',
	'ube-icon-box',
];

if (  settings.hover_animation!=='' ) {
	wrapper_classes.push ( 'ube-image-hover-' + settings.hover_animation);
}
if (  settings.hover_image_animation!=='' ) {
	wrapper_classes.push( 'ube-image-hover-' + settings.hover_image_animation);
}

if ( settings.image_switcher!=='' ) {
	wrapper_classes.push( 'ube-hover-image');
}

var image_tag       = 'span';

view.addRenderAttribute("wrapper",'class', wrapper_classes);

if ( settings.image_box_link.url ) {
	image_tag = 'a';
var target = settings.image_box_link.is_external ? ' target="_blank"' : '';
var nofollow = settings.image_box_link.nofollow ? ' rel="nofollow"' : '';
var attr={
'href': settings.image_box_link.url,
};
    view.addRenderAttribute( "image_link",attr );

}
view.addRenderAttribute( "image_link", 'class', 'card-img' );

var title_classes = [
'ube-ib-title',
'mb-0'
];

if (  settings.title_class !=='' ) {
title_classes.push ( settings.title_class);
}

view.addRenderAttribute("title",'class', title_classes);

var description_classes = [
'ube-ib-title',
'mb-0'
];

if (  settings.description_class !=='' ) {
description_classes.push ( settings.description_class);
}

view.addRenderAttribute("description",'class', description_classes);

#>
<div class="ube-icon-box-wrapper">
    <div {{{ view.getRenderAttributeString( "wrapper") }}}>
        <div class="ube-ib-icon ube-image">
            <{{{image_tag}}} {{{ view.getRenderAttributeString("image_link")}}} {{{target}}} {{{nofollow}}}>
           <# var image = {
            id: settings.image.id,
            url: settings.image.url,
            size: settings.thumbnail_size,
            dimension: settings.thumbnail_custom_dimension,
            model: view.getEditModel()
            };
            var image_url = elementor.imagesManager.getImageUrl( image );
            #>
            <img src="{{{ image_url }}}" />
            <#
            if ( settings.image_switcher!=='' ){
            var image_hover = {
            id: settings.image_hover.id,
            url: settings.image_hover.url,
            size: settings.thumbnail_size,
            dimension: settings.thumbnail_custom_dimension,
            model: view.getEditModel()
            };
            var image_hover_url = elementor.imagesManager.getImageUrl( image_hover );
            #>
            <img src="{{{ image_hover_url }}}" />
            <#}#>

            </{{{image_tag}}}>
        </div>
		<# if (settings.image_box_title!=='' || settings.image_box_description!==''){ #>
            <div class="ube-ib-content">
				<# if (settings.image_box_title!==''){
                var title = settings.image_box_title ? settings.image_box_title : '';
                var title_tag = elementor.helpers.validateHTMLTag(settings.image_box_title_tag ? settings.image_box_title_tag : 'h3');
                #>
                    <{{{title_tag}}} {{{ view.getRenderAttributeString( "title") }}}>
                        <{{{image_tag}}} {{{ view.getRenderAttributeString("image_link")}}} {{{target}}} {{{nofollow}}}>
                            {{{title}}}
                        </{{{image_tag}}}>
                     </{{{title_tag}}}>
				<# } #>
				<# if (settings.image_box_description!=='' && settings.description_position === 'inset'){ #>
                    <p {{{ view.getRenderAttributeString( "description") }}}>{{{settings.image_box_description}}}</p>
				<# } #>
            </div>
		<# } #>
    </div>
	<# if (settings.image_box_description!=='' && settings.description_position === 'outset'){ #>
        <p {{{ view.getRenderAttributeString( "description") }}}>{{{settings.image_box_description}}}</p>
	<# } #>
</div>

