<#
var button_one_link = button_two_link = 'span';

var double_button_wapper = [
'ube-double-button',
'd-flex',
];
view.addRenderAttribute( 'double-button-wapper', 'class', double_button_wapper );

var double_button_one =[
'btn',
'btn-block',
'ube-btn-one',
'btn-' + settings.double_button_size,
settings.double_button_shape,
];

double_button_two =[
'btn',
'btn-block',
'ube-btn-two',
'btn-' + settings.double_button_size,
settings.double_button_shape,
];

view.addRenderAttribute( 'double-button-one', 'class', double_button_one );
view.addRenderAttribute( 'double-button-two', 'class', double_button_two );

if (  settings.button_one_link.url !=='' ) {
if( settings.button_one_link.is_external){
view.addRenderAttribute( 'double-button-one', 'target', '_blank' );
}
if(settings.button_one_link.nofollow){
view.addRenderAttribute( 'double-button-one', 'rel', 'nofollow' );
}
view.addRenderAttribute( 'double-button-one','href' ,settings.button_one_link.url );
button_one_link = 'a';
}
if ( settings.button_two_link.url !=='' ) {
if( settings.button_two_link.is_external){
view.addRenderAttribute( 'double-button-two', 'target', '_blank' );
}
if(settings.button_two_link.nofollow){
view.addRenderAttribute( 'double-button-two', 'rel', 'nofollow' );
}
view.addRenderAttribute( 'double-button-two','href' ,settings.button_two_link.url );
button_two_link = 'a';
}
view.addRenderAttribute( 'double-middle-text', 'class', 'ube-middle-text' );

if ( settings.double_button_before_bg == 'yes' ) {
view.addRenderAttribute( 'double-button-wapper', 'class', 'before_bg' );
}
icon_one = elementor.helpers.renderIcon( view, settings.button_one_icon, { 'aria-hidden': true }, 'i' , 'object' ),
icon_two = elementor.helpers.renderIcon( view, settings.button_two_icon, { 'aria-hidden': true }, 'i' , 'object' ),

#>
<div {{{ view.getRenderAttributeString( 'double-button-wapper' ) }}}>
	<# if (  settings.button_one_text!=='' ) {#>
	<{{{button_one_link}}} {{{ view.getRenderAttributeString( 'double-button-one' ) }}}>
	<# if (  settings.button_one_icon.value !=='' ) {#>
		{{{ icon_one.value }}}
	<# }#>
	{{{settings.button_one_text}}}
</{{{button_one_link}}}>
<#} #>
<# if (settings.show_button_middle_text==='yes' &&  settings.button_middle_text !=='' ) { #>
<span {{{ view.getRenderAttributeString( 'double-middle-text' ) }}}>
{{{settings.button_middle_text }}}
</span>
<# } #>

<# if ( settings.button_two_text !=='') {#>
<{{{button_two_link}}} {{{ view.getRenderAttributeString( 'double-button-two' ) }}}>
<# if (  settings.button_one_icon.value !=='' ) {#>
	{{{ icon_two.value }}}
<# }#>
{{{settings.button_two_text}}}
</{{{button_two_link}}}>
<#}#>
</div>