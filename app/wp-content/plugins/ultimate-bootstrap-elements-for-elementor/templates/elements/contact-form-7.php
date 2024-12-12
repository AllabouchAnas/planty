<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @var $element UBE_Element_Contact_Form_7
 */

$settings = $element->get_settings_for_display();

if ( ! function_exists( 'wpcf7' ) ) {
	return;
}

$settings = $element->get_settings();
$classes  = array(
	'ube-contact-form',
	'ube-contact-form-7',
	'ube-contact-form-' . esc_attr( $element->get_id() ),
	'ube-contact-form-7-button-' . $settings['button_width_type'],
);

$element->add_render_attribute( 'contact-form', 'class', $classes );

if ( ! empty( $settings['contact_form_list'] ) ) :
	?>
    <div class="ube-contact-form-7-wrapper">
        <div <?php echo $element->get_render_attribute_string( 'contact-form' ) ?>>
			<?php
			echo do_shortcode( '[contact-form-7 id="' . $settings['contact_form_list'] . '" ]' );
			?>
        </div>
    </div>
<?php
endif;