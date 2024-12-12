<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @var $element UBE_Element_Flip_Box
 */

use Elementor\Group_Control_Image_Size;
use Elementor\Icons_Manager;

$fix_box_tag      = 'span';
$fix_box_back_tag = 'div';

$settings = $element->get_settings_for_display();

$flip_box_wrapper = array(
	'ube-flip-box',
	'position-relative',
	'ube-flip-effect-' . $settings['flip_effect'],
	'direction-' . $settings['flip_direction'],
);

$element->add_render_attribute( 'flip_box_wrapper', 'class', $flip_box_wrapper );

$ube_front = array(
	'ube-flip-box-front',
	'ube-flip-box-layer',
	'd-flex',
	'position-absolute',
	'w-100',
	'h-100',
	$settings['alignment_front'],
);
if ( $settings['view_front'] !== '' ) {
	$ube_front[] = 'elementor-view-' . $settings['view_front'];
}
if ( $settings['shape_front'] !== '' ) {
	$ube_front[] = 'elementor-shape-' . $settings['shape_front'];
}
$element->add_render_attribute( 'ube-front', 'class', $ube_front);

$ube_back = array(
	'ube-flip-box-back',
	'ube-flip-box-layer',
	'd-flex',
	'position-absolute',
	'w-100',
	'h-100',
	$settings['alignment_back'],
);
if ( $settings['view_back'] !== '' ) {
	$ube_back[] = 'elementor-view-' . $settings['view_back'];
}
if ( $settings['shape_back'] !== '' ) {
	$ube_back[] = 'elementor-shape-' . $settings['shape_back'];
}
$element->add_render_attribute( 'ube-back', 'class',$ube_back) ;

if ( $settings['flip_box_3d'] === 'yes' ) {
	$element->add_render_attribute( 'flip_box_wrapper', 'class', 'ube-flip-3d' );
}

$element->add_render_attribute( 'ube-flip-content', 'class', array(
	'ube-flip-content',
) );

if ( ! empty( $settings['link']['url'] ) && $settings['link_click'] === 'box' ) {
	$element->add_link_attributes( 'ube-back', $settings['link'] );
	$element->add_render_attribute( 'ube-back', 'class', 'd-block' );
	$fix_box_back_tag = 'a';
}

$fix_box_button = array(
	'btn',
	'btn-outline-light',
	'btn-' . $settings['button_size'],
);

if ( ! empty( $settings['link']['url'] ) && $settings['link_click'] === 'button' ) {
	$element->add_link_attributes( 'fix_box_button', $settings['link'] );
	$fix_box_tag = 'a';
}
$element->add_render_attribute( 'fix_box_button', 'class', $fix_box_button );

$title_class_front = array('ube-flip-box-title');
if ($settings['heading_title_size_front'] !== '') {
	$title_class_front[] = 'ube-heading-title';
	$title_class_front[] = 'ube-heading-size-' . $settings['heading_title_size_front'];
}

if (!empty($settings['title_class_front'])) {
	$title_class_front[] = $settings['title_class_front'];
}

$desc_class_front = array('ube-flip-box-description');
if (!empty($settings['desc_class_front'])) {
	$desc_class_front[] = $settings['desc_class_front'];
}




$title_class_back = array('ube-flip-box-title');
if ($settings['heading_title_size_back'] !== '') {
	$title_class_back[] = 'ube-heading-title';
	$title_class_back[] = 'ube-heading-size-' . $settings['heading_title_size_back'];
}

if (!empty($settings['title_class_back'])) {
	$title_class_back[] = $settings['title_class_back'];
}

$desc_class_back = array('ube-flip-box-description');
if (!empty($settings['desc_class_back'])) {
	$desc_class_back[] = $settings['desc_class_back'];
}

$title_tag_front = Elementor\Utils::validate_html_tag(isset($settings['title_tag_front']) ? $settings['title_tag_front'] : 'h3');
$title_tag_back = Elementor\Utils::validate_html_tag(isset($settings['title_tag_back']) ? $settings['title_tag_back'] : 'h3');

