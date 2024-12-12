<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
if (!class_exists('GSF_Field_Radio')) {
	class GSF_Field_Radio extends GSF_Field
	{
		function enqueue() {
			wp_enqueue_script(GSF()->assetsHandle('field_radio'), GSF()->helper()->getAssetUrl('fields/radio/assets/radio.min.js'), array(), GSF()->pluginVer(), true);
			wp_enqueue_style(GSF()->assetsHandle('field_radio'), GSF()->helper()->getAssetUrl('fields/radio/assets/radio.min.css'), array(), GSF()->pluginVer());
		}
		function renderContent()
		{
			if (isset($this->_setting['data'])) {
				switch ($this->_setting['data']) {
					case 'preset':
						if (isset($this->_setting['data-option'])) {
							$this->_setting['options'] = GSF()->themeOptionPage()->getPresetOptionKeys($this->_setting['data-option']);
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
			$value_inline = isset($this->_setting['value_inline']) ? $this->_setting['value_inline'] : true;
			?>
			<div class="gsf-field-radio-inner <?php echo esc_attr($value_inline ? 'value-inline' : ''); ?>">
				<?php foreach ($this->_setting['options'] as $key => $value): ?>
					<label>
						<input data-field-control="" type="radio" <?php GSF()->helper()->theChecked($key, $field_value) ?>
						       name="<?php $this->theInputName(); ?>"
						       value="<?php echo esc_attr($key); ?>" />
						<span><?php echo esc_html($value); ?></span>
					</label>
				<?php endforeach;?>
			</div>
		<?php
		}
	}
}