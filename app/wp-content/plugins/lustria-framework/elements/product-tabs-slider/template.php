<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

/**
 * @var $element UBE_Element_Lustria_Product_Tabs_Slider
 */

$atts = $element->get_settings();
$wrapper_classes = array(
	'woocommerce',
	'gsf-product_tabs',
	'ube-product-tabs-slider',
	$atts['tabs_align'],
);
$element->set_render_attribute('wrapper', array(
	'class' => $wrapper_classes
));

$show = isset($atts['show']) ? $atts['show'] : '';
$post_layout = isset($atts['post_layout']) ? $atts['post_layout'] : 'grid';
$settings = array(
	'post_layout' => $post_layout,
);

$atts['is_slider'] = true;
$element->prepare_display($atts,array(),$settings);

?>
<div <?php $element->print_render_attribute_string('wrapper') ?>>
	<?php if (function_exists('G5Plus_Lustria')) {G5Plus_Lustria()->woocommerce()->archive_markup($element->_query_args, $element->_settings);}  ?>
</div>

