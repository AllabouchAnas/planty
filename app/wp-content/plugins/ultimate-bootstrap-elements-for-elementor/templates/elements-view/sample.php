<#
view.addInlineEditingAttributes( 'text', 'basic' );
view.addRenderAttribute('button', 'class', 'btn btn-primary');
view.addRenderAttribute('icon', 'class', settings.icon.value);
#>
<div {{{ view.getRenderAttributeString( 'button' ) }}}>
	<i {{{ view.getRenderAttributeString( 'icon' ) }}}></i>
	<span {{{ view.getRenderAttributeString( 'text' ) }}}>{{{ settings.text }}}</span>
</div>