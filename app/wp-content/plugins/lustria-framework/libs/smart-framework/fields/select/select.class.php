<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
if (!class_exists('GSF_Field_Select')) {
	class GSF_Field_Select extends GSF_Field
	{
		function enqueue() {
			wp_enqueue_script(GSF()->assetsHandle('field_select'), GSF()->helper()->getAssetUrl('fields/select/assets/select.min.js'), array(), GSF()->pluginVer(), true);
			wp_enqueue_style(GSF()->assetsHandle('field_select'), GSF()->helper()->getAssetUrl('fields/select/assets/select.min.css'), array(), GSF()->pluginVer());
		}
		function renderContent()
		{
			if (isset($this->_setting['data'])) {
				switch ($this->_setting['data']) {
					case 'preset':
						if (isset($this->_setting['data-option'])) {
							$this->_setting['options'] = GSF()->adminThemeOption()->getPresetOptionKeys($this->_setting['data-option']);
						}
						break;
					case 'sidebar':
						$this->_setting['options'] = GSF()->helper()->getSidebars();
						break;
					case 'menu':
						$this->_setting['options'] = GSF()->helper()->getMenus();
						break;
					case 'taxonomy':
						$this->_setting['options'] = GSF()->helper()->getTaxonomies(isset($this->_setting['data_args']) ? $this->_setting['data_args'] : array());
						break;
					default:
						if (isset($this->_setting['data_args']) && !isset($this->_setting['data_args']['post_type'])) {
							$this->_setting['data_args']['post_type'] = $this->_setting['data'];
						}
						$this->_setting['options'] = GSF()->helper()->getPosts(isset($this->_setting['data_args']) ? $this->_setting['data_args'] : array('post_type' => $this->_setting['data']));
						break;
				}
			}

			if (!isset($this->_setting['options']) || !is_array($this->_setting['options'])) {
				return;
			}
			$field_value = $this->getFieldValue();
			$multiple = isset($this->_setting['multiple']) ? $this->_setting['multiple'] : false;
			$attr = array();
			if (isset($this->_setting['width'])) {
				$attr[] = sprintf('style="width:%s"', $this->_setting['width']);
			}
			?>
			<div class="gsf-field-select-inner">
				<select data-field-control=""
					<?php echo join(' ', $attr); ?>
				        name="<?php $this->theInputName(); ?><?php echo $multiple ? '[]' : ''; ?>" <?php echo ($multiple ? ' multiple="multiple"' : '' ); ?>>
					<?php foreach ($this->_setting['options'] as $key => $value): ?>
						<?php if (is_array($value)): ?>
							<optgroup label="<?php echo esc_attr($key); ?>">
								<?php foreach ($value as $opt_key => $opt_value): ?>
									<option <?php GSF()->helper()->theSelected($opt_key, $field_value) ?>
										value="<?php echo esc_attr($opt_key); ?>"><?php echo esc_html($opt_value); ?></option>
								<?php endforeach; ?>
							</optgroup>
						<?php else:; ?>
							<option value="<?php echo esc_attr($key); ?>" <?php GSF()->helper()->theSelected($key, $field_value) ?>><?php echo esc_html($value); ?></option>
						<?php endif; ?>
					<?php endforeach; ?>
				</select>
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