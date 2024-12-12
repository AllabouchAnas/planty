<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
if (!class_exists('GSF_Field_Slider')) {
	class GSF_Field_Slider extends GSF_Field
	{
		/**
		 * Enqueue resources for field
		 */
		function enqueue() {
			wp_enqueue_style('nouislider');
			wp_enqueue_script('nouislider');
			wp_enqueue_script(GSF()->assetsHandle('field_slider'), GSF()->helper()->getAssetUrl('fields/slider/assets/slider.min.js'), array(), GSF()->pluginVer(), true);
			wp_enqueue_style(GSF()->assetsHandle('field_slider'), GSF()->helper()->getAssetUrl('fields/slider/assets/slider.min.css'), array(), GSF()->pluginVer());
		}

		function renderContent()
		{
			$field_value = $this->getFieldValue();

			$is_range = isset($this->_setting['range']) && $this->_setting['range'];
			if ($is_range) {
				$default = $this->getDefault();
				$field_value = wp_parse_args($field_value, $default);
			}
			$opt_default = array(
				'min' => 0,
				'max' => 100,
				'step' => 1
			);

			$option = isset($this->_setting['js_options']) ? $this->_setting['js_options'] : array();
			$option = wp_parse_args($option, $opt_default);
			?>
			<div class="gsf-field-slider-inner <?php echo esc_attr($is_range ? 'gsf-field-slider-range' : ''); ?>">
				<?php if ($is_range): ?>
					<input data-field-control="" class="gsf-slider-from" type="text" pattern="(-)?[0-9]*"
					       name="<?php $this->theInputName(); ?>[from]" value="<?php echo esc_attr($field_value['from']); ?>"/>
					<div class="gsf-slider-place" data-options='<?php echo json_encode($option); ?>'></div>
					<input data-field-control="" class="gsf-slider-to" type="text" pattern="(-)?[0-9]*"
					       name="<?php $this->theInputName(); ?>[to]" value="<?php echo esc_attr($field_value['to']); ?>"/>
				<?php else: ?>
					<input data-field-control="" class="gsf-slider" type="text" pattern="(-)?[0-9]*"
					       name="<?php $this->theInputName(); ?>" value="<?php echo esc_attr($field_value); ?>"/>
					<div class="gsf-slider-place" data-options='<?php echo json_encode($option); ?>'></div>
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
			if (isset($this->_setting['range']) && $this->_setting['range']) {
				$default = array(
					'from' => '',
					'to' => '',
				);
				$field_default = isset($this->_setting['default']) ? $this->_setting['default'] : array();

				return wp_parse_args($field_default, $default);
			}

			return parent::getDefault();
		}
	}
}