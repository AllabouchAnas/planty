<?php
if (!class_exists('G5Plus_Lustria_Options')) {
    class G5Plus_Lustria_Options
    {
        private static $_instance;
        public static function getInstance() {
            if (self::$_instance == NULL) { self::$_instance = new self(); }
            return self::$_instance;
        }
        public function get_lazy_load_images(){ return $this->getOptions('lazy_load_images'); }
        public function get_custom_scroll(){ return $this->getOptions('custom_scroll'); }
        public function get_custom_scroll_width(){ return $this->getOptions('custom_scroll_width'); }
        public function get_custom_scroll_color(){ return $this->getOptions('custom_scroll_color'); }
        public function get_custom_scroll_thumb_color(){ return $this->getOptions('custom_scroll_thumb_color'); }
        public function get_back_to_top(){ return $this->getOptions('back_to_top'); }
        public function get_rtl_enable(){ return $this->getOptions('rtl_enable'); }
        public function get_google_map_api_key(){ return $this->getOptions('google_map_api_key'); }
        public function get_social_meta_enable(){ return $this->getOptions('social_meta_enable'); }
        public function get_twitter_author_username(){ return $this->getOptions('twitter_author_username'); }
        public function get_googleplus_author(){ return $this->getOptions('googleplus_author'); }
        public function get_breadcrumb_enable(){ return $this->getOptions('breadcrumb_enable'); }
        public function get_breadcrumb_show_categories(){ return $this->getOptions('breadcrumb_show_categories'); }
        public function get_breadcrumb_show_post_type_archive(){ return $this->getOptions('breadcrumb_show_post_type_archive'); }
        public function get_search_popup_post_type(){ return $this->getOptions('search_popup_post_type'); }
        public function get_search_popup_result_amount(){ return $this->getOptions('search_popup_result_amount'); }
        public function get_maintenance_mode(){ return $this->getOptions('maintenance_mode'); }
        public function get_maintenance_mode_page(){ return $this->getOptions('maintenance_mode_page'); }
        public function get_page_transition(){ return $this->getOptions('page_transition'); }
        public function get_loading_animation(){ return $this->getOptions('loading_animation'); }
        public function get_loading_logo(){ return $this->getOptions('loading_logo'); }
        public function get_loading_animation_bg_color(){ return $this->getOptions('loading_animation_bg_color'); }
        public function get_spinner_color(){ return $this->getOptions('spinner_color'); }
        public function get_custom_favicon(){ return $this->getOptions('custom_favicon'); }
        public function get_custom_ios_title(){ return $this->getOptions('custom_ios_title'); }
        public function get_custom_ios_icon57(){ return $this->getOptions('custom_ios_icon57'); }
        public function get_custom_ios_icon72(){ return $this->getOptions('custom_ios_icon72'); }
        public function get_custom_ios_icon114(){ return $this->getOptions('custom_ios_icon114'); }
        public function get_custom_ios_icon144(){ return $this->getOptions('custom_ios_icon144'); }
        public function get_404_content_block(){ return $this->getOptions('404_content_block'); }
        public function get_404_content(){ return $this->getOptions('404_content'); }
        public function get_main_layout(){ return $this->getOptions('main_layout'); }
        public function get_content_full_width(){ return $this->getOptions('content_full_width'); }
        public function get_content_padding(){ return $this->getOptions('content_padding'); }
        public function get_sidebar_layout(){ return $this->getOptions('sidebar_layout'); }
        public function get_sidebar(){ return $this->getOptions('sidebar'); }
        public function get_sidebar_width(){ return $this->getOptions('sidebar_width'); }
        public function get_sidebar_sticky_enable(){ return $this->getOptions('sidebar_sticky_enable'); }
        public function get_mobile_sidebar_enable(){ return $this->getOptions('mobile_sidebar_enable'); }
        public function get_mobile_content_padding(){ return $this->getOptions('mobile_content_padding'); }
        public function get_top_drawer_mode(){ return $this->getOptions('top_drawer_mode'); }
        public function get_top_drawer_content_block(){ return $this->getOptions('top_drawer_content_block'); }
        public function get_top_drawer_content_full_width(){ return $this->getOptions('top_drawer_content_full_width'); }
        public function get_top_drawer_padding(){ return $this->getOptions('top_drawer_padding'); }
        public function get_top_drawer_border(){ return $this->getOptions('top_drawer_border'); }
        public function get_mobile_top_drawer_enable(){ return $this->getOptions('mobile_top_drawer_enable'); }
        public function get_top_bar_enable(){ return $this->getOptions('top_bar_enable'); }
        public function get_top_bar_content_block(){ return $this->getOptions('top_bar_content_block'); }
        public function get_mobile_top_bar_enable(){ return $this->getOptions('mobile_top_bar_enable'); }
        public function get_mobile_top_bar_content_block(){ return $this->getOptions('mobile_top_bar_content_block'); }
        public function get_header_enable(){ return $this->getOptions('header_enable'); }
        public function get_header_responsive_breakpoint(){ return $this->getOptions('header_responsive_breakpoint'); }
        public function get_header_layout(){ return $this->getOptions('header_layout'); }
        public function get_header_customize_nav(){ return $this->getOptions('header_customize_nav'); }
        public function get_header_customize_nav_separator(){ return $this->getOptions('header_customize_nav_separator'); }
        public function get_header_customize_nav_separator_bg_color(){ return $this->getOptions('header_customize_nav_separator_bg_color'); }
        public function get_header_customize_nav_search_type(){ return $this->getOptions('header_customize_nav_search_type'); }
        public function get_header_customize_nav_sidebar(){ return $this->getOptions('header_customize_nav_sidebar'); }
        public function get_header_customize_nav_social_networks(){ return $this->getOptions('header_customize_nav_social_networks'); }
        public function get_header_customize_nav_custom_html(){ return $this->getOptions('header_customize_nav_custom_html'); }
        public function get_header_customize_nav_spacing(){ return $this->getOptions('header_customize_nav_spacing'); }
        public function get_header_customize_nav_custom_css(){ return $this->getOptions('header_customize_nav_custom_css'); }
        public function get_header_customize_left(){ return $this->getOptions('header_customize_left'); }
        public function get_header_customize_left_separator(){ return $this->getOptions('header_customize_left_separator'); }
        public function get_header_customize_left_separator_bg_color(){ return $this->getOptions('header_customize_left_separator_bg_color'); }
        public function get_header_customize_left_search_type(){ return $this->getOptions('header_customize_left_search_type'); }
        public function get_header_customize_left_sidebar(){ return $this->getOptions('header_customize_left_sidebar'); }
        public function get_header_customize_left_social_networks(){ return $this->getOptions('header_customize_left_social_networks'); }
        public function get_header_customize_left_custom_html(){ return $this->getOptions('header_customize_left_custom_html'); }
        public function get_header_customize_left_spacing(){ return $this->getOptions('header_customize_left_spacing'); }
        public function get_header_customize_left_custom_css(){ return $this->getOptions('header_customize_left_custom_css'); }
        public function get_header_customize_right(){ return $this->getOptions('header_customize_right'); }
        public function get_header_customize_right_separator(){ return $this->getOptions('header_customize_right_separator'); }
        public function get_header_customize_right_separator_bg_color(){ return $this->getOptions('header_customize_right_separator_bg_color'); }
        public function get_header_customize_right_search_type(){ return $this->getOptions('header_customize_right_search_type'); }
        public function get_header_customize_right_sidebar(){ return $this->getOptions('header_customize_right_sidebar'); }
        public function get_header_customize_right_social_networks(){ return $this->getOptions('header_customize_right_social_networks'); }
        public function get_header_customize_right_custom_html(){ return $this->getOptions('header_customize_right_custom_html'); }
        public function get_header_customize_right_spacing(){ return $this->getOptions('header_customize_right_spacing'); }
        public function get_header_customize_right_custom_css(){ return $this->getOptions('header_customize_right_custom_css'); }
        public function get_header_content_full_width(){ return $this->getOptions('header_content_full_width'); }
        public function get_header_float_enable(){ return $this->getOptions('header_float_enable'); }
        public function get_header_sticky(){ return $this->getOptions('header_sticky'); }
        public function get_header_border(){ return $this->getOptions('header_border'); }
        public function get_header_above_border(){ return $this->getOptions('header_above_border'); }
        public function get_header_padding(){ return $this->getOptions('header_padding'); }
        public function get_navigation_height(){ return $this->getOptions('navigation_height'); }
        public function get_navigation_spacing(){ return $this->getOptions('navigation_spacing'); }
        public function get_mobile_header_layout(){ return $this->getOptions('mobile_header_layout'); }
        public function get_mobile_header_search_enable(){ return $this->getOptions('mobile_header_search_enable'); }
        public function get_mobile_header_float_enable(){ return $this->getOptions('mobile_header_float_enable'); }
        public function get_mobile_header_sticky(){ return $this->getOptions('mobile_header_sticky'); }
        public function get_mobile_header_border(){ return $this->getOptions('mobile_header_border'); }
        public function get_header_customize_mobile(){ return $this->getOptions('header_customize_mobile'); }
        public function get_header_customize_mobile_separator(){ return $this->getOptions('header_customize_mobile_separator'); }
        public function get_header_customize_mobile_separator_bg_color(){ return $this->getOptions('header_customize_mobile_separator_bg_color'); }
        public function get_header_customize_mobile_social_networks(){ return $this->getOptions('header_customize_mobile_social_networks'); }
        public function get_header_customize_mobile_custom_html(){ return $this->getOptions('header_customize_mobile_custom_html'); }
        public function get_header_customize_mobile_spacing(){ return $this->getOptions('header_customize_mobile_spacing'); }
        public function get_header_customize_mobile_custom_css(){ return $this->getOptions('header_customize_mobile_custom_css'); }
        public function get_mobile_header_padding(){ return $this->getOptions('mobile_header_padding'); }
        public function get_logo(){ return $this->getOptions('logo'); }
        public function get_logo_retina(){ return $this->getOptions('logo_retina'); }
        public function get_sticky_logo(){ return $this->getOptions('sticky_logo'); }
        public function get_sticky_logo_retina(){ return $this->getOptions('sticky_logo_retina'); }
        public function get_logo_max_height(){ return $this->getOptions('logo_max_height'); }
        public function get_logo_padding(){ return $this->getOptions('logo_padding'); }
        public function get_mobile_logo(){ return $this->getOptions('mobile_logo'); }
        public function get_mobile_logo_retina(){ return $this->getOptions('mobile_logo_retina'); }
        public function get_mobile_sticky_logo(){ return $this->getOptions('mobile_sticky_logo'); }
        public function get_mobile_sticky_logo_retina(){ return $this->getOptions('mobile_sticky_logo_retina'); }
        public function get_mobile_logo_max_height(){ return $this->getOptions('mobile_logo_max_height'); }
        public function get_mobile_logo_padding(){ return $this->getOptions('mobile_logo_padding'); }
        public function get_page_title_enable(){ return $this->getOptions('page_title_enable'); }
        public function get_page_title_content_block(){ return $this->getOptions('page_title_content_block'); }
        public function get_footer_enable(){ return $this->getOptions('footer_enable'); }
        public function get_footer_content_block(){ return $this->getOptions('footer_content_block'); }
        public function get_footer_fixed_enable(){ return $this->getOptions('footer_fixed_enable'); }
        public function get_body_font(){ return $this->getOptions('body_font'); }
        public function get_primary_font(){ return $this->getOptions('primary_font'); }
        public function get_h1_font(){ return $this->getOptions('h1_font'); }
        public function get_h2_font(){ return $this->getOptions('h2_font'); }
        public function get_h3_font(){ return $this->getOptions('h3_font'); }
        public function get_h4_font(){ return $this->getOptions('h4_font'); }
        public function get_h5_font(){ return $this->getOptions('h5_font'); }
        public function get_h6_font(){ return $this->getOptions('h6_font'); }
        public function get_menu_font(){ return $this->getOptions('menu_font'); }
        public function get_sub_menu_font(){ return $this->getOptions('sub_menu_font'); }
        public function get_mobile_menu_font(){ return $this->getOptions('mobile_menu_font'); }
        public function get_body_background(){ return $this->getOptions('body_background'); }
        public function get_accent_color(){ return $this->getOptions('accent_color'); }
        public function get_foreground_accent_color(){ return $this->getOptions('foreground_accent_color'); }
        public function get_primary_color(){ return $this->getOptions('primary_color'); }
        public function get_content_skin(){ return $this->getOptions('content_skin'); }
        public function get_content_background_color(){ return $this->getOptions('content_background_color'); }
        public function get_top_drawer_skin(){ return $this->getOptions('top_drawer_skin'); }
        public function get_top_drawer_background_color(){ return $this->getOptions('top_drawer_background_color'); }
        public function get_header_skin(){ return $this->getOptions('header_skin'); }
        public function get_header_background(){ return $this->getOptions('header_background'); }
        public function get_logo_text_color(){ return $this->getOptions('logo_text_color'); }
        public function get_header_border_color(){ return $this->getOptions('header_border_color'); }
        public function get_header_text_color(){ return $this->getOptions('header_text_color'); }
        public function get_header_text_hover_color(){ return $this->getOptions('header_text_hover_color'); }
        public function get_menu_skin(){ return $this->getOptions('menu_skin'); }
        public function get_menu_background_color(){ return $this->getOptions('menu_background_color'); }
        public function get_menu_text_color(){ return $this->getOptions('menu_text_color'); }
        public function get_menu_text_hover_color(){ return $this->getOptions('menu_text_hover_color'); }
        public function get_menu_transition(){ return $this->getOptions('menu_transition'); }
        public function get_submenu_skin(){ return $this->getOptions('submenu_skin'); }
        public function get_submenu_background_color(){ return $this->getOptions('submenu_background_color'); }
        public function get_submenu_text_color(){ return $this->getOptions('submenu_text_color'); }
        public function get_submenu_text_hover_color(){ return $this->getOptions('submenu_text_hover_color'); }
        public function get_submenu_heading_color(){ return $this->getOptions('submenu_heading_color'); }
        public function get_submenu_border_color(){ return $this->getOptions('submenu_border_color'); }
        public function get_menu_customize_text_color(){ return $this->getOptions('menu_customize_text_color'); }
        public function get_menu_customize_text_hover_color(){ return $this->getOptions('menu_customize_text_hover_color'); }
        public function get_canvas_sidebar_skin(){ return $this->getOptions('canvas_sidebar_skin'); }
        public function get_canvas_sidebar_background_color(){ return $this->getOptions('canvas_sidebar_background_color'); }
        public function get_header_sticky_skin(){ return $this->getOptions('header_sticky_skin'); }
        public function get_header_sticky_background(){ return $this->getOptions('header_sticky_background'); }
        public function get_logo_sticky_text_color(){ return $this->getOptions('logo_sticky_text_color'); }
        public function get_header_sticky_text_color(){ return $this->getOptions('header_sticky_text_color'); }
        public function get_header_sticky_text_hover_color(){ return $this->getOptions('header_sticky_text_hover_color'); }
        public function get_mobile_header_skin(){ return $this->getOptions('mobile_header_skin'); }
        public function get_mobile_header_background(){ return $this->getOptions('mobile_header_background'); }
        public function get_mobile_logo_text_color(){ return $this->getOptions('mobile_logo_text_color'); }
        public function get_mobile_header_border_color(){ return $this->getOptions('mobile_header_border_color'); }
        public function get_mobile_menu_skin(){ return $this->getOptions('mobile_menu_skin'); }
        public function get_mobile_menu_background_color(){ return $this->getOptions('mobile_menu_background_color'); }
        public function get_mobile_menu_text_color(){ return $this->getOptions('mobile_menu_text_color'); }
        public function get_mobile_menu_text_hover_color(){ return $this->getOptions('mobile_menu_text_hover_color'); }
        public function get_mobile_menu_customize_text_color(){ return $this->getOptions('mobile_menu_customize_text_color'); }
        public function get_mobile_menu_customize_text_hover_color(){ return $this->getOptions('mobile_menu_customize_text_hover_color'); }
        public function get_mobile_header_sticky_skin(){ return $this->getOptions('mobile_header_sticky_skin'); }
        public function get_mobile_header_sticky_background(){ return $this->getOptions('mobile_header_sticky_background'); }
        public function get_mobile_logo_sticky_text_color(){ return $this->getOptions('mobile_logo_sticky_text_color'); }
        public function get_mobile_menu_customize_sticky_text_color(){ return $this->getOptions('mobile_menu_customize_sticky_text_color'); }
        public function get_mobile_menu_customize_sticky_text_hover_color(){ return $this->getOptions('mobile_menu_customize_sticky_text_hover_color'); }
        public function get_page_title_skin(){ return $this->getOptions('page_title_skin'); }
        public function get_page_title_background_color(){ return $this->getOptions('page_title_background_color'); }
        public function get_social_share(){ return $this->getOptions('social_share'); }
        public function get_social_networks(){ return $this->getOptions('social_networks'); }
        public function get_post_layout(){ return $this->getOptions('post_layout'); }
        public function get_post_image_size(){ return $this->getOptions('post_image_size'); }
        public function get_post_image_width(){ return $this->getOptions('post_image_width'); }
        public function get_post_image_ratio(){ return $this->getOptions('post_image_ratio'); }
        public function get_post_image_ratio_custom(){ return $this->getOptions('post_image_ratio_custom'); }
        public function get_blog_cate_filter(){ return $this->getOptions('blog_cate_filter'); }
        public function get_default_thumbnail_placeholder_enable(){ return $this->getOptions('default_thumbnail_placeholder_enable'); }
        public function get_default_thumbnail_image(){ return $this->getOptions('default_thumbnail_image'); }
        public function get_first_image_as_post_thumbnail(){ return $this->getOptions('first_image_as_post_thumbnail'); }
        public function get_post_columns_gutter(){ return $this->getOptions('post_columns_gutter'); }
        public function get_post_columns(){ return $this->getOptions('post_columns'); }
        public function get_post_columns_md(){ return $this->getOptions('post_columns_md'); }
        public function get_post_columns_sm(){ return $this->getOptions('post_columns_sm'); }
        public function get_post_columns_xs(){ return $this->getOptions('post_columns_xs'); }
        public function get_post_columns_mb(){ return $this->getOptions('post_columns_mb'); }
        public function get_posts_per_page(){ return $this->getOptions('posts_per_page'); }
        public function get_post_paging(){ return $this->getOptions('post_paging'); }
        public function get_post_animation(){ return $this->getOptions('post_animation'); }
        public function get_post_ads(){ return $this->getOptions('post_ads'); }
        public function get_search_post_layout(){ return $this->getOptions('search_post_layout'); }
        public function get_search_post_image_size(){ return $this->getOptions('search_post_image_size'); }
        public function get_search_post_image_width(){ return $this->getOptions('search_post_image_width'); }
        public function get_search_post_image_ratio(){ return $this->getOptions('search_post_image_ratio'); }
        public function get_search_post_image_ratio_custom(){ return $this->getOptions('search_post_image_ratio_custom'); }
        public function get_search_post_columns_gutter(){ return $this->getOptions('search_post_columns_gutter'); }
        public function get_search_post_columns(){ return $this->getOptions('search_post_columns'); }
        public function get_search_post_columns_md(){ return $this->getOptions('search_post_columns_md'); }
        public function get_search_post_columns_sm(){ return $this->getOptions('search_post_columns_sm'); }
        public function get_search_post_columns_xs(){ return $this->getOptions('search_post_columns_xs'); }
        public function get_search_post_columns_mb(){ return $this->getOptions('search_post_columns_mb'); }
        public function get_search_posts_per_page(){ return $this->getOptions('search_posts_per_page'); }
        public function get_search_post_paging(){ return $this->getOptions('search_post_paging'); }
        public function get_search_post_animation(){ return $this->getOptions('search_post_animation'); }
        public function get_search_post_type(){ return $this->getOptions('search_post_type'); }
        public function get_single_post_layout(){ return $this->getOptions('single_post_layout'); }
        public function get_single_reading_process_enable(){ return $this->getOptions('single_reading_process_enable'); }
        public function get_single_tag_enable(){ return $this->getOptions('single_tag_enable'); }
        public function get_single_share_enable(){ return $this->getOptions('single_share_enable'); }
        public function get_single_navigation_enable(){ return $this->getOptions('single_navigation_enable'); }
        public function get_single_author_info_enable(){ return $this->getOptions('single_author_info_enable'); }
        public function get_single_related_post_enable(){ return $this->getOptions('single_related_post_enable'); }
        public function get_single_related_post_algorithm(){ return $this->getOptions('single_related_post_algorithm'); }
        public function get_single_related_post_carousel_enable(){ return $this->getOptions('single_related_post_carousel_enable'); }
        public function get_single_related_post_per_page(){ return $this->getOptions('single_related_post_per_page'); }
        public function get_single_related_post_columns_gutter(){ return $this->getOptions('single_related_post_columns_gutter'); }
        public function get_single_related_post_columns(){ return $this->getOptions('single_related_post_columns'); }
        public function get_single_related_post_columns_md(){ return $this->getOptions('single_related_post_columns_md'); }
        public function get_single_related_post_columns_sm(){ return $this->getOptions('single_related_post_columns_sm'); }
        public function get_single_related_post_columns_xs(){ return $this->getOptions('single_related_post_columns_xs'); }
        public function get_single_related_post_columns_mb(){ return $this->getOptions('single_related_post_columns_mb'); }
        public function get_single_related_post_paging(){ return $this->getOptions('single_related_post_paging'); }
        public function get_single_related_post_animation(){ return $this->getOptions('single_related_post_animation'); }
        public function get_product_featured_label_enable(){ return $this->getOptions('product_featured_label_enable'); }
        public function get_product_featured_label_text(){ return $this->getOptions('product_featured_label_text'); }
        public function get_product_sale_label_enable(){ return $this->getOptions('product_sale_label_enable'); }
        public function get_product_sale_flash_mode(){ return $this->getOptions('product_sale_flash_mode'); }
        public function get_product_sale_label_text(){ return $this->getOptions('product_sale_label_text'); }
        public function get_product_new_label_enable(){ return $this->getOptions('product_new_label_enable'); }
        public function get_product_new_label_since(){ return $this->getOptions('product_new_label_since'); }
        public function get_product_new_label_text(){ return $this->getOptions('product_new_label_text'); }
        public function get_product_sale_count_down_enable(){ return $this->getOptions('product_sale_count_down_enable'); }
        public function get_product_add_to_cart_enable(){ return $this->getOptions('product_add_to_cart_enable'); }
        public function get_product_catalog_layout(){ return $this->getOptions('product_catalog_layout'); }
        public function get_product_columns_gutter(){ return $this->getOptions('product_columns_gutter'); }
        public function get_product_columns(){ return $this->getOptions('product_columns'); }
        public function get_product_columns_md(){ return $this->getOptions('product_columns_md'); }
        public function get_product_columns_sm(){ return $this->getOptions('product_columns_sm'); }
        public function get_product_columns_xs(){ return $this->getOptions('product_columns_xs'); }
        public function get_product_columns_mb(){ return $this->getOptions('product_columns_mb'); }
        public function get_product_per_page(){ return $this->getOptions('product_per_page'); }
        public function get_product_swatches_enable(){ return $this->getOptions('product_swatches_enable'); }
        public function get_product_swatches_taxonomies(){ return $this->getOptions('product_swatches_taxonomies'); }
        public function get_product_paging(){ return $this->getOptions('product_paging'); }
        public function get_product_animation(){ return $this->getOptions('product_animation'); }
        public function get_product_image_hover_effect(){ return $this->getOptions('product_image_hover_effect'); }
        public function get_product_category_enable(){ return $this->getOptions('product_category_enable'); }
        public function get_product_rating_enable(){ return $this->getOptions('product_rating_enable'); }
        public function get_product_quick_view_enable(){ return $this->getOptions('product_quick_view_enable'); }
        public function get_woocommerce_customize(){ return $this->getOptions('woocommerce_customize'); }
        public function get_woocommerce_customize_full_width(){ return $this->getOptions('woocommerce_customize_full_width'); }
        public function get_woocommerce_customize_padding(){ return $this->getOptions('woocommerce_customize_padding'); }
        public function get_woocommerce_customize_mobile(){ return $this->getOptions('woocommerce_customize_mobile'); }
        public function get_filter_columns(){ return $this->getOptions('filter_columns'); }
        public function get_filter_columns_md(){ return $this->getOptions('filter_columns_md'); }
        public function get_filter_columns_sm(){ return $this->getOptions('filter_columns_sm'); }
        public function get_filter_columns_xs(){ return $this->getOptions('filter_columns_xs'); }
        public function get_filter_columns_mb(){ return $this->getOptions('filter_columns_mb'); }
        public function get_woocommerce_customize_item_show(){ return $this->getOptions('woocommerce_customize_item_show'); }
        public function get_woocommerce_customize_sidebar(){ return $this->getOptions('woocommerce_customize_sidebar'); }
        public function get_product_single_layout(){ return $this->getOptions('product_single_layout'); }
        public function get_product_single_swatches_enable(){ return $this->getOptions('product_single_swatches_enable'); }
        public function get_product_related_enable(){ return $this->getOptions('product_related_enable'); }
        public function get_product_related_algorithm(){ return $this->getOptions('product_related_algorithm'); }
        public function get_product_related_carousel_enable(){ return $this->getOptions('product_related_carousel_enable'); }
        public function get_product_related_columns_gutter(){ return $this->getOptions('product_related_columns_gutter'); }
        public function get_product_related_columns(){ return $this->getOptions('product_related_columns'); }
        public function get_product_related_columns_md(){ return $this->getOptions('product_related_columns_md'); }
        public function get_product_related_columns_sm(){ return $this->getOptions('product_related_columns_sm'); }
        public function get_product_related_columns_xs(){ return $this->getOptions('product_related_columns_xs'); }
        public function get_product_related_columns_mb(){ return $this->getOptions('product_related_columns_mb'); }
        public function get_product_related_per_page(){ return $this->getOptions('product_related_per_page'); }
        public function get_product_related_animation(){ return $this->getOptions('product_related_animation'); }
        public function get_product_up_sells_enable(){ return $this->getOptions('product_up_sells_enable'); }
        public function get_product_up_sells_columns_gutter(){ return $this->getOptions('product_up_sells_columns_gutter'); }
        public function get_product_up_sells_columns(){ return $this->getOptions('product_up_sells_columns'); }
        public function get_product_up_sells_columns_md(){ return $this->getOptions('product_up_sells_columns_md'); }
        public function get_product_up_sells_columns_sm(){ return $this->getOptions('product_up_sells_columns_sm'); }
        public function get_product_up_sells_columns_xs(){ return $this->getOptions('product_up_sells_columns_xs'); }
        public function get_product_up_sells_columns_mb(){ return $this->getOptions('product_up_sells_columns_mb'); }
        public function get_product_up_sells_per_page(){ return $this->getOptions('product_up_sells_per_page'); }
        public function get_product_up_sells_animation(){ return $this->getOptions('product_up_sells_animation'); }
        public function get_product_cross_sells_enable(){ return $this->getOptions('product_cross_sells_enable'); }
        public function get_product_cross_sells_columns_gutter(){ return $this->getOptions('product_cross_sells_columns_gutter'); }
        public function get_product_cross_sells_columns(){ return $this->getOptions('product_cross_sells_columns'); }
        public function get_product_cross_sells_columns_md(){ return $this->getOptions('product_cross_sells_columns_md'); }
        public function get_product_cross_sells_columns_sm(){ return $this->getOptions('product_cross_sells_columns_sm'); }
        public function get_product_cross_sells_columns_xs(){ return $this->getOptions('product_cross_sells_columns_xs'); }
        public function get_product_cross_sells_columns_mb(){ return $this->getOptions('product_cross_sells_columns_mb'); }
        public function get_product_cross_sells_per_page(){ return $this->getOptions('product_cross_sells_per_page'); }
        public function get_product_cross_sells_animation(){ return $this->getOptions('product_cross_sells_animation'); }
        public function get_preset_page_404(){ return $this->getOptions('preset_page_404'); }
        public function get_preset_blog(){ return $this->getOptions('preset_blog'); }
        public function get_preset_single_blog(){ return $this->getOptions('preset_single_blog'); }
        public function get_preset_archive_product(){ return $this->getOptions('preset_archive_product'); }
        public function get_preset_single_product(){ return $this->getOptions('preset_single_product'); }
        public function get_custom_css(){ return $this->getOptions('custom_css'); }
        public function get_custom_js(){ return $this->getOptions('custom_js'); }
        public function getOptions($key) {
            if (function_exists('GSF')) {
                $option = &GSF()->adminThemeOption()->getOptions('g5plus_lustria_options');
            } else {
                $option = &$this->getDefault();
            }
            if (isset($option[$key])) {
                return $option[$key];
            }
            $option = &$this->getDefault();
            if (isset($option[$key])) {
                return $option[$key];
            }
            return '';
        }

        public function setOptions($key, $value) {
            if (function_exists('GSF')) {
                $option = &GSF()->adminThemeOption()->getOptions('g5plus_lustria_options');
            } else {
                $option = &$this->getDefault();
            }
            $option[$key] = $value;
        }

        public function &getDefault() {
            $default = array (
                'lazy_load_images' => '',
                'custom_scroll' => '',
                'custom_scroll_width' => 10,
                'custom_scroll_color' => '#19394B',
                'custom_scroll_thumb_color' => '#69d2e7',
                'back_to_top' => 'on',
                'rtl_enable' => '',
                'google_map_api_key' => 'AIzaSyDsUcTjt43mTheN9ruCsQVgBE-wgN6_AfY',
                'social_meta_enable' => '',
                'twitter_author_username' => '',
                'googleplus_author' => '',
                'breadcrumb_enable' => 'on',
                'breadcrumb_show_categories' => '',
                'breadcrumb_show_post_type_archive' => '',
                'search_popup_post_type' =>
                    array (
                        0 => 'post',
                        1 => 'product',
                    ),
                'search_popup_result_amount' => 8,
                'maintenance_mode' => '0',
                'maintenance_mode_page' => '',
                'page_transition' => '',
                'loading_animation' => '',
                'loading_logo' =>
                    array (
                        'id' => 0,
                        'url' => '',
                    ),
                'loading_animation_bg_color' => '#fff',
                'spinner_color' => '',
                'custom_favicon' =>
                    array (
                        'id' => 0,
                        'url' => '',
                    ),
                'custom_ios_title' => '',
                'custom_ios_icon57' =>
                    array (
                        'id' => 0,
                        'url' => '',
                    ),
                'custom_ios_icon72' =>
                    array (
                        'id' => 0,
                        'url' => '',
                    ),
                'custom_ios_icon114' =>
                    array (
                        'id' => 0,
                        'url' => '',
                    ),
                'custom_ios_icon144' =>
                    array (
                        'id' => 0,
                        'url' => '',
                    ),
                '404_content_block' => '',
                '404_content' => '',
                'main_layout' => 'wide',
                'content_full_width' => '',
                'content_padding' =>
                    array (
                        'left' => 0,
                        'right' => 0,
                        'top' => 50,
                        'bottom' => 50,
                    ),
                'sidebar_layout' => 'right',
                'sidebar' => 'main',
                'sidebar_width' => 'small',
                'sidebar_sticky_enable' => '',
                'mobile_sidebar_enable' => 'on',
                'mobile_content_padding' =>
                    array (
                        'left' => 0,
                        'right' => 0,
                        'top' => 50,
                        'bottom' => 50,
                    ),
                'top_drawer_mode' => 'hide',
                'top_drawer_content_block' => '',
                'top_drawer_content_full_width' => '',
                'top_drawer_padding' =>
                    array (
                        'left' => '',
                        'right' => '',
                        'top' => 10,
                        'bottom' => 10,
                    ),
                'top_drawer_border' => 'none',
                'mobile_top_drawer_enable' => '',
                'top_bar_enable' => '',
                'top_bar_content_block' => '',
                'mobile_top_bar_enable' => '',
                'mobile_top_bar_content_block' => '',
                'header_enable' => 'on',
                'header_responsive_breakpoint' => '991',
                'header_layout' => 'header-1',
                'header_customize_nav' =>
                    array (
                        0 => 'search',
                    ),
                'header_customize_nav_separator' => '',
                'header_customize_nav_separator_bg_color' => '#e0e0e0',
                'header_customize_nav_search_type' => 'icon',
                'header_customize_nav_sidebar' => '',
                'header_customize_nav_social_networks' =>
                    array (
                    ),
                'header_customize_nav_custom_html' => '',
                'header_customize_nav_spacing' => 25,
                'header_customize_nav_custom_css' => '',
                'header_customize_left' =>
                    array (
                    ),
                'header_customize_left_separator' => '',
                'header_customize_left_separator_bg_color' => '#e0e0e0',
                'header_customize_left_search_type' => 'icon',
                'header_customize_left_sidebar' => '',
                'header_customize_left_social_networks' =>
                    array (
                    ),
                'header_customize_left_custom_html' => '',
                'header_customize_left_spacing' => 25,
                'header_customize_left_custom_css' => '',
                'header_customize_right' =>
                    array (
                    ),
                'header_customize_right_separator' => '',
                'header_customize_right_separator_bg_color' => '#e0e0e0',
                'header_customize_right_search_type' => 'icon',
                'header_customize_right_sidebar' => '',
                'header_customize_right_social_networks' =>
                    array (
                    ),
                'header_customize_right_custom_html' => '',
                'header_customize_right_spacing' => 25,
                'header_customize_right_custom_css' => '',
                'header_content_full_width' => '',
                'header_float_enable' => '',
                'header_sticky' => 'scroll_up',
                'header_border' => 'none',
                'header_above_border' => 'none',
                'header_padding' =>
                    array (
                        'left' => '',
                        'right' => '',
                        'top' => '',
                        'bottom' => '',
                    ),
                'navigation_height' =>
                    array (
                        'width' => '',
                        'height' => '',
                    ),
                'navigation_spacing' => 35,
                'mobile_header_layout' => 'header-1',
                'mobile_header_search_enable' => '',
                'mobile_header_float_enable' => '',
                'mobile_header_sticky' => '',
                'mobile_header_border' => 'none',
                'header_customize_mobile' =>
                    array (
                        0 => 'search',
                    ),
                'header_customize_mobile_separator' => '',
                'header_customize_mobile_separator_bg_color' => '#e0e0e0',
                'header_customize_mobile_social_networks' =>
                    array (
                    ),
                'header_customize_mobile_custom_html' => '',
                'header_customize_mobile_spacing' => 25,
                'header_customize_mobile_custom_css' => '',
                'mobile_header_padding' =>
                    array (
                        'left' => '',
                        'right' => '',
                        'top' => '',
                        'bottom' => '',
                    ),
                'logo' =>
                    array (
                        'id' => 0,
                        'url' => '',
                    ),
                'logo_retina' =>
                    array (
                        'id' => 0,
                        'url' => '',
                    ),
                'sticky_logo' =>
                    array (
                        'id' => 0,
                        'url' => '',
                    ),
                'sticky_logo_retina' =>
                    array (
                        'id' => 0,
                        'url' => '',
                    ),
                'logo_max_height' =>
                    array (
                        'width' => '',
                        'height' => '',
                    ),
                'logo_padding' =>
                    array (
                        'left' => '',
                        'right' => '',
                        'top' => '',
                        'bottom' => '',
                    ),
                'mobile_logo' =>
                    array (
                        'id' => 0,
                        'url' => '',
                    ),
                'mobile_logo_retina' =>
                    array (
                        'id' => 0,
                        'url' => '',
                    ),
                'mobile_sticky_logo' =>
                    array (
                        'id' => 0,
                        'url' => '',
                    ),
                'mobile_sticky_logo_retina' =>
                    array (
                        'id' => 0,
                        'url' => '',
                    ),
                'mobile_logo_max_height' =>
                    array (
                        'width' => '',
                        'height' => '',
                    ),
                'mobile_logo_padding' =>
                    array (
                        'left' => '',
                        'right' => '',
                        'top' => '',
                        'bottom' => '',
                    ),
                'page_title_enable' => 'on',
                'page_title_content_block' => '',
                'footer_enable' => 'on',
                'footer_content_block' => '',
                'footer_fixed_enable' => '',
                'body_font' =>
                    array (
                        'font_family' => 'edmondsans',
                        'font_size' => '16px',
                        'font_weight' => 'regular',
                        'font_style' => '',
                    ),
                'primary_font' =>
                    array (
                        'font_family' => 'edmondsans',
                        'font_size' => '14',
                        'font_weight' => '400',
                        'font_style' => '',
                    ),
                'h1_font' =>
                    array (
                        'font_family' => 'edmondsans',
                        'font_size' => '55px',
                        'font_weight' => '700',
                        'font_style' => '',
                    ),
                'h2_font' =>
                    array (
                        'font_family' => 'edmondsans',
                        'font_size' => '40px',
                        'font_weight' => '700',
                        'font_style' => '',
                    ),
                'h3_font' =>
                    array (
                        'font_family' => 'edmondsans',
                        'font_size' => '32px',
                        'font_weight' => '500',
                        'font_style' => '',
                    ),
                'h4_font' =>
                    array (
                        'font_family' => 'edmondsans',
                        'font_size' => '25px',
                        'font_weight' => '500',
                        'font_style' => '',
                    ),
                'h5_font' =>
                    array (
                        'font_family' => 'edmondsans',
                        'font_size' => '20px',
                        'font_weight' => '500',
                        'font_style' => '',
                    ),
                'h6_font' =>
                    array (
                        'font_family' => 'edmondsans',
                        'font_size' => '16px',
                        'font_weight' => '500',
                        'font_style' => '',
                    ),
                'menu_font' =>
                    array (
                        'font_family' => 'edmondsans',
                        'font_size' => '18px',
                        'font_weight' => '500',
                        'font_style' => '',
                    ),
                'sub_menu_font' =>
                    array (
                        'font_family' => 'edmondsans',
                        'font_size' => '16px',
                        'font_weight' => '500',
                        'font_style' => '',
                    ),
                'mobile_menu_font' =>
                    array (
                        'font_family' => 'edmondsans',
                        'font_size' => '13px',
                        'font_weight' => '500',
                        'font_style' => '',
                    ),
                'body_background' =>
                    array (
                        'background_color' => '#fff',
                        'background_image_id' => 0,
                        'background_image_url' => '',
                        'background_repeat' => 'repeat',
                        'background_size' => 'contain',
                        'background_position' => 'center center',
                        'background_attachment' => 'scroll',
                    ),
                'accent_color' => '#7fa15a',
                'foreground_accent_color' => '#fff',
                'primary_color' => '#282727',
                'content_skin' => 'skin-light',
                'content_background_color' => '',
                'top_drawer_skin' => 'skin-dark',
                'top_drawer_background_color' => '',
                'header_skin' => 'light',
                'header_background' =>
                    array (
                        'background_color' => '#fff',
                        'background_image_id' => 0,
                        'background_image_url' => '',
                        'background_repeat' => 'repeat',
                        'background_size' => 'contain',
                        'background_position' => 'center center',
                        'background_attachment' => 'scroll',
                    ),
                'logo_text_color' => '#333',
                'header_border_color' => '#ededed',
                'header_text_color' => '#323232',
                'header_text_hover_color' => '',
                'menu_skin' => 'light',
                'menu_background_color' => '#fff',
                'menu_text_color' => '#323232',
                'menu_text_hover_color' => '',
                'menu_transition' => 'x-fadeInUp',
                'submenu_skin' => 'light',
                'submenu_background_color' => '#fff',
                'submenu_text_color' => '#323232',
                'submenu_text_hover_color' => '#7fa15a',
                'submenu_heading_color' => '#333',
                'submenu_border_color' => '#ededed',
                'menu_customize_text_color' => '',
                'menu_customize_text_hover_color' => '',
                'canvas_sidebar_skin' => 'skin-dark',
                'canvas_sidebar_background_color' => '',
                'header_sticky_skin' => 'light',
                'header_sticky_background' =>
                    array (
                        'background_color' => '#fff',
                        'background_image_id' => 0,
                        'background_image_url' => '',
                        'background_repeat' => 'repeat',
                        'background_size' => 'contain',
                        'background_position' => 'center center',
                        'background_attachment' => 'scroll',
                    ),
                'logo_sticky_text_color' => '#333',
                'header_sticky_text_color' => '#323232',
                'header_sticky_text_hover_color' => '',
                'mobile_header_skin' => 'light',
                'mobile_header_background' =>
                    array (
                        'background_color' => '#fff',
                        'background_image_id' => 0,
                        'background_image_url' => '',
                        'background_repeat' => 'repeat',
                        'background_size' => 'contain',
                        'background_position' => 'center center',
                        'background_attachment' => 'scroll',
                    ),
                'mobile_logo_text_color' => '#333',
                'mobile_header_border_color' => '#ededed',
                'mobile_menu_skin' => 'dark',
                'mobile_menu_background_color' => '#222',
                'mobile_menu_text_color' => 'rgba(255,255,255,0.7)',
                'mobile_menu_text_hover_color' => '#fff',
                'mobile_menu_customize_text_color' => '#323232',
                'mobile_menu_customize_text_hover_color' => '',
                'mobile_header_sticky_skin' => 'light',
                'mobile_header_sticky_background' =>
                    array (
                        'background_color' => '#fff',
                        'background_image_id' => 0,
                        'background_image_url' => '',
                        'background_repeat' => 'repeat',
                        'background_size' => 'contain',
                        'background_position' => 'center center',
                        'background_attachment' => 'scroll',
                    ),
                'mobile_logo_sticky_text_color' => '#333',
                'mobile_menu_customize_sticky_text_color' => '#333',
                'mobile_menu_customize_sticky_text_hover_color' => '',
                'page_title_skin' => '0',
                'page_title_background_color' => '',
                'social_share' =>
                    array (
                        'facebook' => 'facebook',
                        'twitter' => 'twitter',
                        'linkedin' => 'linkedin',
                        'tumblr' => 'tumblr',
                        'pinterest' => 'pinterest',
                    ),
                'social_networks' =>
                    array (
                        0 =>
                            array (
                                'social_name' => 'Facebook',
                                'social_id' => 'social-facebook',
                                'social_icon' => 'fab fa-facebook-f',
                                'social_link' => '',
                                'social_color' => '#3b5998',
                            ),
                        1 =>
                            array (
                                'social_name' => 'Twitter',
                                'social_id' => 'social-twitter',
                                'social_icon' => 'fab fa-twitter',
                                'social_link' => '',
                                'social_color' => '#1da1f2',
                            ),
                        2 =>
                            array (
                                'social_name' => 'Pinterest',
                                'social_id' => 'social-pinterest',
                                'social_icon' => 'fab fa-pinterest',
                                'social_link' => '',
                                'social_color' => '#bd081c',
                            ),
                        3 =>
                            array (
                                'social_name' => 'Dribbble',
                                'social_id' => 'social-dribbble',
                                'social_icon' => 'fab fa-dribbble',
                                'social_link' => '',
                                'social_color' => '#00b6e3',
                            ),
                        4 =>
                            array (
                                'social_name' => 'LinkedIn',
                                'social_id' => 'social-linkedIn',
                                'social_icon' => 'fab fa-linkedin',
                                'social_link' => '',
                                'social_color' => '#0077b5',
                            ),
                        5 =>
                            array (
                                'social_name' => 'Vimeo',
                                'social_id' => 'social-vimeo',
                                'social_icon' => 'fab fa-vimeo',
                                'social_link' => '',
                                'social_color' => '#1ab7ea',
                            ),
                        6 =>
                            array (
                                'social_name' => 'Tumblr',
                                'social_id' => 'social-tumblr',
                                'social_icon' => 'fab fa-tumblr',
                                'social_link' => '',
                                'social_color' => '#35465c',
                            ),
                        7 =>
                            array (
                                'social_name' => 'Skype',
                                'social_id' => 'social-skype',
                                'social_icon' => 'fab fa-skype',
                                'social_link' => '',
                                'social_color' => '#00aff0',
                            ),
                        8 =>
                            array (
                                'social_name' => 'Google+',
                                'social_id' => 'social-google-plus',
                                'social_icon' => 'fab fa-google-plus',
                                'social_link' => '',
                                'social_color' => '#dd4b39',
                            ),
                        9 =>
                            array (
                                'social_name' => 'Flickr',
                                'social_id' => 'social-flickr',
                                'social_icon' => 'fab fa-flickr',
                                'social_link' => '',
                                'social_color' => '#ff0084',
                            ),
                        10 =>
                            array (
                                'social_name' => 'YouTube',
                                'social_id' => 'social-youTube',
                                'social_icon' => 'fab fa-youtube',
                                'social_link' => '',
                                'social_color' => '#cd201f',
                            ),
                        11 =>
                            array (
                                'social_name' => 'Foursquare',
                                'social_id' => 'social-foursquare',
                                'social_icon' => 'fab fa-foursquare',
                                'social_link' => '',
                                'social_color' => '#f94877',
                            ),
                        12 =>
                            array (
                                'social_name' => 'Instagram',
                                'social_id' => 'social-instagram',
                                'social_icon' => 'fab fa-instagram',
                                'social_link' => '',
                                'social_color' => '#405de6',
                            ),
                        13 =>
                            array (
                                'social_name' => 'GitHub',
                                'social_id' => 'social-gitHub',
                                'social_icon' => 'fab fa-github',
                                'social_link' => '',
                                'social_color' => '#4078c0',
                            ),
                        14 =>
                            array (
                                'social_name' => 'Xing',
                                'social_id' => 'social-xing',
                                'social_icon' => 'fab fa-xing',
                                'social_link' => '',
                                'social_color' => '#026466',
                            ),
                        15 =>
                            array (
                                'social_name' => 'Behance',
                                'social_id' => 'social-behance',
                                'social_icon' => 'fab fa-behance',
                                'social_link' => '',
                                'social_color' => '#1769ff',
                            ),
                        16 =>
                            array (
                                'social_name' => 'Deviantart',
                                'social_id' => 'social-deviantart',
                                'social_icon' => 'fab fa-deviantart',
                                'social_link' => '',
                                'social_color' => '#05cc47',
                            ),
                        17 =>
                            array (
                                'social_name' => 'Sound Cloud',
                                'social_id' => 'social-soundCloud',
                                'social_icon' => 'fab fa-soundcloud',
                                'social_link' => '',
                                'social_color' => '#ff8800',
                            ),
                        18 =>
                            array (
                                'social_name' => 'Yelp',
                                'social_id' => 'social-yelp',
                                'social_icon' => 'fab fa-yelp',
                                'social_link' => '',
                                'social_color' => '#af0606',
                            ),
                        19 =>
                            array (
                                'social_name' => 'RSS Feed',
                                'social_id' => 'social-rss',
                                'social_icon' => 'fas fa-rss',
                                'social_link' => '',
                                'social_color' => '#f26522',
                            ),
                        20 =>
                            array (
                                'social_name' => 'VK',
                                'social_id' => 'social-vk',
                                'social_icon' => 'fab fa-vk',
                                'social_link' => '',
                                'social_color' => '#45668e',
                            ),
                        21 =>
                            array (
                                'social_name' => 'Email',
                                'social_id' => 'social-email',
                                'social_icon' => 'fas fa-envelope',
                                'social_link' => '',
                                'social_color' => '#4285f4',
                            ),
                    ),
                'post_layout' => 'large-image',
                'post_image_size' => 'full',
                'post_image_width' =>
                    array (
                        'width' => '400',
                        'height' => '',
                    ),
                'post_image_ratio' => '4x3',
                'post_image_ratio_custom' =>
                    array (
                        'width' => '',
                        'height' => '',
                    ),
                'blog_cate_filter' => '',
                'default_thumbnail_placeholder_enable' => '',
                'default_thumbnail_image' =>
                    array (
                        'id' => 0,
                        'url' => '',
                    ),
                'first_image_as_post_thumbnail' => '',
                'post_columns_gutter' => '40',
                'post_columns' => '3',
                'post_columns_md' => '2',
                'post_columns_sm' => '2',
                'post_columns_xs' => '2',
                'post_columns_mb' => '1',
                'posts_per_page' => '',
                'post_paging' => 'pagination',
                'post_animation' => 'none',
                'post_ads' =>
                    array (
                    ),
                'search_post_layout' => '',
                'search_post_image_size' => 'full',
                'search_post_image_width' =>
                    array (
                        'width' => '400',
                        'height' => '',
                    ),
                'search_post_image_ratio' => '4x3',
                'search_post_image_ratio_custom' =>
                    array (
                        'width' => '',
                        'height' => '',
                    ),
                'search_post_columns_gutter' => '',
                'search_post_columns' => '',
                'search_post_columns_md' => '',
                'search_post_columns_sm' => '',
                'search_post_columns_xs' => '',
                'search_post_columns_mb' => '',
                'search_posts_per_page' => '',
                'search_post_paging' => '',
                'search_post_animation' => '',
                'search_post_type' =>
                    array (
                        0 => 'post',
                    ),
                'single_post_layout' => 'layout-1',
                'single_reading_process_enable' => 'on',
                'single_tag_enable' => 'on',
                'single_share_enable' => 'on',
                'single_navigation_enable' => 'on',
                'single_author_info_enable' => 'on',
                'single_related_post_enable' => '',
                'single_related_post_algorithm' => 'cat',
                'single_related_post_carousel_enable' => 'on',
                'single_related_post_per_page' => 6,
                'single_related_post_columns_gutter' => '20',
                'single_related_post_columns' => '3',
                'single_related_post_columns_md' => '3',
                'single_related_post_columns_sm' => '2',
                'single_related_post_columns_xs' => '2',
                'single_related_post_columns_mb' => '1',
                'single_related_post_paging' => 'none',
                'single_related_post_animation' => '-1',
                'product_featured_label_enable' => 'on',
                'product_featured_label_text' => 'Hot',
                'product_sale_label_enable' => 'on',
                'product_sale_flash_mode' => 'text',
                'product_sale_label_text' => 'Sale',
                'product_new_label_enable' => '',
                'product_new_label_since' => '5',
                'product_new_label_text' => 'New',
                'product_sale_count_down_enable' => '',
                'product_add_to_cart_enable' => 'on',
                'product_catalog_layout' => 'grid',
                'product_columns_gutter' => '40',
                'product_columns' => '4',
                'product_columns_md' => '4',
                'product_columns_sm' => '3',
                'product_columns_xs' => '2',
                'product_columns_mb' => '1',
                'product_per_page' => '16',
                'product_swatches_enable' => 'on',
                'product_swatches_taxonomies' =>
                    array (
                    ),
                'product_paging' => 'pagination',
                'product_animation' => 'none',
                'product_image_hover_effect' => 'change-image',
                'product_category_enable' => '',
                'product_rating_enable' => '',
                'product_quick_view_enable' => 'on',
                'woocommerce_customize' =>
                    array (
                        'Left' =>
                            array (
                                'result-count' => 'Result Count',
                            ),
                        'Right' =>
                            array (
                                'ordering' => 'Ordering',
                            ),
                        'Disable' =>
                            array (
                                'cat-filter' => 'Category Filter',
                                'items-show' => 'Items Show',
                                'sidebar' => 'Sidebar',
                                'filter' => 'Filter',
                            ),
                    ),
                'woocommerce_customize_full_width' => '',
                'woocommerce_customize_padding' =>
                    array (
                        'left' => '',
                        'right' => '',
                        'top' => '',
                        'bottom' => '',
                    ),
                'woocommerce_customize_mobile' =>
                    array (
                        'Left' =>
                            array (
                                'ordering' => 'Ordering',
                            ),
                        'Right' =>
                            array (
                                'filter' => 'Filter',
                            ),
                        'Disable' =>
                            array (
                                'result-count' => 'Result Count',
                                'items-show' => 'Items Show',
                            ),
                    ),
                'filter_columns' => '4',
                'filter_columns_md' => '3',
                'filter_columns_sm' => '2',
                'filter_columns_xs' => '2',
                'filter_columns_mb' => '1',
                'woocommerce_customize_item_show' => '6,12,18',
                'woocommerce_customize_sidebar' => '',
                'product_single_layout' => 'layout-01',
                'product_single_swatches_enable' => 'on',
                'product_related_enable' => 'on',
                'product_related_algorithm' => 'cat-tag',
                'product_related_carousel_enable' => '',
                'product_related_columns_gutter' => '30',
                'product_related_columns' => '4',
                'product_related_columns_md' => '2',
                'product_related_columns_sm' => '2',
                'product_related_columns_xs' => '2',
                'product_related_columns_mb' => '1',
                'product_related_per_page' => '4',
                'product_related_animation' => '',
                'product_up_sells_enable' => 'on',
                'product_up_sells_columns_gutter' => '30',
                'product_up_sells_columns' => '4',
                'product_up_sells_columns_md' => '2',
                'product_up_sells_columns_sm' => '2',
                'product_up_sells_columns_xs' => '2',
                'product_up_sells_columns_mb' => '1',
                'product_up_sells_per_page' => '4',
                'product_up_sells_animation' => '',
                'product_cross_sells_enable' => 'on',
                'product_cross_sells_columns_gutter' => '30',
                'product_cross_sells_columns' => '3',
                'product_cross_sells_columns_md' => '2',
                'product_cross_sells_columns_sm' => '2',
                'product_cross_sells_columns_xs' => '2',
                'product_cross_sells_columns_mb' => '1',
                'product_cross_sells_per_page' => '4',
                'product_cross_sells_animation' => '',
                'preset_page_404' => '',
                'preset_blog' => '',
                'preset_single_blog' => '',
                'preset_archive_product' => '',
                'preset_single_product' => '',
                'custom_css' => '',
                'custom_js' => '',
            );
            return $default;
        }
    }
}