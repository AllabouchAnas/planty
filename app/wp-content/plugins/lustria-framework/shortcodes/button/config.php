<?php
/**
 * The template for displaying config.php
 *
 * @package WordPress
 * @subpackage lustria
 * @since lustria 1.0
 */
return array(
    'base' => 'gsf_button',
    'name' => esc_html__('Button', 'lustria-framework'),
    'category' => G5P()->shortcode()->get_category_name(),
    'description' => esc_html__('Eye catching button', 'lustria-framework'),
    'icon'        => 'fa fa-bold',
    'params' => array(
        array(
            'type' => 'textfield',
            'heading' => esc_html__('Text', 'lustria-framework'),
            'param_name' => 'title',
            'value' => esc_html__('Text on the button', 'lustria-framework'),
            'admin_label' => true,
        ),
        array(
            'type' => 'vc_link',
            'heading' => esc_html__('URL (Link)', 'lustria-framework'),
            'param_name' => 'link',
            'description' => esc_html__('Add link to button.', 'lustria-framework'),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Style', 'lustria-framework'),
            'description' => esc_html__('Select button display style.', 'lustria-framework'),
            'param_name' => 'style',
            'value' => array(
                esc_html__('Classic', 'lustria-framework') => 'classic',
                esc_html__('Outline', 'lustria-framework') => 'outline',
                esc_html__('Link', 'lustria-framework') => 'link'
            ),
            'std' => 'classic',
            'admin_label' => true,
        ),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__('Border Color', 'lustria-framework'),
            'param_name' => 'border_color',
            'std' => '#fe3d7d',
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'dependency' => array(
                'element' => 'style',
                'value' => 'skew',
            ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Shape', 'lustria-framework'),
            'description' => esc_html__('Select button shape.', 'lustria-framework'),
            'param_name' => 'shape',
            'value' => array(
                esc_html__('Rounded', 'lustria-framework') => 'rounded',
                esc_html__('Square', 'lustria-framework') => 'square',
                esc_html__('Round', 'lustria-framework') => 'round',
            ),
            'dependency' => array(
                'element' => 'style',
                'value_not_equal_to' => array('link'),
            ),
            'std' => 'square',
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Color', 'lustria-framework'),
            'param_name' => 'color',
            'description' => esc_html__('Select button color.', 'lustria-framework'),
            'value' => array(
                esc_html__('Accent', 'lustria-framework') => 'accent',
                esc_html__('Primary', 'lustria-framework') => 'primary',
                esc_html__('Gray', 'lustria-framework') => 'gray',
                esc_html__('Black', 'lustria-framework') => 'black',
                esc_html__('White', 'lustria-framework') => 'white',
                esc_html__('Red', 'lustria-framework') => 'red',
            ),
            'std' => 'primary',
            'admin_label' => true,
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Size', 'lustria-framework'),
            'param_name' => 'size',
            'description' => esc_html__('Select button display size.', 'lustria-framework'),
            'std' => 'md',
            'value' => array(
                esc_html__('Mini', 'lustria-framework') => 'xs',
                esc_html__('Small', 'lustria-framework') => 'sm',
                esc_html__('Normal', 'lustria-framework') => 'md',
                esc_html__('Large', 'lustria-framework') => 'lg',
            ),
            'admin_label' => true,
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Alignment', 'lustria-framework'),
            'param_name' => 'align',
            'description' => esc_html__('Select button alignment.', 'lustria-framework'),
            'value' => array(
                esc_html__('Inline', 'lustria-framework') => 'inline',
                esc_html__('Left', 'lustria-framework') => 'left',
                esc_html__('Right', 'lustria-framework') => 'right',
                esc_html__('Center', 'lustria-framework') => 'center',
            ),
            'std' => 'inline',
            'admin_label' => true,
        ),
        array(
            'type' => 'gsf_switch',
            'heading' => esc_html__('Set full width button?', 'lustria-framework'),
            'param_name' => 'button_block',
            'std' => '',
            'dependency' => array(
                'element' => 'align',
                'value_not_equal_to' => 'inline',
            ),
            'admin_label' => true,
        ),

        G5P()->shortcode()->vc_map_add_icon_font(),
        array(
            'type' => 'gsf_button_set',
            'heading' => esc_html__('Icon Alignment', 'lustria-framework'),
            'description' => esc_html__('Select icon alignment.', 'lustria-framework'),
            'param_name' => 'icon_align',
            'value' => array(
                esc_html__('Left', 'lustria-framework') => 'left',
                esc_html__('Right', 'lustria-framework') => 'right',
            ),
            'dependency' => array(
                'element' => 'icon_font',
                'value_not_equal_to' => array(''),
            ),
        ),
        array(
            'type' => 'gsf_switch',
            'heading' => esc_html__('Advanced on click action', 'lustria-framework'),
            'param_name' => 'custom_onclick',
            'std' => '',
            'description' => esc_html__('Insert inline onclick javascript action.', 'lustria-framework'),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__('On click code', 'lustria-framework'),
            'param_name' => 'custom_onclick_code',
            'description' => esc_html__('Enter onclick action code.', 'lustria-framework'),
            'dependency' => array(
                'element' => 'custom_onclick',
                'value' => 'on',
            ),
        ),
        G5P()->shortcode()->vc_map_add_css_animation(),
        G5P()->shortcode()->vc_map_add_animation_duration(),
        G5P()->shortcode()->vc_map_add_animation_delay(),
        G5P()->shortcode()->vc_map_add_extra_class(),
        G5P()->shortcode()->vc_map_add_css_editor(),
        G5P()->shortcode()->vc_map_add_responsive()
    )
);