<?php
// Do not allow directly accessing this file.
use Elementor\Icons_Manager;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $socials array
 * @var $element Elementor\Widget_Base
 */
?>
<div class="ube-tm-social">
	<?php foreach ( $socials as $index => $item ) {
		$item_classes = array(
			'elementor-icon'
		);
		$item_id  = $item['_id'];
		$social_tag         = 'span';
		if ( ! empty( $item['social_link']['url'] ) ) {
			$element->add_link_attributes( "social_item_{$item_id}", $item['social_link'] );
			$social_tag = 'a';
		}
		$element->add_render_attribute( "social_item_{$item_id}", 'class', $item_classes );
		printf( '<%1$s %2$s>', $social_tag, $element->get_render_attribute_string( "social_item_{$item_id}" ) );
		Icons_Manager::render_icon( $item['social_icon'] );
		printf( '</%1$s>', $social_tag );
	} ?>
</div>
