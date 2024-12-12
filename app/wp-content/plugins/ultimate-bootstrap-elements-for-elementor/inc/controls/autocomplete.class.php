<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Elementor select2 control.
 *
 * A base control for creating select2 control. Displays a select box control
 * based on select2 jQuery plugin @see https://select2.github.io/ .
 * It accepts an array in which the `key` is the value and the `value` is the
 * option name. Set `multiple` to `true` to allow multiple value selection.
 *
 * @since 1.0.0
 */
class UBE_Control_Autocomplete extends Elementor\Control_Select2
{
    public function get_type() {
	    return UBE_Controls_Manager::AUTOCOMPLETE;
    }

    protected function get_default_settings() {
        $ajax_url = admin_url('admin-ajax.php?action=ube_control_autocomplete');
        $ajax_url = add_query_arg( 'ube_autocomplete_nonce', wp_create_nonce( 'ube_autocomplete_action' ), $ajax_url );
        
        return array_merge(parent::get_default_settings(), array(
            'ajax_url'    => $ajax_url,
            'placeholder' => esc_html__('Press any key to search...', 'ube'),
            'select_type'        => 'post',
            'select_args'        => array(),
        ));
    }

    /**
     * Render select2 control output in the editor.
     *
     * Used to generate the control HTML in the editor using Underscore JS
     * template. The variables for the class are available using `data` JS
     * object.
     *
     * @since 1.0.0
     * @access public
     */
    public function content_template() {
        $control_uid = $this->get_control_uid();
        ?>
        <div class="elementor-control-field">
            <# if ( data.label ) {#>
            <label for="<?php echo $control_uid; ?>" class="elementor-control-title">{{{ data.label }}}</label>
            <# } #>
            <div class="elementor-control-input-wrapper elementor-control-unit-5">
                <# var multiple = ( data.multiple ) ? 'multiple' : ''; #>
                <select id="<?php echo $control_uid; ?>" class="elementor-select2" type="select2" {{ multiple }} data-setting="{{ data.name }}"></select>
            </div>
        </div>
        <# if ( data.description ) { #>
        <div class="elementor-control-field-description">{{{ data.description }}}</div>
        <# } #>
        <?php
    }
}
