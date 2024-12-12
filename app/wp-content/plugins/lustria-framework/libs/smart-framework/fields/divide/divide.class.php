<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
if (!class_exists('GSF_Field_Divide')) {
	class GSF_Field_Divide extends GSF_Field
	{
		function enqueue() {
			wp_enqueue_style(GSF()->assetsHandle('field_divide'), GSF()->helper()->getAssetUrl('fields/divide/assets/divide.min.css'), array(), GSF()->pluginVer());
		}
		function render()
		{
			$field_classes = array('gsf-field');
			$field_classes[] = 'gsf-field-' . $this->getType();
			if (isset($this->_setting['style'])) {
				$field_classes[] = 'gsf-divide-style-' . $this->_setting['style'];
			}
			?>
			<div <?php $this->theFieldAttribute()?> class="<?php echo join(' ', $field_classes); ?>">
				<div><span></span></div>
			</div>
			<?php
		}
	}
}