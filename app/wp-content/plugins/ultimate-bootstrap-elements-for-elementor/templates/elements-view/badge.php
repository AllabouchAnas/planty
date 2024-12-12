<#
view.addInlineEditingAttributes( 'badge_text', 'basic' );
var badge_classes = [
	'badge',
	settings.badge_view,
];
if (settings.badge_color_scheme !== '') {
	badge_classes.push('badge-' + settings.badge_color_scheme);
}
view.addRenderAttribute('badge_text', 'class', badge_classes);

var badge_tag = 'span';
var link = '';
if ( settings.badge_link.url) {
	badge_tag = 'a';
	link = 'href="' + settings.badge_link.url + '"';
}
#>
<{{{badge_tag}}} {{{ view.getRenderAttributeString( 'badge_text' ) }}} {{{link}}}>
	{{{ settings.badge_text }}}
</{{{badge_tag}}}>