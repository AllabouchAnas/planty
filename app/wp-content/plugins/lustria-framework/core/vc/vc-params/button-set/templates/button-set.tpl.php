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
$values = preg_split('/\,/', $value);
$field_class = implode(' ', array_filter($field_classes));
$multiple = isset($settings['multiple']) ? $settings['multiple'] : false;
?>
<div class="gsf-field-button_set-wrapper">
	<input type="hidden" name="<?php echo esc_attr($settings['param_name']) ?>"
	       class="<?php echo esc_attr($field_class) ?>" value="<?php echo esc_attr($value) ?>">
	<?php if (!empty($settings['value'])) : ?>
		<div class="gsf-field-button_set-inner">
			<?php foreach ($settings['value'] as $index => $data) : ?>
				<?php
				if (is_numeric($index) && (is_string($data) || is_numeric($data))) {
					$option_label = $data;
					$option_value = $data;
				} elseif (is_numeric($index) && is_array($data)) {
					$option_label = isset($data['label']) ? $data['label'] : array_pop($data);
					$option_value = isset($data['value']) ? $data['value'] : array_pop($data);
				} else {
					$option_value = $data;
					$option_label = $index;
				}
				?>
				<label>
					<?php if ($multiple): ?>
						<input class="gsf-field-button_set-field" type="checkbox"
						       name="gsf-field-button_set-<?php echo esc_attr($settings['param_name']) ?>"
						       value="<?php echo esc_attr($option_value) ?>" <?php echo in_array($option_value, $values) ? ' checked="true"' : '' ?>>
					<?php else: ?>
						<input class="gsf-field-button_set-field" type="radio"
						       name="gsf-field-button_set-<?php echo esc_attr($settings['param_name']) ?>"
						       value="<?php echo esc_attr($option_value) ?>" <?php echo in_array($option_value, $values) ? ' checked="true"' : '' ?>>
					<?php endif; ?>
					<span><?php echo esc_html($option_label); ?></span>
				</label>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>
