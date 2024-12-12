<?php

use Elementor\Group_Control_Image_Size;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @var $element UBE_Element_Image
 */

$settings = $element->get_settings_for_display();

$image_tag = 'div';
if ( ! empty( $settings['link']['url'] ) ) {
	$image_tag = 'a';
	$target    = $settings['link']['is_external'] ? ' target="_blank"' : '';
	$nofollow  = $settings['link']['nofollow'] ? ' rel="nofollow"' : '';
	$element->add_render_attribute( 'image_attr', 'href',esc_url($settings['link']['url']));
	if ( ! empty( $target ) ) {
		$element->add_render_attribute( 'image_attr', 'target', $target );
	}
	if ( ! empty( $nofollow ) ) {
		$element->add_render_attribute( 'image_attr', 'rel', $nofollow );
	}
}

$image_classes[] = 'card ube-image';
if ( ! empty( $settings['hover_animation'] ) ) {
	$image_classes[] = 'ube-image-hover-' . $settings['hover_animation'];
}
if ( ! empty( $settings['hover_overlay_animation'] ) ) {
	$image_classes[] = 'ube-image-hover-' . $settings['hover_overlay_animation'];
}
if ( ! empty( $settings['hover_animation_with_caption'] ) ) {
	$image_classes[] = 'ube-image-hover-' . $settings['hover_animation_with_caption'];
}
$image_classes[] = 'ube-image-caption-' . $settings['caption_position'];

$body_class = 'card-body';
if ( $settings['caption_position'] == 'in' ) {
	$body_class = 'card-img-overlay';
}

$element->add_render_attribute( 'body_attr', 'class', $body_class );

$image_wrapper_class[] = 'card-img';
$element->add_render_attribute( 'image_attr', 'class', $image_classes );
$element->add_render_attribute( 'wrapper_image_attr', 'class', $image_wrapper_class );
?>
<?php printf( '<%1$s %2$s>', $image_tag, $element->get_render_attribute_string( 'image_attr' ) ); ?>
    <div <?php echo $element->get_render_attribute_string( 'wrapper_image_attr' ) ?>>
	    <?php Group_Control_Image_Size::print_attachment_image_html($settings,'image_size','image'); ?>
    </div>
<?php
if ( ! empty( $settings['caption'] ) ):
	?>
    <div <?php echo $element->get_render_attribute_string( 'body_attr' ); ?>>
        <h5 class="card-title"><?php echo esc_html( $settings['caption'] ) ?></h5>
    </div>
<?php
endif;
printf( '</%1$s>', $image_tag );
?>