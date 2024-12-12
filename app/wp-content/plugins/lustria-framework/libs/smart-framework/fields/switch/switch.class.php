<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
if (!class_exists('GSF_Field_Switch')) {
	class GSF_Field_Switch extends GSF_Field
	{
		function enqueue() {
			wp_enqueue_script(GSF()->assetsHandle('field_switch'), GSF()->helper()->getAssetUrl('fields/switch/assets/switch.min.js'), array(), GSF()->pluginVer(), true);
			wp_enqueue_style(GSF()->assetsHandle('field_switch'));
		}
		function renderContent()
		{
			$field_value = $this->getFieldValue();
			$value_inline = isset($this->_setting['value_inline']) ? $this->_setting['value_inline'] : true;
			$on_text = isset($this->_setting['on_text']) ? $this->_setting['on_text'] : esc_html__('On','lustria-framework');
			$off_text = isset($this->_setting['off_text']) ? $this->_setting['off_text'] : esc_html__('Off','lustria-framework');
			?>
			<div class="gsf-field-switch-inner <?php echo esc_attr($value_inline ? 'value-inline' : ''); ?>">
				<label>
					<input data-field-control="" type="checkbox" <?php GSF()->helper()->theChecked('on', $field_value) ?>
					       name="<?php $this->theInputName(); ?>"
					       value="on" />
					<div class="gsf-field-switch-button" data-switch-on="<?php echo esc_attr($on_text); ?>" data-switch-off="<?php echo esc_attr($off_text); ?>">
						<span class="gsf-field-switch-off"><?php echo esc_html($off_text); ?></span>
						<span class="gsf-field-switch-on"><?php echo esc_html($on_text); ?></span>
					</div>
				</label>
			</div>
		<?php
		}
	}
}