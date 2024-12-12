<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @var $element UBE_Element_Double_Button
 */

use Elementor\Icons_Manager;

$button_one_link = $button_two_link = 'span';

$settings = $element->get_settings_for_display();

$double_button_wapper = array(
	'ube-double-button',
	'd-flex',
);

if ( $settings['double_button_before_bg'] == 'yes' ) {
	$double_button_wapper[] = 'before_bg';
};

$element->add_render_attribute( 'double-button-wapper', 'class', $double_button_wapper );

$double_button_one = array(
	'btn',
	'btn-block',
	'ube-btn-one',
	'btn-' . $settings['double_button_size'],
	$settings['double_button_shape'],
);

$double_button_two = array(
	'btn',
	'btn-block',
	'ube-btn-two',
	'btn-' . $settings['double_button_size'],
	$settings['double_button_shape'],
);

$element->add_render_attribute( 'double-button-one', 'class', $double_button_one );
$element->add_render_attribute( 'double-button-two', 'class', $double_button_two );

if ( ! empty( $settings['button_one_link']['url'] ) ) {
	$element->add_link_attributes( 'double-button-one', $settings['button_one_link'] );
	$button_one_link = 'a';
}
if ( ! empty( $settings['button_two_link']['url'] ) ) {
	$element->add_link_attributes( 'double-button-two', $settings['button_two_link'] );
	$button_two_link = 'a';
}
$element->add_render_attribute( 'double-middle-text', 'class', 'ube-middle-text' );
?>
<div <?php echo $element->get_render_attribute_string( 'double-button-wapper' ) ?>>
	<?php if ( ! empty( $settings['button_one_text'] ) ) :
		printf( '<%1$s %2$s>', $button_one_link, $element->get_render_attribute_string( 'double-button-one' ) );
		if ( ! empty( $settings['button_one_icon']['value'] ) ) :?>
            <?php Icons_Manager::render_icon( $settings['button_one_icon'] ); ?>
		<?php endif;
		echo esc_html( $settings['button_one_text'] );
		printf( '</%1$s>', $button_one_link );
	endif; ?>

	<?php if ( ! empty( $settings['button_middle_text'] ) ) : ?>
        <span <?php echo $element->get_render_attribute_string( 'double-middle-text' ) ?>>
			<?php echo esc_html($settings['button_middle_text']) ?>
		</span>
	<?php endif; ?>

	<?php if ( ! empty( $settings['button_two_text'] ) ) :
		printf( '<%1$s %2$s>', $button_two_link, $element->get_render_attribute_string( 'double-button-two' ) );
		if ( ! empty( $settings['button_two_icon']['value'] ) ) :?>
           <?php Icons_Manager::render_icon( $settings['button_two_icon'] ); ?>
		<?php endif;
		echo esc_html( $settings['button_two_text'] );
		printf( '</%1$s>', $button_two_link );
	endif; ?>
</div>
