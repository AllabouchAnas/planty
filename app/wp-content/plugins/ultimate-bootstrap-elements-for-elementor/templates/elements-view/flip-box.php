<#
var fix_box_tag      = 'span';
var fix_box_back_tag = 'div';

var flip_box_wrapper = [
	'ube-flip-box',
	'position-relative',
	'ube-flip-effect-' + settings.flip_effect,
	'direction-' + settings.flip_direction,
];

view.addRenderAttribute( 'flip_box_wrapper', 'class', flip_box_wrapper );

var ube_front = [
	'ube-flip-box-front',
	'ube-flip-box-layer',
	'd-flex',
	'position-absolute',
	'w-100',
	'h-100',
	settings.alignment_front,
];
if ( settings.view_front !== '' ) {
	ube_front.push('elementor-view-' +  settings.view_front);
}
if ( settings.shape_front !== '' ) {
	ube_front.push('elementor-shape-' +  settings.shape_front);
}
view.addRenderAttribute( 'ube-front', 'class',ube_front);

var ube_back = [
	'ube-flip-box-back',
	'ube-flip-box-layer',
	'd-flex',
	'position-absolute',
	'w-100',
	'h-100',
	settings.alignment_back,
];
if ( settings.view_back !== '' ) {
	ube_back.push('elementor-view-' +  settings.view_back);
}
if ( settings.shape_back !== '' ) {
	ube_back.push('elementor-shape-' +  settings.shape_back);
}
view.addRenderAttribute( 'ube-back', 'class',ube_back );

if ( settings.flip_box_3d === 'yes' ) {
	view.addRenderAttribute( 'flip_box_wrapper', 'class', 'ube-flip-3d' );
}

view.addRenderAttribute( 'ube-flip-content', 'class', 'ube-flip-content');

if (  settings.link.url !=='' && settings.link_click === 'box' ) {
	if( settings.link.is_external){
	view.addRenderAttribute( 'ube-back', 'target', '_blank' );
	}
	if(settings.link.nofollow){
	view.addRenderAttribute( 'ube-back', 'rel', 'nofollow' );
	}
	view.addRenderAttribute( 'ube-back','href' ,settings.link.url );
	view.addRenderAttribute( 'ube-back', 'class', 'd-block' );
	fix_box_back_tag = 'a';
}

var fix_box_button = [
	'btn',
	'btn-outline-light',
	'btn-' + settings.button_size,
];

if ( settings.link.url !=='' && settings.link_click === 'button' ) {
	if( settings.link.is_external){
	view.addRenderAttribute( 'fix_box_button', 'target', '_blank' );
	}
	if(settings.link.nofollow){
	view.addRenderAttribute( 'fix_box_button', 'rel', 'nofollow' );
	}
	view.addRenderAttribute( 'fix_box_button','href' ,settings.link.url );
	fix_box_tag = 'a';
}
view.addRenderAttribute( 'fix_box_button', 'class', fix_box_button );

var title_class_front =['ube-flip-box-title'];
if ( settings.heading_title_size_front !== '' ) {
title_class_front.push( 'ube-heading-title');
title_class_front.push( 'ube-heading-size-' + settings.heading_title_size_front);
}

if ( settings.title_class_front !== '' ) {
	title_class_front.push(settings.title_class_front);
}

var desc_class_front = ['ube-flip-box-description'];
if ( settings.desc_class_front !== '' ) {
desc_class_front.push(settings.desc_class_front);
}

var title_class_back =['ube-flip-box-title'];
if ( settings.heading_title_size_back !== '' ) {
title_class_back.push( 'ube-heading-title');
title_class_back.push( 'ube-heading-size-' + settings.heading_title_size_back);
}

if ( settings.title_class_back !== '' ) {
title_class_back.push(settings.title_class_back);
}

var desc_class_back = ['ube-flip-box-description'];
if ( settings.desc_class_back !== '' ) {
desc_class_back.push(settings.desc_class_back);
}


