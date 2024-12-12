<?php
/**
 * Field Ace Editor
 *
 * @package SmartFramework
 * @subpackage Fields
 * @author g5plus
 * @version 1.0
 */
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
if (!class_exists('GSF_Field_Border')) {
	class GSF_Field_Border extends GSF_Field
	{
		function enqueue()
		{
			wp_enqueue_style('wp-color-picker');
			wp_enqueue_script('wp-color-picker');
			wp_enqueue_script(GSF()->assetsHandle('media'));
			wp_enqueue_script('wp-color-picker-alpha');

			wp_enqueue_style(GSF()->assetsHandle('field_border'), GSF()->helper()->getAssetUrl('fields/border/assets/border.min.css'), array(), GSF()->pluginVer());
			wp_enqueue_script(GSF()->assetsHandle('field_border'), GSF()->helper()->getAssetUrl('fields/border/assets/border.min.js'), array(), GSF()->pluginVer(), true);

		}

		function renderContent()
		{
			$field_value = $this->getFieldValue();
			if (!is_array($field_value)) {
				$field_value = array();
			}

			$field_default = $this->getDefault();
			$field_value = wp_parse_args($field_value, $field_default);

			$border_style = array(
				'none'    => 'None',
				'hidden'  => 'Hidden',
				'dotted'  => 'Dotted',
				'dashed'  => 'Dashed',
				'solid'   => 'Solid',
				'double'  => 'Double',
				'groove'  => 'Groove',
				'ridge'   => 'Ridge',
				'inset'   => 'Inset',
				'outset'  => 'Outset',
				'initial' => 'Initial',
				'inherit' => 'Inherit',
			);

			$border_top = isset($this->_setting['top']) && $this->_setting['top'];
			$border_right = isset($this->_setting['right']) && $this->_setting['right'];
			$border_bottom = isset($this->_setting['bottom']) && $this->_setting['bottom'];
			$border_left = isset($this->_setting['left']) && $this->_setting['left'];

			?>
			<div class="gsf-field-border-inner">
				<?php if (!$border_top && !$border_right && !$border_bottom && !$border_left): ?>
					<div class="gsf-border-width-info">
						<span class="dashicons dashicons-move"></span>
						<input data-field-control="" type="number" class="gsf-border-width"
						       min="0" placeholder="<?php esc_attr_e('All','lustria-framework'); ?>"
						       name="<?php $this->theInputName(); ?>[border_width]"
						       value="<?php echo esc_attr($field_value['border_width']); ?>" />
					</div>
				<?php endif;?>
				<?php if ($border_top): ?>
					<div class="gsf-border-width-info">
						<span class="dashicons dashicons-arrow-up-alt"></span>
						<input data-field-control="" type="number" class="gsf-border-top-width"
						       min="0" placeholder="<?php esc_attr_e('Top','lustria-framework'); ?>"
						       name="<?php $this->theInputName(); ?>[border_top_width]"
						       value="<?php echo esc_attr($field_value['border_top_width']); ?>" />
					</div>
				<?php endif;?>
				<?php if ($border_right): ?>
					<div class="gsf-border-width-info">
						<span class="dashicons dashicons-arrow-right-alt"></span>
						<input data-field-control="" type="number" class="gsf-border-top-width" min="0"
						       placeholder="<?php esc_attr_e('Right','lustria-framework'); ?>"
						       name="<?php $this->theInputName(); ?>[border_right_width]"
						       value="<?php echo esc_attr($field_value['border_right_width']); ?>" />
					</div>
				<?php endif;?>
				<?php if ($border_bottom): ?>
					<div class="gsf-border-width-info">
						<span class="dashicons dashicons-arrow-down-alt"></span>
						<input data-field-control="" type="number" class="gsf-border-top-width" min="0"
						       placeholder="<?php esc_attr_e('Bottom','lustria-framework'); ?>"
						       name="<?php $this->theInputName(); ?>[border_bottom_width]"
						       value="<?php echo esc_attr($field_value['border_bottom_width']); ?>" />
					</div>
				<?php endif;?>
				<?php if ($border_left): ?>
					<div class="gsf-border-width-info">
						<span class="dashicons dashicons-arrow-left-alt"></span>
						<input data-field-control="" type="number" class="gsf-border-top-width" min="0"
						       placeholder="<?php esc_attr_e('Left','lustria-framework'); ?>"
						       name="<?php $this->theInputName(); ?>[border_left_width]"
						       value="<?php echo esc_attr($field_value['border_left_width']); ?>"/>
					</div>
				<?php endif;?>
				<select data-field-control=""
				        name="<?php $this->theInputName(); ?>[border_style]"
				        class="gsf-border-style">
					<?php foreach ($border_style as $value => $text): ?>
						<option value="<?php echo esc_attr($value); ?>" <?php selected($value, $field_value['border_style'], true); ?>><?php echo esc_html($text); ?></option>
					<?php endforeach;?>
				</select>
				<div><input data-field-control=""
				            data-field-no-change="true"
				            data-alpha="true"
				            class="gsf-border-color"
				            type="text" name="<?php $this->theInputName(); ?>[border_color]" value="<?php echo esc_attr($field_value['border_color']); ?>"/></div>
			</div>
		<?php
		}

		/**
		 * Get default value
		 * @since   1.0
		 * @return  array
		 */
		function getDefault() {
			$default = array(
				'border_color' => '#fff',
				'border_width' => '',
				'border_top_width' => '',
				'border_right_width' => '',
				'border_bottom_width' => '',
				'border_left_width' => '',
				'border_style' => '',
			);
			$field_default = isset($this->_setting['default']) ? $this->_setting['default'] : array();
			return wp_parse_args($field_default, $default);
		}
	}
}