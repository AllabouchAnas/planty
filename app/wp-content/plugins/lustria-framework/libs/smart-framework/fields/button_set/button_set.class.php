<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
if (!class_exists('GSF_Field_Button_Set')) {
	class GSF_Field_Button_Set extends GSF_Field
	{
		function enqueue() {
			wp_enqueue_style(GSF()->assetsHandle('field_button_set'));
			wp_enqueue_script(GSF()->assetsHandle('field_button_set'), GSF()->helper()->getAssetUrl('fields/button_set/assets/button-set.min.js'), array(), GSF()->pluginVer(), true);
		}
		function renderContent()
		{
			if (!isset($this->_setting['options']) || !is_array($this->_setting['options'])) {
				return;
			}
			$field_value = $this->getFieldValue();

			$is_multiple = isset($this->_setting['multiple']) && $this->_setting['multiple'];
			if ($is_multiple && !is_array($field_value)) {
				$field_value = (array)$field_value;
			}
			$allowClear = (!isset($this->_setting['multiple']) || !$this->_setting['multiple'])
						&& (isset($this->_setting['allow_clear']) && $this->_setting['allow_clear']);
			?>
			<div class="gsf-field-button_set-inner" <?php echo ($is_multiple ? 'data-multiple="true"': ''); ?>>
				<?php foreach ($this->_setting['options'] as $key => $value): ?>
					<?php $key = (string)$key; ?>
					<label>
						<?php if (isset($this->_setting['multiple']) && $this->_setting['multiple']): ?>
							<input data-field-control="" type="checkbox" name="<?php $this->theInputName(); ?>[]" value="<?php echo esc_attr($key); ?>" <?php GSF()->helper()->theChecked($key, $field_value) ?>/>
						<?php else: ?>
							<input data-field-control="" type="radio" name="<?php $this->theInputName(); ?>" value="<?php echo esc_attr($key); ?>" <?php GSF()->helper()->theChecked($key, $field_value) ?>/>
						<?php endif;?>
						<span class="<?php echo ($allowClear ? 'gsf-allow-clear' : ''); ?>"><?php echo esc_html($value); ?></span>
					</label>
				<?php endforeach;?>
			</div>
		<?php
		}

		/**
		 * Field empty value
		 * @return string
		 */
		public function getEmptyValue() {
			if ($this->isClone()) {
				return array();
			}
			else {
				if (isset($this->_setting['multiple']) && $this->_setting['multiple']) {
					return array();
				}
				return '';
			}
		}

		/**
		 * Get default value
		 *
		 * @return array | string
		 */
		function getDefault() {
			$default = '';
			if (isset($this->_setting['multiple']) && $this->_setting['multiple']) {
				$default = array();
			}
			$field_default = isset($this->_setting['default']) ? $this->_setting['default'] : $default;
			return $field_default;
		}
	}
}