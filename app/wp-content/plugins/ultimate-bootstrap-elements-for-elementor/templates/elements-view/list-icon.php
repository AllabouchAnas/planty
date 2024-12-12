<#
var list_icon_tag = 'span';

var list_icon_classes = [
	'ube-list-icon',
];
if(settings.list_icon_size !==''){
  list_icon_classes.push( 'ube-list-icon-' + settings.list_icon_size);
}

if(settings.list_icon_type!=='' && settings.list_icon_view==='list-type-icon'){
   list_icon_classes.push('ube-list-icon-' +settings.list_icon_type);
}

if ( settings.list_icon_scheme !== '' ) {
   list_icon_classes.push( 'text-' + settings.list_icon_scheme);
}

view.addRenderAttribute( 'list_icon', 'class',list_icon_classes );

var list_icon_content_classes = [
	'list-icon',
];


if ( settings.list_icon_layout === 'list-column' ) {
	view.addRenderAttribute( 'list_icon', 'class', 'list-unstyled' );
	view.addRenderAttribute( 'list_icon_item', 'class', 'list-icon-item' );
} else {
	view.addRenderAttribute( 'list_icon', 'class', 'list-inline' );
	view.addRenderAttribute( 'list_icon_item', 'class', 'list-inline-item' );
}

var auto_number       = parseInt(settings.list_icon_number) - 1;
var list_number_start = 'item ' + auto_number;

if ( settings.list_icon_number > 0 ) {
	view.addRenderAttribute( 'list_icon', 'style', 'counter-reset:' + list_number_start );
}
var iconsHTML = {};

#>
<ul {{{view.getRenderAttributeString( 'list_icon' )}}}>
<#
	_.each( settings.list_icon_repeater, function( item, index ) {

		var list_items_classes =view.getIDInt().toString().substr( 0, 3 )+index+"list_icon_content_classes";
		var link_list_icon =view.getIDInt().toString().substr( 0, 3 )+index+"link-list";

		if ( item.list_icon_link.url !=='' ) {
		if( item.list_icon_link.is_external){
		view.addRenderAttribute( link_list_icon, 'target', '_blank' );
		}
		if(item.list_icon_link.nofollow){
		view.addRenderAttribute( link_list_icon, 'rel', 'nofollow' );
		}
		view.addRenderAttribute( link_list_icon,'href' ,item.list_icon_link.url );
			list_icon_tag = 'a';
		}
		view.addRenderAttribute( link_list_icon, 'class','ube-list-icon-title');

		var list_icon_content_classes = ['ube-list-icon-icon'];

		view.addRenderAttribute( list_items_classes, 'class',list_icon_content_classes );

		#>

		<li {{{view.getRenderAttributeString( 'list_icon_item' )}}}>
			<# if (  settings.list_icon_type_icon.value !=='' && item.list_icon_selected_icon.value === "" && settings.list_icon_view === 'list-icon-icon') {
                var iconHTML = elementor.helpers.renderIcon( view, settings.list_icon_type_icon, { 'aria-hidden': true }, 'i' , 'object' );
#>
				<span {{{view.getRenderAttributeString(list_items_classes )}}}>
					{{{ iconHTML.value }}}
				</span>
			<# } #>
			<# if ( item.list_icon_selected_icon.value !=='' && settings.list_icon_view === 'list-icon-icon') {
                iconsHTML[ index ] = elementor.helpers.renderIcon( view, item.list_icon_selected_icon, { 'aria-hidden': true }, 'i', 'object' );
            #>
				<span {{{view.getRenderAttributeString( list_items_classes )}}}>
			        {{{ iconsHTML[ index ].value }}}
				</span>
			<# }#>
			<# if ( item.list_icon_title !=='') { #>
				<{{{list_icon_tag}}} {{{view.getRenderAttributeString(link_list_icon )}}}>
					{{{item.list_icon_title}}}
				</{{{list_icon_tag}}}>
			<# } #>
		</li>
	<# }); #>
</ul>



