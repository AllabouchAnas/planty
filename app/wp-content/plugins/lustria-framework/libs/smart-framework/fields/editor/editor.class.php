<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
if (!class_exists('GSF_Field_Editor')) {
	class GSF_Field_Editor extends GSF_Field
	{
		function enqueue()
		{
			wp_enqueue_script(GSF()->assetsHandle('field_editor'), GSF()->helper()->getAssetUrl('fields/editor/assets/editor.min.js'), array(), GSF()->pluginVer(), true);
		}
		function renderContent()
		{
			$field_value = $this->getFieldValue();
			/**
			 * Setup up default args
			 */
			$args_defaults = array(
				'textarea_name' => $this->getInputName(),
				'editor_class'  => isset($this->_setting['class']) ? $this->_setting['class'] : '',
				'textarea_rows' => 10, //Wordpress default
				'teeny'         => true,
			);
			$this->_setting['args'] = isset($this->_setting['args']) ? $this->_setting['args'] : array();

			$args = wp_parse_args( $this->_setting['args'], $args_defaults);

			$editor_id = $this->getInputName() . '__editor';
			$editor_id = str_replace('[', '__',$editor_id);
			$editor_id = str_replace(']', '__',$editor_id);
			add_filter('the_editor', array($this, 'addDataFieldControl'));
			?>
			<div class="gsf-field-editor-inner">
				<?php wp_editor( $field_value, $editor_id, $args ); ?>
			</div>
		<?php
			remove_filter('the_editor', array($this, 'addDataFieldControl'));
		}

		public function addDataFieldControl($content) {
			return preg_replace(array('/\<textarea/'), '<textarea data-field-control=""', $content);
		}
	}
}