<?php
return array(
    'name' => esc_html__('Pie Chart', 'lustria-framework'),
    'base' => 'gsf_pie_chart',
    'icon' => 'fa fa-pie-chart',
    'category' => G5P()->shortcode()->get_category_name(),
    'description' => esc_html__('Animated pie chart', 'lustria-framework'),
    'params' => array(
        array(
            'type' => 'textfield',
            'heading' => __('Title', 'lustria-framework'),
            'param_name' => 'title',
            'description' => __('Enter text used as widget title (Note: located above content element).', 'lustria-framework'),
            'admin_label' => true,
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__('Value', 'lustria-framework'),
            'param_name' => 'value',
            'description' => esc_html__('Enter value for graph (Note: choose range from 0 to 100).', 'lustria-framework'),
            'value' => '50',
            'admin_label' => true
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__('Units', 'lustria-framework'),
            'param_name' => 'units',
            'description' => esc_html__('Enter measurement units (Example: %, px, points, etc. Note: graph value and units will be appended to graph title).', 'lustria-framework')
        ),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__('Text value color', 'lustria-framework'),
            'param_name' => 'value_color',
            'description' => esc_html__('Select value color.', 'lustria-framework'),
            'edit_field_class' => 'vc_col-sm-6 vc_column',
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Bar color', 'lustria-framework'),
            'param_name' => 'bar_color',
            'value' => array(esc_html__('Accent color', 'lustria-framework') => 'accent-color') + getVcShared('colors-dashed') + array(esc_html__('Custom', 'lustria-framework') => 'custom'),
            'description' => esc_html__('Select pie chart color.', 'lustria-framework'),
            'param_holder_class' => 'vc_colored-dropdown',
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'std' => 'grey'
        ),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__('Custom color', 'lustria-framework'),
            'param_name' => 'bar_custom_color',
            'description' => esc_html__('Select custom bar color.', 'lustria-framework'),
            'dependency' => array(
                'element' => 'bar_color',
                'value' => array('custom')
            ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Bar value color', 'lustria-framework'),
            'param_name' => 'color',
            'value' => array(esc_html__('Accent color', 'lustria-framework') => 'accent-color') + getVcShared('colors-dashed') + array(esc_html__('Custom', 'lustria-framework') => 'custom'),
            'description' => esc_html__('Select bar value color.', 'lustria-framework'),
            'param_holder_class' => 'vc_colored-dropdown',
            'std' => 'accent-color'
        ),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__('Custom color', 'lustria-framework'),
            'param_name' => 'custom_color',
            'description' => esc_html__('Select custom bar value color.', 'lustria-framework'),
            'dependency' => array(
                'element' => 'color',
                'value' => array('custom')
            ),
        ),
        array(
            'type' => 'gsf_number_and_unit',
            'heading' => esc_html__( 'Max width', 'lustria-framework' ),
            'param_name' => 'max_width',
            'std' => '',
            'description' => esc_html__( 'Enter max width for Pie chart', 'lustria-framework' )
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Text Alignment', 'lustria-framework'),
            'param_name' => 'text_align',
            'description' => esc_html__('Select text alignment.', 'lustria-framework'),
            'value' => array(
                esc_html__('Left', 'lustria-framework') => 'text-left',
                esc_html__('Center', 'lustria-framework') => 'text-center',
                esc_html__('Right', 'lustria-framework') => 'text-right'
            ),
            'std' => 'text-left'
        ),
        G5P()->shortcode()->vc_map_add_css_animation(),
        G5P()->shortcode()->vc_map_add_animation_duration(),
        G5P()->shortcode()->vc_map_add_animation_delay(),
        G5P()->shortcode()->vc_map_add_extra_class(),
        G5P()->shortcode()->vc_map_add_css_editor(),
        G5P()->shortcode()->vc_map_add_responsive()
    )
);