<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Group_Control_Image_Size;
use Elementor\Widget_Base;

/**
 * @var $element Elementor\Widget_Base
 * @var $logo array
 * @var $hover
 * @var $link array
 * @var $item_key
 * @var  $custom_css
 */

if (!isset($item_key)) {
	$item_key = '';
}

$item_class = array(
	'ube-client-logo-item'
);

if (isset($custom_css) && !empty($custom_css)) {
	$item_class[] = $custom_css;
}

if ( $hover !== '' ) {
	$item_class[] = 'ube-client-logo-hover-' . $hover;
}

$tag_html = 'div';
if ( isset( $link['url'] ) && ( $link['url'] !== '' ) ) {
	$tag_html = 'a';
	$element->add_link_attributes( "item_class{$item_key}", $link );
}

$element->add_render_attribute( "item_class{$item_key}", 'class', $item_class );
$image_settings = array('image' => $logo, 'image_size' =>  'full');

printf( '<%1$s %2$s>', $tag_html, $element->get_render_attribute_string( "item_class{$item_key}" ) );
Group_Control_Image_Size::print_attachment_image_html($image_settings);
printf( '</%1$s>', $tag_html );
