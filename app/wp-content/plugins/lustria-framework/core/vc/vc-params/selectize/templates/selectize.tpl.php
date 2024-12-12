<?php
/**
 * The template for displaying selectize.tpl.php
 *
 * @var $settings
 * @var $value
 */
$field_classes = array(
	'wpb_vc_param_value wpb-input wpb-select',
	$settings['param_name'],
	"{$settings['type']}_field"
);
$field_class = implode(' ', array_filter($field_classes));
$multiple = isset($settings['multiple']) ? $settings['multiple'] : false;
$tags = isset($settings['tags']) ? $settings['tags'] : false;
$attributes = array(
	'data-selectize="true"'
);

if (($multiple === true) || (($tags === true) && !empty($settings['value']) )) {
	$attributes[] = 'multiple="multiple"';
	if (!is_array($value)) {
		$value = preg_split('/\,/', $value);
	}
}

if ($tags === true) {
	$attributes[] = 'data-tags="true"';
}

if ((($multiple === true) || ($tags === true)) && !empty($settings['value'])) {
	$attributes[] = "data-value='". (is_array($value) ? json_encode($value) : $value)  ."'";
}

$attributes = implode(' ', array_filter($attributes));

$options = array();
if (!empty($settings['value'])) {
	$options = $settings['value'];
}

if (is_array($value) && ($tags === true)) {
	$options = array_merge($options,$value);
}
?>
<div class="gsf-vc-selectize-wrapper">
	<?php if (($tags === true) && empty($settings['value'])): ?>
		<input class="<?php echo esc_attr($field_class) ?>" <?php echo ($attributes); ?> value="<?php echo esc_attr($value); ?>" type="text" name="<?php echo esc_attr($settings['param_name']) ?>" id="<?php echo esc_attr($settings['param_name']) ?>">
	<?php else: ?>
		<select class="<?php echo esc_attr($field_class) ?>" <?php echo ($attributes); ?> name="<?php echo esc_attr($settings['param_name']) ?>" id="<?php echo esc_attr($settings['param_name']) ?>">
			<?php foreach ($options as $index => $data): ?>
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
				$selected = '';
				if (!is_array($value)) {
					$option_value_string = (string) $option_value;
					$value_string = (string) $value;
					if ( '' !== $value && $option_value_string === $value_string ) {
						$selected = ' selected="selected"';
					}
				}
				?>
				<option value="<?php echo esc_attr($option_value) ?>" <?php echo ($selected) ?>><?php echo esc_html($option_label) ?></option>
			<?php endforeach; ?>
		</select>
	<?php endif; ?>
</div>
