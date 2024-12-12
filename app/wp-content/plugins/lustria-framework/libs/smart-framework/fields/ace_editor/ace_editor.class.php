<?php
/**
 * Field Ace Editor
 *
 * @package SmartFramework
 * @subpackage Fields
 * @author g5plus
 * @since 1.0
 */
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
if (!class_exists('GSF_Field_Ace_Editor')) {
	class GSF_Field_Ace_Editor extends GSF_Field
	{
		function enqueue()
		{
			wp_enqueue_script('ace_editor', GSF()->helper()->getAssetUrl('fields/ace_editor/assets/ace.min.js'), array( 'jquery' ), '1.2.6', true);
			wp_enqueue_script(GSF()->assetsHandle('field_ace_editor'), GSF()->helper()->getAssetUrl('fields/ace_editor/assets/ace-editor.min.js'), array(), GSF()->pluginVer(), true);
			wp_enqueue_style(GSF()->assetsHandle('field_ace_editor'), GSF()->helper()->getAssetUrl('fields/ace_editor/assets/ace-editor.min.css'), array(), GSF()->pluginVer());
		}
		function renderContent()
		{
			$field_value = $this->getFieldValue();
			$settings = array(
				'minLines' => 8,
				'maxLines' => 20,
				'showPrintMargin' => false
			);
			if (isset($this->_setting['min_line'])) {
				$settings['minLines'] = $this->_setting['min_line'];
			}
			if (isset($this->_setting['max_line'])) {
				$settings['maxLines'] = $this->_setting['max_line'];
			}
			if (isset($this->_setting['js_options']) && is_array($this->_setting['js_options'])) {
				$settings = wp_parse_args( $this->_setting['js_options'], $settings );
			}
			$mode = isset($this->_setting['mode']) ? $this->_setting['mode'] : '';
			$theme = isset($this->_setting['theme']) ? $this->_setting['theme'] : '';

			$editor_id = $this->getID() . '__ace_editor';
			?>
			<div class="gsf-field-ace-editor-inner">
				<textarea data-field-control="" name="<?php $this->theInputName(); ?>" class="gsf-hidden-field "
				          data-mode="<?php echo esc_attr($mode); ?>"
				          data-theme="<?php echo esc_attr($theme); ?>"
				          data-options="<?php echo esc_attr(wp_json_encode($settings)); ?>"><?php echo esc_textarea($field_value); ?></textarea>
				<pre class="gsf-ace-editor" id="<?php echo esc_attr($editor_id); ?>"><?php echo htmlspecialchars($field_value); ?></pre>
			</div>
		<?php
		}
	}
}