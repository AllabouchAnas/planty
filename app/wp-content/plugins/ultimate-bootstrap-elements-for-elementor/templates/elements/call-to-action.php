<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Icons_Manager;
use \Elementor\Group_Control_Image_Size;

/**
 * @var $element UBE_Element_Call_To_Action
 */

$settings = $element->get_settings_for_display();

$call_to_action_tag = 'button';

if ( ! empty( $settings['call_to_action_link']['url'] ) ) {
	$element->add_link_attributes( 'call_to_action_button', $settings['call_to_action_link'] );
	$call_to_action_tag = 'a';
}

$element->add_render_attribute( 'call_to_action_wrapper', 'class', 'ube-call-to-action' );

$button_classes = array(
	'ube-call-to-action-btn',
	'btn',
	'btn-pos-' . $settings['position_button'],
	"btn-{$settings['call_to_action_button_size']}",
	"btn-{$settings['call_to_action_button_shape']}",
);
if ( $settings['call_to_action_button_type'] !== '' ) {
	$button_classes[] = "btn-{$settings['call_to_action_button_type']}";
}

if ( $settings['call_to_action_button_type'] === 'outline' ) {
	$button_classes[] = "btn-outline-{$settings['call_to_action_button_scheme']}";
} else {
	$button_classes[] = "btn-{$settings['call_to_action_button_scheme']}";
}

if (!empty($settings['icon']) && !empty($settings['icon']['value'])) {
	$button_classes[] = "ube-btn-icon-{$settings['icon_align']}";
}

$element->add_render_attribute( 'call_to_action_button', 'class', $button_classes );
$element->add_render_attribute( 'ube_content', 'class', 'ube-call-to-action-content' );


if ( $settings['position_button'] == 'left' || $settings['position_button'] == 'right' ) {
	$element->add_render_attribute( 'ube_content', 'class', 'media-body' );
	$element->add_render_attribute( 'call_to_action_wrapper', 'class', 'media' );
}
if ( $settings['position_button'] == 'left' ) {
	$element->add_render_attribute( 'call_to_action_wrapper', 'class', 'flex-row-reverse' );
}

$title_class = array(
	'ube-call-to-action-title',
	'ube-heading-title'
);
if ($settings['call_to_action_title_size'] !== '') {
	$title_class[] = 'ube-heading-size-' . $settings['call_to_action_title_size'];
}

if (isset($settings['title_class']) && !empty($settings['title_class'])) {
	$title_class[] = $settings['title_class'];
}

$desc_classes = array('ube-call-to-action-description');
if (isset($settings['description_class']) && !empty($settings['description_class'])) {
	$desc_classes[] = $settings['description_class'];
}

$call_to_action_title_tag = Elementor\Utils::validate_html_tag(isset($settings['call_to_action_title_tag']) ? $settings['call_to_action_title_tag'] : 'h2' );

$element->add_render_attribute( 'call_to_action_desc_attr', 'class',$desc_classes );

?>
<div <?php echo $element->get_render_attribute_string( 'call_to_action_wrapper' ) ?>>
	<?php if ( ! empty( $settings['call_to_action_button'] ) && $settings['position_button'] == 'top' ) {
		printf( '<%1$s %2$s>', $call_to_action_tag, $element->get_render_attribute_string( 'call_to_action_button' ) );?>
			<?php if (!empty($settings['icon']) && !empty($settings['icon']['value']) && ($settings['icon_align'] === 'left')): ?>
				<?php Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>
			<?php endif; ?>
			<?php echo esc_html( $settings['call_to_action_button'] ); ?>
			<?php if (!empty($settings['icon']) && !empty($settings['icon']['value']) && ($settings['icon_align'] === 'right')): ?>
				<?php Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>
			<?php endif; ?>
		<?php printf( '</%1$s>', $call_to_action_tag );
	} ?>
    <div <?php echo $element->get_render_attribute_string( 'ube_content' ) ?>>
		<?php if ( ! empty( $settings['call_to_action_title'] ) ) {
			$element->add_render_attribute( 'call_to_action_title_attr', 'class',$title_class );
			printf( '<%1$s %2$s>', $call_to_action_title_tag, $element->get_render_attribute_string( 'call_to_action_title_attr' ) );
			echo wp_kses_post( $settings['call_to_action_title'] );
			printf( '</%1$s>', $call_to_action_title_tag );
			?>
		<?php } ?>
		<?php if ( ! empty( $settings['call_to_action_description'] ) ) { ?>
            <p <?php $element->print_render_attribute_string('call_to_action_desc_attr') ?>><?php echo esc_html($settings['call_to_action_description']) ?></p>
		<?php } ?>
    </div>
	<?php if ( ! empty( $settings['call_to_action_button'] ) && $settings['position_button'] !== 'top' ) {
		printf( '<%1$s %2$s>', $call_to_action_tag, $element->get_render_attribute_string( 'call_to_action_button' ) );?>
			<?php if (!empty($settings['icon']) && !empty($settings['icon']['value']) && ($settings['icon_align'] === 'left')): ?>
				<?php Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>
			<?php endif; ?>
			<?php echo esc_html( $settings['call_to_action_button'] ); ?>
			<?php if (!empty($settings['icon']) && !empty($settings['icon']['value']) && ($settings['icon_align'] === 'right')): ?>
				<?php Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>
			<?php endif; ?>
		<?php printf( '</%1$s>', $call_to_action_tag );
		?>
	<?php } ?>
</div>

