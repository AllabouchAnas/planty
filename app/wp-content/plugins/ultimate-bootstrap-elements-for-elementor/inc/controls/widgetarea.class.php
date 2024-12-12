<?php

defined( 'ABSPATH' ) || exit;

class UBE_Control_Widgetarea extends \Elementor\Base_Data_Control {
	/**
	 * Get choose control type.
	 *
	 * Retrieve the control type, in this case `choose`.
	 *
	 * @return string Control type.
	 * @since 1.0.0
	 * @access public
	 *
	 */
	public function get_type() {
		return UBE_Controls_Manager::WIDGETAREA;
	}

	/**
	 * Enqueue ontrol scripts and styles.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function enqueue() {

	}


	/**
	 * Render choose control output in the editor.
	 *
	 * Used to generate the control HTML in the editor using Underscore JS
	 * template. The variables for the class are available using `data` JS
	 * object.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function content_template() {
		?>
        <div style="display:block" class="elementor-control-field">
            <label for="elementor-control-{{{ data._cid }}}" class="elementor-control-title">{{{ data.label }}}</label>
            <div class="elementor-control-input-wrapper">
                <input id="elementor-control-{{{ data._cid }}}" type="text" data-setting="{{ data.name }}" class="ube-widget-area-input"/>
            </div>
        </div>
        <# if ( data.description ) { #>
        <div class="elementor-control-field-description">{{{ data.description }}}</div>
        <# } #>
		<?php
	}

	/**
	 * Get choose control default settings.
	 *
	 * Retrieve the default settings of the choose control. Used to return the
	 * default settings while initializing the choose control.
	 *
	 * @return array Control default settings.
	 * @since 1.0.0
	 * @access protected
	 *
	 */
	protected function get_default_settings() {
		return [
			'label_block' => true,
		];
	}
}