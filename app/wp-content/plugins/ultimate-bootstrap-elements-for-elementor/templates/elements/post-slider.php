<?php

use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @var $element UBE_Element_Post_Slider
 */

$settings    = $element->get_settings_for_display();
$args        = ube_get_query_args( $settings );
$nonce_field = wp_create_nonce( 'ube_load_post' );

$slides_to_show        = empty( $settings['slides_to_show'] ) ? 1 : $settings['slides_to_show'];
$slides_to_show_tablet = $settings['slides_to_show_tablet'] == '' ? $slides_to_show : $settings['slides_to_show_tablet'];
$slides_to_show_mobile = $settings['slides_to_show_mobile'] == '' ? $slides_to_show_tablet : $settings['slides_to_show_mobile'];

$navigation_arrow        = $settings['navigation_arrow'];
$navigation_arrow_tablet = $settings['navigation_arrow_tablet'] == '' ? $navigation_arrow : $settings['navigation_arrow_tablet'];
$navigation_arrow_mobile = $settings['navigation_arrow_mobile'] == '' ? $navigation_arrow_tablet : $settings['navigation_arrow_mobile'];

$navigation_dots        = $settings['navigation_dots'];
$navigation_dots_tablet = $settings['navigation_dots_tablet'] == '' ? $navigation_dots : $settings['navigation_dots_tablet'];
$navigation_dots_mobile = $settings['navigation_dots_mobile'] == '' ? $navigation_dots_tablet : $settings['navigation_dots_mobile'];

$center_padding        = $settings['center_padding'];
$center_padding_tablet = $settings['center_padding_tablet'] == '' ? $center_padding : $settings['center_padding_tablet'];
$center_padding_mobile = $settings['center_padding_mobile'] == '' ? $center_padding_tablet : $settings['center_padding_mobile'];

$slide_rows        = $settings['slide_rows'];
$slide_rows_tablet = $settings['slide_rows_tablet'] == '' ? $slide_rows : $settings['slide_rows_tablet'];
$slide_rows_mobile = $settings['slide_rows_mobile'] == '' ? $slide_rows_tablet : $settings['slide_rows_mobile'];

$slides_per_row        = $settings['slides_per_row'];
$slides_per_row_tablet = $settings['slides_per_row_tablet'] == '' ? $slides_per_row : $settings['slides_per_row_tablet'];
$slides_per_row_mobile = $settings['slides_per_row_mobile'] == '' ? $slides_per_row_tablet : $settings['slides_per_row_mobile'];

$wrapper_classes= array('slick-slider ube-slider manual');
if ( ! empty( $settings['slider_arrows_position'] ) ) {
	$wrapper_classes[] = 'ube-slider-arrow-position-' . $settings['slider_arrows_position'];
}
if ( ! empty( $settings['dots_position'] ) ) {
	$wrapper_classes[] = 'ube-slider-dot-position-' . $settings['dots_position'];
}
if ( ! empty( $settings['slider_arrows_type'] ) ) {
	$wrapper_classes[] = 'ube-slider-arrow-type-' . $settings['slider_arrows_type'];
}
if ( ! empty( $settings['slider_arrows_size'] ) ) {
	$wrapper_classes[] = 'ube-slider-arrow-size-' . $settings['slider_arrows_size'];
}
if ( ! empty( $settings['slider_arrows_shape'] ) ) {
	$wrapper_classes[] = 'ube-slider-arrow-' . $settings['slider_arrows_shape'];
}

if ( ! empty( $settings['slider_dots_size'] ) ) {
	$wrapper_classes[] = 'ube-slider-dots-' . $settings['slider_dots_size'];
}


