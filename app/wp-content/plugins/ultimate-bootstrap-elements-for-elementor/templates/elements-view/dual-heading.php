<#
var dual_heading_classes = [
	'ube-dual-heading',
];

var tag_html = elementor.helpers.validateHTMLTag(settings.dual_heading_title_tag);
var tag_html_sub = elementor.helpers.validateHTMLTag(settings.dual_heading_sub_title_tag);

var divider_html = '';
if (settings.dual_heading_divider_enable !== '') {
	divider_html = '<div class="ube-heading-divider"></div>';
	dual_heading_classes.push('ube-dual-heading-divider-' + settings.dual_heading_divider_position);
}

if (settings.dual_heading_title_size !== '') {
dual_heading_classes.push('ube-dual-heading-size-' + settings.dual_heading_title_size);
}

dual_heading_first_html = '';
if (settings.dual_heading_title_first !== '') {
	dual_heading_first_html = '<span class="ube-dual-heading-title-first">' + settings.dual_heading_title_first + '</span>';
}
dual_heading_last_html = '';
if (settings.dual_heading_title_last !== '') {
	dual_heading_last_html = '<span class="ube-dual-heading-title-last">' + settings.dual_heading_title_last + '</span>';
}

view.addRenderAttribute('dual_heading_attr', 'class', dual_heading_classes);
view.addRenderAttribute('dual_heading_sub_title_attr', 'class', 'ube-dual-heading-sub-title');
view.addRenderAttribute('dual_heading_description_attr', 'class', 'ube-dual-heading-desc-heading');

#>
<div {{{ view.getRenderAttributeString('dual_heading_attr') }}}>
	<#
	if (settings.dual_heading_sub_title_text !== '') {#>
		<{{{tag_html_sub}}} {{{ view.getRenderAttributeString('dual_heading_sub_title_attr') }}}>
			{{{settings.dual_heading_sub_title_text}}}
		</{{{tag_html_sub}}}>
	<# }
	if (settings.dual_heading_divider_position === 'before') {#>
		{{{divider_html}}}
	<#}
	if (settings.dual_heading_title_last !== '' || settings.dual_heading_title_first !== '') {#>
		<{{{tag_html}}} class="ube-dual-heading-title">
			{{{dual_heading_first_html}}}
			{{{dual_heading_last_html}}}
		</{{{tag_html}}}>
	<#}
	if (settings.dual_heading_divider_position === 'after') {#>
		{{{divider_html}}}
	<#}
	if (settings.dual_heading_desc_heading !== '') {#>
		<div {{{ view.getRenderAttributeString('dual_heading_description_attr') }}}>
			{{{settings.dual_heading_desc_heading}}}
		</div>
	<#}	#>
</div>