<?php
if (!class_exists('G5Plus_Lustria_Options_Skin')) {
    class G5Plus_Lustria_Options_Skin
    {
        private static $_instance;
        public static function getInstance() {
            if (self::$_instance == NULL) { self::$_instance = new self(); }
            return self::$_instance;
        }
        public function get_color_skin(){ return $this->getOptions('color_skin'); }
        public function getOptions($key) {
            if (function_exists('GSF')) {
                $option = &GSF()->adminThemeOption()->getOptions('g5plus_lustria_skin_options');
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
                $option = &GSF()->adminThemeOption()->getOptions('g5plus_lustria_skin_options');
            } else {
                $option = &$this->getDefault();
            }
            $option[$key] = $value;
        }

        public function &getDefault() {
            $default = array (
                'color_skin' =>
                    array (
                        0 =>
                            array (
                                'skin_id' => 'skin-light',
                                'skin_name' => 'Light',
                                'background_color' => '#fff',
                                'text_color' => '#777777',
                                'text_hover_color' => '',
                                'heading_color' => '#333',
                                'disable_color' => '#ababab',
                                'border_color' => '#eee',
                            ),
                        1 =>
                            array (
                                'skin_id' => 'skin-dark',
                                'skin_name' => 'Dark',
                                'background_color' => '#292929',
                                'text_color' => '#9b9b9b',
                                'text_hover_color' => '',
                                'heading_color' => '#fff',
                                'disable_color' => '#ababab',
                                'border_color' => 'rgba(255,255,255,0.3)',
                            ),
                    ),
            );
            return $default;
        }
    }
}