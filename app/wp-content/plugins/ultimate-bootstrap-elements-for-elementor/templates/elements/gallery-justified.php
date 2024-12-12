<?php

use Elementor\Group_Control_Image_Size;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @var $element UBE_Element_Gallery_Justified
 */


$settings = $element->get_settings_for_display();

$wrapper_classes[] = 'ube-gallery ube-gallery-justified';
$wrapper_classes[] = 'ube-gallery-caption-' . $settings['show_caption'];
$element->add_render_attribute( 'wrapper_attr', 'class', $wrapper_classes );

$image_classes[] = 'card ube-image';
if ( ! empty( $settings['hover_animation'] ) ) {
	$image_classes[] = 'ube-image-hover-' . $settings['hover_animation'];
}
if ( ! empty( $settings['hover_image_animation'] ) ) {
	$image_classes[] = 'ube-image-hover-' . $settings['hover_image_animation'];
}
$image_wrapper_class[] = 'card-img';
$element->add_render_attribute( 'image_attr', 'class', $image_classes );

$justified_settings = array();
if ( ! empty( $settings['row_height']['size'] ) ) {
	$justified_settings['rowHeight'] = $settings['row_height']['size'];
}
if ( ! empty( $settings['image_margin']['size'] ) ) {
	$justified_settings['margins'] = $settings['image_margin']['size'];
}
if ( ! empty( $settings['max_row'] ) ) {
	$justified_settings['maxRowsCount'] = $settings['max_row'];
}
if ( ! empty( $settings['last_row'] ) ) {
	$justified_settings['lastRow'] = $settings['last_row'];
}

$image_settings = array('image_size' =>  $settings['image_size_size'],'image_custom_dimension' =>  $settings['image_size_custom_dimension']);


$element->add_render_attribute( 'wrapper_attr', 'data-justified-settings', wp_json_encode( $justified_settings ) );


$element->add_render_attribute( 'wrapper_image_attr', 'class', $image_wrapper_class );
$element->add_render_attribute( 'caption_attr', array(
	'class' => 'card-text ube-gallery-caption'
) );
if ( ! is_null( $settings['hover_caption_animation'] ) && $settings['hover_caption_animation'] !== '' ) {
	$element->add_render_attribute( 'caption_attr', array(
		'data-animation' => $settings['hover_caption_animation']
	) );
}
?>
<div <?php echo $element->get_render_attribute_string( 'wrapper_attr' ) ?>>
    <div class="ube-gallery-justified-items">
		<?php foreach ( $settings['gallery'] as $i => $item ):
			$column_classes = array();
			$column_classes[] = 'ube-gallery-item';
			$image_url         = Elementor\Group_Control_Image_Size::get_attachment_image_src( $item['id'], 'image_size', $settings );
			$image_meta        = ube_get_img_meta( $item['id'] );
			$caption           = $image_meta['caption'];
			$item_setting_key  = $element->get_repeater_setting_key( 'gallery_item', 'gallery', $i );
			$image_setting_key = $element->get_repeater_setting_key( 'image_attr', 'gallery', $i );

			$element->add_render_attribute( $item_setting_key, 'class', $column_classes );

			$image_settings['image'] = $item;


			$element->add_render_attribute( $image_setting_key, array(
				'href'                              => esc_url($item['url']),
				'class'                             => $image_classes,
				'data-elementor-lightbox-slideshow' => $element->get_id(),
			) );
			?>
            <div <?php echo $element->get_render_attribute_string( $item_setting_key ) ?>>
                <a <?php echo $element->get_render_attribute_string( $image_setting_key ) ?>>
                    <div <?php echo $element->get_render_attribute_string( 'wrapper_image_attr' ) ?>>
						<?php Group_Control_Image_Size::print_attachment_image_html($image_settings); ?>
                    </div>
					<?php
					if ( ! empty( $caption ) && $settings['show_caption'] != 'none' ):
						?>
                        <div class="card-img-overlay">
                            <p <?php echo $element->get_render_attribute_string( 'caption_attr' ) ?>><?php echo esc_html( $caption ) ?></p>
                        </div>
					<?php
					endif;
					?>
                </a>
            </div>
		<?php endforeach; ?>
    </div>
</div>
