<?php

/**
 * Created by PhpStorm.
 */
if (!class_exists('G5P_Widget_Payment_Method')) {
    class G5P_Widget_Payment_Method extends GSF_Widget
    {
        public function __construct()
        {
            $this->widget_cssclass = 'widget-payment';
            $this->widget_id = 'gsf-payment';
            $this->widget_name = esc_html__('G5Plus: Payment', 'lustria-framework');
            $this->settings = array(
                'fields' => array(
                    array(
                        'id' => 'title',
                        'type' => 'text',
                        'default' => '',
                        'title' => esc_html__('Title:', 'lustria-framework')
                    ),
                    array(
                        'id' => 'payment_gr',
                        'title' => __('Payment Method', 'lustria-framework'),
                        'type' => 'panel',
                        'sort' => true,
                        'fields' => array(
                            array(
                                'id' => 'payment_name',
                                'type' => 'text',
                                'default' => '',
                                'title' => esc_html__('Payment Name', 'lustria-framework')
                            ),
                            array(
                                'id' => 'image',
                                'type' => 'image',
                                'title' => esc_html__('Select Image', 'lustria-framework'),
                            ),
                            array(
                                'id' => 'link',
                                'title' => esc_html__('Url redirect:', 'lustria-framework'),
                                'type' => 'text',
                                'default' => '',
                            ),
                        ),
                    ),
                )

            );
            parent::__construct();
        }

        function widget($args, $instance)
        {
            extract($args, EXTR_SKIP);
            $wrapper_classes = array(
                'widget-payment-wrap',
            );
            $title = (!empty($instance['title'])) ? $instance['title'] : '';
            $title = apply_filters('widget_title', $title, $instance, $this->id_base);
            echo wp_kses_post($args['before_widget']);
            if ($title) {
                echo wp_kses_post($args['before_title'] . $title . $args['after_title']);
            }
            $payment_method = array_key_exists('payment_gr', $instance) ? $instance['payment_gr'] : array();
            ?>
            <ul class="<?php echo join(' ', $wrapper_classes) ?>">
                <?php foreach ($payment_method as $payment_method_item) {
                    $image = isset($payment_method_item['image']) ? $payment_method_item['image'] : '';
                    $link = isset($payment_method_item['link']) ? $payment_method_item['link'] : '';
                    $name = isset($payment_method_item['name']) ? $payment_method_item['name'] : '';
                    ?>
                    <?php if (!empty($image['url'])): ?>
                        <li class="widget-payment-item">
                            <?php if (!empty($link)): ?>
                            <a href="<?php echo esc_url($link) ?>">
                                <?php endif; ?>
                                <img src="<?php echo esc_url($image['url']) ?>" alt="<?php echo esc_attr($name) ?>">
                                <?php if (!empty($link)): ?>
                            </a>
                        <?php endif; ?>
                        </li>
                    <?php endif; ?>
                <?php } ?>
            </ul>
            <?php
            echo wp_kses_post($args['after_widget']);
            ?>
            <?php
        }
    }
}
