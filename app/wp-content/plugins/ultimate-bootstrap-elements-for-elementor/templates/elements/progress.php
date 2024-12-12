<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @var $element UBE_Element_Progress
 */


$settings = $element->get_settings_for_display();


$element->add_render_attribute( 'progress_wrapper', 'class', 'progress' );

$progress_ube_classes = array(
	'ube-progress',
	'ube-progress-style-' . $settings['progress_style'],
);

if ( $settings['progress_bar_indicator'] == 'yes' ) {
	$progress_ube_classes[] = 'ube-progress-indicator';
}

$element->add_render_attribute( 'progress_ube_classes', 'class', $progress_ube_classes );


?>
<div <?php echo $element->get_render_attribute_string( 'progress_ube_classes' ); ?>>
	<?php foreach ( $settings['progress_bar_multiple'] as $index => $item ) : ?>
		<?php
		$progress_items_classes = $element->get_repeater_setting_key( 'progress_item', 'progress_bar_multiple', $index );

		$progress_classes = array(
			'progress-bar'
		);
		if ( ! empty( $settings['progress_type'] )) {
			$progress_classes[] = $settings['progress_type'];
		}

		if ( $settings['progress_mode_animated'] == 'yes' ) {
			$progress_classes[] = 'progress-bar-animated';
		}
		if ( ! empty( $settings['progress_bg_color_scheme'] ) ) {
			$progress_classes[] = 'bg-' . $settings['progress_bg_color_scheme'];
		}

		if ( $item['progress_lable_switcher'] === 'yes' ) {
			$progress_classes[] = 'elementor-repeater-item-' . $item['_id'];
		}
		$progressbar_settings = [
			'progress_value' => $item['progress_multiple_bar_value'],
			'speed'          => $item['progressbar_speed'],
		];
		$element->add_render_attribute( $progress_items_classes, array(
			'class'         => $progress_classes,
			'role'          => 'progressbar',
			'aria-valuemin' => 0,
			'aria-valuemax' => 100,
			'aria-valuenow' => $item['progress_multiple_bar_value'],
			'data-settings' => wp_json_encode( $progressbar_settings ),
		) );

		?>
        <div class="ube-progress-content">
			<?php if ( ! empty( $item['progress_label'] ) && $settings['progress_style'] == '01' || $settings['progress_style'] == '04' ) : ?>
                <span class="ube-progress-label"><?php echo esc_html( $item['progress_label'] ); ?></span>
			<?php endif; ?>
            <div <?php echo $element->get_render_attribute_string( 'progress_wrapper' ); ?>>
                <div <?php echo $element->get_render_attribute_string( $progress_items_classes ); ?>>
					<?php if ( ! empty( $item['progress_label'] ) || ! empty( $item['progress_multiple_bar_value'] ) ) : ?>
							<?php if ( ! empty( $item['progress_label'] ) && $settings['progress_style'] == '02' ) : ?>
                                <span class="ube-progress-label"><?php echo esc_html( $item['progress_label'] ); ?></span>
							<?php endif; ?>
							<?php if ( ! empty( $item['progress_multiple_bar_value'] ) && $settings['progress_display_value'] == "yes" ) : ?>
                                <span class="ube-progress-value"><?php echo esc_html( $item['progress_multiple_bar_value'] ) . '%'; ?></span>
							<?php endif; ?>
					<?php endif; ?>
                </div>
            </div>
			<?php if ( ! empty( $item['progress_label'] ) && $settings['progress_style'] == '03' ) : ?>
                <span class="ube-progress-label"><?php echo esc_html( $item['progress_label'] ); ?></span>
			<?php endif; ?>
        </div>
	<?php endforeach; ?>
</div>


