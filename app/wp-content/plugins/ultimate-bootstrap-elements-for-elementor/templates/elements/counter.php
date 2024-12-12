<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Group_Control_Image_Size;
use Elementor\Icons_Manager;

/**
 * @var $element UBE_Element_Counter
 */

$settings      = $element->get_settings_for_display();
$separator     = $settings['thousand_separator_char'];
$setting_array = array(
	'start'     => $settings['starting_number'],
	'end'       => $settings['ending_number'],
	'duration'  => $settings['duration'],
	'decimals'  => $settings['ending_decimals'],
	'decimal'  => $settings['data_decimal'],
	'separator' => $separator,
);

$counter_number_classes = array('ube-counter-number');
if (!empty($settings['counter_number_class'])) {
	$counter_number_classes[] = $settings['counter_number_class'];
}

$element->add_render_attribute( 'counter_options', 'data-counter-options', json_encode( $setting_array ) );
$element->add_render_attribute( 'counter_options', 'class', $counter_number_classes );
$counter_classes[] = 'ube-counter';
if ( ! empty( $settings['counter_icon'] ) || ! empty( $settings['counter_image']['url'] ) ) {
	$counter_classes[] = 'ube-counter-media-' . $settings['counter_icon_position'];
}

$counter_classes[] = 'ube-counter-number-' . $settings['counter_number_position'];

if ( ! empty( $settings['counter_scheme'] ) ) {
	$colors            = ube_color_schemes_configs();
	$text_color        = ube_color_contrast( $colors[ $settings['counter_scheme'] ]['color'], 'white', 'dark' );
	$counter_classes[] = 'bg-' . $settings['counter_scheme'] . ' text-' . $text_color;
}

$counter_title_classes = array('card-text');
if (!empty($settings['counter_title_class'])) {
	$counter_title_classes[] = $settings['counter_title_class'];
}

$element->add_render_attribute( 'counter_classes', 'class', $counter_classes );

$element->add_inline_editing_attributes( 'counter_title', 'basic' );
$element->add_render_attribute( 'counter_title', 'class', $counter_title_classes );

?>
<div <?php echo $element->get_render_attribute_string( 'counter_classes' ) ?>>
    <div class="card">
		<?php
		if ( ! empty( $settings['counter_icon'] ) ):
			$media_class = array( 'card-image' );
			if ( ! empty( $settings['counter_icon_view'] ) ) {
				$media_class[] = 'elementor-view-' . $settings['counter_icon_view'];
			}
			$media_class[] = 'elementor-shape-' . $settings['counter_icon_shape'];
			$element->add_render_attribute( 'counter_media', 'class', $media_class );
			?>
            <div <?php echo $element->get_render_attribute_string( 'counter_media' ) ?>>
                <span class="ube-counter-icon elementor-icon">
                    <?php
                    Icons_Manager::render_icon( $settings['counter_icon'] );
                    ?>
                </span>
            </div>
		<?php
		endif;
		?>
		<?php
		if ( ! empty( $settings['counter_image']['url'] ) ):
			?>
            <div class="card-image">
                <img src="<?php echo esc_url( $settings['counter_image']['url'] ) ?>"
                     alt="<?php esc_attr_e( 'Counter image', 'ube' ) ?>">
            </div>
		<?php
		endif;
		?>
        <div class="card-body">
            <div class="card-title">
				<?php
				if ( ! empty( $settings['counter_number_prefix'] ) ) {
					?>
                    <span class="ube-counter-icon-prefix"><?php echo esc_html( $settings['counter_number_prefix'] ) ?></span><?php
				}
				?>
                <span <?php echo $element->get_render_attribute_string( 'counter_options' ) ?>><?php
					echo esc_html( $settings['ending_number'] )
					?>
                </span>
				<?php
				if ( ! empty( $settings['counter_number_suffix'] ) ) {
					?>
                    <span class="ube-counter-icon-suffix"><?php echo esc_html( $settings['counter_number_suffix'] ) ?></span>
					<?php
				}
				?>
            </div>
			<?php if ( ! empty( $settings['counter_title'] ) ): ?>
                <div <?php echo $element->get_render_attribute_string( 'counter_title' ) ?>><?php
					echo esc_html( $settings['counter_title'] )
					?></div>
			<?php endif; ?>
        </div>
    </div>
</div>
