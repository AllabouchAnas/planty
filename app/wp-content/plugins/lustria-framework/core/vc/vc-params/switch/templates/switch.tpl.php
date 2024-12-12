<?php
/**
 * The template for displaying button-set.tpl.php
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
$on_text = isset($settings['on_text']) ? $settings['on_text'] : esc_html__('On','lustria-framework');
$off_text = isset($settings['off_text']) ? $settings['off_text'] : esc_html__('Off','lustria-framework');
$value_inline = isset($settings['value_inline']) ? $settings['value_inline'] : true;

?>
<div class="gsf-vc-switch-wrapper">
	<div class="gsf-field-switch-inner <?php echo esc_attr($value_inline ? 'value-inline' : ''); ?>">
		<label>
			<input class="<?php echo esc_attr($field_class) ?>" type="checkbox" <?php GSF()->helper()->theChecked('on', $value) ?>
			       name="<?php echo esc_attr($settings['param_name']) ?>"
               value="<?php echo esc_attr($value); ?>"/>
			<div class="gsf-field-switch-button" data-switch-on="<?php echo esc_attr($on_text); ?>" data-switch-off="<?php echo esc_attr($off_text); ?>">
				<span class="gsf-field-switch-off"><?php echo esc_html($off_text); ?></span>
				<span class="gsf-field-switch-on"><?php echo esc_html($on_text); ?></span>
			</div>
		</label>
	</div>
</div>
