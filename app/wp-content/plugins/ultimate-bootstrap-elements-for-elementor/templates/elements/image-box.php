<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Control_Media;
use Elementor\Group_Control_Image_Size;
use Elementor\Widget_Base;

/**
 * @var $element Elementor\Widget_Base
 * @var $item_key
 * @var $image_box_link
 * @var $image_html
 * @var $title
 * @var $title_tag
 * @var $title_class
 * @var $description
 * @var $description_pos
 * @var $description_class
 * @var $hover_animation
 * @var $hover_image_animation
 * @var $image_hover
 * @var $image_switcher
 */

if (!isset($item_key)) {
	$item_key = '';
}

$wrapper_classes = array(
	'ube-image-box',
	'ube-icon-box',
);

if ( ! empty( $hover_animation) ) {
	$wrapper_classes[] = 'ube-image-hover-' . $hover_animation;
}
if ( ! empty( $hover_image_animation ) ) {
	$wrapper_classes[] = 'ube-image-hover-' . $hover_image_animation;
}
if ( ! empty( $image_switcher ) ) {
	$wrapper_classes[] = 'ube-hover-image';
}

$image_tag       = 'span';

$element->add_render_attribute("wrapper{$item_key}",'class', $wrapper_classes);

if ( ! empty( $image_box_link['url'] ) ) {
	$element->add_link_attributes( "image_link{$item_key}", $image_box_link);
	$element->add_link_attributes( "title{$item_key}", $image_box_link);
	$image_tag = 'a';
}

$title_classes = array('ube-ib-title', 'mb-0');
if (isset($title_class)) {
	$title_classes[] = $title_class;
}

$description_classes = array('ube-ib-desc', 'mb-0');
if (isset($description_class)) {
	$description_classes[] = $description_class;
}
$element->add_render_attribute( "image_link{$item_key}", 'class', 'card-img' );
?>
<div class="ube-icon-box-wrapper">
	<div <?php $element->print_render_attribute_string("wrapper{$item_key}") ?>>
		<?php if (!empty($image_html)): ?>
			<div class="ube-ib-icon ube-image">
				<?php printf( '<%1$s %2$s>%3$s %4$s</%1$s>', $image_tag, $element->get_render_attribute_string( "image_link{$item_key}" ),$image_html,$image_hover );?>
			</div>
		<?php endif; ?>
		<?php if (!empty($title) || !empty($description)): ?>
			<div class="ube-ib-content">
				<?php if (!empty($title)){
					printf( '<%1$s class="%5$s"><%2$s %3$s>%4$s</%2$s></%1$s>',$title_tag, $image_tag, $element->get_render_attribute_string( "title{$item_key}" ),$title, join(' ', $title_classes) );
				} ?>
				<?php if (!empty($description) && ($description_pos === 'inset')): ?>
					<div class="<?php echo esc_attr(join(' ', $description_classes))?>"><?php echo wp_kses_post($description)?></div>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
	<?php if (!empty($description) && ($description_pos === 'outset')): ?>
		<div class="<?php echo esc_attr(join(' ', $description_classes))?>"><?php echo wp_kses_post($description)?></div>
	<?php endif; ?>
</div>

