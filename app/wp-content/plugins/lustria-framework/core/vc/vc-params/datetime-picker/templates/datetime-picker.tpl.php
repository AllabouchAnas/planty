<?php
/**
 * The template for displaying icon-picker.tmpl.php
 * @var $settings
 * @var $value
 */
$field_classes = array(
	'wpb-textinput',
	'wpb_vc_param_value',
	'datetimepicker',
	$settings['param_name'],
	"{$settings['type']}_field"
);

$field_class = implode(' ', array_filter($field_classes));

?>
<div class="gsf-vc-datetime-picker-wrapper">
	<input type="text" name="<?php echo esc_attr($settings['param_name']) ?>" class="<?php echo esc_attr($field_class) ?>" value="<?php echo esc_attr($value)?>">
</div>

