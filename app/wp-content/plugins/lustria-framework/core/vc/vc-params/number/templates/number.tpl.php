<?php
/**
 * The template for displaying number.tpl.php
 *
 * @var $settings
 * @var $value
 */
$field_classes = array(
	'wpb_vc_param_value',
	$settings['param_name'],
	"{$settings['type']}_field"
);
$field_class = implode(' ', array_filter($field_classes));
$min = isset($settings['args']['min']) ? $settings['args']['min'] : 0;
$max = isset($settings['args']['max']) ? $settings['args']['max'] : '';
$step = isset($settings['args']['step']) ? $settings['args']['step'] : 1;
?>
<div class="gsf-field-number-wrapper">
    <div class="gsf-field-number-inner">
        <input type="number" min="<?php echo esc_attr($min) ?>" max="<?php echo esc_attr($max) ?>"
               step="<?php echo esc_attr($step) ?>" name="<?php echo esc_attr($settings['param_name']) ?>"
               class="<?php echo esc_attr($field_class) ?>" value="<?php echo esc_attr($value) ?>">
    </div>
</div>