$slick_options = array(
	'vertical'        => $settings['slider_type'] === 'vertical',
	'verticalSwiping' => $settings['slider_type'] === 'vertical',
	'slidesToShow'    => intval( $slides_to_show ),
	'slidesToScroll'  => $settings['single_slide_scroll'] === 'on' ? 1 : intval( $slides_to_show ),
	'centerMode'      => $settings['center_mode'] === 'on',
	'centerPadding'   => $center_padding,
	'arrows'          => $navigation_arrow === 'on',
	'dots'            => $navigation_dots === 'on',
	'infinite'        => ( $settings['center_mode'] === 'on' ) ? true : ( $settings['infinite_loop'] === 'on' ),
	'adaptiveHeight'  => $settings['adaptive_height'] === 'on',
	'speed'           => intval( $settings['transition_speed'] ),
	'autoplay'        => $settings['autoplay_enable'] === 'on',
	'pauseOnHover'    => $settings['pause_on_hover'] === 'on',
	'fade'            => $settings['fade_enabled'] === 'on',
	'rtl'             => $settings['rtl_mode'] === 'on',
	'focusOnSelect'   => $settings['focus_on_select'] === 'on',
	'draggable'       => true,
);
if ( ! empty( $autoplay_speed ) ) {
	$slick_options['autoplaySpeed'] = intval( $autoplay_speed );
}

if ( ( $settings['slider_syncing'] === 'on' ) && ( ! empty( $settings['slider_syncing_element'] ) ) ) {
	$slick_options['asNavFor'] = $settings['slider_syncing_element'];
}
if ( $settings['slider_arrows_position'] == 'vertical' ) {
	$slick_options['prevArrow'] = '<div class="slick-prev" aria-label="Previous"><i class="fas fa-chevron-up"></i></div>';
	$slick_options['nextArrow'] = '<div class="slick-next" aria-label="Next"><i class="fas fa-chevron-down"></i></div>';
}


$mobile_breakpoint_value = \Elementor\Plugin::$instance->breakpoints->get_breakpoints( 'mobile' )->get_value();
$tablet_breakpoint_value = \Elementor\Plugin::$instance->breakpoints->get_breakpoints( 'tablet' )->get_value();

$tablet_settings = array(
	'slidesToShow'   => intval( $slides_to_show_tablet ),
	'slidesToScroll' => $settings['single_slide_scroll'] === 'on' ? 1 : intval( $slides_to_show_tablet ),
	'centerPadding'  => $center_padding_tablet,
	'arrows'         => $navigation_arrow_tablet === 'on',
	'dots'           => $navigation_dots_tablet === 'on',
);

$mobile_settings = array(
	'slidesToShow'   => intval( $slides_to_show_mobile ),
	'slidesToScroll' => $settings['single_slide_scroll'] === 'on' ? 1 : intval( $slides_to_show_mobile ),
	'centerPadding'  => $center_padding_mobile,
	'arrows'         => $navigation_arrow_mobile === 'on',
	'dots'           => $navigation_dots_mobile === 'on',
);

if ( $settings['grid_mode'] === 'on' ) {
	$slick_options['rows']         = intval( $slide_rows );
	$slick_options['slidesPerRow'] = intval( $slides_per_row );

	$tablet_settings['rows']         = intval( $slide_rows_tablet );
	$tablet_settings['slidesPerRow'] = intval( $slides_per_row_tablet );

	$mobile_settings['rows']         = intval( $slide_rows_mobile );
	$mobile_settings['slidesPerRow'] = intval( $slides_per_row_mobile );
}

$responsive = array(
	array(
		'breakpoint' => ( $tablet_breakpoint_value + 1 ),
		'settings'   => $tablet_settings
	),
	array(
		'breakpoint' => ( $mobile_breakpoint_value + 1 ),
		'settings'   => $mobile_settings
	)
);

$slick_options['responsive'] = $responsive;

$element->add_render_attribute( 'post_list_wrapper', 'data-slick-options', json_encode( $slick_options ) );

$btn_class = array(
	'btn',
	"btn-{$settings['read_more_button_size']}",
	"btn-{$settings['read_more_button_shape']}",
);

if ( $settings['read_more_button_type'] === '' || $settings['read_more_button_type'] === '3d' ) {
	$btn_class[] = "btn-{$settings['read_more_button_scheme']}";
}

if ( $settings['read_more_button_type'] === 'outline' ) {
	$btn_class[] = "btn-outline-{$settings['read_more_button_scheme']}";
}

