<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use \Elementor\Icons_Manager;

/**
 * @var $element UBE_Element_Button_Group
 */

$settings = $element->get_settings_for_display();

$button_group_classes = array(
	'ube-button-group',
    'flex-wrap'
);
if ( $settings['button_group_style'] ) {
	$button_group_classes[] = $settings['button_group_style'];
}

if ( $settings['button_group_icon_position'] === 'before' ) {
	$button_group_classes[] = 'icon-before';
} else {
	$button_group_classes[] = 'icon-after';
}

$element->add_render_attribute( 'button_group_classes', 'class', $button_group_classes );
$element->add_render_attribute( 'button_group_classes', 'role', 'group' );

$button_classes = array(
	'btn',
	$settings['button_group_size'],
);

if ( $settings['button_group_color_scheme'] !== '' && ! is_null( $settings['button_group_color_scheme'] ) ) {
	$button_classes[] = 'btn-' . $settings['button_group_color_scheme'];
}
if ( $settings['button_group_outline_color_scheme'] !== '' && ! is_null( $settings['button_group_outline_color_scheme'] ) ) {
	$button_classes[] = 'btn-outline-' . $settings['button_group_outline_color_scheme'];
}
if ( $settings['button_group_hover_animation'] ) {
	$button_classes[] = 'elementor-animation-' . $settings['button_group_hover_animation'];
}


?>
<div <?php echo $element->get_render_attribute_string( 'button_group_classes' ) ?>>
	<?php if ( $settings['button_group_items'] && count( $settings['button_group_items'] ) > 0 ) {
		foreach ( $settings['button_group_items'] as $key => $item ) {
			$item_link_key = $element->get_repeater_setting_key( 'item_link', 'button_group_items', $key );
			$element->add_render_attribute( $item_link_key, 'class', $button_classes );
			if ( $item['button_group_link']['url'] === '' ) {
				$item['button_group_link']['url'] = '#';
			}
			if ( ! empty( $item['button_group_link']['url'] ) ) {
				$element->add_link_attributes( $item_link_key, $item['button_group_link'] );
			}
			?>
            <a <?php echo $element->get_render_attribute_string( $item_link_key ); ?>>
				<?php if ( $settings['button_group_icon_position'] === 'before' ) {
					if ( isset( $item['button_group_icon'] ) ) {
						Icons_Manager::render_icon( $item['button_group_icon'] );
					}
					if ( isset( $item['button_group_text'] ) ) {
						echo esc_html( $item['button_group_text'] );
					}

				} else {
					if ( isset( $item['button_group_text'] ) ) {
						echo esc_html( $item['button_group_text'] );
					}
					if ( isset( $item['button_group_icon'] ) ) {
						Icons_Manager::render_icon( $item['button_group_icon'] );
					}
				} ?>

            </a>
			<?php

		}
	}
	?>
</div>



