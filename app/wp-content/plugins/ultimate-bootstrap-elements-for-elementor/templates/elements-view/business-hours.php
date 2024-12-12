<#
var bh_classes = [
'ube-business-hours',
"ube-business-hours-layout-"+settings.bh_layout,
];

if (settings.bh_divider_position !== '') {
	bh_classes.push('ube-business-hours-divider-position-' + settings.bh_divider_position);
}

view.addRenderAttribute( 'business_attr', 'class', bh_classes );
#>

<div {{{ view.getRenderAttributeString( 'business_attr' ) }}}>
    <ul class="ube-business-hours-inner">
		<# _.each( settings.bh_list, function( item, index ) {
            var item_setting_key = view.getIDInt().toString().substr( 0, 3 )+index;
			var item_classes = ['ube-business-hours-item', 'elementor-repeater-item-' +item._id ];
			if ( item.bh_this_day === 'yes' ) {
				item_classes.push('ube-business-hours-hight-ligh');
			}
         view.addRenderAttribute( item_setting_key,'class', item_classes );
			#>
            <li {{{ view.getRenderAttributeString( item_setting_key ) }}}>
				<#
				if ( item.bh_day!==''  ) {#>
				<span class="ube-business-day">{{{item.bh_day}}}</span>
				<#}
				if ( settings.bh_layout === '04' ) {#>
					<span class="ube-business-divider"></span>
				<#}
				if ( item.bh_time!=='') {#>
					<span class="ube-business-time"> {{{item.bh_time}}}</span>
				<#}#>
            </li>
		<#});#>
    </ul>
</div>