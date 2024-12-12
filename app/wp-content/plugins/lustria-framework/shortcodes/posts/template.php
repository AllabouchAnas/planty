<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $post_layout
 * @var $image_size
 * @var $image_ratio
 * @var $image_ratio_custom_width
 * @var $image_ratio_custom_height
 * @var $image_masonry_width
 * @var $category
 * @var $tag
 * @var $ids
 * @var $orderby
 * @var $time_filter
 * @var $order
 * @var $meta_key
 * @var $posts_per_page
 * @var $show_cate_filter
 * @var $cate_filter_align
 * @var $post_columns_gutter
 * @var $is_slider
 * @var $rows
 * @var $dots
 * @var $nav
 * @var $nav_position
 * @var $nav_size
 * @var $nav_style
 * @var $nav_hover_scheme
 * @var $nav_hover_style
 * @var $autoplay
 * @var $autoplay_timeout
 * @var $columns
 * @var $columns_md
 * @var $columns_sm
 * @var $columns_xs
 * @var $columns_mb
 * @var $post_paging
 * @var $post_animation
 * @var $css_animation
 * @var $animation_duration
 * @var $animation_delay
 * @var $el_class
 * @var $css
 * @var $responsive
 * Shortcode class
 * @var $this WPBakeryShortCode_GSF_Posts
 */
$post_layout = $image_size = $image_ratio = $image_ratio_custom_width = $image_ratio_custom_height = $image_masonry_width = $category = $tag = $ids = $orderby = $time_filter =
$order = $meta_key = $posts_per_page = $show_cate_filter = $cate_filter_align
    = $post_columns_gutter = $is_slider = $rows = $dots = $nav = $nav_position = $nav_size = $nav_hover_scheme = $nav_hover_style = $nav_style = $autoplay = $autoplay_timeout = $columns = $columns_md = $columns_sm = $columns_xs
    = $columns_mb = $post_paging = $post_animation = $css_animation = $animation_duration = $animation_delay = $el_class = $css = $responsive = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

$wrapper_classes = array(
	'gf-posts',
    $cate_filter_align,
    'clearfix',
	G5P()->core()->vc()->customize()->getExtraClass($el_class),
	$this->getCSSAnimation($css_animation),
	vc_shortcode_custom_css_class( $css ),
	$responsive
);

if ('' !== $css_animation && 'none' !== $css_animation) {
	$animation_class = G5P()->core()->vc()->customize()->get_animation_class($animation_duration, $animation_delay);
	$wrapper_classes[] = $animation_class;
}

$args = array(
	'post_type'=> 'post',
	'ignore_sticky_posts' => true,
	'posts_per_page' => (is_numeric( $posts_per_page ) && $posts_per_page > 0) ? $posts_per_page : 10,
	'orderby' => $orderby,
	'order' => $order,
	'meta_key' => ( 'meta_value' == $orderby || 'meta_value_num' == $orderby ) ? $meta_key : ''
);
$category = G5P()->helper()->get_term_ids_from_slugs(explode(',', $category), 'category');
if (count($category) > 0) {
	$args['category__in'] = $category;
}
$tag = G5P()->helper()->get_term_ids_from_slugs(explode(',', $tag), 'post_tag');
if (count($tag) > 0) {
	$args['tag__in'] = $tag;
}
// Prepares time filter
if ( $time_filter !== 'none' ) {
	$args['date_query'] = $this ->get_time_filter_query( $time_filter );
}
if ( ! empty( $ids ) ) {
	$post_id_array = explode( ',', $ids );

	// Split ids into post_in and post_not_in
    $post_in = array();
    foreach ( $post_id_array as $post_id ) {
		$post_id = trim( $post_id );
		if ( is_numeric( $post_id ) ) {
			$post_in[] = $post_id;
		}
	}
	if ( ! empty( $post_in ) ) {
		$args['post__in'] = $post_in;
	}
}
$settings = array(
	'posts_per_page' => (is_numeric( $posts_per_page ) && $posts_per_page > 0) ? $posts_per_page : 10,
	'post_columns_gutter' => $post_columns_gutter,
	'post_layout' => $post_layout,
	'post_paging' => $post_paging,
	'cat' => $category,
    'post_columns' => array(
		'xl' => $columns,
		'lg' => $columns_md,
		'md' => $columns_sm,
		'sm' => $columns_xs,
		'' => $columns_mb,
	),
    'image_size' => $image_size,
    'image_ratio' => $image_ratio,
    'image_width' => array(
        'width' => intval($image_masonry_width)
    ),
    'image_ratio_custom' => array(
        'width' => intval($image_ratio_custom_width),
        'height' => intval($image_ratio_custom_height)
    )
);


