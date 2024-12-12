<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * @var $element UBE_Element_Badge
 */

$settings = $element->get_settings_for_display();

$element->add_inline_editing_attributes( 'badge_text', 'basic' );

$badge_classes = array(
	'badge',
	$settings['badge_view'],
);

if ( $settings['badge_color_scheme'] !== '' ) {
	$badge_classes[] = 'badge-' . $settings['badge_color_scheme'];
}

$element->add_render_attribute( 'badge_text', 'class', $badge_classes );

$badge_tag = 'span';

if ( ! empty( $settings['badge_link']['url'] ) ) {
	$element->add_link_attributes( 'badge_text', $settings['badge_link'] );
	$badge_tag = 'a';
}

if ( $settings['badge_hover_animation'] ) {
	$element->add_render_attribute( 'badge_text', 'class', 'elementor-animation-' . $settings['badge_hover_animation'] );
}
printf( '<%1$s %2$s>', $badge_tag, $element->get_render_attribute_string( 'badge_text' ) );
echo esc_html( $settings['badge_text'] );
printf( '</%1$s>', $badge_tag );
?>