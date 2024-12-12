<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
if (!class_exists('GSF_Field_Text')) {
	class GSF_Field_Text extends  GSF_Field {
		function enqueue() {
			wp_enqueue_script(GSF()->assetsHandle('field_text'), GSF()->helper()->getAssetUrl('fields/text/assets/text.min.js'), array(), GSF()->pluginVer(), true);
			wp_enqueue_style(GSF()->assetsHandle('field_text'), GSF()->helper()->getAssetUrl('fields/text/assets/text.min.css'), array(), GSF()->pluginVer());
		}

		public function getFieldClass()  {
			$field_class = parent::getFieldClass();

			$input_type = isset($this->_setting['input_type']) ? $this->_setting['input_type'] : 'text';
			if ($input_type === 'unique_id') {
				$field_class[] = 'gsf-hidden-field';
			}

			return $field_class;
		}

		function renderContent()
		{
			$field_value = $this->getFieldValue();

			$input_type = isset($this->_setting['input_type']) ? $this->_setting['input_type'] : 'text';

			$attr = array();
			if (isset($this->_setting['maxlength'])) {
				$attr[] = sprintf('maxlength="%s"', esc_attr($this->_setting['maxlength']));
			}
			if (isset($this->_setting['pattern'])) {
				$attr[] = sprintf('pattern="%s"', esc_attr($this->_setting['pattern']));
			}

			if (isset($this->_setting['panel_title']) && $this->_setting['panel_title']) {
				$attr[] = 'data-panel-title="true"';
			}
			if ($input_type === 'unique_id') {
				$attr[] = 'readonly="readonly"';
				$attr[] = 'data-unique_id="true"';
				$attr[] = 'data-unique_id-prefix="'. (isset($this->_setting['default']) ? $this->_setting['default'] : '')  .'"';
				$input_type = 'text';

			}

			if (isset($this->_setting['width'])) {
				$attr[] = sprintf('style="width:%s"', $this->_setting['width']);
			}

			switch ($input_type) {
				case 'range':
				case 'number':
					if (isset($this->_setting['args'])) {
						if (isset($this->_setting['args']['min'])) {
							$attr[] = sprintf('min="%s"', esc_attr($this->_setting['args']['min']));
						}
						if (isset($this->_setting['args']['max'])) {
							$attr[] = sprintf('max="%s"', esc_attr($this->_setting['args']['max']));
						}
						if (isset($this->_setting['args']['step'])) {
							$attr[] = sprintf('step="%s"', esc_attr($this->_setting['args']['step']));
						}
					}
					break;
			}
			?>
			<div class="gsf-field-text-inner">
				<input data-field-control=""
				       type="<?php echo esc_attr($input_type); ?>"
					   <?php echo join(' ', $attr); ?>
						<?php if (!empty($this->_setting['placeholder'])): ?>
							placeholder="<?php echo esc_attr($this->_setting['placeholder']); ?>"
						<?php endif;?>
				       name="<?php $this->theInputName(); ?>" value="<?php echo esc_attr($field_value) ?>" />
			</div>
		<?php
		}
	}
}