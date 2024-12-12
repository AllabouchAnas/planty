<#
var map_options     = {};
var all_markerslist = [];
var id              = view.getIDInt().toString();
_.each( settings.map_marker_list, function( marker_item, i ) {
    var marker_opts     = {};
	marker_opts.latitude  = ( marker_item.marker_lat!=='' ) ? marker_item.marker_lat : '';
	marker_opts.longitude = ( marker_item.marker_lng!=='' ) ? marker_item.marker_lng : '';

	var image_url = '';
	if (  marker_item.custom_marker.url !=='' ) {
        image_url = marker_item.custom_marker.url;

	}
	var popup_image_url = '';
	if (  marker_item.marker_popup_image.url !=='' ) {
        popup_image_url = marker_item.marker_popup_image.url;
	}
	var ballon_text ='';
        if (popup_image_url==='' &&  marker_item.marker_title ==='' && marker_item.marker_description==='' ) {
        ballon_text= '';
        }else{
         ballon_text+= '<div class="card">';

            if ( popup_image_url!=='' ) {
           ballon_text+=  '<img class="card-img-top" src="' + popup_image_url+ '">';
            }

           ballon_text+=  '<div class="card-body">';

                if ( marker_item.marker_title!=='' ) {
               ballon_text+=  '<h5 class="card-title">' + marker_item.marker_title + '</h5>';
                }

                if (  marker_item.marker_description!=='' ) {
                ballon_text+=  '<p class="card-text">' + marker_item.marker_description + '</p>';
                }

        ballon_text+=  '</div >';
        ballon_text+=  '</div >';
    }
if(ballon_text!==''){
marker_opts.baloon_text = ballon_text;
}
if(image_url!==''){
marker_opts.icon        = image_url;
}
all_markerslist.push(marker_opts);
});
map_options.mapTypeId   = settings.google_map_type;
map_options.zoomControl = false;
if ( settings.zoom_control == 'yes' ) {
map_options.zoomControl = true;
}
if(settings.center_address!==''){
map_options.center=settings.center_address;
}
map_options.mapTypeControl = false;
if ( settings.google_map_map_type_control == 'yes' ) {
	map_options.mapTypeControl = true;
}
map_options.zoom =  settings.map_default_zoom.size!=='' ? settings.map_default_zoom.size : 5;
map_options.streetViewControl = false;
if ( settings.google_map_option_streeview === 'yes' ) {
	map_options.streetViewControl = true;
}
map_options.fullscreenControl = false;
if ( settings.google_map_option_fullscreen_control === 'yes' ) {
	map_options.fullscreenControl = true;
}
map_options.draggable = false;
if ( settings.google_map_option_draggable_control === 'yes' ) {
	map_options.draggable = true;
}
map_options.scaleControl = false;
if ( settings.google_map_option_scale_control === 'yes' ) {
	map_options.scaleControl = true;
}

view.addRenderAttribute( 'googlemaps_attr', {
	'class'           : 'ube-google-map',
	'id'              : 'ube-google-map-' + id,
	'data-id'         : id,
	'data-mapmarkers' : JSON.stringify( all_markerslist ),
	'data-mapoptions' : JSON.stringify( map_options ),
	'data-mapstyle'   : settings.style_address,
});

#>
<div {{{ view.getRenderAttributeString( 'googlemaps_attr' ) }}}></div>