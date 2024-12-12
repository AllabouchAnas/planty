<?php
return array(
    'base' => 'gsf_testimonials',
    'name' => esc_html__('Testimonials', 'lustria-framework'),
    'icon' => 'fa fa-quote-right',
    'category' => G5P()->shortcode()->get_category_name(),
    'params' => array_merge(
        array(
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Columns Gutter', 'lustria-framework'),
                'param_name' => 'columns_gutter',
                'value' => G5P()->shortcode()->switch_array_key_value(G5P()->settings()->get_post_columns_gutter()),
                'std' => '30|px',
                'edit_field_class' => 'vc_col-sm-6 vc_column',
                'dependency' => array('element' => 'layout_style', 'value' => array(''))
            ),
            array(
                'type' => 'param_group',
                'heading' => esc_html__('Values', 'lustria-framework'),
                'param_name' => 'values',
                'description' => esc_html__('Enter values for author', 'lustria-framework'),
                'value' => '',
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Author Name', 'lustria-framework'),
                        'param_name' => 'author_name',
                        'admin_label' => true,
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Author Job', 'lustria-framework'),
                        'param_name' => 'author_job',
                        'admin_label' => true,
                    ),
                    array(
                        'type' => 'textarea',
                        'heading' => esc_html__('Content testimonials of the author', 'lustria-framework'),
                        'param_name' => 'author_bio'
                    ),
                    array(
                        'type' => 'attach_image',
                        'heading' => esc_html__('Upload Avatar', 'lustria-framework'),
                        'param_name' => 'author_avatar',
                        'value' => '',
                        'description' => esc_html__('Upload avatar for author.', 'lustria-framework'),
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__('Rating stars', 'lustria-framework'),
                        'param_name' => 'user_rating',
                        'std' => '',
                        'value' => array(
                            esc_html__('None', 'lustria-framework') => '',
                            '1' => '1',
                            '2' => '2',
                            '3' => '3',
                            '4' => '4',
                            '5' => '5'
                        )
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Author Link', 'lustria-framework'),
                        'param_name' => 'author_link'
                    ),
                )
            ),
            G5P()->shortcode()->vc_map_add_pagination(array(
                'group' => esc_html__('Slider Options', 'lustria-framework'),
                'edit_field_class' => 'vc_col-sm-6 vc_column'
            )),
            G5P()->shortcode()->vc_map_add_navigation(array(
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
           /* G5P()->shortcode()->vc_map_add_navigation_hover_scheme(array(
                'group' => esc_html__('Slider Options', 'lustria-framework')
            )),*/
            G5P()->shortCode()->vc_map_add_autoplay_enable(array(
                'dependency' => array('element' => 'is_slider', 'value' => 'on'),
                'group' => esc_html__('Slider Options', 'lustria-framework'),
            )),
            G5P()->shortCode()->vc_map_add_autoplay_timeout(array(
                'group' => esc_html__('Slider Options', 'lustria-framework'),
            )),
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