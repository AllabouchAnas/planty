<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
if (!class_exists('GSF_Field_Font')) {
	class GSF_Field_Font extends GSF_Field
	{
		function enqueue()
		{
			wp_enqueue_style('selectize');
			wp_enqueue_style('selectize-default');
			wp_enqueue_script('selectize');

			wp_enqueue_script(GSF()->assetsHandle('field_font'), GSF()->helper()->getAssetUrl('fields/font/assets/font.min.js'), array(), GSF()->pluginVer(), true);
			wp_enqueue_style(GSF()->assetsHandle('field_font'), GSF()->helper()->getAssetUrl('fields/font/assets/font.min.css'), array(), GSF()->pluginVer());
		}

		function renderContent()
		{
			$field_value = $this->getFieldValue();
			if (!is_array($field_value)) {
				$field_value = array();
			}

			$field_default = $this->getDefault();

			$field_value = wp_parse_args($field_value, $field_default);

			$font_size = $field_value['font_size'];
			$font_size_unit = preg_replace('/[0-9]*/', '', $font_size);
			$font_size_value = preg_replace('/em|px|\%/', '', $font_size);
			$step = 1;
			if ($font_size_unit === 'em') {
				$step = 0.01;
			}
			?>
			<div class="gsf-field-font-inner gsf-clearfix">
				<input data-field-control="" type="hidden" class="gsf-font-size-kind"
				       name="<?php $this->theInputName(); ?>[font_kind]"
				       value="<?php echo esc_attr($field_value['font_kind']); ?>"/>
				<div class="gsf-font-family">
					<div class="gsf-font-label"><?php esc_html_e('Font Family','lustria-framework'); ?></div>
					<select data-field-control="" data-field-no-change="true" placeholder="<?php esc_attr_e('Select Font Family','lustria-framework'); ?>"
					        name="<?php $this->theInputName(); ?>[font_family]"
					        data-value="<?php echo esc_attr($field_value['font_family']); ?>">
						<option value="<?php echo esc_attr($field_value['font_family']); ?>" selected="selected"><?php echo esc_html($field_value['font_family']); ?></option>
					</select>
				</div>
				<?php if (isset($this->_setting['font_size']) && $this->_setting['font_size']): ?>
					<div class="gsf-font-size">
						<div class="gsf-font-label"><?php esc_html_e('Font Size','lustria-framework'); ?></div>
						<input data-field-control="" type="hidden" class="gsf-font-size-full"
						       name="<?php $this->theInputName(); ?>[font_size]"
						       value="<?php echo esc_attr($field_value['font_size']); ?>"/>
						<input type="number" placeholder="<?php esc_attr_e('Font size','lustria-framework'); ?>" step="<?php echo esc_attr($step); ?>"
						       class="gsf-font-size-value" value="<?php echo esc_attr($font_size_value); ?>"/>
						<select class="gsf-font-size-unit">
							<option value="px" <?php selected('px', $font_size_unit); ?>>px</option>
							<option value="em" <?php selected('em', $font_size_unit); ?>>em</option>
							<option value="%" <?php selected('%', $font_size_unit); ?>>%</option>
						</select>
					</div>
				<?php endif;?>
				<?php if (isset($this->_setting['font_weight']) && $this->_setting['font_weight']): ?>
					<div class="gsf-font-weight-style">
						<input data-field-control="" type="hidden" class="gsf-font-weight"
						       name="<?php $this->theInputName(); ?>[font_weight]"
						       value="<?php echo esc_attr($field_value['font_weight']); ?>"/>
						<input data-field-control="" type="hidden" class="gsf-font-style"
						       name="<?php $this->theInputName(); ?>[font_style]"
						       value="<?php echo esc_attr($field_value['font_style']); ?>"/>
						<div class="gsf-font-label"><?php esc_html_e('Font Weight & Style','lustria-framework'); ?></div>
						<select data-value="<?php echo esc_attr($field_value['font_weight'].$field_value['font_style']); ?>">
							<option value="<?php echo esc_attr($field_value['font_weight'].$field_value['font_style']); ?>"><?php echo esc_html($field_value['font_weight'].$field_value['font_style']); ?></option>
						</select>
					</div>
				<?php endif;?>
				<?php if (isset($this->_setting['font_subsets']) && $this->_setting['font_subsets']): ?>
					<div class="gsf-font-subsets">
						<div class="gsf-font-label"><?php esc_html_e('Font Subsets','lustria-framework'); ?></div>
						<select data-field-control="" name="<?php $this->theInputName(); ?>[font_subsets]" data-value="<?php echo esc_attr($field_value['font_subsets']); ?>">
							<option value="<?php echo esc_attr($field_value['font_subsets']); ?>" selected="selected"><?php echo esc_html($field_value['font_subsets']); ?></option>
						</select>
					</div>
				<?php endif;?>
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
				'font_kind' => 'google',
				'font_family' => "'Open Sans'",
				'font_size' => '14',
				'font_weight' => '400',
				'font_style' => '',
				'font_subsets' => ''
			);
			$field_default = isset($this->_setting['default']) ? $this->_setting['default'] : array();

			return wp_parse_args($field_default, $default);
		}
	}
}