<?php
/**
 * The template for displaying config.php
 *
 */
return array(
    'base' => 'gsf_posts',
    'name' => esc_html__('Posts', 'lustria-framework'),
    'category' => G5P()->shortcode()->get_category_name(),
    'icon' => 'fa fa-file-text',
    'params' => array_merge(
        array(
            array(
                'param_name' => 'post_layout',
                'heading' => esc_html__('Post Layout', 'lustria-framework'),
                'description' => esc_html__('Specify your post layout', 'lustria-framework'),
                'type' => 'gsf_image_set',
                'value' => array(
                    'large-image' => array(
                        'label' => esc_html__('Large Image', 'lustria-framework'),
                        'img' => G5P()->pluginUrl('assets/images/theme-options/blog-large-image.png'),
                    ),
                    'medium-image' => array(
                        'label' => esc_html__('Medium Image', 'lustria-framework'),
                        'img' => G5P()->pluginUrl('assets/images/theme-options/blog-medium-image.png'),
                    ),
                    'grid' => array(
                        'label' => esc_html__('Grid', 'lustria-framework'),
                        'img' => G5P()->pluginUrl('assets/images/theme-options/blog-grid.png'),
                    ),
                    'masonry' => array(
                        'label' => esc_html__('Masonry', 'lustria-framework'),
                        'img' => G5P()->pluginUrl('assets/images/theme-options/blog-masonry.png'),
                    ),
                ),
                'std' => 'grid',
                'admin_label' => true
            ),
            array(
                'param_name' => 'image_size',
                'heading' => esc_html__('Image size', 'lustria-framework'),
                'description' => esc_html__('Enter your post image size', 'lustria-framework'),
                'type' => 'textfield',
                'std' => '440x266',
                'edit_field_class' => 'vc_col-sm-6 vc_column',
                'dependency' => array('element' => 'post_layout', 'value_not_equal_to' => array('masonry'))
            ),
            array(
                'param_name' => 'image_ratio',
                'heading' => esc_html__('Image ratio', 'lustria-framework'),
                'description' => esc_html__('Specify your image post ratio', 'lustria-framework'),
                'type' => 'dropdown',
                'value' => G5P()->shortcode()->switch_array_key_value(G5P()->settings()->get_image_ratio()),
                'std' => '1x1',
                'edit_field_class' => 'vc_col-sm-6 vc_column',
                'dependency' => array('element' => 'image_size', 'value' => 'full')
            ),
            array(
                'param_name' => 'image_ratio_custom_width',
                'heading' => esc_html__('Image ratio custom width', 'lustria-framework'),
                'description' => esc_html__('Enter custom width for image ratio', 'lustria-framework'),
                'type' => 'gsf_number',
                'std' => '500',
                'edit_field_class' => 'vc_col-sm-6 vc_column',
                'dependency' => array('element' => 'image_ratio', 'value' => 'custom')
            ),
            array(
                'param_name' => 'image_ratio_custom_height',
                'heading' => esc_html__('Image ratio custom height', 'lustria-framework'),
                'description' => esc_html__('Enter custom height for image ratio', 'lustria-framework'),
                'type' => 'gsf_number',
                'std' => '500',
                'edit_field_class' => 'vc_col-sm-6 vc_column',
                'dependency' => array('element' => 'image_ratio', 'value' => 'custom')
            ),
            array(
                'param_name' => 'image_masonry_width',
                'heading' => esc_html__('Image masonry width', 'lustria-framework'),
                'type' => 'gsf_number',
                'std' => '500',
                'dependency' => array('element' => 'post_layout', 'value' => 'masonry')
            ),
        ),

        G5P()->shortcode()->get_post_filter(),
        array(
            array(
                'param_name' => 'posts_per_page',
                'heading' => esc_html__('Posts Per Page', 'lustria-framework'),
                'description' => esc_html__('Enter number of posts per page you want to display. Default 10', 'lustria-framework'),
                'type' => 'textfield',
                'std' => '',
                'edit_field_class' => 'vc_col-sm-6 vc_column'
            ),
            array(
                'param_name' => 'show_cate_filter',
                'heading' => esc_html__('Category Filter', 'lustria-framework'),
                'type' => 'gsf_switch',
                'edit_field_class' => 'vc_col-sm-6 vc_column',
                'std' => '0',
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
                'dependency' => array('element' => 'show_cate_filter', 'value' => 'on'),
                'edit_field_class' => 'vc_col-sm-6 vc_column'
            ),
        ),
        array(
            array(
                'param_name' => 'post_columns_gutter',
                'heading' => esc_html__('Post Columns Gutter', 'lustria-framework'),
                'description' => esc_html__('Specify your horizontal space between post.', 'lustria-framework'),
                'type' => 'dropdown',
                'value' => G5P()->shortcode()->switch_array_key_value(G5P()->settings()->get_post_columns_gutter()),
                'std' => '30',
                'dependency' => array('element' => 'post_layout', 'value_not_equal_to' => array('large-image','medium-image')),
                'edit_field_class' => 'vc_col-sm-6 vc_column'
            ),

            array(
                'type' => 'gsf_switch',
                'heading' => esc_html__('Is Slider?', 'lustria-framework'),
                'param_name' => 'is_slider',
                'std' => '',
                'admin_label' => true,
                'dependency' => array(
                    'element' => 'post_layout',
                    'value' => 'grid'
                ),
                'edit_field_class' => 'vc_col-sm-6 vc_column'
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
                'dependency' => array('element' => 'is_slider', 'value' => 'on'),
                'group' => esc_html__('Slider Options', 'lustria-framework'),
                'edit_field_class' => 'vc_col-sm-6 vc_column'
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
            G5P()->shortcode()->vc_map_add_navigation_hover_scheme(array(
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
                'param_name' => 'post_paging',
                'heading' => esc_html__('Post Paging', 'lustria-framework'),
                'description' => esc_html__('Specify your post paging mode', 'lustria-framework'),
                'type' => 'dropdown',
                'value' => array(
                    esc_html__('No Pagination', 'lustria-framework') => 'none',
                    esc_html__('Ajax - Pagination', 'lustria-framework') => 'pagination-ajax',
                    esc_html__('Ajax - Next Prev', 'lustria-framework') => 'next-prev',
                    esc_html__('Ajax - Load More', 'lustria-framework') => 'load-more',
                    esc_html__('Ajax - Infinite Scroll', 'lustria-framework') => 'infinite-scroll'
                ),
                'dependency' => array('element' => 'is_slider', 'value_not_equal_to' => array('on')),
                'edit_field_class' => 'vc_col-sm-6 vc_column',
                'std' => ''
            ),
            array(
                'param_name' => 'post_animation',
                'heading' => esc_html__('Animation', 'lustria-framework'),
                'description' => esc_html__('Specify your post animation', 'lustria-framework'),
                'type' => 'dropdown',
                'value' => G5P()->shortcode()->switch_array_key_value(G5P()->settings()->get_animation(true)),
                'edit_field_class' => 'vc_col-sm-6 vc_column',
                'std' => '-1'
            ),
        ),
        G5P()->shortCode()->get_column_responsive(array(
            'element' => 'post_layout',
            'value' => array('grid', 'masonry')
        )),
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