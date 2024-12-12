<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use \Elementor\Icons_Manager;
use \Elementor\Plugin;

/**
 * @var $element UBE_Element_Offcanvas
 */

$settings = $element->get_settings_for_display();

if ( ! empty( $settings['button_icon'] ) ) {
	$align_icon = 'align-icon-' . $settings['button_icon_pos'];
}
$offcanvas_classes = array(
	'ube-offcanvas',
	$align_icon,
);

$element->add_render_attribute( 'offcanvas_warpper', 'class', $offcanvas_classes );

$element->add_render_attribute( 'offcanvas', array(
	'class' => array(
		'offcanvas-menu',
		'align-' . $settings['offcanvas_position'] . '-active'
	),
	'id'    => 'offcanvas-' . $element->get_id()
) );

?>
<div <?php echo $element->get_render_attribute_string( 'offcanvas_warpper' ) ?>>
    <button class="btn-canvas">
		<?php if ( ! empty( $settings['button_icon'] ) && $settings['button_icon_pos'] === 'left' ) : ?>
            <span class="ube-icon"><?php Icons_Manager::render_icon( $settings['button_icon'] ); ?></span>
		<?php endif; ?>
		<?php echo $settings['button_text'] ?>
		<?php if ( ! empty( $settings['button_icon'] ) && $settings['button_icon_pos'] === 'right' ) : ?>
            <span class="ube-icon"><?php Icons_Manager::render_icon( $settings['button_icon'] ); ?></span>
		<?php endif; ?>
    </button>
    <div <?php echo $element->get_render_attribute_string( 'offcanvas' ) ?>>
        <a href="#offcanvas-<?php echo esc_attr( $element->get_id() ) ?>" class="canvas-closebtn"><i
                    class="fa fa-times"></i></a>
		<?php
		if ( $settings['content_source'] == 'sidebar' && ! empty( $settings['sidebars_id'] ) ) {
			dynamic_sidebar( $settings['sidebars_id'] );
		} elseif ( $settings['content_source'] == 'elementor' && ! empty( $settings['template_id'] ) ) {
			echo ube_get_builder_content_for_display( $settings['template_id'] );
		}
		?>
    </div>
</div>
