<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Group_Control_Image_Size;

/**
 * @var $element UBE_Element_Client_Logo
 */

$settings = $element->get_settings_for_display();

$client_logo_classes = array(
	'ube-client-logo',
);
$element->add_render_attribute( 'client_logo_classes', 'class', $client_logo_classes );

$item_class = array(
	'ube-item-client-logo',
	'd-flex'
);

if ( $settings['client_logo_hover'] !== '' ) {
	$item_class[] = 'ube-client-logo-hover-' . $settings['client_logo_hover'];
}

if ( $settings['client_logo_content_alignment'] !== '' ) {
	$item_class[] = $settings['client_logo_content_alignment'];
}

$tag_html = 'div';
if ( $settings['client_logo_link']['url'] !== '' ) {
	$tag_html = 'a';
	$element->add_link_attributes( 'item_class', $settings['client_logo_link'] );
}

$element->add_render_attribute( 'item_class', 'class', $item_class );
$image_meta = ube_get_img_meta( $settings['client_logo_logo']['id'] );
?>

<div <?php echo $element->get_render_attribute_string( 'client_logo_classes' ) ?>>
	<?php
	printf( '<%1$s %2$s>', $tag_html, $element->get_render_attribute_string( 'item_class' ) );
	if ( $settings['client_logo_logo']['url'] !== '' ) : ?>
        <img src="<?php echo esc_url( $settings['client_logo_logo']['url'] ) ?>"
             alt="<?php echo esc_attr( $image_meta['alt'] ) ?>">
	<?php endif;
	printf( '</%1$s>', $tag_html ); ?>
</div>