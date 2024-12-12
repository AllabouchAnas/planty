<#
var call_to_action_tag = 'button';
if ( settings.call_to_action_link.url!=='' ) {
		view.addRenderAttribute( 'call_to_action_button','href', settings.call_to_action_link.url );
		if( settings.call_to_action_link.is_external){
		view.addRenderAttribute( 'call_to_action_button', 'target', '_blank' );
		}
		if(settings.call_to_action_link.nofollow){
		view.addRenderAttribute( 'call_to_action_button', 'rel', 'nofollow' );
		}
		call_to_action_tag = 'a';
}

view.addRenderAttribute( 'call_to_action_wrapper', 'class', 'ube-call-to-action' );

var button_classes = [
    'ube-call-to-action-btn',
	'btn',
	'btn-pos-' + settings.position_button,
	'btn-' + settings.call_to_action_button_size,
	'btn-' + settings.call_to_action_button_shape,
];
if ( settings.call_to_action_button_type !== '' ) {
    button_classes.push( 'btn-' + settings.call_to_action_button_type);
}
if (settings.call_to_action_button_type === '' || settings.call_to_action_button_type === '3d') {
    button_classes.push('btn-' + settings.call_to_action_button_scheme);
}

if (settings.call_to_action_button_type === 'outline') {
  button_classes.push('btn-outline-' + settings.call_to_action_button_scheme);
}
view.addRenderAttribute( 'call_to_action_button', 'class', button_classes );
view.addRenderAttribute( 'ube-content', 'class', 'ube-call-to-action-content' );

if ( settings.position_button == 'left' || settings.position_button == 'right' ) {
	view.addRenderAttribute( 'ube-content', 'class', 'media-body' );
	view.addRenderAttribute( 'call_to_action_wrapper', 'class', 'media' );
}
if ( settings.position_button == 'left' ) {
	view.addRenderAttribute( 'call_to_action_wrapper', 'class', 'flex-row-reverse' );
}

var iconHTML = elementor.helpers.renderIcon( view, settings.icon, { 'aria-hidden': true }, 'i' , 'object' );

var title_class = ['ube-call-to-action-title','ube-heading-title'];
if ( settings.call_to_action_title_size !== '' ) {
   title_class.push( 'ube-heading-size-' + settings.call_to_action_title_size);
}

if ( settings.title_class !== '' ) {
title_class.push( settings.title_class);
}

var desc_class = ['ube-call-to-action-description'];
if ( settings.description_class !== '' ) {
desc_class.push( settings.description_class);
}

var call_to_action_title_tag = elementor.helpers.validateHTMLTag(settings.call_to_action_title_tag ? settings.call_to_action_title_tag : 'h2');

view.addRenderAttribute( 'call_to_action_desc_attr', 'class', desc_class );

#>
<div {{{ view.getRenderAttributeString( 'call_to_action_wrapper' ) }}}>
    <# if (settings.call_to_action_button!=='' && settings.position_button == 'top' ) {#>
    <{{{call_to_action_tag}}} {{{ view.getRenderAttributeString( 'call_to_action_button' ) }}}>
		<# if ((iconHTML.rendered) && (settings.icon_align === 'left')) { #>
			{{{ iconHTML.value }}}
		<# } #>
		{{{settings.call_to_action_button}}}
		<# if ((iconHTML.rendered) && (settings.icon_align === 'right')) { #>
			{{{ iconHTML.value }}}
		<# } #>
    </{{{call_to_action_tag}}}>
    <#} #>
	<div {{{ view.getRenderAttributeString( 'ube-content' ) }}}>
		<# if (  settings.call_to_action_title !='' ) {
			view.addRenderAttribute( 'call_to_action_title_attr', 'class', title_class );#>
			<{{{call_to_action_title_tag}}} {{{ view.getRenderAttributeString( 'call_to_action_title_attr' ) }}}>
                {{{settings.call_to_action_title}}}
            </{{{call_to_action_title_tag}}}>
		<# } #>
		<# if ( settings.call_to_action_description !=='' ) { #>
			<p {{{ view.getRenderAttributeString( 'call_to_action_desc_attr' ) }}}>{{{settings.call_to_action_description}}}</p>
		<# } #>
	</div>
	<# if (settings.call_to_action_button !=='' && settings.position_button !== 'top' ) {#>
        <{{{call_to_action_tag}}} {{{ view.getRenderAttributeString( 'call_to_action_button' ) }}}>
			<# if ((iconHTML.rendered) && (settings.icon_align === 'left')) { #>
			{{{ iconHTML.value }}}
			<# } #>
			{{{settings.call_to_action_button}}}
			<# if ((iconHTML.rendered) && (settings.icon_align === 'right')) { #>
			{{{ iconHTML.value }}}
			<# } #>
        </{{{call_to_action_tag}}}>
	<# } #>
</div>

