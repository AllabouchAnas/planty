<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @var $element UBE_Element_Google_Map
 */

$settings = $element->get_settings_for_display();

$map_options     = [];
$marker_opts     = [];
$all_markerslist = [];
$id              = $element->get_id();
foreach ( $settings['map_marker_list'] as $i => $marker_item ) {
	$marker_opts['latitude']  = ( $marker_item['marker_lat'] ) ? $marker_item['marker_lat'] : '';
	$marker_opts['longitude'] = ( $marker_item['marker_lng'] ) ? $marker_item['marker_lng'] : '';

	$image_url = '';
	if ( ! empty( $marker_item['custom_marker']['url'] ) ) {
		$image_url = $marker_item['custom_marker']['url'];

	}
	$popup_image_url = '';
	if ( ! empty( $marker_item['marker_popup_image']['url'] ) ) {
		$popup_image_url = $marker_item['marker_popup_image']['url'];
	}
	$ballon_text = $element->render_popup_item( $marker_item['marker_popup_image']['id'],$popup_image_url, $marker_item['marker_title'], $marker_item['marker_description'] );
	$marker_opts['baloon_text'] = $ballon_text;
	$marker_opts['icon']        = $image_url;
	$all_markerslist[]          = $marker_opts;
};
$map_options['mapTypeId']   = $settings['google_map_type'];

$map_options['center'] = !empty( $settings['center_address'] ) ? $settings['center_address'] : 'Americal';
$map_options['mapTypeControl'] = false;
if ( $settings['google_map_map_type_control'] == 'yes' ) {
	$map_options['mapTypeControl'] = true;
}
$map_options['zoomControl'] = false;
if ( $settings['zoom_control'] == 'yes' ) {
	$map_options['zoomControl'] = true;
}
$map_options['zoom'] = ! empty( $settings['map_default_zoom']['size'] ) ? $settings['map_default_zoom']['size'] : 5;

$map_options['streetViewControl'] = false;
if ( $settings['google_map_option_streeview'] == 'yes' ) {
	$map_options['streetViewControl'] = true;
}
$map_options['fullscreenControl'] = false;
if ( $settings['google_map_option_fullscreen_control'] == 'yes' ) {
	$map_options['fullscreenControl'] = true;
}
$map_options['draggable'] = false;
if ( $settings['google_map_option_draggable_control'] == 'yes' ) {
	$map_options['draggable'] = true;
}
$map_options['scaleControl'] = false;
if ( $settings['google_map_option_scale_control'] == 'yes' ) {
	$map_options['scaleControl'] = true;
}

$element->add_render_attribute( 'googlemaps_attr', array(
	'class'           => 'ube-google-map',
	'id'              => 'ube-google-map-' . $id,
	'data-id'         => $id,
	'data-mapmarkers' => wp_json_encode( $all_markerslist ),
	'data-mapoptions' => wp_json_encode( $map_options ),
	'data-mapstyle'   => $settings['style_address'],
) );

?>
<div <?php echo $element->get_render_attribute_string( 'googlemaps_attr' ); ?> >&nbsp;</div>