<?php
return array(
    'base' => 'gsf_product_category',
    'name' => esc_html__( 'Product Category', 'lustria-framework' ),
    'icon' => 'fa fa-image',
    'category' => G5P()->shortcode()->get_category_name(),
    'params' => array(
        array(
            'type' => 'gsf_image_set',
            'heading' => esc_html__('Layout Style', 'lustria-framework'),
            'param_name' => 'layout_style',
            'value' => array(
                'style-01' => array(
                    'label' => esc_html__('Style 01', 'lustria-framework'),
                    'img' => G5P()->pluginUrl('assets/images/shortcode/shop-category-01.png')
                ),
                'style-02' => array(
                    'label' => esc_html__('Style 02', 'lustria-framework'),
                    'img' => G5P()->pluginUrl('assets/images/shortcode/shop-category-02.jpg')
                ),
            ),
            'std' => 'style-01',
            'admin_label' => true
        ),
        G5P()->shortcode()->vc_map_add_product_category(),
        array(
            'type' => 'attach_image',
            'heading' => esc_html__('Background Image', 'lustria-framework'),
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'param_name' => 'image'
        ),
        array(
            'param_name'        => 'hover_effect',
            'heading'     => esc_html__('Hover Effect', 'lustria-framework'),
            'type'      => 'dropdown',
            'std'      => '',
            'value' => array(
                esc_html__('None', 'lustria-framework') => '',
                esc_html__('Suprema', 'lustria-framework') => 'suprema-effect',
                esc_html__('Layla', 'lustria-framework') => 'layla-effect',
                esc_html__('Bubba', 'lustria-framework') => 'bubba-effect',
                esc_html__('Jazz', 'lustria-framework') => 'jazz-effect',
                esc_html__('Flash', 'lustria-framework') => 'flash-effect'
            ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Height Mode', 'lustria-framework' ),
            'param_name' => 'height_mode',
            'value' => array(
                '1:1' => '100',
                esc_html__( 'Original', 'lustria-framework' )=> 'original',
                '4:3' => '133.333333333',
                '3:4' => '75',
                '16:9' => '177.777777778',
                '9:16' => '56.25',
                esc_html__( 'Custom', 'lustria-framework' )=> 'custom'
            ),
            'std' => 'original',
            'dependency' => array('element' => 'banner_bg_image', 'value_not_equal_to' => array('')),
            'description' => esc_html__( 'Sizing proportions for height and width. Select "Original" to scale image without cropping.', 'lustria-framework' )
        ),
        G5P()->shortcode()->vc_map_add_css_animation(),
        G5P()->shortcode()->vc_map_add_animation_duration(),
        G5P()->shortcode()->vc_map_add_animation_delay(),
        G5P()->shortcode()->vc_map_add_extra_class(),
        G5P()->shortcode()->vc_map_add_css_editor(),
        G5P()->shortcode()->vc_map_add_responsive()
    ),
);