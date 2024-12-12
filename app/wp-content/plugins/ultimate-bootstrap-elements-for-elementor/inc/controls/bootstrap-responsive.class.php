<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

class UBE_Control_Bootstrap_Responsive extends \Elementor\Base_Data_Control {

	public function get_type() {
		return UBE_Controls_Manager::BOOTSTRAP_RESPONSIVE;
	}

	public function content_template() {
		$index = -1;
		?>
		<div class="elementor-control-field">
			<label for="elementor-control-{{{ data._cid }}}" class="elementor-control-title">{{{ data.label }}}</label>
			<div class="ube-element-responsive-switcher">

			</div>
			<div class="ube-elementor-control-responsive-switchers" tabindex="1">
				<div class="ube-elementor-control-responsive-switchers__holder">
					<?php foreach ($this->get_responsive_breakpoints() as $k => $v): $index++ ?>
						<a class="tooltip-target ube-elementor-responsive-switcher ube-elementor-responsive-switcher-<?php echo esc_attr($k) ?>"
						   data-width="<?php echo esc_attr($v['width']) ?>"
						   data-index="<?php echo esc_attr($index) ?>"
						   data-device="<?php echo esc_attr($k) ?>" data-tooltip="<?php echo esc_attr($v['name']) ?>" data-tooltip-pos="w">
							<i class="<?php echo esc_attr($v['icon']) ?>"></i>
						</a>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="elementor-control-input-wrapper">
				<# if ((data.data_type === undefined) || (data.data_type === 'text')) { #>
				<input id="elementor-control-{{{ data._cid }}}" type="text" data-setting="{{ data.name }}" />
				<# } else if (data.data_type === 'number') { #>
					<# var attr_min = data.number_min !== undefined ? ' min="' + data.number_min + '"' : '' #>
					<# var attr_max = data.number_max !== undefined ? ' max="' + data.number_max + '"' : '' #>
					<# var attr_step = data.number_step !== undefined ? ' step="' + data.number_step + '"' : '' #>
				<input id="elementor-control-{{{ data._cid }}}" type="number" data-setting="{{ data.name }}" {{{ attr_min }}}{{{ attr_max }}}{{{ attr_step }}} />
				<# } else if (data.data_type === 'select') { #>
				<select id="elementor-control-{{{ data._cid }}}" data-setting="{{ data.name }}">
					<# _.each( data.options, function( value, key ) { #>
					<option value="{{ key }}">{{ value }}</option>
					<# }) #>
				</select>
				<# } #>
			</div>
		</div>
		<# if ( data.description ) { #>
		<div class="elementor-control-field-description">{{{ data.description }}}</div>
		<# } #>
		<?php
	}

	public function get_responsive_breakpoints() {
		return array(
			'xl' => array(
				'name'  => esc_html__('Desktop', 'ube'),
				'icon'  => 'eicon-device-desktop',
				'width' => ''
			),
			'lg'      => array(
				'name'  => esc_html__('Large', 'ube'),
				'icon'  => 'fas fa-tablet-alt',
				'width' => '1199'
			),
			'md'      => array(
				'name'  => esc_html__('Medium', 'ube'),
				'icon'  => 'eicon-device-tablet',
				'width' => '991'
			),
			'sm'      => array(
				'name'  => esc_html__('Small', 'ube'),
				'icon'  => 'eicon-device-mobile',
				'width' => '767'
			),
			'xs'      => array(
				'name'  => esc_html__('X-Small', 'ube'),
				'icon'  => 'fas fa-mobile-alt',
				'width' => '575'
			),
		);
	}
}