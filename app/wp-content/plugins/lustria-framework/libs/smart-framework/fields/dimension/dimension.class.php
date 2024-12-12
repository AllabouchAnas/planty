<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
if (!class_exists('GSF_Field_Dimension')) {
	class GSF_Field_Dimension extends GSF_Field
	{
		function enqueue() {
			wp_enqueue_script(GSF()->assetsHandle('field_dimension'), GSF()->helper()->getAssetUrl('fields/dimension/assets/dimension.min.js'), array(), GSF()->pluginVer(), true);
			wp_enqueue_style(GSF()->assetsHandle('field_dimension'), GSF()->helper()->getAssetUrl('fields/dimension/assets/dimension.min.css'), array(), GSF()->pluginVer());
		}
		function renderContent()
		{
			$field_value = $this->getFieldValue();
			if (!is_array($field_value)) {
				$field_value = array();
			}

			$is_width = isset($this->_setting['width']) ? $this->_setting['width'] : true;
			$is_height = isset($this->_setting['height']) ? $this->_setting['height'] : true;
			$default = $this->getDefault();
			$field_value = wp_parse_args($field_value, $default);

			?>
			<div class="gsf-field-dimension-inner">
				<?php if ($is_width): ?>
					<div class="gsf-dimension-item">
						<div class="dashicons dashicons-leftright"></div>
						<input data-field-control="" class="gsf-dimension" type="number" placeholder="<?php esc_attr_e('Width','lustria-framework'); ?>"
						       name="<?php $this->theInputName(); ?>[width]" value="<?php echo esc_attr($field_value['width']); ?>"/>
					</div>
				<?php endif;?>
				<?php if ($is_height): ?>
					<div class="gsf-dimension-item">
						<div class="dashicons dashicons-leftright gsf-rotate-90deg" style="margin-right: 1px"></div>
						<input data-field-control="" class="gsf-dimension" type="number" placeholder="<?php esc_attr_e('Height','lustria-framework'); ?>"
						       name="<?php $this->theInputName(); ?>[height]" value="<?php echo esc_attr($field_value['height']); ?>"/>
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
				'width' => '',
				'height' => '',
			);
			$field_default = isset($this->_setting['default']) ? $this->_setting['default'] : array();

			return wp_parse_args($field_default, $default);
		}
	}
}