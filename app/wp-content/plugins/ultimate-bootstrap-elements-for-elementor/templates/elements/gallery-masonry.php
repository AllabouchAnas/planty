<?php

use Elementor\Group_Control_Image_Size;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @var $element UBE_Element_Gallery_Masonry
 */

$settings = $element->get_settings_for_display();

$wrapper_classes[] = 'ube-gallery ube-gallery-masonry';
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


$element->add_render_attribute( 'wrapper_image_attr', 'class', $image_wrapper_class );

$element->add_render_attribute( 'caption_attr', array(
	'class' => 'card-text ube-gallery-caption'
) );
if ( ! is_null( $settings['hover_caption_animation'] ) && $settings['hover_caption_animation'] !== '' ) {
	$element->add_render_attribute( 'caption_attr', array(
		'data-animation' => $settings['hover_caption_animation'],
	) );
}

$image_settings = array('image_size' =>  $settings['image_size_size'],'image_custom_dimension' =>  $settings['image_size_custom_dimension']);
?>
<div <?php echo $element->get_render_attribute_string( 'wrapper_attr' ) ?>>
    <div class="row ube-masonry-grid">
		<?php foreach ( $settings['gallery'] as $i => $item ):
			$column_classes = array();
			$column_classes[] = 'ube-gallery-item';
			if ( ! empty( $settings['number_column_mobile'] ) ) {
				if ( $settings['number_column_mobile'] != '5' ) {
					$grid_mb          = 12 / intval( $settings['number_column_mobile'] );
					$column_classes[] = 'col-' . $grid_mb;
				} elseif ( $settings['number_column_mobile'] == '5' ) {
					$column_classes[] = 'ube-col-custom-5';
				}
			}else{
				$column_classes[]='col-auto';
            }
			if ( ! empty( $settings['number_column_tablet'] ) ) {
				if ( $settings['number_column_tablet'] != '5' ) {
					$grid_tb          = 12 / intval( $settings['number_column_tablet'] );
					$column_classes[] = 'col-md-' . $grid_tb;
				} elseif ( $settings['number_column_tablet'] == '5' ) {
					$column_classes[] = 'ube-col-md-custom-5';
				}
			}else{
				$column_classes[]='col-md-auto';
			}

			if ( ! empty( $settings['number_column'] ) ) {
				if ( $settings['number_column'] != '5' ) {
					$grid             = 12 / intval( $settings['number_column'] );
					$column_classes[] = 'col-lg-' . $grid;
				} elseif ( $settings['number_column'] == '5' ) {
					$column_classes[] = 'ube-col-lg-custom-5';
				}
			}else{
				$column_classes[]='col-lg-auto';
			}

			$image_settings['image'] = $item;
			$item_setting_key = $element->get_repeater_setting_key( 'gallery_item', 'gallery', $i );
			$element->add_render_attribute( $item_setting_key, 'class', $column_classes );
			$image_meta        = ube_get_img_meta( $item['id'] );
			$caption           = $image_meta['caption'];
			$image_setting_key = $element->get_repeater_setting_key( 'image_attr', 'gallery', $i );
			$element->add_render_attribute( $image_setting_key, array(
				'href'                              => $item['url'],
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
