<#
var divider_classes = [
'ube-divider',
"ube-divider-style-" + settings.divider_style
];

if ( settings.divider_add_element !== '' ) {
divider_classes.push( 'has-element');
}

view.addRenderAttribute('divider_attr', 'class', divider_classes );

#>
<div {{{ view.getRenderAttributeString( 'divider_attr' ) }}}>
<div class="ube-divider-separator">
    <# if ( settings.divider_add_element !== '' ) { #>
    <span class="ube-divider-element"></span>
    <span class="ube-divider-content">
				<# if ( settings.divider_add_element === 'text' && settings.divider_text !== '' ){ #>
					{{{ settings.divider_text }}}
				<#} #>
				<# if ( settings.divider_add_element === 'icon' &&  settings.divider_icon.value !=='' ){
                   var iconHTML = elementor.helpers.renderIcon( view, settings.divider_icon, { 'aria-hidden': true }, 'i' , 'object' );
        console.log(iconHTML);
        #>
					{{{ iconHTML.value }}}
				<# } #>
			</span>
    <span class="ube-divider-element"></span>
    <# } #>
</div>
</div>
