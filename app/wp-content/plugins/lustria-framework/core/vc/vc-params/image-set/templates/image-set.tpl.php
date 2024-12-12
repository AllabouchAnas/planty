<?php
/**
 * The template for displaying image-set.tpl.php
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
?>
<div class="gsf-vc-image-set-wrapper">
	<input type="hidden" name="<?php echo esc_attr($settings['param_name']) ?>"
	       class="<?php echo esc_attr($field_class) ?>" value="<?php echo esc_attr($value) ?>">
	<?php if (!empty($settings['value'])) : ?>
		<div class="gsf-vc-image-set-inner">
			<?php foreach ($settings['value'] as $k => $v) : ?>
				<div class="gsf-vc-image-set-item<?php echo ($value == $k) ? ' current': '' ?>" data-value="<?php echo esc_attr($k); ?>">
					<img class="" src="<?php echo esc_url( $v['img'] ); ?>" alt="<?php echo esc_html($v['label']); ?>">
					<p><?php echo esc_html($v['label']); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>
