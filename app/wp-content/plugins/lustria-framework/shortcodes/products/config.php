<?php
return array(
	'base' => 'gsf_products',
	'name' => esc_html__('Products','lustria-framework'),
	'icon' => 'fab fa-product-hunt',
    'category' => G5P()->shortcode()->get_category_name(),
	'params' =>  array_merge(
	    array(
            array(
                'type' => 'gsf_switch',
                'heading' => esc_html__('Category Filter', 'lustria-framework' ),
                'param_name' => 'show_category_filter',
                'std' => '',
                'dependency' => array('element' => 'show','value_not_equal_to' => array('products'))
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Category Filter Alignment', 'lustria-framework'),
                'param_name' => 'cate_filter_align',
                'value' => array(
                    esc_html__('Left', 'lustria-framework') => 'cate-filter-left',
                    esc_html__('Center', 'lustria-framework') => 'cate-filter-center',
                    esc_html__('Right', 'lustria-framework') => 'cate-filter-right'
                ),
                'std' => 'cate-filter-left',
                'dependency' => array('element'=>'show_category_filter', 'value'=> 'on'),
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Show', 'lustria-framework'),
                'param_name' => 'show',
                'value' => array(
                    esc_html__('All', 'lustria-framework') => 'all',
                    esc_html__('Sale Off', 'lustria-framework') => 'sale',
                    esc_html__('New In', 'lustria-framework') => 'new-in',
                    esc_html__('Featured', 'lustria-framework') => 'featured',
                    esc_html__('Top rated', 'lustria-framework') => 'top-rated',
                    esc_html__('Recent review', 'lustria-framework') => 'recent-review',
                    esc_html__('Best Selling', 'lustria-framework') => 'best-selling',
                    esc_html__('Narrow Products', 'lustria-framework') => 'products'
                )
            ),
            array(
                'type' => 'autocomplete',
                'heading' => esc_html__( 'Narrow Products', 'lustria-framework' ),
                'param_name' => 'product_ids',
                'settings' => array(
                    'multiple' => true,
                    'sortable' => true,
                    'unique_values' => true,
                ),
                'save_always' => true,
                'description' => esc_html__( 'Enter List of Products', 'lustria-framework' ),
                'dependency' => array('element' => 'show','value' => 'products'),
            ),
            G5P()->shortCode()->vc_map_add_product_narrow_categories(array(
                'dependency' => array('element' => 'show','value_not_equal_to' => array('products'))
            )),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Products Per Page', 'lustria-framework' ),
                'param_name' => 'products_per_page',
                'value' => 6,
                'admin_label' => true,
                'edit_field_class' => 'vc_col-sm-6 vc_column',
                'dependency' => array('element' => 'show','value_not_equal_to' => array('products'))
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Offset', 'lustria-framework' ),
                'param_name' => 'offset',
                'value' => '',
                'admin_label' => true,
                'edit_field_class' => 'vc_col-sm-6 vc_column',
                'dependency' => array('element' => 'show','value_not_equal_to' => array('products'))
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Columns Gutter', 'lustria-framework'),
                'param_name' => 'columns_gutter',
                'value' => G5P()->shortcode()->switch_array_key_value(G5P()->settings()->get_post_columns_gutter()),
                'std' => '40',
                'edit_field_class' => 'vc_col-sm-6 vc_column'
            ),

            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Order by', 'lustria-framework'),
                'param_name' => 'orderby',
                'value' => array(
                    esc_html__('Date', 'lustria-framework') => 'date',
                    esc_html__('Price', 'lustria-framework') => 'price',
                    esc_html__('Random', 'lustria-framework') => 'rand',
                    esc_html__('Sales', 'lustria-framework') => 'sales'
                ),
                'description' => esc_html__('Select how to sort retrieved products.', 'lustria-framework'),
                'dependency' => array('element' => 'show','value' => array('all', 'sale', 'featured')),
                'edit_field_class' => 'vc_col-sm-6 vc_column'
            ),

            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Sort order', 'lustria-framework'),
                'param_name' => 'order',
                'value' => array(
                    esc_html__('Descending', 'lustria-framework') => 'DESC',
                    esc_html__('Ascending', 'lustria-framework') => 'ASC'
                ),
                'description' => esc_html__('Designates the ascending or descending order.', 'lustria-framework'),
                'dependency' => array('element' => 'show','value' => array('all', 'sale', 'featured')),
                'edit_field_class' => 'vc_col-sm-6 vc_column'
            ),
            array(
                'type' => 'gsf_switch',
                'heading' => esc_html__('Is Slider?', 'lustria-framework' ),
                'param_name' => 'is_slider',
                'std' => '',
                'admin_label' => true,
                'group' => esc_html__('Slider Options','lustria-framework'),
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Carousel Rows', 'lustria-framework'),
                'param_name' => 'rows',
                'value' => array(
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4'
                ),
                'dependency' => array('element' => 'is_slider','value' => 'on'),
                'group' => esc_html__('Slider Options','lustria-framework'),
            ),
            G5P()->shortcode()->vc_map_add_pagination(array(
                'dependency' => array('element' => 'is_slider', 'value' => 'on'),
                'group' => esc_html__('Slider Options', 'lustria-framework'),
                'edit_field_class' => 'vc_col-sm-6 vc_column'
            )),
            G5P()->shortcode()->vc_map_add_navigation(array(
                'dependency' => array('element' => 'is_slider', 'value' => 'on'),
                'group' => esc_html__('Slider Options', 'lustria-framework'),
            )),
            G5P()->shortcode()->vc_map_add_navigation_position(array(
                'group' => esc_html__('Slider Options', 'lustria-framework')
            )),
            G5P()->shortcode()->vc_map_add_navigation_style(array(
                'group' => esc_html__('Slider Options', 'lustria-framework')
            )),
            G5P()->shortcode()->vc_map_add_navigation_size(array(
                'group' => esc_html__('Slider Options', 'lustria-framework')
            )),
            G5P()->shortcode()->vc_map_add_navigation_hover_style(array(
                'group' => esc_html__('Slider Options', 'lustria-framework')
            )),
            G5P()->shortCode()->vc_map_add_autoplay_enable(array(
                'dependency' => array('element' => 'is_slider', 'value' => 'on'),
                'group' => esc_html__('Slider Options', 'lustria-framework'),
            )),
            G5P()->shortCode()->vc_map_add_autoplay_timeout(array(
                'group' => esc_html__('Slider Options', 'lustria-framework'),
            )),
            array(
                'param_name' => 'product_paging',
                'heading' => esc_html__( 'Product Paging', 'lustria-framework' ),
                'description' => esc_html__( 'Specify your post paging mode', 'lustria-framework' ),
                'type' => 'dropdown',
                'value' => array(
                    esc_html__('No Pagination', 'lustria-framework')=> 'none',
                    esc_html__('Ajax - Pagination', 'lustria-framework') => 'pagination-ajax',
                    esc_html__('Ajax - Next Prev', 'lustria-framework') => 'next-prev',
                    esc_html__('Ajax - Load More', 'lustria-framework') => 'load-more',
                    esc_html__('Ajax - Infinite Scroll', 'lustria-framework') => 'infinite-scroll'
                ),
                'edit_field_class' => 'vc_col-sm-6 vc_column',
                'std' => 'none'
            ),
            array(
                'param_name' => 'product_animation',
                'heading' => esc_html__( 'Product Animation', 'lustria-framework' ),
                'description' => esc_html__( 'Specify your product animation', 'lustria-framework' ),
                'type' => 'dropdown',
                'value' => G5P()->shortcode()->switch_array_key_value( G5P()->settings()->get_animation(true) ),
                'edit_field_class' => 'vc_col-sm-6 vc_column',
                'std' => ''
            ),
        ),
        G5P()->shortCode()->get_column_responsive(),
        array(
            G5P()->shortcode()->vc_map_add_css_animation(),
            G5P()->shortcode()->vc_map_add_animation_duration(),
            G5P()->shortcode()->vc_map_add_animation_delay(),
            G5P()->shortcode()->vc_map_add_extra_class(),
            G5P()->shortcode()->vc_map_add_css_editor(),
            G5P()->shortcode()->vc_map_add_responsive()
        )
	)
);