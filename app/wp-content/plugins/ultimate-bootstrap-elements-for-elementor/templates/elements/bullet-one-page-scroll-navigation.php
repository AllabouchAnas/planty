<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @var $element
 * @var $element UBE_Element_Bullet_One_Page_Scroll_Navigation
 * @var $scrollspy_items
 * @var $dots_position
 */
$settings = $element->get_settings_for_display();
extract( $settings );
$wrapper_classes = array(
	'nav',
	'ube-nav',
	'bullet-one-page-scroll-navigation',
	'nav-dark',
);
if ( ! empty( $dots_position ) ) {
	$wrapper_classes[] = "alignment-{$dots_position}";
}


$element->add_render_attribute( 'scrollspy_wrapper', array(
	'class' => $wrapper_classes,
	'id'    => 'ube-main-nav'
) );

?>
<nav <?php echo $element->get_render_attribute_string( 'scrollspy_wrapper' ); ?>>
	<?php
	foreach ( $scrollspy_items as $value ):
		$skin = isset( $value['dots_skin'] ) ? $value['dots_skin'] : 'dark';
		?>
        <a href="#<?php echo esc_attr( $value['section_id'] ) ?>" data-skin="<?php echo esc_attr( $skin ) ?>"
           title="<?php echo esc_attr( isset( $value['section_title'] ) ? $value['section_title'] : '' ) ?>"
           class="nav-link"></a>
	<?php endforeach; ?>
</nav>
