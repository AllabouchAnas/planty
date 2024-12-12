<#
var tl_classes = [
	'ube-timeline',
	"ube-timeline-style-"+settings.timeline_style];

view.addRenderAttribute( 'timeline_attr', 'class', tl_classes );

#>
<div {{{ view.getRenderAttributeString( 'timeline_attr' ) }}}>
	<# if ( settings.timeline_content_list.length>0){#>
		<#_.each( settings.timeline_content_list, function( items, i ) {
			var items_class = [
				'ube-timeline-item',
				'd-flex',
				'justify-content-between'
			];
			if ( i % 2 !== 0 ) {
				items_class.push( 'item-reverse');
			}
			if ( items.timeline_active === 'yes' ) {
				items_class.push( 'item-active');
			}
			var item_setting_key =view.getIDInt().toString().substr( 0, 3 )+i;
			view.addRenderAttribute( item_setting_key, 'class', items_class )
			#>
			<div {{{ view.getRenderAttributeString( item_setting_key ) }}}>
				<# if ( items.timeline_time !==''){ #>
					<div class="ube-timeline-time">
						<span>{{{items.timeline_time }}}</span>
					</div>
				<# } #>
				<# if ( items.timeline_content!=='' ||  items.timeline_title!=='' ){ #>
					<div class="ube-timeline-content">
						<#
						if (  items.timeline_title !=='' ) {#>
							<h6 class="ube-timeline-title"> {{{ items.timeline_title }}}</h6>
						<# } #>
						<div class="content">{{{items.timeline_content }}}</div>
					</div>
				<# } #>
			</div>
		<# });#>
	<# } #>
</div>
