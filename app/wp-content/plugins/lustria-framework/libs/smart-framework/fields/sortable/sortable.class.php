<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
if (!class_exists('GSF_Field_Sortable')) {
	class GSF_Field_Sortable extends GSF_Field
	{
		/**
		 * Enqueue field resources
		 */
		function enqueue() {
			wp_enqueue_script(GSF()->assetsHandle('field_sortable'), GSF()->helper()->getAssetUrl('fields/sortable/assets/sortable.min.js'), array(), GSF()->pluginVer(), true);
			wp_enqueue_style(GSF()->assetsHandle('field_sortable'), GSF()->helper()->getAssetUrl('fields/sortable/assets/sortable.min.css'), array(), GSF()->pluginVer());
		}

		function renderContent()
		{
			$field_value = $this->getFieldValue();

			if (!is_array($field_value)) {
				$field_value = array();
			}

			$sort = array();
			if (isset($field_value['sort_order'])) {
				$sort = explode('|', $field_value['sort_order']);
			}

			if (is_array($this->_setting['options'])) {
				foreach ($this->_setting['options'] as $key => $value) {
					if (!in_array($key, $sort)) {
						$sort[] = $key;
					}
				}

				foreach ($sort as $key => $value) {
					if (!isset($this->_setting['options'][$value])) {
						unset($field_value[$key]);
					}
				}
			}

			?>
			<div class="gsf-field-sortable-inner gsf-clearfix">
				<?php foreach ($sort as $sortValue): ?>
					<div class="gsf-field-sortable-item">
						<i class="dashicons dashicons-menu"></i>
						<label>
							<input type="checkbox"
							       data-field-control=""
							       data-uncheck-novalue="true"
							       name="<?php $this->theInputName(); ?>[<?php echo esc_attr($sortValue) ?>]"
							       value="<?php echo esc_attr($sortValue) ?>"
								<?php GSF()->helper()->theChecked($sortValue, $field_value) ?>/>
							<span><?php echo esc_html($this->_setting['options'][$sortValue]); ?></span>
						</label>
					</div>
					<input class="gsf-field-sortable-sort" data-field-control="" type="hidden" name="<?php $this->theInputName(); ?>[sort_order]" value="<?php echo join('|', $sort) ?>"/>
				<?php endforeach;?>
			</div>
		<?php
		}

		/**
		 * Field empty value
		 * @return string
		 */
		public function getEmptyValue() {
			return array();
		}

		/**
		 * Get default value
		 *
		 * @return array
		 */
		function getDefault() {
			$field_default = isset($this->_setting['default']) ? $this->_setting['default'] : array();

			return $field_default;
		}
	}
}