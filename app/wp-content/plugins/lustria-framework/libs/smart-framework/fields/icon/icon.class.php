<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
if (!class_exists('GSF_Field_Icon')) {
	class GSF_Field_Icon extends GSF_Field
	{
		function enqueue() {
			GSF()->core()->iconPopup()->enqueue();
			wp_enqueue_script(GSF()->assetsHandle('field_icon'), GSF()->helper()->getAssetUrl('fields/icon/assets/icon.min.js'), array(), GSF()->pluginVer(), true);
			wp_enqueue_style(GSF()->assetsHandle('field_icon'), GSF()->helper()->getAssetUrl('fields/icon/assets/icon.min.css'), array(), GSF()->pluginVer());
		}
		function renderContent()
		{
			$field_value = $this->getFieldValue();
			?>
			<div class="gsf-field-icon-inner">
				<input data-field-control="" type="hidden"
				       name="<?php $this->theInputName(); ?>"
				       value="<?php echo esc_attr($field_value); ?>"/>
				<div class="gsf-field-icon-item"
				     data-icon-title="<?php esc_attr_e('Select icon','lustria-framework'); ?>"
				     data-icon-remove="<?php esc_attr_e('Remove icon','lustria-framework'); ?>"
				     data-icon-search="<?php esc_attr_e('Search icon...','lustria-framework'); ?>">
					<div class="gsf-field-icon-item-info">
						<span class="<?php echo esc_attr($field_value); ?>"></span>
						<div class="gsf-field-icon-item-label"><?php esc_html_e('Set Icon','lustria-framework'); ?></div>
					</div>
				</div>
			</div>
		<?php
		}
	}
}