if('none' === $post_paging) {
    $query_args['no_found_rows']  = 1;
}
if('on' === $show_cate_filter) {
    $settings['category_filter_enable'] = true;
    $settings['category_filter_vertical'] = false;
}
if($post_animation !== '') {
    $settings['post_animation'] = $post_animation;
}
$columns = intval($columns);
$post_columns_gutter = intval($post_columns_gutter);
$columns_md = intval($columns_md);
$columns_sm = intval($columns_sm);
$columns_xs = intval($columns_xs);
$columns_mb = intval($columns_mb);
if(in_array($post_layout, array('large-image','medium-image'))) {
    $columns = $columns_md = $columns_sm = $columns_xs = $columns_mb = 1;
}
if('on' === $is_slider) {
    $settings['post_paging'] = 'none';
    $carousel_class = '';
    if($rows == 1) {
        $owl_args = array(
            'items' => $columns,
            'margin' => $columns == 1 ? 0 : $post_columns_gutter,
            'slideBy' => $columns,
            'dots' => ($dots === 'on') ? true : false,
            'nav' => ($nav === 'on') ? true : false,
            'responsive' => array(
                '1200' => array(
                    'items' => $columns,
                    'margin' => $columns == 1 ? 0 : $post_columns_gutter,
                    'slideBy' => $columns,
                ),
                '992' => array(
                    'items' => $columns_md,
                    'margin' => $columns_md == 1 ? 0 : ($post_columns_gutter > 30 ? 30 : $post_columns_gutter),
                    'slideBy' => $columns_md,
                ),
                '768' => array(
                    'items' => $columns_sm,
                    'margin' => $columns_sm == 1 ? 0 : ($post_columns_gutter > 30 ? 30 : $post_columns_gutter),
                    'slideBy' => $columns_sm,
                ),
                '600' => array(
                    'items' => $columns_xs,
                    'margin' => $columns_xs == 1 ? 0 : ($post_columns_gutter > 30 ? 30 : $post_columns_gutter),
                    'slideBy' => $columns_xs,
                ),
                '0' => array(
                    'items' => $columns_mb,
                    'margin' => $columns_mb == 1 ? 0 : ($post_columns_gutter > 30 ? 30 : $post_columns_gutter),
                    'slideBy' => $columns_mb,
                )
            ),
            'autoHeight' => true,
            'autoplay' => ($autoplay === 'on') ? true : false,
            'autoplayTimeout' => intval($autoplay_timeout),
        );
    } else {
        $settings['itemSelector'] = '.owl-item-inner';
        $owl_args = array(
            'items' => 1,
            'margin' => 0,
            'slideBy' => 1,
            'dots' => ($dots === 'on') ? true : false,
            'nav' => ($nav === 'on') ? true : false,
            'autoHeight' => true,
            'autoplay' => ($autoplay === 'on') ? true : false,
            'autoplayTimeout' => intval($autoplay_timeout),
        );
        $settings['carousel_rows'] = array(
            'rows' => intval($rows),
            'items_show' => $rows*$columns
        );
        $carousel_class = 'carousel-gutter-'.$post_columns_gutter;
    }
    if($nav_style == 'nav-square-text' || $nav_style == 'nav-circle-text') {
        $owl_args['navText'] = array('<i class="far fa-angle-left"></i> <span>'.esc_html__( 'Prev', 'lustria-framework' ).'</span>', '<span>'.esc_html__( 'Next', 'lustria-framework' ).'</span> <i class="far fa-angle-right"></i>');
    }

    if($nav === 'on') {
        $carousel_class .= ' ' . $nav_position. ' ' . $nav_style . ' ' .$nav_size. ' ' .$nav_hover_scheme .' '.$nav_hover_style;
    }
    if(!empty($carousel_class)) {
        $settings['carousel_class'] = $carousel_class;
    }
    $settings['carousel'] = $owl_args;
}
$wrapper_class = implode(' ', array_filter($wrapper_classes));
?>
<div class="<?php echo esc_attr($wrapper_class) ?>">
	<?php if (function_exists('G5Plus_Lustria')){G5Plus_Lustria()->blog()->archive_markup($args, $settings);}  ?>
</div>