?>
<div <?php echo $element->get_render_attribute_string( 'flip_box_wrapper' ) ?>>
    <div <?php echo $element->get_render_attribute_string( 'ube-front' ) ?>>
        <div <?php echo $element->get_render_attribute_string( 'ube-flip-content' ) ?>>
			<?php if ( 'image' === $settings['flip_box_graphic'] && ! empty( $settings['image_front']['url'] ) ) : ?>
                <div class="ube-flip-flip-image d-inline-block">
					<?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'image_front_size', 'image_front' ); ?>
				</div>
			<?php endif; ?>
			<?php if ( 'icon' === $settings['flip_box_graphic'] && ! empty( $settings['icon_front']['value'] ) ) : ?>
                <div class="ube-flip-box-icon">
	                <div class="elementor-icon">
		                <?php Icons_Manager::render_icon( $settings['icon_front'] ); ?>
	                </div>
				</div>
			<?php endif; ?>
			<?php if ( ! empty( $settings['title_front'] ) ) {
				$element->add_render_attribute( 'title_tag_front_attr', 'class', $title_class_front );
				printf( '<%1$s %2$s>', $title_tag_front, $element->get_render_attribute_string( 'title_tag_front_attr' ) );
				echo esc_html( $settings['title_front'] );
				printf( '</%1$s>', $title_tag_front );
			} ?>
			<?php if ( ! empty( $settings['description_front'] ) ) : ?>
				<?php $element->add_render_attribute( 'desc_tag_front_attr', 'class', $desc_class_front ); ?>
                <div <?php $element->print_render_attribute_string('desc_tag_front_attr') ?>><?php echo esc_html($settings['description_front']) ?></div>
			<?php endif; ?>
        </div>
    </div>
	<?php printf( '<%1$s %2$s>', $fix_box_back_tag, $element->get_render_attribute_string( 'ube-back' ) ); ?>
    <div <?php echo $element->get_render_attribute_string( 'ube-flip-content' ) ?>>
		<?php if ( 'image' === $settings['flip_box_graphic_back'] && ! empty( $settings['image_back']['url'] ) ) : ?>
            <div class="ube-flip-flip-image d-inline-block">
				<?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'image_back_size', 'image_back' ); ?>
			</div>
		<?php endif; ?>
		<?php if ( 'icon' === $settings['flip_box_graphic_back'] && ! empty( $settings['icon_back']['value'] ) ) : ?>
            <div class="ube-flip-box-icon">
	            <div class="elementor-icon">
					<?php Icons_Manager::render_icon( $settings['icon_back'] ); ?>
	            </div>
			</div>
		<?php endif; ?>
		<?php if ( ! empty( $settings['title_back'] ) ) {
			$element->add_render_attribute( 'title_tag_back_attr', 'class', $title_class_back );
			printf( '<%1$s %2$s>', $title_tag_back, $element->get_render_attribute_string( 'title_tag_back_attr' ) );
			echo esc_html( $settings['title_back'] );
			printf( '</%1$s>', $title_tag_back );
		} ?>
		<?php if ( ! empty( $settings['description_back'] ) ) : ?>
			<?php $element->add_render_attribute( 'desc_tag_back_attr', 'class', $desc_class_back ); ?>
            <div <?php $element->print_render_attribute_string('desc_tag_back_attr') ?>><?php echo esc_html($settings['description_back']) ?></div>
		<?php endif; ?>
		<?php if ( ! empty( $settings['button_text'] ) ) {
			printf( '<%1$s %2$s>', $fix_box_tag, $element->get_render_attribute_string( 'fix_box_button' ) );
			echo esc_html( $settings['button_text'] );
			printf( '</%1$s>', $fix_box_tag );
		} ?>
    </div>
	<?php printf( '</%1$s>', $fix_box_back_tag ); ?>
</div>