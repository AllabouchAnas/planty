<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
if (!class_exists('GSF_Field_Textarea')) {
	class GSF_Field_Textarea extends GSF_Field
	{
		function enqueue()
		{
			wp_enqueue_script(GSF()->assetsHandle('field_textarea'), GSF()->helper()->getAssetUrl('fields/textarea/assets/textarea.min.js'), array(), GSF()->pluginVer(), true);
			wp_enqueue_style(GSF()->assetsHandle('field_textarea'), GSF()->helper()->getAssetUrl('fields/textarea/assets/textarea.min.css'), array(), GSF()->pluginVer());
		}

		function renderContent($content_args = '')
		{
			$field_value = $this->getFieldValue();
			$row = (isset($this->_setting['args']) && isset($this->_setting['args']['row'])) ? esc_attr($this->_setting['args']['row']) : '5';
			$col = (isset($this->_setting['args']) && isset($this->_setting['args']['col'])) ? esc_attr($this->_setting['args']['col']) : '';
			?>
			<div class="gsf-field-textarea-inner">
			<textarea data-field-control=""
				name="<?php $this->theInputName(); ?>"
				<?php if (!empty($col)): ?>
				    cols="<?php echo esc_attr($col); ?>"
				<?php endif;?>
				<?php if (!empty($row)): ?>
					rows="<?php echo esc_attr($row); ?>"
				<?php endif;?>><?php echo esc_textarea($field_value); ?></textarea>
			</div>
			<?php
		}
	}
}