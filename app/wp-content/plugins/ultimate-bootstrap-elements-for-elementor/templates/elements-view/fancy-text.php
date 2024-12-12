<#

var fancy_classes = [
	'ube-fancy-text',
];

if (settings.fancy_text_animation_type !== '') {
	fancy_classes.push('ube-fancy-text-' + settings.fancy_text_animation_type);
}

if (settings.fancy_text_class !== '') {
fancy_classes.push(settings.fancy_text_class);
}

if (settings.fancy_text_animated_background !== '') {
	fancy_classes.push('ube-fancy-text-animate-has-bg');
}

var additional_data = {};
if (settings.fancy_text_slide_up_pause_time !== '') {
	additional_data.animationDelay = settings.fancy_text_slide_up_pause_time;
}
var data_text = [] ;
if (settings.fancy_text_animation_type === 'typing' && settings.fancy_text_animated_text.length>0) {
	_.each( settings.fancy_text_animated_text, function( items, i ) {
		data_text.push(items.fancy_text_field_animated);
	});
	view.addRenderAttribute('fancy_attr', 'data-text', JSON.stringify( data_text ));

	if (settings.fancy_text_typing_speed !== '') {
		additional_data.typingSpeed = settings.fancy_text_typing_speed;
	}
	if (settings.fancy_text_typing_delay !== '') {
		additional_data.typingDelay = settings.fancy_text_typing_delay;
	}
	if (settings.fancy_text_typing_loop == 'yes') {
		additional_data.typingLoop = true;
	}
	if (settings.fancy_text_typing_cursor == 'yes') {
		additional_data.typingCursor = true;
	}
}

view.addRenderAttribute( 'fancy_attr', {
	'data-additional-options' : JSON.stringify( additional_data ),
	'class'                   : fancy_classes,
});

var tag_html=  elementor.helpers.validateHTMLTag(settings.fancy_text_tag ? settings.fancy_text_tag : 'h2'),
	j=0;


var fancy_text_animated_classes = [
'ube-fancy-text-animated',
];


if (settings.fancy_text_animated_class !== '') {
fancy_text_animated_classes.push(settings.fancy_text_animated_class);
}

view.addRenderAttribute( 'fancy_text_animated_attr', {
	'class'                   : fancy_text_animated_classes,
});



#>
<{{{tag_html}}} {{{ view.getRenderAttributeString( 'fancy_attr' ) }}}>
	<# if ( settings.fancy_text_prefix !== '' ) {#>
		<span class="ube-fancy-text-before">{{{settings.fancy_text_prefix}}}</span>
	<# } #>
	<span {{{ view.getRenderAttributeString( 'fancy_text_animated_attr' ) }}}>
		<# if ( settings.fancy_text_animated_text.length>0 && settings.fancy_text_animation_type !== 'typing'){#>
			<#_.each( settings.fancy_text_animated_text, function( items, i ) {
				var item_setting_key =view.getIDInt().toString().substr( 0, 3 )+i;
				j ++;
                var items_class = [
					'ube-fancy-text-item',
				];

				if ( j ==1 ) {
					items_class.push('ube-fancy-text-show');
				}
				view.addRenderAttribute('fancy_text_item'+j, 'class', items_class);
				#>
				<b {{{ view.getRenderAttributeString( 'fancy_text_item'+j ) }}}>{{{items.fancy_text_field_animated }}}</b>
			<# });#>
		<# } #>
	</span>
	<# if ( settings.fancy_text_suffix !== '' ) {#>
	<span class="ube-fancy-text-after">{{{settings.fancy_text_suffix}}}</span>
	<# } #>
</{{{tag_html}}}>
