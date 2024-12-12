<?php
/**
 * @var $element
 * @var $settings
 */

?>
<div class="ube-pricing-bg">
	<div class="ube-pricing-tag">
		<span class="ube-pricing-price-tag"><?php $element->render_pricing($settings); ?></span>
		<span class="ube-pricing-price-period">
                        <?php if ($settings['pricing_table_period_separator'] !== ''): ?>
	                        <?php echo esc_html($settings['pricing_table_period_separator']); ?>
                        <?php endif; ?>
                        <?php if ($settings['pricing_table_price_period'] !== ''): ?>
	                        <?php echo esc_html($settings['pricing_table_price_period']); ?>
                        <?php endif; ?>
                    </span>
	</div>
</div>
<div class="ube-pricing-header">
	<?php if ($settings['pricing_table_title'] !== ''): ?>
		<h2 class="ube-pricing-title"><?php echo esc_html($settings['pricing_table_title']); ?></h2>
	<?php endif; ?>
	<?php if ($settings['pricing_table_sub_title'] !== ''): ?>
		<span class="ube-pricing-subtitle"><?php echo esc_html($settings['pricing_table_sub_title']); ?></span>
	<?php endif; ?>
</div>
<div class="ube-pricing-body">
	<?php $element->render_feature_list($settings); ?>
</div>
<div class="ube-pricing-footer">
	<?php if ($settings['pricing_table_button_show'] === 'yes'): ?>
		<?php $element->render_btn($settings, $element->get_render_attribute_string('table_btn_attr')); ?>
	<?php endif; ?>
</div>