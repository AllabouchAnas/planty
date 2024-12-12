<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
if (!class_exists('G5P_ShortCode_Base')) {
    abstract class G5P_ShortCode_Base extends WPBakeryShortCode
    {
        /**
         * Find html template for shortcode output.
         */
        protected function findShortcodeTemplate()
        {
            // Check template path in shortcode's mapping settings
            if (!empty($this->settings['html_template']) && is_file($this->settings('html_template'))) {
                return $this->setTemplate($this->settings['html_template']);
            }
            // Check template in theme directory
            $user_template = vc_shortcodes_theme_templates_dir($this->getFileName() . '.php');
            if (is_file($user_template)) {
                return $this->setTemplate($user_template);
            }
            $template_name = preg_replace('/^gsf_/', '', $this->getFileName());
            $template = G5P()->pluginDir('shortcodes/' . str_replace('_', '-', $template_name) . '/template.php');
            // Check default place
            if (is_file($template)) {
                return $this->setTemplate($template);
            }

            return '';
        }

        /**
         * Get param value by providing key
         *
         * @param $key
         *
         * @since 4.4
         * @return array|bool
         */
        public function getParamData($key)
        {
            return WPBMap::getParam($this->shortcode, $key);
        }


        /**
         * @param $font_container
         * @return array
         */
        public function get_font_container_attributes($font_container)
        {
            $attributes = array();
            $font_container_obj = new Vc_Font_Container();
            $font_container_field = $this->getParamData('font_container');
            $font_container_field_settings = isset($font_container_field['settings'], $font_container_field['settings']['fields']) ? $font_container_field['settings']['fields'] : array();
            $font_container_data = $font_container_obj->_vc_font_container_parse_attributes($font_container_field_settings, $font_container);
            if (!empty($font_container_data) && isset($font_container_data['values'])) {
                foreach ($font_container_data['values'] as $key => $value) {
                    if ('tag' !== $key && strlen($value)) {
                        if (preg_match('/description/', $key)) {
                            continue;
                        }
                        if ('font_size' === $key) {
                            $value = preg_replace('/\s+/', '', $value);
                            $pattern = '/^(\d*(?:\.\d+)?)\s*(px|\%|in|cm|mm|em|rem|ex|pt|pc|vw|vh|vmin|vmax)?$/';
                            $regexr = preg_match($pattern, $value, $matches);
                            $value = isset($matches[1]) ? (float)$matches[1] : (float)$value;
                            $unit = isset($matches[2]) ? $matches[2] : 'px';
                            $value = $value . $unit;
                        }
                        if ('text_align' === $key) {
                            $value = 'text-' . $value;
                        }
                        if (strlen($value) > 0) {
                            $attributes[$key] = $value;
                        }
                    }
                }
            }
            return $attributes;
        }

        public function get_time_filter_query($time_filter = null)
        {
            $date_query = array();

            switch ($time_filter) {
                // Today posts
                case 'today':
                    $date_query = array(
                        array(
                            'after' => '1 day ago', // should not escaped because will be passed to WP_Query
                        ),
                    );
                    break;
                // Today + Yesterday posts
                case 'yesterday':
                    $date_query = array(
                        array(
                            'after' => '2 day ago', // should not escaped because will be passed to WP_Query
                        ),
                    );
                    break;
                // Week posts
                case 'week':
                    $date_query = array(
                        array(
                            'after' => '1 week ago', // should not escaped because will be passed to WP_Query
                        ),
                    );
                    break;
                // Month posts
                case 'month':
                    $date_query = array(
                        array(
                            'after' => '1 month ago', // should not escaped because will be passed to WP_Query
                        ),
                    );
                    break;
                // Year posts
                case 'year':
                    $date_query = array(
                        array(
                            'after' => '1 year ago', // should not escaped because will be passed to WP_Query
                        ),
                    );
                    break;
            }
            return $date_query;
        }
        public function get_font_attrs($template) {
            if (empty($template)) {
                $fonts = GSF()->core()->fonts()->getActiveFonts();
                $font = $fonts[0];
                $font_family = $font_variant = $font_weight = $font_style = '';
                $font_family = isset($font['name']) ? $font['name'] : $font['family'];
                $font_variant = isset($font['variants'][0]) ? $font['variants'][0] : '400';
                if (strpos($font_variant, 'i') && strpos($font_variant, 'i') != -1) {
                    $font_style = 'italic';
                    $font_weight = substr($font_variant, 0, strpos($font_variant, 'i'));
                    if (!$font_weight || '' == $font_weight) {
                        $font_weight = '400';
                    }
                } else {
                    $font_style = 'normal';
                    if ($font_variant == 'regular') {
                        $font_weight = '400';
                    } else {
                        $font_weight = $font_variant;
                    }
                }
                $template = array($font_family, $font_variant, $font_weight, $font_style);
            } else {
                $template = explode('|', $template);
            }
            return $template;
        }
    }
    abstract class G5P_ShortCode_Container extends WPBakeryShortCodesContainer {
        /**
         * Find html template for shortcode output.
         */
        protected function findShortcodeTemplate() {
            // Check template path in shortcode's mapping settings
            if ( ! empty( $this->settings['html_template'] ) && is_file( $this->settings( 'html_template' ) ) ) {
                return $this->setTemplate( $this->settings['html_template'] );
            }
            // Check template in theme directory
            $user_template = vc_shortcodes_theme_templates_dir( $this->getFileName() . '.php' );
            if ( is_file( $user_template ) ) {
                return $this->setTemplate( $user_template );
            }
            $template_name = preg_replace('/^gsf_/', '', $this->getFileName());
            $template = G5P()->pluginDir('shortcodes/' . str_replace('_', '-', $template_name) . '/template.php');
            // Check default place
            if ( is_file( $template ) ) {
                return $this->setTemplate( $template );
            }

            return '';
        }

        public function getStyleAnimation( $animation_duration, $animation_delay ) {
            $styles = array();
            if ($animation_duration != '0' && !empty($animation_duration)) {
                $animation_duration = (float)trim($animation_duration, "\n\ts");
                $styles[] = "-webkit-animation-duration: {$animation_duration}s";
                $styles[] = "-moz-animation-duration: {$animation_duration}s";
                $styles[] = "-ms-animation-duration: {$animation_duration}s";
                $styles[] = "-o-animation-duration: {$animation_duration}s";
                $styles[] = "animation-duration: {$animation_duration}s";
            }
            if ($animation_delay != '0' && !empty($animation_delay)) {
                $animation_delay = (float)trim($animation_delay, "\n\ts");
                $styles[] = "opacity: 0";
                $styles[] = "-webkit-animation-delay: {$animation_delay}s";
                $styles[] = "-moz-animation-delay: {$animation_delay}s";
                $styles[] = "-ms-animation-delay: {$animation_delay}s";
                $styles[] = "-o-animation-delay: {$animation_delay}s";
                $styles[] = "animation-delay: {$animation_delay}s";
            }
            return $styles;
        }

        public function the_widget($widget, $instance = array()){
            $wrapper_classes = array();

            if (isset($instance['css']) && !empty($instance['css'])) {
                $wrapper_classes[] = vc_shortcode_custom_css_class($instance['css'], ' ');
            }

            $args = array(
                'before_title'  => '<h4 class="widget-title"><span>',
                'after_title'   => '</span></h4>',
                'before_widget' => '<div class="' . implode(' ', $wrapper_classes) .' widget %s">',
            );
            if (isset($instance['widget_id'])) {
                $args['widget_id'] = $instance['widget_id'];
            }
            the_widget($widget,$instance,$args);
        }
    }
}