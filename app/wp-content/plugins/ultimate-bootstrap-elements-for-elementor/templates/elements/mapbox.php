<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @var $element UBE_Element_Mapbox
 */

$settings = $element->get_settings_for_display();
$wrapper_classes = array(
	'ube-map-box',
);

if ($settings['marker_effect'] === 'yes') {
	$wrapper_classes[] = 'ube-map-box-effect';
}

$element->add_render_attribute('wrapper','class',$wrapper_classes);


$id = 'ube_map_box_' .  $element->get_id();

$element->add_render_attribute('wrapper','id', $id);

$options = array(
	'scrollwheel' => $settings['zoom_mouse_wheel'] === 'yes',
	'skin'        => $settings['map_style'],
	'container' => $id
);

if ( $settings['map_zoom'] !== '' ) {
	$options['zoom'] = $settings['map_zoom'];
}



$element->add_render_attribute('wrapper','data-options',json_encode($options));
$markers = array();
foreach ( $settings['items'] as $i => $value ) {
	$address     = isset( $value['address'] ) ? ( $value['address'] ) : '';
	$position = false;
	if ( !empty($address) && strpos($address,',') > 0 ) {
		$address_arr = explode( ',', $address);
		$position =  array(
			'lat' => $address_arr[0],
			'lng' => $address_arr[1]
		);
	}
	$marker_html = '';
	if (!empty($value['image_marker']['id'])) {
		$marker_html =  wp_get_attachment_image($value['image_marker']['id'], 'full');
	}

	$popup_html                = $element->render_popup_item($value['title'], $value['description'],$value['image']);
	$markers[] = array(
		'position' => $position,
		'marker'   => $marker_html,
		'popup'    => $popup_html
	);
}
$element->add_render_attribute('wrapper','data-markers',json_encode($markers));
?>
<div <?php $element->print_render_attribute_string( 'wrapper' ); ?> ></div>
