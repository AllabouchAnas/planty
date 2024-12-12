<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
class UBE_Module_Site_Settings extends UBE_Abstracts_Module {
    public function init() {
        add_action('init', array($this, 'process_site_settings'), 5);
        add_action('wp_head', array($this,  'custom_global_colors_variable'));
    }

    public function process_site_settings() {
        ube_change_color_settings();
        ube_set_default_colors();
    }

    public function custom_global_colors_variable() {
        $system_colors = ube_get_system_colors();

        $css = '';
        foreach ($system_colors as $v) {
            $color_foreground = ube_color_contrast($v['color'], '#fff', '#212121');
            $color_hover = ube_color_adjust_brightness($v['color'], '7.5%');
            $color_border = ube_color_adjust_brightness($v['color'], '10%');
            $color_active = ube_color_adjust_brightness($v['color'], '12.5%');
            $color_darken_15 = ube_color_adjust_brightness($v['color'], '15%');
            $color_darken_25 = ube_color_adjust_brightness($v['color'], '25%');
            $color_darken_35 = ube_color_adjust_brightness($v['color'], '35%');

	        $css .= "--e-global-color-{$v['_id']}: {$v['color']};";
            $css .= "--e-global-color-{$v['_id']}-foreground: {$color_foreground};";
            $css .= "--e-global-color-{$v['_id']}-hover: {$color_hover};";
            $css .= "--e-global-color-{$v['_id']}-border: {$color_border};";
            $css .= "--e-global-color-{$v['_id']}-active: {$color_active};";
            $css .= "--e-global-color-{$v['_id']}-darken-15: {$color_darken_15};";

            if ($v['_id'] === 'accent') {
                $css .= "--e-global-color-{$v['_id']}-darken-25: {$color_darken_25};";
                $css .= "--e-global-color-{$v['_id']}-darken-35: {$color_darken_35};";
            }


            // Alert variables
            $theme_level_text = ube_color_theme_level($v['color'], 6);
            $theme_level_bg = ube_color_theme_level($v['color'], -10);
            $theme_level_border = ube_color_theme_level($v['color'], -9);
            $theme_level_table_border = ube_color_theme_level($v['color'], -6);
            $theme_level_text_darken = ube_color_darken($theme_level_text, '10%');
            $theme_level_border_darken = ube_color_darken($theme_level_border, '5%');

            $css .= "--ube-theme-level-color-{$v['_id']}-text: {$theme_level_text};";
            $css .= "--ube-theme-level-color-{$v['_id']}-bg: {$theme_level_bg};";
            $css .= "--ube-theme-level-color-{$v['_id']}-border: {$theme_level_border};";
            $css .= "--ube-theme-level-color-{$v['_id']}-table-border: {$theme_level_table_border};";
            $css .= "--ube-theme-level-color-{$v['_id']}-text-darken: {$theme_level_text_darken};";
            $css .= "--ube-theme-level-color-{$v['_id']}-border-darken: {$theme_level_border_darken};";
        }

	    $kit_id = Elementor\Plugin::$instance->kits_manager->get_active_id();
        $css_selector = ':root';
        if ($kit_id) {
        	$css_selector .= ',.elementor-kit-' . $kit_id;
        }

        echo "<style id='ube-global-variable' type='text/css'>{$css_selector}{{$css}}</style>";
    }
}