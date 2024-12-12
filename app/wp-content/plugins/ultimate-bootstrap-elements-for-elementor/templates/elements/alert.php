<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Utils;

/**
 * @var $element UBE_Element_Alert
 */
$settings = $element->get_settings_for_display();

$wrapper_classes = array(
	'ube-alert',
	'alert',
);

$element->add_render_attribute( 'wrapper', 'role', 'alert' );

if ( ! empty( $settings['scheme'] ) ) {
	$wrapper_classes[] = "alert-{$settings['scheme']}";
}

if ( $settings['show_dismiss'] === 'show' ) {
	$wrapper_classes[] = 'alert-dismissible';
	$wrapper_classes[] = 'fade';
	$wrapper_classes[] = 'show';
}

$title_html_tag = Elementor\Utils::validate_html_tag(isset($settings['title_html_tag']) ? $settings['title_html_tag'] : 'h4');

$element->add_render_attribute( 'wrapper', 'class', $wrapper_classes );
?>
<div <?php echo $element->get_render_attribute_string( 'wrapper' ) ?>>
	<?php if ( ! Utils::is_empty( $settings['title'] ) ) : ?>
		<?php
		$element->add_inline_editing_attributes( 'title', 'none' );
		$element->add_render_attribute( 'title', 'class', 'alert-heading' );
		?>
		<?php
		printf( '<%1$s %2$s>', $title_html_tag, $element->get_render_attribute_string( 'title' ) );
		echo esc_html( $settings['title'] );
		printf( '</%1$s>', $title_html_tag );
		?>

	<?php endif; ?>
	<?php if ( ! Utils::is_empty( $settings['description'] ) ): ?>
		<?php
		$element->add_inline_editing_attributes( 'description', 'advanced' );
		$element->add_render_attribute( 'description', 'class', 'alert-description' );
		?>
        <div <?php echo $element->get_render_attribute_string( 'description' ) ?>>
			<?php echo $element->parse_text_editor( $settings['description'] ) ?>
        </div>
	<?php endif; ?>
	<?php if ( $settings['show_dismiss'] === 'show' ): ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="<?php esc_attr_e('Close','ube')?>">
            <span aria-hidden="true">&times;</span>
        </button>
	<?php endif; ?>
</div>