if ( $settings['read_more_button_type'] !== '' ) {
	$btn_class[] = "btn-{$settings['read_more_button_type']}";
}

$post_layout_allow = array_keys(ube_get_post_grid_layout());
$post_layout = isset($settings['post_layout']) ? $settings['post_layout'] : 'post-grid-layout-01';
if (!in_array($post_layout,$post_layout_allow)) {
    $post_layout = 'post-grid-layout-01';
}

$settings_array = [
	'id'                                 => $element->get_id(),
	'show_image'                         => $settings['show_image'],
	'show_title'                         => $settings['show_title'],
	'show_excerpt'                       => $settings['show_excerpt'],
	'show_meta'                          => $settings['show_meta'],
	'excerpt_length'                     => intval( $settings['excerpt_length'], 10 ),
	'show_read_more_button'              => $settings['show_read_more_button'],
	'read_more_button_text'              => $settings['read_more_button_text'],
	'show_read_more_button_prefix_style' => $settings['show_read_more_button_prefix_style'],
	'read_more_button_text_suffix'       => $settings['read_more_button_text_suffix'],
	'excerpt_expansion_indicator'        => $settings['excerpt_expansion_indicator'],
	'orderby'                            => $settings['orderby'],
	'show_category'                      => $settings['show_category'],
	'category_length'                    => $settings['category_length'],
	'show_category_icon'                 => $settings['show_category_icon'],
	'show_author'                        => $settings['show_author'],
	'show_author_icon'                   => $settings['show_author_icon'],
	'show_avatar'                        => $settings['show_avatar'],
	'author_text_prefix'                 => $settings['author_text_prefix'],
	'show_date'                          => $settings['show_date'],
	'show_date_icon'                     => $settings['show_date_icon'],
	'date_text_prefix'                   => $settings['date_text_prefix'],
	'show_comment_count'                 => $settings['show_comment_count'],
	'show_comment_icon'                  => $settings['show_comment_icon'],
	'comment_text_suffix'                => $settings['comment_text_suffix'],
	'show_filter_category'               => $settings['show_filter_category'],
	'post_layout'                        => $post_layout,
	'column_class'                       => 'ube-post-grid-item',
	'image_size_mode'                    => $settings['image_size_mode'],
	'image_size_width'                   => $settings['image_size_width'],
	'image_size_height'                  => $settings['image_size_height'],
	'read_more_class'                    => implode( " ", $btn_class ),
];

$wrapper_classes[] = 'ube-posts ube-post-grid ube-posts-slider ube-post-appender';

$category_separate_style = '';
if ( $settings['show_category'] == 'yes' ) {
	$wrapper_classes[] = 'ube-post-list-category-separate-' . $settings['category_separate_style'];
}
if ( $settings['show_meta_separate'] == 'yes' ) {
	$wrapper_classes[] = 'ube-post-list-meta-separate';
}
if ( ! empty( $settings['hover_animation'] ) ) {
	$wrapper_classes[] = 'ube-post-image-hover-' . $settings['hover_animation'];
}
$element->add_render_attribute(
	'post_list_wrapper',
	[
		'id'    => 'ube-post-list-' . esc_attr( $element->get_id() ),
		'class' => $wrapper_classes,
	]
);
$total_page    = 1;
$post_per_page = $args['posts_per_page'];

if ( $post_per_page != 0 && $post_per_page != '' ) {
	$new_arg                   = $args;
	$new_arg['posts_per_page'] = - 1;
	$query                     = new \WP_Query( $new_arg );
	$post_count                = $query->post_count;
	$total_page                = ceil( $post_count / intval( $post_per_page ) );
	$paging_post_count         = $post_count;
}
?>
<?php if ( $settings['show_filter_category'] == 'yes' ) {
	ube_get_template( 'post/pagination/categories.php', array(
		'settings'       => $settings,
		'settings_array' => $settings_array,
		'nonce_field'    => $nonce_field,
		'posts_per_page' => $post_per_page
	) );
} ?>


<div <?php echo $element->get_render_attribute_string( 'post_list_wrapper' ) ?>>
	<?php echo ube_render_template_post( $args, $settings_array ) ?>
</div>
