<?php
/**
 * @var $element
 * @var $settings
 */

use Elementor\Icons_Manager;
use Elementor\Group_Control_Image_Size;

?>
<div class="ube-pricing-header">
	<?php if (!empty($settings['pricing_table_icon']) && !empty($settings['pricing_table_icon']['value']) && $settings['pricing_table_icon_type'] == 'icon'): ?>
        <div class="ube-pricing-icon">
                     <span class="ube-icon">
                         <?php Icons_Manager::render_icon($settings['pricing_table_icon'], ['aria-hidden' => 'true']); ?>
                     </span>
        </div>
	<?php endif; ?>
	<?php if (isset($settings['pricing_table_image']) && $settings['pricing_table_icon_type'] == 'image'): ?>
		<?php if ($settings['pricing_table_image']['url'] !== ''): ?>
            <div class="ube-pricing-image">
				<?php echo Group_Control_Image_Size::get_attachment_image_html($settings, 'pricing_table_image_size', 'pricing_table_image'); ?>
            </div>
		<?php endif; ?>
	<?php endif; ?>
	<?php
	if ($settings['pricing_table_title'] !== ''): ?>
        <h2 class="ube-pricing-title">
			<?php echo esc_html($settings['pricing_table_title']); ?>
        </h2>
	<?php endif; ?>
	<?php if ($settings['pricing_table_sub_title'] !== ''): ?>
        <span class="ube-pricing-subtitle"><?php echo esc_html($settings['pricing_table_sub_title']); ?></span>
	<?php endif; ?>
</div>
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
<div class="ube-pricing-body">
	<?php $element->render_feature_list($settings); ?>
</div>
<div class="ube-pricing-footer">
	<?php if ($settings['pricing_table_button_show'] === 'yes'): ?>
		<?php $element->render_btn($settings, $element->get_render_attribute_string('table_btn_attr')); ?>
	<?php endif; ?>
</div>
