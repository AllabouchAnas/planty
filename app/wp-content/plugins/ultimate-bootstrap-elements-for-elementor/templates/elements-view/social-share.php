<#
var social_items_color = social_items_bg = social_animation = social_share_outline = '';
var social_share_classes = [
	'ube-social-share',
	'ube-social-icons',
	'ube-social-' + settings.social_share_shape,
	'ube-social-' + settings.social_size,
];

view.addRenderAttribute( 'social_share', 'class', social_share_classes );

if (  settings.social_item_text_scheme !=='' ) {
	social_items_color = 'text-' + settings.social_item_text_scheme;
}

if (  settings.social_item_background_scheme !=='' && settings.social_share_shape !== 'classic'
&& settings.social_share_shape !== 'text' ) {
	social_items_bg = 'bg-' + settings.social_item_background_scheme;
}

if (  settings.social_hover_animation !=='' ) {
	social_animation = 'elementor-animation-' + settings.social_hover_animation;
}

if ( settings.social_share_outline === 'yes' && settings.social_share_shape !== 'classic'
&& settings.social_share_shape !== 'text') {
	social_share_outline = 'ube-social-outline';
}

#>

<ul {{{ view.getRenderAttributeString( 'social_share' ) }}}>
	<#_.each( settings.social_share_list, function( item, index ) {
		var social_classes = [ 'ube-social-' + item.social_share_label, 'elementor-repeater-item-' + item._id ];
		if ( social_items_color !=='' ) {
			social_classes.push( social_items_color);
		}
		if ( social_items_bg !=='' ) {
			social_classes.push( social_items_bg);
		}
		if (  social_share_outline !=='' ) {
			social_classes.push( social_share_outline);
		}
		if (  social_animation !=='' ) {
			social_classes.push( social_animation);
		}

		var social_items_classes = view.getIDInt().toString().substr( 0, 3 )+index;

		if ( settings.social_switcher_tooltip !== '' ) {
			view.addRenderAttribute( social_items_classes, {
			'data-toggle' : 'tooltip',
			'data-placement' : settings.social_position,
			} )
		};

		view.addRenderAttribute( social_items_classes, {
			'class'       : social_classes,
			'data-social' : item.social_share_media,
			'title' : item.social_share_label,
		});

		icon_social = elementor.helpers.renderIcon( view, item.social_icon, { 'aria-hidden': true }, 'i' , 'object' ),
		#>
		<li {{{ view.getRenderAttributeString( social_items_classes ) }}}>
			{{{ icon_social.value }}}
			<# if ( settings.social_share_shape === 'text' || settings.social_share_shape === 'text-background' ) { #>
				<span class="ube-text-social">{{{ item.social_share_label}}}</span>
			<#} #>
		</li>
	<# }); #>
</ul>
