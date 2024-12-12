<?php
return array(
    'base'        => 'gsf_view_demo',
    'name'        => esc_html__('View Demo', 'lustria-framework'),
    'icon'        => 'fa fa-eye',
    'category' => G5P()->shortcode()->get_category_name(),
    'params'      => array_merge(
        array(
            array(
                'param_name' => 'columns_gutter',
                'heading' => esc_html__('Columns Gutter', 'lustria-framework'),
                'description' => esc_html__('Specify your horizontal space between items.', 'lustria-framework'),
                'type' => 'dropdown',
                'value' => G5P()->shortcode()->switch_array_key_value(G5P()->settings()->get_post_columns_gutter()),
                'std' => '30'
            ),
            array(
                'type' => 'gsf_switch',
                'heading' => esc_html__('Scroll on Hover', 'lustria-framework' ),
                'param_name' => 'scroll_on_hover',
                'std' => '',
                'edit_field_class' => 'vc_col-sm-6 vc_column'
            ),
            array(
                'type'       => 'param_group',
                'heading'    => esc_html__('Demo Items', 'lustria-framework'),
                'param_name' => 'demo_items',
                'params'     => array(
                    array(
                        'type'        => 'textfield',
                        'heading'     => esc_html__('Title demo', 'lustria-framework'),
                        'param_name'  => 'title',
                        'value'       => '',
                        'admin_label' => true,
                    ),
                    array(
                        'type'        => 'attach_image',
                        'heading'     => esc_html__('Images', 'lustria-framework'),
                        'param_name'  => 'image',
                        'value'       => ''
                    ),
                    array(
                        'type' => 'vc_link',
                        'heading' => esc_html__('URL (Link)', 'lustria-framework'),
                        'param_name' => 'link',
                        'dependency' => array('element' => 'is_coming_soon', 'value_not_equal_to' => 'on')
                    ),
                ),
            )
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
    ),
);
