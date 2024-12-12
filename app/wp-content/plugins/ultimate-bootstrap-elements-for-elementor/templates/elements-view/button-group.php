<#
var button_group_classes = [
	'ube-button-group',
	'flex-wrap'
];
if ( settings.button_group_style ) {
	button_group_classes.push(settings.button_group_style);
}

if ( settings.button_group_icon_position === 'before' ) {
	button_group_classes.push('icon-before');
} else {
	button_group_classes.push ('icon-after');
}

view.addRenderAttribute( 'button_group_classes', 'class', button_group_classes );
view.addRenderAttribute( 'button_group_classes', 'role', 'group' );

var button_classes = [
	'btn',
	settings.button_group_size,
];
if ( settings.button_group_layout==='classic' && settings.button_group_color_scheme !== '' && settings.button_group_color_scheme!==null  ) {
	button_classes.push('btn-' + settings.button_group_color_scheme);
}
if (settings.button_group_layout==='outline' && settings.button_group_outline_color_scheme !== '' && settings.button_group_outline_color_scheme!==null  ) {
	button_classes.push('btn-outline-' + settings.button_group_outline_color_scheme);
}
if ( settings.button_group_hover_animation ) {
	button_classes.push('elementor-animation-' + settings.button_group_hover_animation);
}
#>
<div {{{ view.getRenderAttributeString( 'button_group_classes' ) }}}>
	<# if ( settings.button_group_items && settings.button_group_items.length> 0 ) {
		_.each( settings.button_group_items, function( item, index ) {
			var item_link_key = view.getIDInt().toString().substr( 0, 3 )+index;
			view.addRenderAttribute( item_link_key, 'class', button_classes );
			if ( item.button_group_link.url === '' ) {
				item.button_group_link.url = '#';
			}
			if ( item.button_group_link.url!=='' ) {
                if( item.button_group_link.is_external){
                view.addRenderAttribute( item_link_key, 'target', '_blank' );
                }
                if(item.button_group_link.nofollow){
                view.addRenderAttribute( item_link_key, 'rel', 'nofollow' );
                }
				view.addRenderAttribute( item_link_key,'href' ,item.button_group_link.url );
			}
			#>
			<a {{{ view.getRenderAttributeString( item_link_key ) }}}>
				<#if ( settings.button_group_icon_position === 'before' ) {
					if ( item.button_group_icon.value) {#>
						<i class="{{{ item.button_group_icon.value }}}"></i>
					<#}
					if ( item.button_group_text ) {#>
						{{{ item.button_group_text}}}
					<#}
				} else {
					if ( item.button_group_text!=='' ) {#>
						{{{ item.button_group_text }}}
					<#}
					if ( item.button_group_icon.value ) {#>
                        <i class="{{{ item.button_group_icon.value }}}"></i>
					<#}
				} #>

			</a>
			<#});
	}
	#>
</div>