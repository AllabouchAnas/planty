<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @var $element UBE_Element_Pricing_Table
 */

use Elementor\Icons_Manager;
use Elementor\Group_Control_Image_Size;

$settings = $element->get_settings_for_display();

$pricing_classes = array(
	'ube-pricing',
	'ube-pricing-' . $settings['pricing_table_style'],
);

$inner_class = array( 'ube-pricing-inner' );

if ( $settings['pricing_table_featured_styles'] === 'ribbon-4' && $settings['enable_pricing_table_featured'] === 'yes' ) {
	$inner_class[] = 'overflow-hidden';
}

$element->add_render_attribute( 'pricing_attr', 'class', $pricing_classes );

if ( ! empty( $settings['pricing_table_btn_link']['url'] ) ) {
	$element->add_link_attributes( 'table_btn_attr', $settings['pricing_table_btn_link'] );
}
$btn_class = array(
	'btn',
	"btn-{$settings['btn_size']}",
	"btn-{$settings['btn_shape']}",
	'ube-pricing-button'
);

if ( $settings['btn_type'] !== '' ) {
	$btn_class[] = "btn-{$settings['btn_type']}";
}

if ( $settings['btn_type'] === '' || $settings['btn_type'] === '3d' ) {
	$btn_class[] = "btn-{$settings['btn_scheme']}";
}

if ( $settings['btn_type'] === 'outline' ) {
	$btn_class[] = "btn-outline-{$settings['btn_scheme']}";
	$btn_class[] = "btn-{$settings['btn_scheme']}";
}

if ( $settings['pricing_table_button_icon_alignment'] !== '' ) {
	$btn_class[] = "icon-{$settings['pricing_table_button_icon_alignment']}";
}

$element->add_render_attribute( 'table_btn_attr', 'class', $btn_class );

if ( $settings['pricing_table_icon_bg_show'] !== 'yes' ) {
	$inner_class[] = "ube-pricing-bg-icon-none";
}

if ( $settings['enable_pricing_table_featured'] == 'yes' ) {
	$inner_class[] = 'ube-pricing-featured';
	$inner_class[] = 'ube-pricing-' . $settings['pricing_table_featured_styles'];
}

$element->add_render_attribute( 'inner_attr', 'class', $inner_class );
$style_allow = array_keys(ube_get_pricing_table_style());
$style = isset( $settings['pricing_table_style'] ) ? $settings['pricing_table_style'] : 'style-1';
if (!in_array($style, $style_allow)) {
    $style = 'style-1';
}
?>
<div <?php echo $element->get_render_attribute_string( 'pricing_attr' ) ?>>
    <div <?php echo $element->get_render_attribute_string( 'inner_attr' ) ?>>
		<?php ube_get_template( "elements/pricing-table/{$style}.php", array(
			'element'  => $element,
			'settings' => $settings,
		) ); ?>
    </div>
</div>
