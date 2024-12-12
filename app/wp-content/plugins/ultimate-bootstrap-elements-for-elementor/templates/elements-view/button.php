<#
var wrapper_classes = [
	'ube-btn',
	'btn',
	'btn-' +  settings.size,
	'btn-' +  settings.shape,
];

if (settings.type !== '') {
	wrapper_classes.push('btn-' + settings.type);
}

if (settings.type === '' || settings.type === '3d') {
	wrapper_classes.push('btn-' + settings.scheme);
}

if (settings.type === 'outline') {
	wrapper_classes.push('btn-outline-' + settings.scheme);
	wrapper_classes.push('btn-' + settings.scheme);
}

if ( settings.hover_animation ) {
	wrapper_classes.push('elementor-animation-' + settings.hover_animation);
}

if ((settings.icon !== '') && (settings.icon.value !== '')) {
	wrapper_classes.push('ube-btn-icon-' + settings.icon_align);
}

var iconHTML = elementor.helpers.renderIcon( view, settings.icon, { 'aria-hidden': true }, 'i' , 'object' );

view.addRenderAttribute('wrapper', 'class', wrapper_classes);

view.addRenderAttribute('text', 'class', 'ube-btn-text');
view.addInlineEditingAttributes( 'text', 'none' );


if ( settings.button_css_id !== '' ) {
	view.addRenderAttribute('wrapper', 'id', settings.button_css_id);
}

if( ('yes' === settings.button_event_switcher) && ( settings.button_event_function !== '' ) ) {
	view.addRenderAttribute('wrapper', 'onclick', settings.button_event_function);
}

#>
<a href="{{ settings.link.url }}" {{{ view.getRenderAttributeString( 'wrapper' ) }}}>
	<# if ((iconHTML.rendered) && (settings.icon_align === 'left')) { #>
		<span class="ube-btn-icon">{{{ iconHTML.value }}}</span>
	<# } #>
	<span {{{ view.getRenderAttributeString( 'text' ) }}}>{{{ settings.text }}}</span>
	<# if ((iconHTML.rendered) && (settings.icon_align === 'right')) { #>
		<span class="ube-btn-icon">{{{ iconHTML.value }}}</span>
	<# } #>
</a>