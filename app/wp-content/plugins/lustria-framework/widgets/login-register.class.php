<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
if (!class_exists('G5P_Widget_Login_Register')) {
    class G5P_Widget_Login_Register extends GSF_Widget
    {
        public function __construct()
        {
            $this->widget_cssclass = 'widget-login-register';
            $this->widget_description = esc_html__("Display login register text", 'lustria-framework');
            $this->widget_id = 'gsf-login-register';
            $this->widget_name = esc_html__('G5Plus: Login - Register', 'lustria-framework');
            $this->settings = array(
                'fields' => array(
                    array(
                        'id' => 'login_text',
                        'type' => 'text',
                        'default' => esc_html__('Sign In', 'lustria-framework'),
                        'title' => esc_html__('Login Text', 'lustria-framework')
                    ),
                    array(
                        'id' => 'register_text',
                        'type' => 'text',
                        'default' => esc_html__('Join', 'lustria-framework'),
                        'title' => esc_html__('Register Text', 'lustria-framework')
                    )
                )
            );
            parent::__construct();
        }

        function widget($args, $instance)
        {
            extract($args, EXTR_SKIP);
            $login_text = (!empty($instance['login_text'])) ? $instance['login_text'] : esc_html__('Sign In', 'lustria-framework');
            $register_text = (!empty($instance['register_text'])) ? $instance['register_text'] : esc_html__('Join', 'lustria-framework');
            add_action('g5plus_after_page_wrapper', array(G5Plus_Lustria()->templates(),'login_register_popup'));
            ?>
            <?php echo wp_kses_post($args['before_widget']); ?>
            <i class="fal fa-user"></i>
            <?php if (!is_user_logged_in()): ?>
                <a class="gsf-login-link-sign-in no-animation transition03 gsf-link" href="#"><?php echo esc_html($login_text); ?></a>
                <span class="gsf-login-register-separator"> / </span>
                <a class="gsf-login-link-sign-up no-animation transition03 gsf-link" href="#"><?php echo esc_html($register_text); ?></a>
            <?php else: ?>
                <?php
                $current_user = wp_get_current_user();
                $display_name = empty($current_user->display_name) ? $current_user->user_login : $current_user->display_name;
                ?>
                <a href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')); ?>"
                   title="<?php esc_attr_e('My Account', 'lustria-framework'); ?>"><?php echo esc_html($display_name).','
                    ?></a>
                <a href="<?php echo esc_url(wp_logout_url(is_home() ? home_url('/') : get_permalink())); ?>"><?php esc_html_e('Logout', 'lustria-framework'); ?></a>
            <?php endif; ?>
            <?php echo wp_kses_post($args['after_widget']);
        }
    }
}