icon_front = elementor.helpers.renderIcon( view, settings.icon_front, { 'aria-hidden': true }, 'i' , 'object' ),
icon_back = elementor.helpers.renderIcon( view, settings.icon_back, { 'aria-hidden': true }, 'i' , 'object' ),

#>
<div {{{ view.getRenderAttributeString( 'flip_box_wrapper' ) }}}>
	<div {{{ view.getRenderAttributeString( 'ube-front' ) }}}>
		<div {{{ view.getRenderAttributeString( 'ube-flip-content' ) }}}>
			<# if ( 'image' === settings.flip_box_graphic &&  settings.image_front.url !=='' ) {
				var image_front = {
				id: settings.image_front.id,
				url: settings.image_front.url,
				size: settings.image_front_size_size,
				dimension: settings.image_front_size_custom_dimension,
				model: view.getEditModel()
				};
				var image_front_url = elementor.imagesManager.getImageUrl( image_front );
				#>
				<div class="ube-flip-flip-image d-inline-block">
					<img src="{{{image_front_url}}}">
				</div>
			<# } #>
			<# if ( 'icon' === settings.flip_box_graphic && settings.icon_front.value !=='' ) { #>
				<div class="ube-flip-box-icon">
					<div class="elementor-icon">
						{{{ icon_front.value }}}
					</div>
				</div>
			<# } #>
			<# if ( settings.title_front!=='' ) {
				view.addRenderAttribute( 'title_tag_front_attr', 'class', title_class_front );#>
				<{{{settings.title_tag_front}}} {{{ view.getRenderAttributeString( 'title_tag_front_attr' ) }}}>
					{{{settings.title_front}}}
				</{{{settings.title_tag_front}}}>
			<#} #>
			<# if (  settings.description_front !=='' ) { #>
				<# view.addRenderAttribute( 'desc_tag_front_attr', 'class', desc_class_front ); #>
				<div {{{ view.getRenderAttributeString( 'desc_tag_front_attr' ) }}}>{{{settings.description_front}}}</div>
			<# } #>
		</div>
	</div>
	<{{{fix_box_back_tag}}} {{{ view.getRenderAttributeString( 'ube-back' ) }}}>
	<div {{{ view.getRenderAttributeString( 'ube-flip-content' ) }}}>
		<# if ( 'image' === settings.flip_box_graphic_back && settings.image_back.url!=='' ) {
			var image_back = {
			id: settings.image_back.id,
			url: settings.image_back.url,
			size: settings.image_back_size_size,
			dimension: settings.image_back_size_custom_dimension,
			model: view.getEditModel()
			};
			var image_back_url = elementor.imagesManager.getImageUrl( image_back );
		#>
			<div class="ube-flip-flip-image d-inline-block">
				<img src="{{{image_back_url}}}">
			</div>
		<# } #>
		<# if ( 'icon' === settings.flip_box_graphic_back &&  settings.icon_back.value !=='' ) { #>
			<div class="ube-flip-box-icon">
				<div class="elementor-icon">
					{{{ icon_back.value }}}
				</div>
			</div>
		<# } #>
		<# if ( settings.title_back!=='' ) {
			view.addRenderAttribute( 'title_tag_back_attr', 'class', title_class_back );#>
			<{{{settings.title_tag_back}}} {{{ view.getRenderAttributeString( 'title_tag_back_attr' ) }}}>
				{{{settings.title_back}}}
			</{{{settings.title_tag_back}}}>
		<# } #>
		<# if ( settings.description_back !=='' ) { #>
			<# view.addRenderAttribute( 'desc_tag_back_attr', 'class', desc_class_back ); #>
			<div {{{ view.getRenderAttributeString( 'desc_tag_back_attr' ) }}}>{{{settings.description_back}}}</div>
		<# } #>
		<# if ( settings.button_text!=='' ) {#>
			<{{{fix_box_tag}}} {{{view.getRenderAttributeString( 'fix_box_button' )}}}>
				{{{settings.button_text}}}
			</{{{fix_box_tag}}}>
		<# } #>
	</div>
	</{{{fix_box_back_tag}}}>
</div>