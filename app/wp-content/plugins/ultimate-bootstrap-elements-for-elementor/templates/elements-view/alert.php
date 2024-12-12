<#
var wrapper_classes = [
	'ube-alert',
	'alert',
];

if (settings.scheme !== '') {
	wrapper_classes.push('alert-' + settings.scheme);
}

if (settings.show_dismiss === 'show') {
	wrapper_classes.push('alert-dismissible');
	wrapper_classes.push('fade');
	wrapper_classes.push('show');
}

var title_html_tag = elementor.helpers.validateHTMLTag(settings.title_html_tag ? settings.title_html_tag : 'h4');

view.addRenderAttribute('wrapper', 'class', wrapper_classes);
view.addRenderAttribute('wrapper','role','alert');
#>
<div {{{ view.getRenderAttributeString( 'wrapper' ) }}}>
	<# if ( settings.title ) {
		view.addInlineEditingAttributes( 'title', 'none' );
		view.addRenderAttribute('title', 'class', 'alert-heading');
	#>
		<{{{ title_html_tag }}} {{{ view.getRenderAttributeString( 'title' ) }}}>
		{{{ settings.title }}}
		</{{{ title_html_tag }}}>
	<# } #>

	<# if (settings.description) {
	view.addInlineEditingAttributes( 'description', 'advanced' );
	view.addRenderAttribute('description', 'class', 'alert-description');
	#>
		<div {{{ view.getRenderAttributeString( 'description' ) }}}>
			{{{ settings.description }}}
		</div>
	<# } #>

	<# if (settings.show_dismiss === 'show') { #>
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
	<# } #>
</div>
