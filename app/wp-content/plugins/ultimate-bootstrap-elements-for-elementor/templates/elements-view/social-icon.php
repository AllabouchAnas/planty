<#
var social_items_color = social_items_bg = social_animation = social_icon_outline='';

var social_icon_classes = [
	'ube-social-icons',
	'ube-social-' + settings.social_icon_shape,
	'ube-social-' + settings.social_size,
];

view.addRenderAttribute( 'social_icon', 'class', social_icon_classes );

if ( settings.social_item_text_scheme !=='' ) {
	social_items_color = 'text-' + settings.social_item_text_scheme;
}

if ( settings.social_item_background_scheme !=='' && settings.social_icon_shape !== 'text' && settings.social_icon_shape !== 'classic' ) {
	social_items_bg = 'bg-' + settings.social_item_background_scheme;
}

if (  settings.social_hover_animation !=='' ) {
	social_animation = 'elementor-animation-' + settings.social_hover_animation;
}

if ( settings.social_icon_outline === 'yes' && settings.social_icon_shape !== 'text' && settings.social_icon_shape !== 'classic') {
	social_icon_outline = 'ube-social-outline';
}

#>
<ul {{{ view.getRenderAttributeString( 'social_icon' ) }}}>
	<#
	_.each( settings.social_icon_list, function( item, index ) {

		var social_str ='';
		if (  item.social_title == '' ) {
			if ( 'svg' !== item.social_icon.library ) {
				var social = item.social_icon.value.split(' ');
		        var social_str='';
				if (  social[1] ==='' ) {
		        social_str = '';
				} else {
		            social_str = social[1].replace( 'fa-', '' );
				}
				social_icon = 'ube-social-' + social_str;
			} else{
				social_icon = 'ube-social-svg';
			}
		} else{
			social_icon = 'ube-social-' +  item.social_title;
		}

		var social_items_classes =view.getIDInt().toString().substr( 0, 3 )+index +"social_classes";
		var social_items_links   = view.getIDInt().toString().substr( 0, 3 )+index +"social_link";

		var social_icon_tag = 'span';

		if ( item.social_icon_link.url !== '' ) {
			if( item.social_icon_link.is_external){
			view.addRenderAttribute( social_items_links, 'target', '_blank' );
			}
			if(item.social_icon_link.nofollow){
			view.addRenderAttribute( social_items_links, 'rel', 'nofollow' );
			}
			view.addRenderAttribute( social_items_links,'href' ,item.social_icon_link.url );
			social_icon_tag = 'a';
		}


		var social_classes   = [ social_icon,'elementor-repeater-item-' + item._id ];
		if (  social_items_color !=='' ) {
			social_classes.push( social_items_color);
		}
		if (  social_items_bg !=='' ) {
			social_classes.push( social_items_bg);
		}
		if (  social_icon_outline !=='' ) {
			social_classes.push( social_icon_outline);
		}
		if ( social_animation !=='' ) {
			social_classes.push( social_animation);
		}
		if (item.social_title =='' ) {
			socials_title = social_str;
		} else {
			socials_title = item.social_title;
		}

		if ( settings.social_switcher_tooltip === '' ) {
			view.addRenderAttribute( social_items_classes, 'class', social_classes );
			view.addRenderAttribute( social_items_links, {
			'class'       : 'ube-social-icon-icon',
			'title' : socials_title,
			} );
		} else {
			view.addRenderAttribute( social_items_classes, {
			'class'       : social_classes,
			'data-toggle' : 'tooltip',
			'data-placement' : settings.social_position,
			'title' : socials_title,
			} );
			view.addRenderAttribute( social_items_links, 'class', 'ube-social-icon-icon' );
		}

		icon_social = elementor.helpers.renderIcon( view, item.social_icon, { 'aria-hidden': true }, 'i' , 'object' ),
		#>
		<li {{{ view.getRenderAttributeString( social_items_classes ) }}}>
			<{{{social_icon_tag}}} {{{view.getRenderAttributeString( social_items_links )}}}>
				{{{ icon_social.value }}}
			<# if ( settings.social_icon_shape === 'text' && item.social_title == '') { #>
				<span class="ube-text-social">{{{ social_str }}}</span>
			<# } #>
			<# if ( settings.social_icon_shape === 'text' && item.social_title !== '') { #>
				<span class="ube-text-social">{{{ item.social_title }}}</span>
			<# } #>
			</{{{social_icon_tag}}}>
		</li>
	<# }); #>
</ul>
