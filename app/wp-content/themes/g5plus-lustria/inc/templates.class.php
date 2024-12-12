<?php
/**
 * Class Defined Templates
 *
 */
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
if (!class_exists('G5Plus_Lustria_Templates')) {
    class G5Plus_Lustria_Templates
    {

        private static $_instance;

        public static function getInstance()
        {
            if (self::$_instance == NULL) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        /**
         * Template Site Loading
         */
        public function site_loading()
        {
            G5Plus_Lustria()->helper()->getTemplate('site-loading');
        }

        /**
         * Template Top Drawer
         */
        public function top_drawer()
        {
            G5Plus_Lustria()->helper()->getTemplate('top-drawer');
        }

        /**
         * Template Header
         */
        public function header()
        {
            G5Plus_Lustria()->helper()->getTemplate('header');
        }

        /**
         * Template Search Popup
         */
        public function search_popup()
        {
            G5Plus_Lustria()->helper()->getTemplate('popup/search');
        }

        /**
         * Template Canvas Sidebar
         */
        public function canvas_sidebar()
        {
            G5Plus_Lustria()->helper()->getTemplate('canvas-sidebar');
        }

        /**
         * Template Canvas Menu
         */
        public function canvas_menu()
        {
            G5Plus_Lustria()->helper()->getTemplate('popup/canvas-menu');
        }

        /**
         * Template Content Wrapper Start
         */
        public function content_wrapper_start()
        {
            G5Plus_Lustria()->helper()->getTemplate('global/wrapper-start');
        }

        /**
         * Template Content Wrapper End
         */
        public function content_wrapper_end()
        {
            G5Plus_Lustria()->helper()->getTemplate('global/wrapper-end');
        }

        /**
         * Template Back To Top
         */
        public function back_to_top()
        {
            G5Plus_Lustria()->helper()->getTemplate('back-to-top');
        }

        /**
         * Template Page Title
         */
        public function page_title()
        {
            G5Plus_Lustria()->helper()->getTemplate('page-title');
        }

        /**
         * Head Meta
         */
        public function head_meta()
        {
            G5Plus_Lustria()->helper()->getTemplate('head/head-meta');
        }

        /**
         * Social Meta
         */
        public function social_meta()
        {
            G5Plus_Lustria()->helper()->getTemplate('head/social-meta');
        }

        /**
         * Footer
         */
        public function footer()
        {
            G5Plus_Lustria()->helper()->getTemplate('footer');
        }

        /**
         * Get Template Social Network
         *
         * @param array $social_networks
         * @param string $layout - The layout of social network. Accepts 'classic', 'circle', 'square'
         */
        public function social_networks($social_networks = array(), $layout = 'classic', $size = 'normal')
        {
            G5Plus_Lustria()->helper()->getTemplate('social-networks', array('social_networks' => $social_networks, 'layout' => $layout, 'size' => $size));
        }


        public function zoom_image_thumbnail($args)
        {
            G5Plus_Lustria()->helper()->getTemplate('loop/zoom-image', $args);
        }


        public function post_single_tag_share()
        {
            G5Plus_Lustria()->helper()->getTemplate('single/post-tag-share');
        }

        public function post_single_navigation()
        {
            G5Plus_Lustria()->helper()->getTemplate('single/post-navigation');
        }

        public function post_single_author_info()
        {
            G5Plus_Lustria()->helper()->getTemplate('single/post-author-info');
        }

        public function post_single_related()
        {
            G5Plus_Lustria()->helper()->getTemplate('single/post-related');
        }

        public function post_single_comment()
        {
            G5Plus_Lustria()->helper()->getTemplate('single/post-comment');
        }

        public function post_single_image()
        {
            G5Plus_Lustria()->helper()->getTemplate('single/post-image');
        }

        public function mobile_navigation()
        {
            G5Plus_Lustria()->helper()->getTemplate('header/mobile/navigation');
        }

        public function canvas_overlay()
        {
            G5Plus_Lustria()->helper()->getTemplate('canvas-overlay');
        }

        public function post_view()
        {
            G5Plus_Lustria()->helper()->getTemplate('loop/post-view');
        }

        public function post_like()
        {
            G5Plus_Lustria()->helper()->getTemplate('loop/post-like');
        }

        // Login register popup
        public function login_register_popup()
        {
            G5Plus_Lustria()->helper()->getTemplate('popup/login-register');
        }


        public function userSocialNetworks($userId, $layout = '')
        {
            G5Plus_Lustria()->helper()->getTemplate('user-social-networks', array('userId' => $userId, 'layout' => $layout));
        }

        public function post_single_reading_process()
        {
            G5Plus_Lustria()->helper()->getTemplate('single/post-reading-process');
        }

        public function shop_catalog_filter()
        {
            G5Plus_Lustria()->helper()->getTemplate('woocommerce/loop/catalog-filter');
        }

        public function shop_swatches_loop()
        {
            G5Plus_Lustria()->helper()->getTemplate('woocommerce/loop/swatches-loop');
        }


        public function shop_quick_view_product_title()
        {
            G5Plus_Lustria()->helper()->getTemplate('woocommerce/quick-view/title');
        }

        public function shop_loop_product_title()
        {
            G5Plus_Lustria()->helper()->getTemplate('woocommerce/loop/title');
        }

        public function shop_loop_product_cat()
        {
            G5Plus_Lustria()->helper()->getTemplate('woocommerce/loop/product-cat');
        }

        function shop_loop_quick_view()
        {
            G5Plus_Lustria()->helper()->getTemplate('woocommerce/loop/quick-view');
        }



        public function shop_loop_compare()
        {
            if ((in_array('yith-woocommerce-compare/init.php', apply_filters('active_plugins', get_option('active_plugins')))
                    || in_array('yith-woocommerce-compare-premium/init.php', apply_filters('active_plugins', get_option('active_plugins'))))
                && get_option('yith_woocompare_compare_button_in_products_list') == 'yes'
            ) {
                if (!shortcode_exists('yith_compare_button') && class_exists('YITH_Woocompare') && function_exists('yith_woocompare_constructor')) {
                    $context = isset($_REQUEST['context']) ? $_REQUEST['context'] : null;
                    $_REQUEST['context'] = 'frontend';
                    yith_woocompare_constructor();
                    $_REQUEST['context'] = $context;
                }


                global $yith_woocompare;
                if (isset($yith_woocompare) && isset($yith_woocompare->obj)) {
                    remove_action('woocommerce_after_shop_loop_item', array($yith_woocompare->obj, 'add_compare_link'), 20);
                }

                echo do_shortcode('[yith_compare_button container="false" type="link"]');
            }
        }

        public function shop_loop_grid_add_to_cart()
        {
            $product_add_to_cart_enable = G5Plus_Lustria()->options()->get_product_add_to_cart_enable();
            if ('on' === $product_add_to_cart_enable) {
                global $product;
                echo '<div class="product-action-item add_to_cart_tooltip" data-toggle="tooltip" data-original-title="' . $product->add_to_cart_text() . '">';
                woocommerce_template_loop_add_to_cart(array(
                    'class' => implode(' ', array_filter(array(
                        'product_type_' . $product->get_type(),
                        $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : 'product_out_of_stock',
                        $product->supports('ajax_add_to_cart') ? 'ajax_add_to_cart' : ''
                    )))
                ));
                echo '</div>';
            }
        }




        public function shop_loop_sale_count_down()
        {
            G5Plus_Lustria()->helper()->getTemplate('woocommerce/loop/sale-count-down', array('is_single' => false));
        }

        public function shop_single_loop_sale_count_down()
        {
            G5Plus_Lustria()->helper()->getTemplate('woocommerce/loop/sale-count-down', array('is_single' => true));
        }

        public function shop_loop_wishlist()
        {
	        $enabled_on_loop = 'yes' == get_option( 'yith_wcwl_show_on_loop', 'no' );
	        if( ! $enabled_on_loop ){
		        return;
	        }
            if (function_exists('YITH_WCWL_Frontend')) {
	            YITH_WCWL_Frontend()->print_button();
            }
        }

        public function shop_single_video()
        {
            G5Plus_Lustria()->helper()->getTemplate('woocommerce/single/video-introduction');
        }

        public function swatches_single()
        {
            G5Plus_Lustria()->helper()->getTemplate('woocommerce/single/swatches-single');
        }

        public function shop_single_function()
        {
            G5Plus_Lustria()->helper()->getTemplate('woocommerce/single/product-functions');
        }


        public function quick_view_rating()
        {
            G5Plus_Lustria()->helper()->getTemplate('woocommerce/quick-view/rating');
        }

        public function shop_loop_rating()
        {
            wc_get_template('loop/rating.php');
        }

        public function post_meta($args = array()) {
            $args = wp_parse_args($args, array(
                'cat' => false,
                'author' => false,
                'date' => false,
                'comment' => false,
                'edit' => false,
                'view' => false,
                'like' => false,
                'extend_class' => ''
            ));
            G5Plus_Lustria()->helper()->getTemplate('loop/post-meta', $args);
        }
    }
}