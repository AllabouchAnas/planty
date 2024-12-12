<?php
/**
 * The template for displaying slider.tpl.php
 *
 * @var $settings
 * @var $value
 */
$field_classes = array(
	'wpb_vc_param_value wpb-input',
	$settings['param_name'],
	"{$settings['type']}_field"
);
$field_class = implode(' ', array_filter($field_classes));

$opt_default = array(
	'min' => 0,
	'max' => 100,
	'step' => 1
);

$option = isset($settings['js_options']) ? $settings['js_options'] : array();
$option = wp_parse_args($option, $opt_default);

?>
<div class="gsf-vc-slider-wrapper clearfix">
	<div class="gsf-vc-slider-place" data-options='<?php echo json_encode($option); ?>'></div>
	<input class="<?php echo esc_attr($field_class) ?>" type="text" pattern="(-)?[0-9]*" name="<?php echo esc_attr($settings['param_name']) ?>" id="<?php echo esc_attr($settings['param_name']) ?>" value="<?php echo esc_attr($value); ?>"/>
</div>
