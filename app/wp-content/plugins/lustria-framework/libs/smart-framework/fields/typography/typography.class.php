<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
if (!class_exists('GSF_Field_Typography')) {
	class GSF_Field_Typography extends GSF_Field
	{
		function enqueue()
		{
			wp_enqueue_style('selectize');
			wp_enqueue_style('selectize-default');
			wp_enqueue_script('selectize');

			wp_enqueue_script(GSF()->assetsHandle('field_typography'), GSF()->helper()->getAssetUrl('fields/typography/assets/typography.min.js'), array(), GSF()->pluginVer(), true);
			wp_enqueue_style(GSF()->assetsHandle('field_typography'), GSF()->helper()->getAssetUrl('fields/typography/assets/typography.min.css'), array(), GSF()->pluginVer());
			wp_localize_script(GSF()->assetsHandle('field_typography'), 'GSF_TYPOGRAPHY_META_DATA', array(
				'activeFonts' => GSF()->core()->fonts()->getActiveFonts()
			));
		}

		function renderContent()
		{
			$fonts_active = GSF()->core()->fonts()->getActiveFonts();

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
			$current_font = array();
			foreach ($fonts_active as $font) {
				if ($font['family'] == $field_value['font_family']) {
					$current_font = $font;
					break;
				}
			}
			?>
			<div class="gsf-field-typography-inner gsf-clearfix">
				<div class="gsf-typography-family">
					<div class="gsf-typography-label"><?php esc_html_e('Font Family','lustria-framework'); ?></div>
					<select data-field-control="" placeholder="<?php esc_attr_e('Select Font Family','lustria-framework'); ?>"
					        class="gsf-typography-font-family"
					        name="<?php $this->theInputName(); ?>[font_family]"
					        data-value="<?php echo esc_attr($field_value['font_family']); ?>">
						<?php foreach ($fonts_active as $font): ?>
							<option value="<?php echo esc_attr($font['family']); ?>"
								<?php selected($font['family'], $field_value['font_family']); ?>><?php echo esc_html(isset($font['name']) ? $font['name'] : $font['family']); ?></option>
						<?php endforeach;?>
					</select>
				</div>
				<?php if (isset($this->_setting['font_size']) && $this->_setting['font_size']): ?>
					<div class="gsf-typography-size">
						<div class="gsf-typography-label"><?php esc_html_e('Font Size','lustria-framework'); ?></div>
						<input data-field-control="" type="hidden" class="gsf-typography-size"
						       name="<?php $this->theInputName(); ?>[font_size]"
						       value="<?php echo esc_attr($field_value['font_size']); ?>"/>
						<input type="number" placeholder="<?php esc_attr_e('Font size','lustria-framework'); ?>" step="<?php echo esc_attr($step); ?>"
						       class="gsf-typography-size-value" value="<?php echo esc_attr($font_size_value); ?>"/>
						<select class="gsf-typography-size-unit">
							<option value="px" <?php selected('px', $font_size_unit); ?>>px</option>
							<option value="em" <?php selected('em', $font_size_unit); ?>>em</option>
							<option value="%" <?php selected('%', $font_size_unit); ?>>%</option>
						</select>
					</div>
				<?php endif;?>
				<?php if (isset($this->_setting['font_variants']) && $this->_setting['font_variants']): ?>
					<div class="gsf-typography-weight-style">
						<input data-field-control="" type="hidden" class="gsf-typography-weight"
						       name="<?php $this->theInputName(); ?>[font_weight]"
						       value="<?php echo esc_attr($field_value['font_weight']); ?>"/>
						<input data-field-control="" type="hidden" class="gsf-typography-style"
						       name="<?php $this->theInputName(); ?>[font_style]"
						       value="<?php echo esc_attr($field_value['font_style']); ?>"/>
						<div class="gsf-typography-label"><?php esc_html_e('Font Weight & Style','lustria-framework'); ?></div>
						<select class="gsf-typography-variants">
							<?php foreach ($current_font['variants'] as $variant): ?>
								<option value="<?php echo esc_attr($variant); ?>"
									<?php selected($variant, $field_value['font_weight'].$field_value['font_style']); ?>><?php echo esc_html($variant); ?></option>
							<?php endforeach;?>
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
			$fonts_active = GSF()->core()->fonts()->getActiveFonts();
			if (count($fonts_active) > 0) {
				$default = array(
					'font_family' => $fonts_active[0]['family'],
					'font_size' => '14',
					'font_weight' => '400',
					'font_style' => '',
				);
			}
			else {
				$default = array(
					'font_family' => "Open Sans",
					'font_size' => '14',
					'font_weight' => '400',
					'font_style' => '',
				);
			}
			$field_default = isset($this->_setting['default']) ? $this->_setting['default'] : array();

			return wp_parse_args($field_default, $default);
		}
	}
}