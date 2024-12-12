<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
if (!class_exists('GSF_Field_Sorter')) {
	class GSF_Field_Sorter extends GSF_Field
	{
		/**
		 * Enqueue field resources
		 */
		function enqueue() {
			wp_enqueue_script(GSF()->assetsHandle('field_sorter'), GSF()->helper()->getAssetUrl('fields/sorter/assets/sorter.min.js'), array(), GSF()->pluginVer(), true);
			wp_enqueue_style(GSF()->assetsHandle('field_sorter'), GSF()->helper()->getAssetUrl('fields/sorter/assets/sorter.min.css'), array(), GSF()->pluginVer());
		}

		function renderContent()
		{
			$field_value = $this->getFieldValue();
			$default = $this->getDefault();

			$field_value = wp_parse_args($field_value, $default);

			$fielKeyValue = array();
			foreach ($default as $group_key => $group) {
				foreach ($group as $item_key => $item_value) {
					$fielKeyValue[$item_key] = $item_value;
				}
			}
			foreach ($field_value as $group_key => $group) {
				if (!isset($default[$group_key])) {
					 unset($field_value[$group_key]);
				}
			}

			?>
			<div class="gsf-field-sorter-inner gsf-clearfix">
				<?php foreach ($field_value as $group_key => $group): ?>
					<div class="gsf-field-sorter-group" data-group="<?php echo esc_attr($group_key); ?>">
						<div class="gsf-field-sorter-title"><?php echo esc_html($group_key); ?></div>
						<div class="gsf-field-sorter-items">
							<?php foreach ($group as $item_key => $item_value): ?>
								<?php $item_value = isset($fielKeyValue[$item_key]) ? $fielKeyValue[$item_key] : $item_value; ?>
								<div class="gsf-field-sorter-item" data-id="<?php echo esc_attr($item_key); ?>">
									<input data-field-control="" type="hidden"
									       name="<?php $this->theInputName(); ?>[<?php echo esc_attr($group_key); ?>][<?php echo esc_attr($item_key); ?>]"
									       value="<?php echo esc_attr($item_value); ?>"/>
									<?php echo esc_html($item_value); ?>
								</div>
							<?php endforeach;?>
						</div>
					</div>
				<?php endforeach;?>
			</div>
			<?php
		}

		/**
		 * Get default value
		 *
		 * @return array
		 */
		function getDefault() {
			$default = array(
				'enable' => array(),
				'disable' => array()
			);
			$field_default = isset($this->_setting['default']) ? $this->_setting['default'] : array();
			if (empty($field_default)) {
				$field_default = $default;
			}

			return $field_default;
		}
	}
}