<?php
/**
 * Class Ajax
 *
 */
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
if (!class_exists('G5Plus_Lustria_Ajax')) {
    class G5Plus_Lustria_Ajax
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
         * Search Result
         */
        public function search_result()
        {
            check_ajax_referer('search_popup_nonce', 'nonce');
            global $wpdb;
            $keyword = isset($_REQUEST['keyword']) ? $_REQUEST['keyword'] : '';
            if (empty($keyword)) {
                wp_send_json_error();
            }

            $keyword = $wpdb->esc_like($keyword);
            $search_popup_post_type = G5Plus_Lustria()->options()->get_search_popup_post_type();
            $search_popup_result_amount = G5Plus_Lustria()->options()->get_search_popup_result_amount();
            if (empty($search_popup_result_amount)) {
                $search_popup_result_amount = 8;
            }

            $args = array(
                's' => $keyword,
                'post_status' => 'publish',
                'ignore_sticky_posts' => true,
                'orderby' => 'date',
                'order' => 'DESC',
                'post_type' => $search_popup_post_type,
                'posts_per_page' => $search_popup_result_amount
            );
            $query = new WP_Query($args);
            ob_start();
            ?>
            <ul class="search-popup-list">
                <?php if ($query->have_posts()): ?>
                    <?php
                    while ($query->have_posts()) {
                        $query->the_post();
                        G5Plus_Lustria()->helper()->getTemplate('popup/content');
                        wp_reset_postdata();
                    }
                    ?>
                <?php else: ?>
                    <li class="sa-nothing"><?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with different keywords.', 'g5plus-lustria'); ?></li>
                <?php endif; ?>
            </ul>
            <?php
            echo ob_get_clean();
            wp_die();
        }

        public function pagination_ajax_response()
        {
            $query_args = isset($_REQUEST['query']) ? $_REQUEST['query'] : array();
            ob_start();
            $settings = isset($_REQUEST['settings']) ? $_REQUEST['settings'] : array();
            $postType = isset($settings['post_type']) ? $settings['post_type'] : 'post';
            $query_args = G5Plus_Lustria()->query()->parse_ajax_query($query_args);
            if ($postType === 'product') {
                G5Plus_Lustria()->woocommerce()->archive_markup($query_args, $settings);
            } else {
                G5Plus_Lustria()->blog()->archive_markup($query_args, $settings);
            }

            echo ob_get_clean();
            wp_die();
        }


        public function gsf_user_login_ajax_callback()
        {
            global $wpdb;

            //We shall SQL escape all inputs to avoid sql injection.
            $username = $_REQUEST['username'];
            $password = $_REQUEST['password'];
            $remember = $_REQUEST['rememberme'];

            if ($remember) $remember = "true";
            else $remember = "false";
            $login_data = array();
            $login_data['user_login'] = $username;
            $login_data['user_password'] = $password;
            $login_data['remember'] = $remember;
            $user_verify = wp_signon($login_data, false);


            $code = 1;

            if (is_wp_error($user_verify)) {
                $message = $user_verify->get_error_message();
                $code = -1;
            } else {
                wp_set_current_user($user_verify->ID, $username);
                do_action('set_current_user');
                $message = '';
            }

            $response_data = array(
                'code' => $code,
                'message' => $message
            );

            ob_end_clean();
            echo json_encode($response_data);
            die(); // this is required to return a proper result
        }

        public function gsf_user_sign_up_ajax_callback()
        {
            include_once ABSPATH . WPINC . '/ms-functions.php';
            include_once ABSPATH . WPINC . '/user.php';

            //We shall SQL escape all inputs to avoid sql injection.
            $user_name = $_REQUEST['username'];
            $user_email = $_REQUEST['email'];


            $error = wpmu_validate_user_signup($user_name, $user_email);
            $code = 1;
            $message = '';
            if ($error['errors']->get_error_code() != '') {
                $code = -1;
                foreach ($error['errors']->get_error_messages() as $key => $value) {
                    $message .= '<div/>' . wp_kses_post(__('<strong>ERROR:</strong> ', 'g5plus-lustria'))  . esc_html($value) . '</div>';
                }
            } else {
                register_new_user($user_name, $user_email);
            }

            $response_data = array(
                'code' => $code,
                'message' => $message
            );

            ob_end_clean();
            echo json_encode($response_data);
            die(); // this is required to return a proper result
        }


        public function popup_product_quick_view(){
            $product_id = $_REQUEST['id'];
            global $post, $product;
            $post = get_post($product_id);
            setup_postdata($post);
            $product = wc_get_product( $product_id );
            G5Plus_Lustria()->helper()->getTemplate('woocommerce/content-product-quick-view');
            wp_reset_postdata();
            die();
        }

        public function in_admin() {
            return false;
        }
    }
}