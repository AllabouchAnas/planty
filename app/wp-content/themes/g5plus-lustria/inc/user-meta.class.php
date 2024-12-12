<?php
if (!class_exists('G5Plus_Lustria_User_Meta')) {
    class G5Plus_Lustria_User_Meta {
        private static $_instance;
        public static function getInstance() {
            if (self::$_instance == NULL) { self::$_instance = new self(); }
            return self::$_instance;
        }
        public function get_social_networks($id = ''){ return $this->getMetaValue('g5plus_lustria_social_networks', $id); }
        public function getMetaValue($meta_key, $id = '') {
            if ($id === '') {
                $current_user = wp_get_current_user();
                $id = $current_user->ID;
            }

            $value = get_user_meta($id, $meta_key, true);
            if ($value === '') {
                $default = &$this->getDefault();
                if (isset($default[$meta_key])) {
                    $value = $default[$meta_key];
                }
            }
            return $value;
        }


        public function &getDefault() {
            $default = array (
                'g5plus_lustria_social_networks' =>
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
            );
            return $default;
        }
    }
}