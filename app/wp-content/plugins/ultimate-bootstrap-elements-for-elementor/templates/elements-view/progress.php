<#
view.addRenderAttribute( 'progress-warrper', 'class', 'progress' );
var progress_ube_classes = [
	'ube-progress',
	'ube-progress-style-' + settings.progress_style,
];
if ( settings.progress_bar_indicator == 'yes' ) {
   progress_ube_classes.push( 'ube-progress-indicator');
}
view.addRenderAttribute( 'progress_ube_classes', 'class', progress_ube_classes );


#>
<div {{{ view.getRenderAttributeString( 'progress_ube_classes' )}}}>
	<#  _.each( settings.progress_bar_multiple, function( item, index ) {
		var progress_items_classes = view.getIDInt().toString().substr( 0, 3 ) + index;
		var progress_classes = [
			'progress-bar'
		];
		if (settings.progress_type !=='' &&  settings.progress_type !==null ) {
			progress_classes.push( settings.progress_type);
		}

		if ( settings.progress_mode_animated == 'yes' ) {
			progress_classes.push( 'progress-bar-animated');
		}
		if ( settings.progress_bg_color_scheme !=='' ) {
			progress_classes.push( 'bg-' + settings.progress_bg_color_scheme);
		}
        progress_classes.push( 'elementor-repeater-item-' + item._id);
		var progressbar_settings = {
			progress_value : item.progress_multiple_bar_value,
			speed        : item.progressbar_speed,
		};
		view.addRenderAttribute( progress_items_classes, {
			"class"         : progress_classes,
			"role"          : 'progressbar',
			"aria-valuemin" : 0,
			"aria-valuemax" : 100,
			"aria-valuenow" : item.progress_multiple_bar_value,
			"data-settings" : JSON.stringify(progressbar_settings)
		} );
		#>
        <div class="ube-progress-content">
			<# if (  item.progress_label !=='' && settings.progress_style == '01' || settings.progress_style == '04' ) { #>
                <span class="ube-progress-label">{{{ item.progress_label }}}</span>
			<# } #>
            <div {{{ view.getRenderAttributeString( 'progress-warrper' )}}}>
                <div {{{ view.getRenderAttributeString( progress_items_classes )}}}>
					<# if (  item.progress_label !=='' ||  item.progress_multiple_bar_value !=='') { #>
							<# if (  item.progress_label!=='' && settings.progress_style == '02' ) { #>
                                <span class="ube-progress-label"> {{{item.progress_label }}}</span>
							<# } #>
							<# if (item.progress_multiple_bar_value !=='' && settings.progress_display_value == "yes" ) { #>
                                <span class="ube-progress-value"> {{{ item.progress_multiple_bar_value }}}%</span>
							<# } #>
					<# } #>
                </div>
            </div>
			<# if (  item.progress_label!=='' && settings.progress_style == '03' ) { #>
                <span class="ube-progress-label">{{{ item.progress_label }}}</span>
			<# } #>
        </div>
	<# });#>
</div>


