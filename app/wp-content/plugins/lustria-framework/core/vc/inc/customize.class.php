<?php
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
if (!class_exists('G5P_Vc_Customize')) {
    class G5P_Vc_Customize
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
            add_action('vc_before_init', array($this, 'set_shortcodes_templates_dir'));

            add_action('vc_after_init', array($this, 'custom_params'));

            // custom shortcode vc_section
            add_action('vc_after_init', array($this, 'custom_param_vc_section'));

            // custom shortcode vc_row
            add_action('vc_after_init', array($this, 'custom_param_vc_row'));

            add_action('vc_after_init', array($this,'custom_param_vc_progress_bar' ));

            // custom param el_class
            add_action('vc_after_init', array($this, 'custom_param_el_class'));
            add_filter(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, array($this, 'custom_css_param_el_class'), 10, 3);

            // custom param responsive
            add_action('vc_after_init', array($this, 'custom_param_responsive'));
            add_filter(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, array($this, 'custom_css_param_responsive'), 10, 3);

            // custom param animation
            add_action('vc_after_init', array($this, 'custom_param_animation'));
            add_filter(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, array($this, 'custom_css_param_animation'), 10, 3);

            // custom param color skin
            add_action('vc_after_init', array($this, 'custom_param_color_skin'));
            add_filter(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, array($this, 'custom_css_param_color_skin'), 10, 3);


            add_filter('vc_param_animation_style_list', array($this, 'custom_animation_style_list'));

        }

        public function set_shortcodes_templates_dir()
        {
            // Link your VC elements's folder
            if (function_exists('vc_set_shortcodes_templates_dir')) {
                vc_set_shortcodes_templates_dir(G5P()->pluginDir('core/vc/vc_templates'));
            }
        }

        public function custom_params()
        {
            require_once G5P()->pluginDir('core/vc/vc-params/icon-picker/icon-picker.php');
            require_once G5P()->pluginDir('core/vc/vc-params/responsive/responsive.php');
            require_once G5P()->pluginDir('core/vc/vc-params/number-and-unit/number-and-unit.php');
            require_once G5P()->pluginDir('core/vc/vc-params/number-responsive/number-responsive.php');
            require_once G5P()->pluginDir('core/vc/vc-params/button-set/button-set.php');
            require_once G5P()->pluginDir('core/vc/vc-params/datetime-picker/datetime-picker.php');
            require_once G5P()->pluginDir('core/vc/vc-params/image-set/image-set.php');
            require_once G5P()->pluginDir('core/vc/vc-params/number/number.php');
            require_once G5P()->pluginDir('core/vc/vc-params/selectize/selectize.php');
            require_once G5P()->pluginDir('core/vc/vc-params/slider/slider.php');
            require_once G5P()->pluginDir('core/vc/vc-params/switch/switch.php');
            require_once G5P()->pluginDir('core/vc/vc-params/typography/typography.php');
        }

        public function custom_param_vc_row()
        {

            // remove param
            vc_remove_param('vc_row', 'full_width');

            $vc_row = WPBMap::getShortCode('vc_row');
            $vc_row_params = $vc_row['params'];
            $index = 97;
            $background_overlay_index = 0;
            foreach ($vc_row_params as $key => $param) {
                $param['weight'] = $index;
                if ($param['param_name'] == 'parallax_speed_bg') {
                    $background_overlay_index = $index - 1;
                    $index = $index - 5;
                }
                vc_update_shortcode_param('vc_row', $param);
                $index--;
            }

            // add custom param
            $params = array(
                array(
                    'type' => 'gsf_button_set',
                    'heading' => esc_html__('Container Width', 'lustria-framework'),
                    'description' => esc_html__('Define the width of the container.', 'lustria-framework'),
                    'param_name' => 'container_width',
                    'value' => array(
                        esc_html__('Full', 'lustria-framework') => 'full',
                        esc_html__('Limit', 'lustria-framework') => 'limit'
                    ),
                    'std' => 'full',
                    'admin_label' => true,
                    'weight' => 99
                ),
                array(
                    'type' => 'gsf_button_set',
                    'heading' => esc_html__('Content Width', 'lustria-framework'),
                    'description' => esc_html__('Define the width of the content area.', 'lustria-framework'),
                    'param_name' => 'content_width',
                    'value' => array(
                        esc_html__('Full', 'lustria-framework') => 'full',
                        esc_html__('Full Desktop', 'lustria-framework') => 'full-desktop',
                        esc_html__('Limit', 'lustria-framework') => 'limit'
                    ),
                    'std' => 'limit',
                    'dependency' => array(
                        'element' => 'container_width',
                        'value' => 'full',
                    ),
                    'admin_label' => true,
                    'weight' => 98
                ),
                array(
                    'type' => 'gsf_button_set',
                    'heading' => esc_html__('Background Overlay', 'lustria-framework'),
                    'param_name' => 'bg_overlay_mode',
                    'description' => esc_html__('Specify overlay mode for the background.', 'lustria-framework'),
                    'value' => array(
                        esc_html__('Hide', 'lustria-framework') => '',
                        esc_html__('Color', 'lustria-framework') => 'color',
                        esc_html__('Image', 'lustria-framework') => 'image',
                    ),
                    'std' => '',
                    'weight' => $background_overlay_index
                ),
                array(
                    'type' => 'colorpicker',
                    'heading' => esc_html__('Overlay color', 'lustria-framework'),
                    'param_name' => 'bg_overlay_color',
                    'description' => esc_html__('Specify an overlay color for the background.', 'lustria-framework'),
                    'dependency' => array('element' => 'bg_overlay_mode', 'value' => 'color'),
                    'weight' => ($background_overlay_index - 1)
                ),
                array(
                    'type' => 'attach_image',
                    'heading' => esc_html__('Overlay Image', 'lustria-framework'),
                    'param_name' => 'bg_overlay_image',
                    'description' => esc_html__('Specify an overlay image for the background.', 'lustria-framework'),
                    'dependency' => array('element' => 'bg_overlay_mode', 'value' => 'image'),
                    'weight' => ($background_overlay_index - 2)
                ),
                array(
                    'type' => 'gsf_slider',
                    'heading' => esc_html__('Overlay Opacity', 'lustria-framework'),
                    'param_name' => 'bg_overlay_opacity',
                    'std' => '50',
                    'js_options' => array(
                        'step' => 1,
                        'min' => 0,
                        'max' => 100
                    ),
                    'description' => esc_html__('Specify overlay opacity for the background.', 'lustria-framework'),
                    'dependency' => array('element' => 'bg_overlay_mode', 'value' => 'image'),
                    'weight' => ($background_overlay_index - 3)
                ),
            );
            vc_add_params('vc_row', $params);
        }


        // Custom vc_progress_bars
        public function custom_param_vc_progress_bar()
        {
            $vc_progress_bar = WPBMap::getShortCode('vc_progress_bar');
            $vc_progress_bar_params = $vc_progress_bar['params'];
            $index = 100;
            $background_overlay_index = 0;
            foreach ($vc_progress_bar_params as $key => $param) {
                $param['weight'] = $index;
                if ($param['param_name'] == 'bgcolor') {
                    $background_overlay_index = $index - 1;
                    $index = $index - 1;
                }
                vc_update_shortcode_param('vc_progress_bar', $param);
                $index--;
            }
            $params = array(
                array(
                    'type' => 'dropdown',
                    'heading' => esc_html__('Layout Style', 'lustria-framework'),
                    'param_name' => 'layout_style',
                    'value' => array(
                        esc_html__('Normal', 'lustria-framework') => '',
                        esc_html__('Value move', 'lustria-framework') => 'prb_vl_move',
                        esc_html__('Value right position', 'lustria-framework') => 'prb_vl_right'
                    ),
                    'admin_label' => true,
                    'description' => esc_html__('Select Layout Style.', 'lustria-framework'),
                    'weight' => ($background_overlay_index + $background_overlay_index),
                ),

            );
            $colors = array(
                esc_html__('Accent', 'lustria-framework') => 'accent'
            );
            $param_color = WPBMap::getParam('vc_progress_bar', 'bgcolor');
            $param_color['value'] = array_merge($colors, $param_color['value']);
            $param_color['heading'] = esc_html__('Color', 'lustria-framework');
            $param_color['std'] = 'accent';
            vc_update_shortcode_param('vc_progress_bar', $param_color);
            vc_add_params('vc_progress_bar', $params);
        }

        public function custom_param_vc_section()
        {
            // remove param
            vc_remove_param('vc_section', 'full_width');

            // add custom param
            $params = array(
                array(
                    'type' => 'gsf_button_set',
                    'heading' => esc_html__('Container Width', 'lustria-framework'),
                    'description' => esc_html__('Define the width of the container.', 'lustria-framework'),
                    'param_name' => 'container_width',
                    'value' => array(
                        esc_html__('Full', 'lustria-framework') => 'full',
                        esc_html__('Limit', 'lustria-framework') => 'limit'
                    ),
                    'std' => 'full',
                    'admin_label' => true,
                    'weight' => 99
                ),
                array(
                    'type' => 'gsf_button_set',
                    'heading' => esc_html__('Content Width', 'lustria-framework'),
                    'description' => esc_html__('Define the width of the content area.', 'lustria-framework'),
                    'param_name' => 'content_width',
                    'value' => array(
                        esc_html__('Full', 'lustria-framework') => 'full',
                        esc_html__('Full Desktop', 'lustria-framework') => 'full-desktop',
                        esc_html__('Limit', 'lustria-framework') => 'limit'
                    ),
                    'std' => 'limit',
                    'dependency' => array(
                        'element' => 'container_width',
                        'value' => 'full',
                    ),
                    'admin_label' => true,
                    'weight' => 98
                ),
            );
            vc_add_params('vc_section', $params);
        }

        public function custom_param_el_class()
        {
            $shortcodes = $this->get_shorcodes_custom_param_el_class();
            foreach ($shortcodes as $shortcode) {
                vc_update_shortcode_param($shortcode, G5P()->shortcode()->vc_map_add_extra_class());
            }
        }

        public function custom_css_param_el_class($css_class, $shortcode, $atts)
        {
            $shortcodes = $this->get_shorcodes_custom_param_el_class();
            if (in_array($shortcode, $shortcodes)) {
                $css_class = str_replace(',', ' ', $css_class);
            }
            return $css_class;
        }

        private function get_shorcodes_custom_param_el_class()
        {
            return apply_filters('gsf_vc_custom_param_el_class', array(
                'vc_row',
                'vc_section',
                'vc_column',
                'vc_column_inner',
                'vc_row_inner',
                'vc_column_text',
                'vc_icon',
                'vc_separator',
                'vc_text_separator',
                'vc_message',
                'vc_toggle',
                'vc_gallery',
                'vc_images_carousel',
                'vc_tta_tabs',
                'vc_tta_tour',
                'vc_tta_accordion',
                'vc_tta_section',
                'vc_custom_heading',
                'vc_btn',
                'vc_cta',
                'vc_widget_sidebar',
                'vc_posts_slider',
                'vc_video',
                'vc_gmaps',
                'vc_raw_html',
                'vc_raw_js',
                'vc_flickr',
                'vc_progress_bar',
                'vc_pie',
                'vc_round_chart',
                'vc_line_chart',
                'vc_wp_search',
                'vc_wp_meta',
                'vc_wp_recentcomments',
                'vc_wp_calendar',
                'vc_wp_pages',
                'vc_wp_tagcloud',
                'vc_wp_custommenu',
                'vc_wp_text',
                'vc_wp_posts',
                'vc_wp_links',
                'vc_wp_categories',
                'vc_wp_archives',
                'vc_wp_rss',
                'vc_empty_space',
                'vc_single_image'
            ));
        }

        public function custom_param_responsive()
        {
            $shortcodes = $this->get_shorcodes_custom_param_responsive();
            foreach ($shortcodes as $shortcode) {
                vc_add_param($shortcode, G5P()->shortcode()->vc_map_add_responsive());
            }
        }

        public function custom_css_param_responsive($css_class, $shortcode, $atts)
        {
            $shortcodes = $this->get_shorcodes_custom_param_responsive();
            if (in_array($shortcode, $shortcodes)) {
                if (isset($atts['responsive']) && !empty($atts['responsive'])) {
                    $css_class = $css_class . ' ' . $atts['responsive'];
                }
            }
            return $css_class;
        }

        private function get_shorcodes_custom_param_responsive()
        {
            return apply_filters('gsf_vc_custom_param_responsive', array(
                'vc_row',
                'vc_section',
                'vc_row_inner',
                'vc_column_text',
                'vc_separator',
                'vc_text_separator',
                'vc_message',
                'vc_facebook',
                'vc_tweetmeme',
                'vc_googleplus',
                'vc_pinterest',
                'vc_toggle',
                'vc_single_image',
                'vc_gallery',
                'vc_images_carousel',
                'vc_tta_tabs',
                'vc_tta_tour',
                'vc_tta_accordion',
                'vc_custom_heading',
                'vc_cta',
                'vc_posts_slider',
                'vc_video',
                'vc_gmaps',
                'vc_raw_html',
                'vc_raw_js',
                'vc_flickr',
                'vc_progress_bar',
                'vc_pie',
                'vc_round_chart',
                'vc_line_chart',
                'vc_wp_search',
                'vc_wp_meta',
                'vc_wp_recentcomments',
                'vc_wp_calendar',
                'vc_wp_pages',
                'vc_wp_tagcloud',
                'vc_wp_custommenu',
                'vc_wp_text',
                'vc_wp_posts',
                'vc_wp_links',
                'vc_wp_categories',
                'vc_wp_archives',
                'vc_wp_rss',
                'vc_empty_space'
            ));
        }

        public function custom_param_animation()
        {
            $shortcodes = $this->get_shorcodes_custom_param_animation();
            foreach ($shortcodes as $shortcode) {
                vc_remove_param($shortcode, 'css_animation');
                $params = array(
                    G5P()->shortcode()->vc_map_add_css_animation(),
                    G5P()->shortcode()->vc_map_add_animation_duration(),
                    G5P()->shortcode()->vc_map_add_animation_delay(),

                );
                vc_add_params($shortcode, $params);
            }
        }

        public function custom_css_param_animation($css_class, $shortcode, $atts)
        {
            $shortcodes = $this->get_shorcodes_custom_param_animation();
            if (in_array($shortcode, $shortcodes)) {

                if (isset($atts['css_animation']) && isset($atts['animation_duration']) && isset($atts['animation_delay']) && ('' !== $atts['css_animation']) && ('none' !== $atts['css_animation'])) {
                    $animation_class = G5P()->core()->vc()->customize()->get_animation_class($atts['animation_duration'], $atts['animation_delay']);
                    $css_class = $css_class . ' ' . $animation_class;
                }
            }
            return $css_class;
        }

        private function get_shorcodes_custom_param_animation()
        {
            return apply_filters('gsf_vc_custom_param_animation', array(
                'vc_row',
                'vc_section',
                'vc_column',
                'vc_column_text',
                'vc_separator',
                'vc_text_separator',
                'vc_message',
                'vc_facebook',
                'vc_tweetmeme',
                'vc_googleplus',
                'vc_pinterest',
                'vc_toggle',
                'vc_single_image',
                'vc_gallery',
                'vc_images_carousel',
                'vc_tta_tabs',
                'vc_tta_tour',
                'vc_tta_accordion',
                'vc_custom_heading',
                'vc_cta',
                'vc_video',
                'vc_gmaps',
                'vc_flickr',
                'vc_progress_bar',
                'vc_pie',
                'vc_round_chart',
                'vc_line_chart'
            ));
        }

        public function custom_param_color_skin()
        {
            $shortcodes = $this->get_shorcodes_custom_param_color_skin();
            foreach ($shortcodes as $shortcode) {
                vc_add_param($shortcode, G5P()->shortcode()->vc_map_add_color_skin(array(
                    'weight' => 100
                )));
            }
        }

        public function custom_css_param_color_skin($css_class, $shortcode, $atts)
        {
            $shortcodes = $this->get_shorcodes_custom_param_color_skin();
            if (in_array($shortcode, $shortcodes)) {
                $skin_id = isset($atts['color_skin']) ? $atts['color_skin'] : '';
                if ('' !== $skin_id) {
                    $css_class .= ' gf-skin ' . $skin_id;
                    if (function_exists('G5Plus_Lustria')) {
                        wp_enqueue_style(G5Plus_Lustria()->helper()->assetsHandle("skin-{$skin_id}"));
                    }
                }
            }
            return $css_class;
        }

        private function get_shorcodes_custom_param_color_skin()
        {
            return apply_filters('gsf_vc_custom_param_color_skin', array(
                'vc_row',
                'vc_section',
                'vc_column'
            ));
        }


        public function getExtraClass($el_class)
        {
            $output = '';
            if ('' !== $el_class) {
                $el_class = preg_split('/\,/', $el_class);
                $output = implode(' ', $el_class);
                $output = str_replace('.', '', $output);
            }
            return $output;
        }

        public function get_animation_class($animation_duration, $animation_delay)
        {
            $animation_attributes = array();
            if ($animation_duration != '0' && !empty($animation_duration)) {
                $animation_duration = (float)trim($animation_duration, "\n\ts");
                $animation_attributes[] = "-webkit-animation-duration: {$animation_duration}s !important";
                $animation_attributes[] = "-moz-animation-duration: {$animation_duration}s !important";
                $animation_attributes[] = "-ms-animation-duration: {$animation_duration}s !important";
                $animation_attributes[] = "-o-animation-duration: {$animation_duration}s !important";
                $animation_attributes[] = "animation-duration: {$animation_duration}s !important";
            }
            if ($animation_delay != '0' && !empty($animation_delay)) {
                $animation_delay = (float)trim($animation_delay, "\n\ts");
                $animation_attributes[] = "-webkit-animation-delay: {$animation_delay}s !important";
                $animation_attributes[] = "-moz-animation-delay: {$animation_delay}s !important";
                $animation_attributes[] = "-ms-animation-delay: {$animation_delay}s !important";
                $animation_attributes[] = "-o-animation-delay: {$animation_delay}s !important";
                $animation_attributes[] = "animation-delay: {$animation_delay}s !important";
            }

            $animation_class = '';
            if ($animation_attributes) {
                $animation_css = implode('; ', array_filter($animation_attributes));
                $animation_class = 'gf-animation-' . random_int(1000, 9999);
                $custom_css = <<<CSS
				.{$animation_class} {
					{$animation_css}
				}
CSS;
                GSF()->customCss()->addCss($custom_css, $animation_class);
            }
            return $animation_class;
        }

        public function custom_animation_style_list()
        {
            return array(
                array(
                    'values' => array(
                        esc_html__('None', 'lustria-framework') => 'none'
                    ),
                ),
            );
        }
    }
}