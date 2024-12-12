<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $product_tabs
 * @var $tabs_align
 * @var $columns
 * @var $columns_md
 * @var $columns_sm
 * @var $columns_xs
 * @var $columns_mb
 * @var $columns_gutter
 * @var $products_per_page
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
 * @var $this WPBakeryShortCode_GSF_Product_Tabs
 */

$product_tabs = $tabs_align = $columns = $columns_md = $columns_sm = $columns_xs = $columns_mb = $columns_gutter = $products_per_page = $is_slider = $rows =
    $dots = $nav = $nav_position = $nav_size =  $nav_hover_style = $nav_style = $autoplay = $autoplay_timeout = $product_paging = $product_animation = $css_animation = $animation_duration = $animation_delay = $el_class = $css = $responsive = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$wrapper_classes = array(
	'woocommerce',
	'gsf-product_tabs',
    $tabs_align,
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

$query_args = array();
$tabs = (array)vc_param_group_parse_atts($product_tabs);
$tabs_args = array();
if(count($tabs) > 0) {
    foreach ($tabs as $tab) {
        $tab_args = array(
            'posts_per_page' => intval($products_per_page),
            'no_found_rows' => true,
            'post_status' => 'publish',
            'post_type' => 'product',
            'tax_query'      => array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'product_visibility',
                    'field'    => 'term_taxonomy_id',
                    'terms'    => is_search() ? $product_visibility_term_ids['exclude-from-search'] : $product_visibility_term_ids['exclude-from-catalog'],
                    'operator' => 'NOT IN',
                )
            ),
            'post_parent'  => 0
        );
        if('none' === $product_paging) {
            $query_args['no_found_rows']  = 1;
        }
        if (!empty($tab['category'])) {
            $tab_args['tax_query'][] = array(
                'taxonomy' 		=> 'product_cat',
                'terms' 		=>  $tab['category'],
                'field' 		=> 'slug',
                'operator' 		=> 'IN'
            );
        }
        switch($tab['show']) {
            case 'sale':
                $product_ids_on_sale    = wc_get_product_ids_on_sale();
                $product_ids_on_sale[]  = 0;
                $tab_args['post__in'] = $product_ids_on_sale;
                break;
            case 'new-in':
                $tab_args['orderby'] = 'date';
                $tab_args['order'] = 'DESC';
                break;
            case 'featured':
                $tab_args['tax_query'][] = array(
                    'taxonomy' => 'product_visibility',
                    'field'    => 'term_taxonomy_id',
                    'terms'    => $product_visibility_term_ids['featured'],
                );
                break;
            case 'top-rated':
                $tab_args['meta_key'] = '_wc_average_rating';
                $tab_args['orderby'] = 'meta_value_num';
                $tab_args['order'] = 'DESC';
                $tab_args['meta_query'] = WC()->query->get_meta_query();
                $tab_args['tax_query'] = WC()->query->get_tax_query();
                break;
            case 'recent-review':
                add_filter( 'posts_clauses', array($this, 'order_by_comment_date_post_clauses' ) );
                break;
            case 'best-selling' :
                $tab_args['meta_key'] = 'total_sales';
                $tab_args['orderby'] = 'meta_value_num';
                break;
        }
        if (in_array($tab['show'],array('all','sale','featured'))) {
            $tab_args['order'] = $tab['order'];
            switch ( $tab['orderby'] ) {
                case 'price' :
                    $tab_args['meta_key'] = '_price';
                    $tab_args['orderby']  = 'meta_value_num';
                    break;
                case 'rand' :
                    $tab_args['orderby']  = 'rand';
                    break;
                case 'sales' :
                    $tab_args['meta_key'] = 'total_sales';
                    $tab_args['orderby']  = 'meta_value_num';
                    break;
                default :
                    $tab_args['orderby']  = 'date';
            }
        }

        if($tab['show'] =='recent-review' ){
            remove_filter( 'posts_clauses', array($this, 'order_by_comment_date_post_clauses' )  );
        }
        $tab_args = array(
            'title' => $tab['tab_title'],
            'query_args' => $tab_args
        );
        $tabs_args[] = $tab_args;
    }
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
    'post_type' => 'product'
);
$settings['tabs'] = $tabs_args;

if($product_animation !== '') {
    $settings['post_animation'] = $product_animation;
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
                '600' => array(
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
    if($nav_style == 'nav-square-text' || $nav_style == 'nav-circle-text') {
        $owl_args['navText'] = array('<i class="fal fa-angle-left"></i> <span>'.esc_html__( 'Prev', 'lustria-framework' ).'</span>', '<span>'.esc_html__( 'Next', 'lustria-framework' ).'</span> <i class="fal fa-angle-right"></i>');
    }

    if($nav === 'on') {
        $carousel_class .= ' ' . $nav_position. ' ' . $nav_style . ' ' .$nav_size. ' ' .$nav_hover_style;
    }
    if(!empty($carousel_class)) {
        $settings['carousel_class'] = $carousel_class;
    }
    $settings['carousel'] = $owl_args;
}

$class_to_filter = implode(' ', array_filter($wrapper_classes) );
$class_to_filter .= vc_shortcode_custom_css_class($css, ' ');
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);
?>
<div class="<?php echo esc_attr($css_class) ?>">
    <?php if (function_exists('G5Plus_Lustria')) {G5Plus_Lustria()->woocommerce()->archive_markup($query_args, $settings);}  ?>
</div>