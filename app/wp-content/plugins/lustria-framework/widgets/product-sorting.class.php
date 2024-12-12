<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if (!class_exists('G5P_Widget_Product_Sorting')) {
    class G5P_Widget_Product_Sorting extends GSF_Widget
    {
        /**
         * Constructor
         */
        public function __construct()
        {
            $this->widget_cssclass = 'widget-product-sorting woocommerce';
            $this->widget_description = __('Display a product sorting list.', 'lustria-framework');
            $this->widget_id = 'gsf-product-sorting';
            $this->widget_name = __('G5Plus: Product Sorting', 'lustria-framework');
            $this->settings = array(
                'fields' => array(
                    array(
                        'id'      => 'title',
                        'title'   => esc_html__('Title:', 'lustria-framework'),
                        'type'    => 'text',
                        'default' => esc_html__('Sort By', 'lustria-framework')
                    )
                )
            );

            parent::__construct();
        }

        /**
         * Widget function
         *
         * @see WP_Widget
         * @access public
         * @param array $args
         * @param array $instance
         * @return void
         */
        public function widget($args, $instance)
        {
            global $wp_query;
            extract($args, EXTR_SKIP);
            $title = (!empty($instance['title'])) ? $instance['title'] : '';
            $title = apply_filters('widget_title', $title, $instance, $this->id_base);


            if ( !is_post_type_archive( 'product' ) && ! is_tax( get_object_taxonomies( 'product' ) )) {
                return;
            }


            echo wp_kses_post($args['before_widget']);
            if ($title) {
                echo wp_kses_post($args['before_title'] . $title . $args['after_title']);
            }

            $output = '';
            if (1 != $wp_query->found_posts || woocommerce_products_will_display()) {
                $output .= '<ul id="gf-product-sorting" class="gf-product-sorting">';

                $orderby = isset($_GET['orderby']) ? wc_clean($_GET['orderby']) : apply_filters('woocommerce_default_catalog_orderby', get_option('woocommerce_default_catalog_orderby'));
                $orderby == ($orderby === 'title') ? 'menu_order' : $orderby;

                $catalog_orderby_options = apply_filters('woocommerce_catalog_orderby', array(
                    'menu_order' => __('Default', 'lustria-framework'),
                    'popularity' => __('Popularity', 'lustria-framework'),
                    'rating' => __('Average rating', 'lustria-framework'),
                    'date' => __('Newness', 'lustria-framework'),
                    'price' => __('Price: Low to High', 'lustria-framework'),
                    'price-desc' => __('Price: High to Low', 'lustria-framework')
                ));

                if (get_option('woocommerce_enable_review_rating') === 'no') {
                    unset($catalog_orderby_options['rating']);
                }

                global $wp;
                $link = trailingslashit(home_url($wp->request));
                $pos = strpos($link , '/page');
                if($pos) {
                    $link = substr($link, 0, $pos);
                }

                // Unset query strings used for Ajax shop filters
                unset($_GET['_']);

                $qs_count = count($_GET);

                if ($qs_count > 0) {
                    $i = 0;
                    $link .= '?';

                    // Build query string
                    foreach ($_GET as $key => $value) {
                        $i++;
                        $link .= $key . '=' . $value;
                        if ($i != $qs_count) {
                            $link .= '&';
                        }
                    }
                }

                foreach ($catalog_orderby_options as $id => $name) {
                    if ($orderby == $id) {
                        $output .= '<li class="active"><span>' . esc_attr($name) . '</span></li>';
                    } else {
                        $link = add_query_arg('orderby', $id, $link);
                        $output .= '<li><a class="transition03 gsf-link no-animation" href="' . esc_url($link) . '">' . esc_attr($name) . '</a></li>';
                    }
                }
                $output .= '</ul>';
            }
            echo $output;
            echo wp_kses_post($args['after_widget']);
        }
    }
}