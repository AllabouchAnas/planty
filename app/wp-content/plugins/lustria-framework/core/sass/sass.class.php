<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}

if (!function_exists('G5P_Core_Sass')) {
	class G5P_Core_Sass
	{
		private static $_instance;

		public static function getInstance()
		{
			if (self::$_instance == NULL) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		public function init()
		{
			add_filter('g5plus_custom_css', array($this, 'change_css_variable'));
			add_filter('g5plus_custom_css_editor',array($this,'change_custom_css_editor'));
		}

		public function change_custom_css_editor($custom_css) {
			$custom_css .= $this->get_css_variable();
			return $custom_css;
		}

		public function change_css_variable($custom_css)
		{
			$custom_css .= $this->get_css_variable();
			$custom_css .= $this->get_skins_variable();
			return $custom_css;
		}

		public function get_css_variable()
		{
			$body_font = G5P()->options()->get_body_font();
			$body_font = GSF()->core()->fonts()->processFont($body_font);
			$body_font_family = GSF()->core()->fonts()->getFontFamily($body_font['font_family']);

			$primary_font = G5P()->options()->get_primary_font();
			$primary_font = GSF()->core()->fonts()->getFontFamily($primary_font['font_family']);

			$h1_font = G5P()->options()->get_h1_font();
			$h1_font = GSF()->core()->fonts()->processFont($h1_font);
			$h1_font_family = GSF()->core()->fonts()->getFontFamily($h1_font['font_family']);

			$h2_font = G5P()->options()->get_h2_font();
			$h2_font = GSF()->core()->fonts()->processFont($h2_font);
			$h2_font_family = GSF()->core()->fonts()->getFontFamily($h2_font['font_family']);

			$h3_font = G5P()->options()->get_h3_font();
			$h3_font = GSF()->core()->fonts()->processFont($h3_font);
			$h3_font_family = GSF()->core()->fonts()->getFontFamily($h3_font['font_family']);

			$h4_font = G5P()->options()->get_h4_font();
			$h4_font = GSF()->core()->fonts()->processFont($h4_font);
			$h4_font_family = GSF()->core()->fonts()->getFontFamily($h4_font['font_family']);

			$h5_font = G5P()->options()->get_h5_font();
			$h5_font = GSF()->core()->fonts()->processFont($h5_font);
			$h5_font_family = GSF()->core()->fonts()->getFontFamily($h5_font['font_family']);

			$h6_font = G5P()->options()->get_h6_font();
			$h6_font = GSF()->core()->fonts()->processFont($h6_font);
			$h6_font_family = GSF()->core()->fonts()->getFontFamily($h6_font['font_family']);

			$menu_font = G5P()->options()->get_menu_font();
			$menu_font = GSF()->core()->fonts()->processFont($menu_font);
			$menu_font_family = GSF()->core()->fonts()->getFontFamily($menu_font['font_family']);

			$sub_menu_font = G5P()->options()->get_sub_menu_font();
			$sub_menu_font = GSF()->core()->fonts()->processFont($sub_menu_font);
			$sub_menu_font_family = GSF()->core()->fonts()->getFontFamily($sub_menu_font['font_family']);

			$mobile_menu_font = G5P()->options()->get_mobile_menu_font();
			$mobile_menu_font = GSF()->core()->fonts()->processFont($mobile_menu_font);
			$mobile_menu_font_family = GSF()->core()->fonts()->getFontFamily($mobile_menu_font['font_family']);

			$header_responsive_breakpoint = G5P()->options()->get_header_responsive_breakpoint();
			$accent_color = $this->process_color_value(G5P()->options()->get_accent_color(),'#fe3d7d');
			$accent_foreground_color = $this->process_color_value(G5P()->options()->get_foreground_accent_color(),'#fff');
			$accent_adjust_brightness = $this->color_adjust_brightness($accent_color, '7.5%');
			$accent_color_rgba = $this->color_to_rgba($accent_color);
			$primary_color = $this->process_color_value(G5P()->options()->get_primary_color(),'#c5a374');
			$primary_foreground_color = $this->color_contrast($primary_color);
			$primary_adjust_brightness = $this->color_adjust_brightness($primary_color, '7.5%');

			$spinner_color = $this->process_color_value(G5P()->options()->get_spinner_color(),$accent_color);


			$header_layout = G5P()->options()->get_header_layout();
			$header_spacing_default = &$this->get_header_spacing_default($header_layout);

			$header_background = G5P()->options()->get_header_background();
			$header_background_color = isset($header_background['background_color']) ? $header_background['background_color'] : '#fff';
			$header_background_color = $this->process_color_value($header_background_color,'#fff');
			$header_text_color =  $this->process_color_value(G5P()->options()->get_header_text_color(),'#323232');
			$header_text_hover_color =  $this->process_color_value(G5P()->options()->get_header_text_hover_color(),$accent_color);
			$header_sticky_text_color = $this->process_color_value(G5P()->options()->get_header_sticky_text_color(),'#323232');
			$header_sticky_text_hover_color = $this->process_color_value(G5P()->options()->get_header_sticky_text_hover_color(),$accent_color);
			$header_sticky_bg = G5P()->options()->get_header_sticky_background();
			$header_sticky_bg = (isset($header_sticky_bg['background_color']) && !empty($header_sticky_bg['background_color'])) ? $header_sticky_bg['background_color'] : '#fff';
			$header_sticky_box_shadow_affix = $this->color_neutral($header_sticky_bg, "rgba(255, 255, 255, 0.1)", "rgba(0, 0, 0, 0.1)");
			$header_customize_search_form_background = $this->color_neutral($header_background_color, "#444", "#f8f8f8");
			$header_sticky_customize_search_form_background = $this->color_neutral($header_sticky_bg, "#444", "#f8f8f8");




			$menu_background_color = $this->process_color_value(G5P()->options()->get_menu_background_color(),'#fff');
			$menu_text_color = $this->process_color_value(G5P()->options()->get_menu_text_color(),'#323232');
			$menu_text_hover_color = $this->process_color_value(G5P()->options()->get_menu_text_hover_color(),$accent_color);

			$menu_sticky_text_color = $header_sticky_text_color;
			$menu_sticky_text_hover_color = $header_sticky_text_hover_color;


			if(in_array($header_layout, array('header-1', 'header-2', 'header-3', 'header-5', 'header-6', 'header-11', 'header-12'))) {
				$menu_background_color = $header_background_color;
				$menu_text_color = $header_text_color;
				$menu_text_hover_color = $header_text_hover_color;

			}


			$menu_customize_text_color = $this->process_color_value(G5P()->options()->get_menu_customize_text_color(),$menu_text_color);
			$menu_customize_text_hover_color = $this->process_color_value(G5P()->options()->get_menu_customize_text_hover_color(),$accent_color);

			$menu_customize_sticky_text_color = $header_sticky_text_color;
			$menu_customize_sticky_text_hover_color = $header_sticky_text_hover_color;

			if (in_array($header_layout,array('header-4','header-7','header-8','header-9','header-11','header-12'))) {
				$menu_customize_text_color = $header_text_color;
				$menu_customize_text_hover_color = $header_text_hover_color;
			}


			$header_sticky_bg = G5P()->options()->get_header_sticky_background();
			$header_sticky_bg = (isset($header_sticky_bg['background_color']) && !empty($header_sticky_bg['background_color'])) ? $header_sticky_bg['background_color'] : '#fff';

			$submenu_text_color = $this->process_color_value(G5P()->options()->get_submenu_text_color(),'#9b9b9b');
			$submenu_text_hover_color = $this->process_color_value(G5P()->options()->get_submenu_text_hover_color(),$accent_color);
			$submenu_heading_color = $this->process_color_value(G5P()->options()->get_submenu_heading_color(), '#333');
			$submenu_border_color = $this->process_color_value(G5P()->options()->get_submenu_border_color(), '#ededed');

			$logo_text_color = $this->process_color_value(G5P()->options()->get_logo_text_color(),'#333');
			$logo_sticky_text_color = $this->process_color_value(G5P()->options()->get_logo_sticky_text_color(),'#333');

			$header_border_color = $this->process_color_value(G5P()->options()->get_header_border_color(),'#ededed');

			$mobile_header_background = G5P()->options()->get_mobile_header_background();
			$mobile_header_background_color = isset($mobile_header_background['background_color']) ? $mobile_header_background['background_color'] : '#fff';
			$mobile_header_background_color = $this->process_color_value($mobile_header_background_color,'#fff');
			$mobile_logo_text_color = $this->process_color_value(G5P()->options()->get_mobile_logo_text_color(),'#333');
			$mobile_logo_sticky_text_color = $this->process_color_value(G5P()->options()->get_mobile_logo_sticky_text_color(),'#333');
			$mobile_header_border_color = $this->process_color_value(G5P()->options()->get_mobile_header_border_color(),'#ededed');


			$mobile_menu_text_color = $this->process_color_value(G5P()->options()->get_mobile_menu_text_color(),'rgba(255,255,255,0.7)');
			$mobile_menu_text_hover_color = $this->process_color_value(G5P()->options()->get_mobile_menu_text_hover_color(),$accent_color);
			$mobile_menu_customize_text_color = $this->process_color_value(G5P()->options()->get_mobile_menu_customize_text_color(),'#323232');
			$mobile_menu_customize_sticky_text_color = $this->process_color_value(G5P()->options()->get_mobile_menu_customize_sticky_text_color(),'#323232');
			$mobile_menu_customize_text_hover_color = $this->process_color_value(G5P()->options()->get_mobile_menu_customize_text_hover_color(),$accent_color);
			$mobile_menu_customize_sticky_text_hover_color = $this->process_color_value(G5P()->options()->get_mobile_menu_customize_sticky_text_hover_color(),$accent_color);

			$mobile_menu_background_color = $this->process_color_value(G5P()->options()->get_mobile_menu_background_color(),'#222');

			$menu_vertical_background_color_1 = $mobile_menu_background_color;
			$menu_vertical_background_color_2 = $this->color_adjust_brightness($menu_vertical_background_color_1, '5%');
			$menu_vertical_background_color_3 = $this->color_adjust_brightness($menu_vertical_background_color_2, '5%');
			$menu_vertical_background_color_4 = $this->color_adjust_brightness($menu_vertical_background_color_3, '5%');
			$menu_vertical_background_color_5 = $this->color_adjust_brightness($menu_vertical_background_color_4, '5%');
			$menu_vertical_background_color_6 = $this->color_adjust_brightness($menu_vertical_background_color_5, '5%');
			$menu_vertical_background_color_7 = $this->color_adjust_brightness($menu_vertical_background_color_6, '5%');

			$mobile_menu_background_color_contrast = $this->color_adjust_brightness($mobile_menu_background_color, '2%');

			$main_menu_vertical_background_color_1 = $menu_background_color;
			$main_menu_vertical_background_color_2 = $this->color_adjust_brightness($main_menu_vertical_background_color_1, '5%');
			$main_menu_vertical_background_color_3 = $this->color_adjust_brightness($main_menu_vertical_background_color_2, '5%');
			$main_menu_vertical_background_color_4 = $this->color_adjust_brightness($main_menu_vertical_background_color_3, '5%');
			$main_menu_vertical_background_color_5 = $this->color_adjust_brightness($main_menu_vertical_background_color_4, '5%');
			$main_menu_vertical_background_color_6 = $this->color_adjust_brightness($main_menu_vertical_background_color_5, '5%');
			$main_menu_vertical_background_color_7 = $this->color_adjust_brightness($main_menu_vertical_background_color_6, '5%');


			$logo_max_height = G5P()->options()->get_logo_max_height();
			$logo_max_height = $this->process_unit_value(isset($logo_max_height['height']) ? $logo_max_height['height'] : '', $header_spacing_default['logo_max_height']);
			$mobile_logo_max_height = G5P()->options()->get_mobile_logo_max_height();
			$mobile_logo_max_height = $this->process_unit_value(isset($mobile_logo_max_height['height']) ? $mobile_logo_max_height['height'] : '', '100');

			$logo_padding = G5P()->options()->get_logo_padding();
			$logo_padding = $this->process_spacing($logo_padding, array(
				'top' => $header_spacing_default['logo_padding_top'],
				'bottom' => $header_spacing_default['logo_padding_bottom'],
			));

			$mobile_logo_padding = G5P()->options()->get_mobile_logo_padding();
			$mobile_logo_padding = $this->process_spacing($mobile_logo_padding, array(
				'top' => '5',
				'bottom' => '5',
			));

			$navigation_height = G5P()->options()->get_navigation_height();
			$navigation_height = $this->process_unit_value(isset($navigation_height['height']) ? $navigation_height['height'] : '', $header_spacing_default['navigation_height']);
			if (in_array($header_layout, array('header-1', 'header-2','header-3','header-5','header-6', 'header-7'))) {
				$navigation_height = $logo_max_height;
			}
			$navigation_spacing = $this->process_unit_value(G5P()->options()->get_navigation_spacing(), '30');
			$header_customize_nav_spacing = $this->process_unit_value(G5P()->options()->get_header_customize_nav_spacing(), '15');
			$header_customize_left_spacing = $this->process_unit_value(G5P()->options()->get_header_customize_left_spacing(), '15');
			$header_customize_right_spacing = $this->process_unit_value(G5P()->options()->get_header_customize_right_spacing(), '15');
			$header_customize_mobile_spacing = $this->process_unit_value(G5P()->options()->get_header_customize_mobile_spacing(), '15');

			/**
			 * Content Skin
			 */
			$content_skin_variables = $this->getSkinVariable(G5P()->options()->getOptions('content_skin'));
			$text_color = $content_skin_variables['text_color'];
			$text_hover_color = (isset($content_skin_variables['text_hover_color']) && !empty($content_skin_variables['text_hover_color'])) ? $content_skin_variables['text_hover_color'] : G5P()->options()->get_accent_color();
			$background_color = $content_skin_variables['background_color'];
			$heading_color = $content_skin_variables['heading_color'];
			$heading_color_rgba = $this->color_to_rgba($heading_color);
			$color_countdown_single_product = $this->color_neutral($heading_color, "#fff", "#333");

			$disable_color = $content_skin_variables['disable_color'];
			$border_color = $content_skin_variables['border_color'];

			$accent_color_darken = $this->color_darken($accent_color,'5%');
			$accent_color_lighten = $this->color_lighten($accent_color,'5%');

			$background_color_contrast = $this->color_contrast($background_color, '#444', '#f8f8f8');
			$background_color_contrast_02 = $this->color_contrast($background_color, '#444', '#f5f5f5');
			$background_color_contrast_03 = $this->color_contrast($background_color, '#444', '#f8f8f8');
			$background_color_contrast_04 = $this->color_contrast($background_color, '#555', '#E0E8EE');
			$background_color_contrast_05 = $this->color_contrast( $background_color , 'rgba(93, 151, 175, 0.7)','rgba(255, 255, 255, 0.7)');
			$background_color_contrast_06 = $this->color_contrast($background_color, '#444', '#f9f9f9');
			$background_color_contrast_07 = $this->color_contrast($background_color, '#666', '#333');
			$background_color_contrast_08 = $this->color_contrast($background_color,$text_color, $disable_color);
			$background_color_contrast_09 = $this->color_contrast($background_color, '#444', '#fafafa');
			$background_color_contrast_10 = $this->color_contrast( $background_color , '#fff','#000');
			$background_color_contrast_11 = $this->color_contrast( $background_color , '#666','#9b9b9b');
			$background_color_contrast_12 = $this->color_contrast( $background_color , '#444','#ababab');
			$background_color_contrast_13 = $this->color_contrast( $background_color , '#202020','#f8f8f8');
			$background_color_contrast_14 = $this->color_contrast( $background_color , '#444','#ccc');
			$background_color_contrast_15 = $this->color_contrast( $background_color , '#ababab','#d6d6d6');
			$background_color_contrast_16 = $this->color_contrast( $background_color , '#f8f8f8','#444');



			return <<<CSS
:root {
	--g5-body-font: '{$body_font_family}';
	--g5-body-font-size: {$body_font['font_size']};
	--g5-body-font-weight: {$body_font['font_weight']};
	--g5-body-font-style: {$body_font['font_style']};
	--g5-primary-font: '{$primary_font}';
	--g5-h1-font : '{$h1_font_family}';
	--g5-h1-font-size:  {$h1_font['font_size']};
	--g5-h1-font-weight : {$h1_font['font_weight']};
	--g5-h1-font-style : {$h1_font['font_style']};
	--g5-h2-font : '{$h2_font_family}';
	--g5-h2-font-size:  {$h2_font['font_size']};
	--g5-h2-font-weight : {$h2_font['font_weight']};
	--g5-h2-font-style : {$h2_font['font_style']};
	--g5-h3-font : '{$h3_font_family}';
	--g5-h3-font-size:  {$h3_font['font_size']};
	--g5-h3-font-weight : {$h3_font['font_weight']};
	--g5-h3-font-style : {$h3_font['font_style']};
	--g5-h4-font : '{$h4_font_family}';
	--g5-h4-font-size:  {$h4_font['font_size']};
	--g5-h4-font-weight : {$h4_font['font_weight']};
	--g5-h4-font-style : {$h4_font['font_style']};
	--g5-h5-font : '{$h5_font_family}';
	--g5-h5-font-size:  {$h5_font['font_size']};
	--g5-h5-font-weight : {$h5_font['font_weight']};
	--g5-h5-font-style : {$h5_font['font_style']};
	--g5-h6-font : '{$h6_font_family}';
	--g5-h6-font-size:  {$h6_font['font_size']};
	--g5-h6-font-weight : {$h6_font['font_weight']};
	--g5-h6-font-style : {$h6_font['font_style']};
	
	
	--g5-color-accent: {$accent_color};
	--g5-color-accent-r :  {$accent_color_rgba[0]};
	--g5-color-accent-g :  {$accent_color_rgba[1]};
	--g5-color-accent-b :  {$accent_color_rgba[2]};
	--g5-color-accent-foreground: {$accent_foreground_color};
	--g5-color-accent-brightness : {$accent_adjust_brightness};

	
	--g5-color-heading: {$heading_color};
	--g5-color-heading-r :  {$heading_color_rgba[0]};
	--g5-color-heading-g :  {$heading_color_rgba[1]};
	--g5-color-heading-b :  {$heading_color_rgba[2]};
	--g5-color-countdown-single-product: {$color_countdown_single_product};
	
	--g5-color-text-main: {$text_color};
	--g5-background-color: {$background_color};
	--g5-color-muted : {$disable_color};

	
	--g5-color-link: {$accent_color};
	--g5-color-link-hover: {$text_hover_color};
	--g5-color-border : {$border_color};
	
	
	--g5-menu-font: '{$menu_font_family}';
	--g5-menu-font-size: {$menu_font['font_size']};
	--g5-menu-font-weight: {$menu_font['font_weight']};
	--g5-menu-font-style: {$menu_font['font_style']};
	--g5-sub-menu-font: '{$sub_menu_font_family}';
	--g5-sub-menu-font-size: {$sub_menu_font['font_size']};
	--g5-sub-menu-font-weight: {$sub_menu_font['font_weight']};
	--g5-sub-menu-font-style: {$sub_menu_font['font_style']};
	--g5-mobile-menu-font: '{$mobile_menu_font_family}';
	--g5-mobile-menu-font-size: {$mobile_menu_font['font_size']};
	--g5-mobile-menu-font-weight: {$mobile_menu_font['font_weight']};
	--g5-mobile-menu-font-style: {$mobile_menu_font['font_style']};
	
	--g5-header-responsive-breakpoint: {$header_responsive_breakpoint}px;
	--g5-spinner-color: {$spinner_color};
	
	--g5-color-primary :  {$primary_color};
	--g5-color-primary-foreground :  {$primary_foreground_color};
	--g5-color-primary-brightness : {$primary_adjust_brightness};
	
	--g5-header-background-color : {$header_background_color};
	--g5-header-border-color : {$header_border_color};
	--g5-header-sticky-background-color: {$header_sticky_bg};
	--g5-header-sticky-box-shadow-affix: {$header_sticky_box_shadow_affix};
	--g5-header-customize-search-form-background: {$header_customize_search_form_background};
	--g5-header-sticky-customize-search-form-background: {$header_sticky_customize_search_form_background};
	
	--g5-menu-background-color: {$menu_background_color};
	--g5-menu-text-color: {$menu_text_color};
	--g5-menu-sticky-text-color: {$menu_sticky_text_color};
	--g5-menu-text-hover-color : {$menu_text_hover_color};
	--g5-menu-sticky-text-hover-color : {$menu_sticky_text_hover_color};
	--g5-menu-customize-text-color : {$menu_customize_text_color};
	--g5-menu-customize-sticky-text-color : {$menu_customize_sticky_text_color};
	--g5-menu-customize-text-hover-color : {$menu_customize_text_hover_color};
	--g5-menu-customize-sticky-text-hover-color : {$menu_customize_sticky_text_hover_color};
	
	--g5-submenu-text-color : {$submenu_text_color};
	--g5-submenu-text-hover-color : {$submenu_text_hover_color};
	--g5-submenu-heading-color : {$submenu_heading_color};
	--g5-submenu-border-color : {$submenu_border_color};
	
	--g5-logo-text-color : {$logo_text_color};
	--g5-logo-sticky-text-color : {$logo_sticky_text_color};
	--g5-mobile-header-background-color: {$mobile_header_background_color};
	--g5-mobile-logo-text-color : {$mobile_logo_text_color};
	--g5-mobile-logo-sticky-text-color : {$mobile_logo_sticky_text_color};
	--g5-mobile-header-border-color : {$mobile_header_border_color};
	
	--g5-mobile-menu-background-color: {$mobile_menu_background_color};
	--g5-mobile-menu-text-color: {$mobile_menu_text_color};
	--g5-mobile-menu-text-hover-color : {$mobile_menu_text_hover_color};
	--g5-mobile-menu-customize-text-color : {$mobile_menu_customize_text_color};
	--g5-mobile-menu-customize-sticky-text-color : {$mobile_menu_customize_sticky_text_color};
	--g5-mobile-menu-customize-text-hover-color : {$mobile_menu_customize_text_hover_color};
	--g5-mobile-menu-customize-sticky-text-hover-color : {$mobile_menu_customize_sticky_text_hover_color};
	
	
	--g5-logo-max-height: {$logo_max_height};
	--g5-logo-padding-top: {$logo_padding['top']};
	--g5-logo-padding-bottom: {$logo_padding['bottom']};
	--g5-mobile-logo-max-height: {$mobile_logo_max_height};
	--g5-mobile-logo-padding-top: {$mobile_logo_padding['top']};
	--g5-mobile-logo-padding-bottom: {$mobile_logo_padding['bottom']};
	--g5-navigation-height: {$navigation_height};
	--g5-navigation-spacing: {$navigation_spacing};
	--g5-header-customize-nav-spacing: {$header_customize_nav_spacing};
	--g5-header-customize-left-spacing: {$header_customize_left_spacing};
	--g5-header-customize-right-spacing: {$header_customize_right_spacing};
	--g5-header-customize-mobile-spacing: {$header_customize_mobile_spacing};
	
	--g5-color-accent-darken : {$accent_color_darken};
	--g5-color-accent-lighten : {$accent_color_lighten};
	
	--g5-background-color-contrast : {$background_color_contrast};
	--g5-background-color-contrast-02 : {$background_color_contrast_02};
	--g5-background-color-contrast-03 : {$background_color_contrast_03};
	--g5-background-color-contrast-04: {$background_color_contrast_04};
	--g5-background-color-contrast-05 : {$background_color_contrast_05};
	--g5-background-color-contrast-06 : {$background_color_contrast_06};
	--g5-background-color-contrast-07: {$background_color_contrast_07};
	--g5-background-color-contrast-08: {$background_color_contrast_08};
	--g5-background-color-contrast-09: {$background_color_contrast_09};
	--g5-background-color-contrast-10 : {$background_color_contrast_10};
	--g5-background-color-contrast-11 : {$background_color_contrast_11};
	--g5-background-color-contrast-12 : {$background_color_contrast_12};
	--g5-background-color-contrast-13 : {$background_color_contrast_13};
	--g5-background-color-contrast-14 : {$background_color_contrast_14};
	--g5-background-color-contrast-15 : {$background_color_contrast_15};
	--g5-background-color-contrast-16 : {$background_color_contrast_16};
	
	
	--g5-menu-vertical-background-color-1 : {$menu_vertical_background_color_1};
	--g5-menu-vertical-background-color-2 : {$menu_vertical_background_color_2};
	--g5-menu-vertical-background-color-3 : {$menu_vertical_background_color_3};
	--g5-menu-vertical-background-color-4 : {$menu_vertical_background_color_4};
	--g5-menu-vertical-background-color-5 : {$menu_vertical_background_color_5};
	--g5-menu-vertical-background-color-6 : {$menu_vertical_background_color_6};
	--g5-menu-vertical-background-color-7 : {$menu_vertical_background_color_7};
	
	--g5-mobile-menu-background-color-contrast : {$mobile_menu_background_color_contrast};
	
	--g5-main-menu-vertical-background-color-1 : {$main_menu_vertical_background_color_1};
	--g5-main-menu-vertical-background-color-2 : {$main_menu_vertical_background_color_2};
	--g5-main-menu-vertical-background-color-3 : {$main_menu_vertical_background_color_3};
	--g5-main-menu-vertical-background-color-4 : {$main_menu_vertical_background_color_4};
	--g5-main-menu-vertical-background-color-5 : {$main_menu_vertical_background_color_5};
	--g5-main-menu-vertical-background-color-6 : {$main_menu_vertical_background_color_6};
	--g5-main-menu-vertical-background-color-7 : {$main_menu_vertical_background_color_7};
	
}
CSS;
		}

		public function get_skins_variable()
		{
			$skins = $this->getSkinsVariable();
			$custom_css = '';
			$accent_color = $this->process_color_value(G5P()->options()->get_accent_color(), '#7fa15a');
			foreach ($skins as $k => $v) {

				$content_skin_variables = $this->getSkinVariable($k);
				$text_color = $content_skin_variables['text_color'];
				$text_hover_color = (isset($content_skin_variables['text_hover_color']) && !empty($content_skin_variables['text_hover_color'])) ? $content_skin_variables['text_hover_color'] : $accent_color;
				$background_color = $content_skin_variables['background_color'];
				$heading_color = $content_skin_variables['heading_color'];
				$disable_color = $content_skin_variables['disable_color'];
				$border_color = $content_skin_variables['border_color'];

				$background_color_contrast = $this->color_contrast($background_color, '#444', '#f8f8f8');
				$background_color_contrast_02 = $this->color_contrast($background_color, '#444', '#f5f5f5');
				$background_color_contrast_03 = $this->color_contrast($background_color, '#444', '#f8f8f8');
				$background_color_contrast_04 = $this->color_contrast($background_color, '#555', '#E0E8EE');
				$background_color_contrast_05 = $this->color_contrast( $background_color , 'rgba(93, 151, 175, 0.7)','rgba(255, 255, 255, 0.7)');
				$background_color_contrast_06 = $this->color_contrast($background_color, '#444', '#f9f9f9');
				$background_color_contrast_07 = $this->color_contrast($background_color, '#666', '#333');
				$background_color_contrast_08 = $this->color_contrast($background_color,$text_color, $disable_color);
				$background_color_contrast_09 = $this->color_contrast($background_color, '#444', '#fafafa');
				$background_color_contrast_10 = $this->color_contrast( $background_color , '#fff','#000');
				$background_color_contrast_11 = $this->color_contrast( $background_color , '#666','#9b9b9b');
				$background_color_contrast_12 = $this->color_contrast( $background_color , '#444','#ababab');
				$background_color_contrast_13 = $this->color_contrast( $background_color , '#202020','#f8f8f8');
				$background_color_contrast_14 = $this->color_contrast( $background_color , '#444','#ccc');
				$background_color_contrast_15 = $this->color_contrast( $background_color , '#ababab','#d6d6d6');



				$custom_css .= <<<CSS
			.{$k} {
				--g5-color-heading: {$heading_color};
				--g5-color-text-main: {$text_color};
				--g5-background-color: {$background_color};
				--g5-color-muted : {$disable_color};
				
				--g5-color-link-hover: {$text_hover_color};
				--g5-color-border : {$border_color};
				
				--g5-background-color-contrast : {$background_color_contrast};
				--g5-background-color-contrast-02 : {$background_color_contrast_02};
				--g5-background-color-contrast-03 : {$background_color_contrast_03};
				--g5-background-color-contrast-04: {$background_color_contrast_04};
				--g5-background-color-contrast-05 : {$background_color_contrast_05};
				--g5-background-color-contrast-06 : {$background_color_contrast_06};
				--g5-background-color-contrast-07: {$background_color_contrast_07};
				--g5-background-color-contrast-08: {$background_color_contrast_08};
				--g5-background-color-contrast-09: {$background_color_contrast_09};
				--g5-background-color-contrast-10 : {$background_color_contrast_10};
				--g5-background-color-contrast-11 : {$background_color_contrast_11};
				--g5-background-color-contrast-12 : {$background_color_contrast_12};
				--g5-background-color-contrast-13 : {$background_color_contrast_13};
				--g5-background-color-contrast-14 : {$background_color_contrast_14};
				--g5-background-color-contrast-15 : {$background_color_contrast_15};

			}
CSS;

			}

			return $custom_css;
		}

		public function process_unit_value($value, $default)
		{
			return (empty($value) ? $default : $value) . 'px';
		}

		public function process_spacing($spacing, $default)
		{
			foreach ($default as $key => $value) {
				$spacing[$key] = (!isset($spacing[$key]) || empty($spacing[$key]) ? $value : $spacing[$key]) . 'px';
			}
			return $spacing;
		}

		private function &get_header_spacing_default($header_layout)
		{
			$header_default = null;
			switch ($header_layout) {
				case 'header-8':
				case 'header-9':
				case 'header-11':
				case 'header-12':
					$header_default = array(
						'navigation_height' => '40',
						'header_padding_top' => '0',
						'header_padding_bottom' => '0',
						'logo_max_height' => '90',
						'logo_padding_top' => '19',
						'logo_padding_bottom' => '19'
					);
					break;
				default:
					$header_default = array(
						'navigation_height' => '70',
						'header_padding_top' => '0',
						'header_padding_bottom' => '0',
						'logo_max_height' => '125',
						'logo_padding_top' => '10',
						'logo_padding_bottom' => '10'
					);
					break;
			}
			return $header_default;
		}

		public function process_color_value($value, $default)
		{
			return empty($value) ? $default : $value;
		}

		private function getSkinsVariable()
		{
			$color_keys = array(
				'background_color',
				'text_color',
				'text_hover_color',
				'heading_color',
				'disable_color',
				'border_color',
			);
			$skins = array();
			$options_default = G5P()->optionsSkin()->getDefault();
			$css_variable_default = $options_default['color_skin'][0];
			$color_skin = G5P()->optionsSkin()->get_color_skin();
			if (is_array($color_skin)) {
				foreach ($color_skin as $key => $value) {
					foreach ($color_keys as $color_key) {
						$value[$color_key] = (empty($value[$color_key]) && $color_key !== 'text_hover_color') ? $css_variable_default[$color_key] : $value[$color_key];
						if($color_key === 'text_hover_color' && empty($value[$color_key])) {
							$value[$color_key] = G5P()->options()->get_accent_color();
						}
					}
					if (isset($value['skin_id'])) {
						$skins[$value['skin_id']] = $value;
					}
				}
			}
			return $skins;
		}

		public function getSkinVariable($skin_id)
		{
			$skins = $this->getSkinsVariable();
			if (array_key_exists($skin_id, $skins)) {
				return $skins[$skin_id];
			}
			$options_default = G5P()->optionsSkin()->getDefault();
			return $options_default['color_skin'][0];
		}

		public function color_to_rgba($color)
		{
			if (preg_match('/^\#([0-9a-f])([0-9a-f])([0-9a-f])$/i', $color, $matchs)) {
				return array(
					hexdec($matchs[1] . $matchs[1]),
					hexdec($matchs[2] . $matchs[2]),
					hexdec($matchs[3] . $matchs[3]),
					1
				);
			}
			if (preg_match('/^\#([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})$/i', $color, $matchs)) {
				return array(
					hexdec($matchs[1]),
					hexdec($matchs[2]),
					hexdec($matchs[3]),
					1
				);
			}
			if (preg_match('/^rgba\((\d{1,3})\,(\d{1,3})\,(\d{1,3}),(.*)\)$/i', $color, $matchs)) {
				if (($matchs[1] >= 0) && ($matchs[1] < 256)
					&& ($matchs[2] >= 0) && ($matchs[2] < 256)
					&& ($matchs[3] >= 0) && ($matchs[3] < 256)
					&& is_numeric($matchs[4])) {
					return array(
						intval($matchs[1]),
						intval($matchs[2]),
						intval($matchs[3]),
						intval($matchs[4])
					);
				}
			}
			if (preg_match('/^rgb\((\d{1,3})\,(\d{1,3})\,(\d{1,3})\)$/i', $color, $matchs)) {
				if (($matchs[1] >= 0) && ($matchs[1] < 256)
					&& ($matchs[2] >= 0) && ($matchs[2] < 256)
					&& ($matchs[3] >= 0) && ($matchs[3] < 256)) {
					return array(
						intval($matchs[1]),
						intval($matchs[2]),
						intval($matchs[3]),
						1
					);
				}
			}

			return array();
		}

		public function color_to_rgba_color($color, $opacity = null)
		{
			$rgba = $this->color_to_rgba($color);
			if (empty($rgba)) {
				return $color;
			}
			if ($opacity !== null) {
				$rgba[3] = $opacity;
			}
			return "rgba({$rgba[0]},{$rgba[1]},{$rgba[2]},{$rgba[3]})";
		}

		public function color_to_hsla($color)
		{
			$rgb = $this->color_to_rgba($color);
			if (empty($rgb)) {
				return array(
					'H' => 0,
					'S' => 0,
					'L' => 0,
					'A' => 0,
				); // Fail to return Black Color
			}

			$R = $rgb[0];
			$G = $rgb[1];
			$B = $rgb[2];

			$HSLA = array();

			$var_R = ($R / 255);
			$var_G = ($G / 255);
			$var_B = ($B / 255);

			$var_Min = min($var_R, $var_G, $var_B);
			$var_Max = max($var_R, $var_G, $var_B);
			$del_Max = $var_Max - $var_Min;

			$L = ($var_Max + $var_Min) / 2;

			if ($del_Max == 0) {
				$H = 0;
				$S = 0;
			} else {
				if ($L < 0.5) {
					$S = $del_Max / ($var_Max + $var_Min);
				} else {
					$S = $del_Max / (2 - $var_Max - $var_Min);
				}

				$del_R = ((($var_Max - $var_R) / 6) + ($del_Max / 2)) / $del_Max;
				$del_G = ((($var_Max - $var_G) / 6) + ($del_Max / 2)) / $del_Max;
				$del_B = ((($var_Max - $var_B) / 6) + ($del_Max / 2)) / $del_Max;

				if ($var_R == $var_Max) {
					$H = $del_B - $del_G;
				} else if ($var_G == $var_Max) {
					$H = (1 / 3) + $del_R - $del_B;
				} else if ($var_B == $var_Max) {
					$H = (2 / 3) + $del_G - $del_R;
				}

				if ($H < 0) {
					$H++;
				}
				if ($H > 1) {
					$H--;
				}
			}

			$HSLA['H'] = ($H * 360);
			$HSLA['S'] = $S;
			$HSLA['L'] = $L;
			$HSLA['A'] = $rgb[3];

			return $HSLA;
		}

		public function color_from_hsla($hsla)
		{
			if (!is_array($hsla) && (count($hsla) != 4)) {
				return '#000'; // Fail to return black to color
			}
			list($H, $S, $L, $A) = array($hsla['H'] / 360, $hsla['S'], $hsla['L'], $hsla['A']);

			if ($S == 0) {
				$r = round($L * 255);
				$g = round($L * 255);
				$b = round($L * 255);
			} else {

				if ($L < 0.5) {
					$hue_value_2 = $L * (1 + $S);
				} else {
					$hue_value_2 = ($L + $S) - ($S * $L);
				}

				$hue_value_1 = 2 * $L - $hue_value_2;

				$r = round(255 * $this->color_hue_to_rgb($hue_value_1, $hue_value_2, $H + (1 / 3)));
				$g = round(255 * $this->color_hue_to_rgb($hue_value_1, $hue_value_2, $H));
				$b = round(255 * $this->color_hue_to_rgb($hue_value_1, $hue_value_2, $H - (1 / 3)));

			}

			if ($A < 1) {
				return "rgba({$r},{$g},{$b},{$A})";
			}

			// Convert to hex
			$r = dechex($r);
			$g = dechex($g);
			$b = dechex($b);

			// Make sure we get 2 digits for decimals
			$r = (strlen("" . $r) === 1) ? "0" . $r : $r;
			$g = (strlen("" . $g) === 1) ? "0" . $g : $g;
			$b = (strlen("" . $b) === 1) ? "0" . $b : $b;


			return "#{$r}{$g}{$b}";
		}

		public function color_hue_to_rgb($v1, $v2, $vH)
		{
			if ($vH < 0) {
				$vH += 1;
			}

			if ($vH > 1) {
				$vH -= 1;
			}

			if ((6 * $vH) < 1) {
				return ($v1 + ($v2 - $v1) * 6 * $vH);
			}

			if ((2 * $vH) < 1) {
				return $v2;
			}

			if ((3 * $vH) < 2) {
				return ($v1 + ($v2 - $v1) * ((2 / 3) - $vH) * 6);
			}

			return $v1;

		}

		public function color_adjust_hue($color, $value)
		{
			$hsla = $this->color_to_hsla($color);
			$hsla['H'] = $hsla['H'] + $value;
			return $this->color_from_hsla($hsla);
		}

		public function color_desaturate($color, $value)
		{
			$hsla = $this->color_to_hsla($color);
			$hsla['S'] = $hsla['S'] - $value;
			return $this->color_from_hsla($hsla);
		}

		public function color_for_gradient($color)
		{
			$hsla = $this->color_to_hsla($color);
			$hsla['H'] = $hsla['H'] + 333;
			$hsla['S'] = $hsla['S'] - 6.04;
			$hsla['L'] = max($hsla['L'] - 0.0765, 0);
			return $this->color_from_hsla($hsla);
		}

		public function color_is_dark($color)
		{
			$hsl = $this->color_to_hsla($color);
			return $hsl['L'] < 0.75;
		}

		public function color_is_light($color)
		{
			return !$this->color_is_dark($color);
		}

		public function color_invert($color)
		{
			$rgba = $this->color_to_rgba($color);

			$rgba[0] = 255 - $rgba[0];
			$rgba[1] = 255 - $rgba[1];
			$rgba[2] = 255 - $rgba[2];

			if ($rgba[3] < 1) {
				return "rgba({$rgba[0]},{$rgba[1]},{$rgba[2]},{$rgba[3]})";
			}
			// Convert to hex
			$rgba[0] = dechex($rgba[0]);
			$rgba[1] = dechex($rgba[1]);
			$rgba[2] = dechex($rgba[2]);

			$rgba[0] = (strlen("" . $rgba[0]) === 1) ? "0" . $rgba[0] : $rgba[0];
			$rgba[1] = (strlen("" . $rgba[1]) === 1) ? "0" . $rgba[1] : $rgba[1];
			$rgba[2] = (strlen("" . $rgba[2]) === 1) ? "0" . $rgba[2] : $rgba[2];

			return "#{$rgba[0]}{$rgba[1]}{$rgba[2]}";

		}

		public function color_neutral($color, $color_1, $color_2)
		{
			$hsl = $this->color_to_hsla($color);
			if ($hsl["L"] < 0.5) {
				return $color_1;
			}
			return $color_2;
		}

		public function color_contrast($color, $lightColor = '#fff', $darkColor = '#222')
		{

			return $this->color_is_dark($color) ? $lightColor : $darkColor;
		}

		public function color_lighten($color, $step = '10%')
		{
			if (is_numeric($step)) {
				$step = $step / 255;
			} else {
				$step = floatval($step) / 100;
			}

			$hsla = $this->color_to_hsla($color);
			$hsla['L'] = min($hsla['L'] + $step, 1);
			return $this->color_from_hsla($hsla);
		}

		public function color_darken($color, $step = '10%')
		{
			if (is_numeric($step)) {
				$step = $step / 255;
			} else {
				$step = floatval($step) / 100;
			}

			$hsla = $this->color_to_hsla($color);
			$hsla['L'] = max($hsla['L'] - $step, 0);

			return $this->color_from_hsla($hsla);
		}

		public function color_adjust_brightness($color, $step = '10%')
		{
			return $this->color_is_dark($color)
				? $this->color_lighten($color, $step)
				: $this->color_darken($color, $step);
		}

		public function is_color($color)
		{
			$rgba = $this->color_to_rgba($color);
			return !empty($rgba);
		}
	}
}