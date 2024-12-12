<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
if (!class_exists('GSF_Field_Spacing')) {
	class GSF_Field_Spacing extends GSF_Field
	{
		function enqueue() {
			wp_enqueue_script(GSF()->assetsHandle('field_spacing'), GSF()->helper()->getAssetUrl('fields/spacing/assets/spacing.min.js'), array(), GSF()->pluginVer(), true);
			wp_enqueue_style(GSF()->assetsHandle('field_spacing'), GSF()->helper()->getAssetUrl('fields/spacing/assets/spacing.min.css'), array(), GSF()->pluginVer());
		}

		function renderContent()
		{
			$field_value = $this->getFieldValue();
			$default = $this->getDefault();
			if (!is_array($field_value)) {
				$field_value = array();
			}
			$field_value = wp_parse_args($field_value, $default);

			$is_left = isset($this->_setting['left']) ? $this->_setting['left'] : true;
			$is_right = isset($this->_setting['right']) ? $this->_setting['right'] : true;
			$is_top = isset($this->_setting['top']) ? $this->_setting['top'] : true;
			$is_bottom = isset($this->_setting['bottom']) ? $this->_setting['bottom'] : true;
			?>
			<div class="gsf-field-spacing-inner">
				<?php if ($is_left): ?>
					<div class="gsf-spacing-item">
						<div class="dashicons dashicons-arrow-left-alt"></div>
						<input data-field-control="" class="gsf-spacing" type="number" placeholder="<?php esc_attr_e('Left','lustria-framework'); ?>"
						       name="<?php $this->theInputName(); ?>[left]" value="<?php echo esc_attr($field_value['left']); ?>"/>
					</div>
				<?php endif;?>
				<?php if ($is_right): ?>
					<div class="gsf-spacing-item">
						<div class="dashicons dashicons-arrow-right-alt"></div>
						<input data-field-control="" class="gsf-spacing" type="number" placeholder="<?php esc_attr_e('Right','lustria-framework'); ?>"
						       name="<?php $this->theInputName(); ?>[right]" value="<?php echo esc_attr($field_value['right']); ?>"/>
					</div>
				<?php endif;?>
				<?php if ($is_top): ?>
					<div class="gsf-spacing-item">
						<div class="dashicons dashicons-arrow-up-alt"></div>
						<input data-field-control="" class="gsf-spacing" type="number" placeholder="<?php esc_attr_e('Top','lustria-framework'); ?>"
						       name="<?php $this->theInputName(); ?>[top]" value="<?php echo esc_attr($field_value['top']); ?>"/>
					</div>
				<?php endif;?>
				<?php if ($is_bottom): ?>
					<div class="gsf-spacing-item">
						<div class="dashicons dashicons-arrow-down-alt"></div>
						<input data-field-control="" class="gsf-spacing" type="number" placeholder="<?php esc_attr_e('Bottom','lustria-framework'); ?>"
						       name="<?php $this->theInputName(); ?>[bottom]" value="<?php echo esc_attr($field_value['bottom']); ?>"/>
					</div>
				<?php endif;?>
			</div>

		<?php
		}

		/**
		 * Get default value
		 *
		 * @return array
		 */
		function getDefault() {
			$default = array(
				'left' => '',
				'right' => '',
				'top' => '',
				'bottom' => '',
			);
			$field_default = isset($this->_setting['default']) ? $this->_setting['default'] : array();

			return wp_parse_args($field_default, $default);
		}
	}
}