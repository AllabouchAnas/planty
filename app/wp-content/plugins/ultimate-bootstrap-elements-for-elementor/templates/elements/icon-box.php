<?php

use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @var $element Elementor\Widget_Base
 * @var $item_key
 * @var $icon_box_link array
 * @var $icon_html
 * @var $hover_animation
 * @var $title
 * @var $title_tag
 * @var $title_class
 * @var $description
 * @var $description_pos
 * @var $description_class
 * @var $svg_animate array
 */
if (!isset($item_key)) {
	$item_key = '';
}

$wrapper_classes = array(
	'ube-icon-box',
);

$icon_tag       = 'span';

$icon_wrapper_classes = array(
	'ube-ib-icon',
);

$icon_classes = array(
	'elementor-icon',
);

if (!empty($hover_animation)) {
	$icon_classes[] = "elementor-animation-{$hover_animation}";
}

if (count($svg_animate) > 0) {
	$element->add_render_attribute( "wrapper{$item_key}", 'data-vivus', wp_json_encode($svg_animate) );
}

$element->add_render_attribute( "icon_wrapper{$item_key}", 'class', $icon_wrapper_classes );

$element->add_render_attribute( "icon{$item_key}", 'class', $icon_classes );

$element->add_render_attribute("wrapper{$item_key}",'class', $wrapper_classes);

if ( ! empty( $icon_box_link['url'] ) ) {
	$element->add_link_attributes( "icon{$item_key}", $icon_box_link);
	$element->add_link_attributes( "title{$item_key}", $icon_box_link);
	$icon_tag = 'a';
}

$title_classes = array('ube-ib-title', 'mb-0');
if (isset($title_class)) {
	$title_classes[] = $title_class;
}

$description_classes = array('ube-ib-desc', 'mb-0');
if (isset($description_class)) {
	$description_classes[] = $description_class;
}

?>
<div class="ube-icon-box-wrapper">
	<div <?php $element->print_render_attribute_string("wrapper{$item_key}") ?>>
		<?php if (!empty($icon_html)): ?>
			<div <?php $element->print_render_attribute_string("icon_wrapper{$item_key}") ?>>
				<?php printf( '<%1$s %2$s>%3$s</%1$s>', $icon_tag, $element->get_render_attribute_string( "icon{$item_key}" ),$icon_html ); ?>
			</div>
		<?php endif; ?>
		<?php if (!empty($title) || !empty($description)): ?>
			<div class="ube-ib-content">
				<?php if (!empty($title)){
					printf( '<%1$s class="%5$s"><%2$s %3$s>%4$s</%2$s></%1$s>',$title_tag, $icon_tag, $element->get_render_attribute_string( "title{$item_key}" ),$title, join(' ', $title_classes)  );
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

