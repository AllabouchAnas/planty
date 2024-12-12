<?php
/**
 * The template for displaying icon-picker.tmpl.php
 * @var $settings
 * @var $value
 */
$field_classes = array(
	'wpb_vc_param_value',
	$settings['param_name'],
	"{$settings['type']}_field"
);

$field_class = implode(' ', array_filter($field_classes));

?>
<div class="gsf-vc-icon-picker-wrapper">
	<input type="hidden" name="<?php echo esc_attr($settings['param_name']) ?>" class="<?php echo esc_attr($field_class) ?>" value="<?php echo esc_attr($value)?>">
	<div class="vc-icons-selector fip-vc-theme-grey" style="position: relative;">
		<div class="selector" style="width: auto;display: inline-block;">
			<span class="selected-icon"><i class="<?php echo esc_attr($value) ?>"></i></span>
			<span title="<?php esc_attr_e('Chose an icon', 'lustria-framework') ?>" class="selector-button gsf-add-icon"><i class="fas fa-upload"></i></span>
            <span style="display:<?php echo esc_attr($value === '' ? 'none' : 'inline-block')   ?>" title="<?php esc_attr_e('Remove an icon', 'lustria-framework') ?>" class="selector-button gsf-remove-icon"><i class="fa fa-times"></i></span>
		</div>
	</div>
</div>
