<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}

/**
 * @var $element UBE_Element_Lustria_Posts_Slider
 */

$atts = $element->get_settings_for_display();

$wrapper_classes = array(
	'ube__posts_slider',
	'gf-posts',
	'clearfix',
	$atts['cate_filter_align'],
);

$element->set_render_attribute('wrapper', array(
	'class' => $wrapper_classes
));

$post_image_size = isset($atts['image_size']) ? $atts['image_size'] : 'medium';
$post_image_width = isset($atts['post_image_width']) ? $atts['post_image_width'] : '400';
$post_layout = isset($atts['post_layout']) ? $atts['post_layout'] : 'grid';
$post_image_ratio_width = isset($atts['post_image_ratio_width']) ? $atts['post_image_ratio_width'] : '';
$post_image_ratio_height = isset($atts['post_image_ratio_height']) ? $atts['post_image_ratio_height'] : '';

$query_args = array();

$settings = array(
	'post_layout' => $post_layout,
	'image_size' => $post_image_size,
	'image_width' => array(
		'width' => $post_image_width
	),
	'image_ratio_custom' => array(
		'width' => $post_image_ratio_width,
		'height' => $post_image_ratio_height
	)
);
$atts['is_slider'] = true;
$element->prepare_display($atts,$query_args,$settings);
?>
<div <?php echo $element->get_render_attribute_string('wrapper') ?>>
	<?php if (function_exists('G5Plus_Lustria')) {
		G5Plus_Lustria()->blog()->archive_markup($element->_query_args, $element->_settings);
	} ?>
</div>