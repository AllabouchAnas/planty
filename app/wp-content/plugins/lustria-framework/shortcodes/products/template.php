<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $show
 * @var $product_ids
 * @var $category
 * @var $show_category_filter
 * @var $cate_filter_align
 * @var $products_per_page
 * @var $offset
 * @var $columns
 * @var $columns_md
 * @var $columns_sm
 * @var $columns_xs
 * @var $columns_mb
 * @var $columns_gutter
 * @var $orderby
 * @var $order
 * @var $is_slider
 * @var $rows
 * @var $dots
 * @var $nav
 * @var $nav_position
 * @var $nav_size
 * @var $nav_style
 * @var $nav_hover_style
 * @var $autoplay
 * @var $autoplay_timeout
 * @var $product_paging
 * @var $product_animation
 * @var $css_animation
 * @var $animation_duration
 * @var $animation_delay
 * @var $el_class
 * @var $css
 * @var $responsive
 * Shortcode class
 * @var $this WPBakeryShortCode_GSF_Products
 */

$show = $product_ids = $category = $show_category_filter =
    $cate_filter_align = $products_per_page = $offset = $columns = $columns_md = $columns_sm = $columns_xs = $columns_mb = $columns_gutter = $orderby = $order = $is_slider = $rows =
    $dots = $nav = $nav_position = $nav_size =  $nav_hover_style = $nav_style = $autoplay = $autoplay_timeout = $product_paging = $product_animation = $css_animation = $animation_duration = $animation_delay = $el_class = $css = $responsive = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$wrapper_classes = array(
	'woocommerce',
	'gsf-products',
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

$product_visibility_term_ids = wc_get_product_visibility_term_ids();

$query_args = array(
    'posts_per_page' => intval($products_per_page),
    'post_status'    => 'publish',
    'post_type'      => 'product',
    'meta_query'     => array(),
    'tax_query'      => array(
        'relation' => 'AND',
    ),
);

if (!empty($offset)) {
    $query_args['offset'] = intval($offset);
}

if(($show != 'products')) {
    if (!empty($category)) {
        $query_args['tax_query'][] = array(
            'taxonomy' => 'product_cat',
            'terms' => explode(',', $category),
            'field' => 'slug',
            'operator' => 'IN'
        );
        $category = G5P()->helper()->get_term_ids_from_slugs(explode(',', $category), 'product_cat');
    }
} else {
    $category = array();
    $show_category_filter = '';
}
switch($show) {
    case 'sale':
        $product_ids_on_sale    = wc_get_product_ids_on_sale();
        $product_ids_on_sale[]  = 0;
        $query_args['post__in'] = $product_ids_on_sale;
        break;
    case 'new-in':
        $query_args['orderby'] = 'date';
        $query_args['order'] = 'DESC';
        break;
    case 'featured':
        $query_args['tax_query'][] = array(
            'taxonomy' => 'product_visibility',
            'field'    => 'term_taxonomy_id',
            'terms'    => $product_visibility_term_ids['featured'],
        );
        break;
    case 'top-rated':
        $query_args['meta_key'] = '_wc_average_rating';
        $query_args['orderby'] = 'meta_value_num';
        $query_args['order'] = 'DESC';
        $query_args['meta_query'] = WC()->query->get_meta_query();
        $query_args['tax_query'] = WC()->query->get_tax_query();
        break;
    case 'recent-review':
        add_filter( 'posts_clauses', array($this, 'order_by_comment_date_post_clauses' ) );
        break;
    case 'best-selling' :
        $query_args['meta_key'] = 'total_sales';
        $query_args['orderby'] = 'meta_value_num';
        break;
    case 'products':
        if ( ! empty( $product_ids ) ) {
            $product_ids = explode( ',', $product_ids );
            $query_args['post__in'] = $product_ids;
            $query_args['posts_per_page'] = -1;
            $query_args['orderby'] = 'post__in';
        }
        break;
}

if (in_array($show,array('all','sale','featured'))) {
	$query_args['order'] = $order;
	switch ( $orderby ) {
		case 'price' :
			$query_args['meta_key'] = '_price';
			$query_args['orderby']  = 'meta_value_num';
			break;
		case 'rand' :
			$query_args['orderby']  = 'rand';
			break;
		case 'sales' :
			$query_args['meta_key'] = 'total_sales';
			$query_args['orderby']  = 'meta_value_num';
			break;
		default :
			$query_args['orderby']  = 'date';
	}
}

if($show =='recent-review' ){
	remove_filter( 'posts_clauses', array($this, 'order_by_comment_date_post_clauses' )  );
}

$settings = array(
    'post_layout'            => 'grid',
    'post_columns'           => array(
        'xl' => $columns,
        'lg' => $columns_md,
        'md' => $columns_sm,
        'sm' => $columns_xs,
        '' => $columns_mb
    ),
    'post_columns_gutter'    => $columns_gutter,
    'post_paging'            => $product_paging,
    'itemSelector'           => 'article',
    'category_filter_enable' => false,
    'post_type' => 'product',
	'cat' => $category
);
if('none' === $product_paging) {
    $query_args['no_found_rows']  = 1;
}
if($product_animation !== '') {
    $settings['post_animation'] = $product_animation;
}
if('on' === $show_category_filter) {
    $settings['category_filter_enable'] = true;
    $settings['current_cat'] = -1;
    $wrapper_classes[] = $cate_filter_align;
}
$columns = intval($columns);
$columns_gutter = intval($columns_gutter);
$columns_md = intval($columns_md);
$columns_sm = intval($columns_sm);
$columns_xs = intval($columns_xs);
$columns_mb = intval($columns_mb);

if('on' === $is_slider) {
    $settings['post_paging'] = 'none';
    $carousel_class = '';
    if($rows == 1) {
        $owl_args = array(
            'items' => $columns,
            'margin' => $columns == 1 ? 0 : $columns_gutter,
            'slideBy' => $columns,
            'dots' => ($dots === 'on') ? true : false,
            'nav' => ($nav === 'on') ? true : false,
            'responsive' => array(
                '1200' => array(
                    'items' => $columns,
                    'margin' => $columns == 1 ? 0 : $columns_gutter,
                    'slideBy' => $columns,
                ),
                '992' => array(
                    'items' => $columns_md,
                    'margin' => $columns_md == 1 ? 0 : $columns_gutter,
                    'slideBy' => $columns_md,
                ),
                '768' => array(
                    'items' => $columns_sm,
                    'margin' => $columns_sm == 1 ? 0 : $columns_gutter,
                    'slideBy' => $columns_sm,
                ),
                '576' => array(
                    'items' => $columns_xs,
                    'margin' => $columns_xs == 1 ? 0 : $columns_gutter,
                    'slideBy' => $columns_xs,
                ),
                '0' => array(
                    'items' => $columns_mb,
                    'margin' => $columns_mb == 1 ? 0 : $columns_gutter,
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
        $carousel_class = 'carousel-gutter-'.$columns_gutter;
    }

    if($nav === 'on') {
        $carousel_class .= ' ' . $nav_position. ' ' . $nav_style . ' ' .$nav_size. ' ' .$nav_hover_scheme .' '.$nav_hover_style;
    }
    if(!empty($carousel_class)) {
        $settings['carousel_class'] = $carousel_class;
    }
    $settings['carousel'] = $owl_args;
}

$class_to_filter = implode(' ', array_filter($wrapper_classes) );
$class_to_filter .= vc_shortcode_custom_css_class($css, ' ');
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->getShortcode(), $atts);
?>
<div class="<?php echo esc_attr($css_class) ?>">
    <?php if (function_exists('G5Plus_Lustria')) {G5Plus_Lustria()->woocommerce()->archive_markup($query_args, $settings);}  ?>
</div>