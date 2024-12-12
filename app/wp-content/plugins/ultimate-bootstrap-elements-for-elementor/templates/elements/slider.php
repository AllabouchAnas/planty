<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Plugin;

/**
 * @var $element Elementor\Widget_Base
 * @var $slider_background_animation
 * @var $slider_setting_key
 * @var $slider_dots_type
 * @var $slider_setting_key_content
 * @var $slider_content_layout
 *
 *
 */


$element->add_render_attribute( $slider_setting_key_content, 'class', 'ube-slider-content' );
if ( ! empty( $slider_content_animation ) ) {
	$element->add_render_attribute( $slider_setting_key_content, 'data-animation', $slider_content_animation );
}

if ( $slider_dots_type == 'thumbnails' ) {
	$data_thumb = '';
	if ( ! empty( $slider_background_image['url'] ) ) {
		$image_url  = $slider_background_image['url'];
		$data_thumb = "background-image:url('" . $image_url . "');";
	} elseif ( ! empty( $slider_background_color ) ) {
		$data_thumb = 'background:' . $slider_background_color . ';';
	}
	$element->add_render_attribute( $slider_setting_key, 'data-thumb', $data_thumb );
}

$box_classes   = array();
$box_classes[] = 'ube-slider-box';
if ( $slider_background_animation !== '' ) {
	$box_classes[] = 'ube-slide-background-' . $slider_background_animation;
}
$element->add_render_attribute( $slider_setting_key, 'class', $box_classes );

?>
<div <?php echo $element->get_render_attribute_string( $slider_setting_key ); ?>>
    <div class="ube-slider-background-wrapper">
        <div class="ube-slide-bg">
        </div>
    </div>
	<?php
	if ( $slider_content_layout == 'container' ): ?>
    <div class="container">
		<?php
		endif;
		?>
        <div <?php echo $element->get_render_attribute_string( $slider_setting_key_content ) ?>>
			<?php
			if ( ! empty( $slider_content_template ) ) {

				echo ube_get_builder_content_for_display( $slider_content_template );
			}
			?>
        </div>
		<?php
		if ( $slider_content_layout == 'container' ): ?>
    </div>
<?php
endif; ?>
</div>

