<?php
if (!defined('ABSPATH')) {
    exit;
//	Exit if accessed directly
}
if (!class_exists('G5P_Widget_Price_Filter')) {
    class G5P_Widget_Price_Filter extends GSF_Widget
    {
        public function __construct()
        {
            $this->widget_cssclass = 'widget-price-filter woocommerce';
            $this->widget_description = __('Shows a price filter list in a widget which lets you narrow down the list of shown products when viewing product categories.', 'lustria-framework');
            $this->widget_id = 'gsf-price-filter';
            $this->widget_name = __('G5Plus: Price Filter List', 'lustria-framework');
            $this->settings = array(
                'fields' => array(
                    array(
                        'id'      => 'title',
                        'title'   => esc_html__('Title:', 'lustria-framework'),
                        'type'    => 'text',
                        'default' => __('Filter by price', 'lustria-framework')
                    ),
                    array(
                        'id' => 'price_range_size',
                        'type'       => 'text',
                        'input_type' => 'number',
                        'args' => array(
                            'min' => '1',
                            'max' => '1000',
                            'step' => '1'
                        ),
                        'default' => 50,
                        'title' => __('Price range size', 'lustria-framework')
                    ),
                    array(
                        'id' => 'max_price_ranges',
                        'type'       => 'text',
                        'input_type' => 'number',
                        'args' => array(
                            'min' => '1',
                            'max' => '20',
                            'step' => '1'
                        ),
                        'default' => 5,
                        'title' => __('Max price ranges', 'lustria-framework')
                    ),
                    array(
                        'id' => 'hide_empty_ranges',
                        'type' => 'switch',
                        'default' => 'on',
                        'title' => __('Hide empty price ranges', 'lustria-framework')
                    )
                )
            );

            parent::__construct();
        }

        function widget($args, $instance)
        {
            global $wp, $wp_query;
            if (!is_post_type_archive('product') && !is_tax(get_object_taxonomies('product'))) return;
            if (!$wp_query->post_count) return;

            extract($args, EXTR_SKIP);
            $title = (!empty($instance['title'])) ? $instance['title'] : '';
            $title = apply_filters('widget_title', $title, $instance, $this->id_base);
            $price_range_size = (!empty($instance['price_range_size'])) ? intval($instance['price_range_size']) : 50;
            $max_price_ranges = (!empty($instance['max_price_ranges'])) ? intval($instance['max_price_ranges']) : 5;
            $hide_empty_ranges = (!empty($instance['hide_empty_ranges'])) ? $instance['hide_empty_ranges'] : 'on';

            $min_price = isset($_GET['min_price']) ? esc_attr($_GET['min_price']) : '';
            $max_price = isset($_GET['max_price']) ? esc_attr($_GET['max_price']) : '';

            $link = trailingslashit(home_url($wp->request));
            $pos = strpos($link , '/page');
            if($pos) {
                $link = substr($link, 0, $pos);
            }
            // Find min and max price in current result set
            $prices = $this->get_filtered_price();
            $min = floor($prices->min_price);
            $max = ceil($prices->max_price);

            if ($min == $max) {
                return;
            }

            echo wp_kses_post($args['before_widget']);
            if ($title) {
                echo wp_kses_post($args['before_title'] . $title . $args['after_title']);
            }

            if (wc_tax_enabled() && 'incl' === get_option('woocommerce_tax_display_shop') && !wc_prices_include_tax()) {
                $tax_classes = array_merge(array(''), WC_Tax::get_tax_classes());
                $class_max = $max;

                foreach ($tax_classes as $tax_class) {
                    if ($tax_rates = WC_Tax::get_rates($tax_class)) {
                        $class_max = $max + WC_Tax::get_tax_total(WC_Tax::calc_exclusive_tax($max, $tax_rates));
                    }
                }

                $max = $class_max;
            }

            $min = apply_filters('woocommerce_price_filter_widget_min_amount', $min);
            $max_unfiltered = $max;
            $max = apply_filters('woocommerce_price_filter_widget_max_amount', $max);

            $count = 0;
            if ($max_unfiltered != $max) {
                $range_size = round(apply_filters('woocommerce_price_filter_widget_max_amount', $price_range_size), 0);
                $range_size = apply_filters('gf_price_filter_range_size', $range_size);
            } else {
                $range_size = $price_range_size;
            }
            $max_ranges = ($max_price_ranges - 1);

            $wc_price_args = array('decimals' => 0);

            $output = '<ul class="gf-price-filter">';

            // Unset query strings used for Ajax shop filters
            unset($_GET['_']);

            $qs_count = count($_GET);

            if ($qs_count > 0) {
                $i = 0;
                $link .= '?';

                // Build query string
                foreach ($_GET as $key => $value) {
                    if(in_array($key, array('min_price', 'max_price'))) continue;
                    $i++;
                    $link .= $key . '=' . $value;
                    if ($i != $qs_count) {
                        $link .= '&';
                    }
                }
            }

            if ($_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes()) {
                foreach ($_chosen_attributes as $attribute => $data) {
                    $taxonomy_filter = 'filter_' . str_replace('pa_', '', $attribute);

                    $link = add_query_arg($taxonomy_filter, implode(',', $data['terms']), $link);

                    if ('or' == $data['query_type']) {
                        $link = add_query_arg(str_replace('pa_', 'query_type_', $attribute), 'or', $link);
                    }
                }
            }
            $link = str_replace('%2C', ',', $link);
            if (strlen($min_price) > 0) {
                $output .= '<li><a class="gsf-link transition03" href="' . esc_url($link) . '">' . esc_html__('All', 'lustria-framework') . '</a></li>';
            } else {
                $output .= '<li class="active"><span>' . esc_html__('All', 'lustria-framework') . '</span></li>';
            }
            for ($range_min = 0; $range_min < ($max + $range_size); $range_min += $range_size) {
                $range_max = $range_min + $range_size;

                if ('on' === $hide_empty_ranges) {
                    // Are there products in this price range?
                    if ($min > $range_max || ($max + $range_size) < $range_max) {
                        continue;
                    }
                }

                $count++;

                $min_price_output = wc_price($range_min, $wc_price_args);

                if ($count == $max_ranges) {
                    $price_output = $min_price_output . '+';
                    if ($range_min != $min_price) {
                        $url = add_query_arg(array('min_price' => $range_min, 'max_price' => $max), $link);
                        $url = str_replace('%2C', ',', $url);
                        $output .= '<li><a class="gsf-link transition03 no-animation" href="' . esc_url($url) . '">' . $price_output . '</a></li>';
                    } else {
                        $output .= '<li class="active">' . $price_output . '</li>';
                    }

                    break;
                } else {
                    $price_output = $min_price_output . ' - ' . wc_price($range_min + $range_size, $wc_price_args);

                    if ($range_min != $min_price || $range_max != $max_price) {
                        $url = add_query_arg(array('min_price' => $range_min, 'max_price' => $range_max), $link);
                        $url = str_replace('%2C', ',', $url);
                        $output .= '<li><a class="gsf-link transition03 no-animation" href="' . esc_url($url) . '">' . $price_output . '</a></li>';
                    } else {
                        $output .= '<li class="active">' . $price_output . '</li>';
                    }
                }
            }

            $output .= '</ul>';
            echo $output;
            echo wp_kses_post($args['after_widget']);
        }

        protected function get_filtered_price()
        {
            global $wpdb, $wp_query;
            $args = $wp_query->query_vars;
            $tax_query = isset($args['tax_query']) ? $args['tax_query'] : array();
            $meta_query = isset($args['meta_query']) ? $args['meta_query'] : array();

            if (!empty($args['taxonomy']) && !empty($args['term'])) {
                $tax_query[] = array(
                    'taxonomy' => $args['taxonomy'],
                    'terms' => array($args['term']),
                    'field' => 'slug',
                );
            }

            foreach ($meta_query as $key => $query) {
                if (!empty($query['price_filter']) || !empty($query['rating_filter'])) {
                    unset($meta_query[$key]);
                }
            }

            $meta_query = new WP_Meta_Query($meta_query);
            $tax_query = new WP_Tax_Query($tax_query);

            $meta_query_sql = $meta_query->get_sql('post', $wpdb->posts, 'ID');
            $tax_query_sql = $tax_query->get_sql($wpdb->posts, 'ID');

            $sql = "SELECT min( CAST( price_meta.meta_value AS UNSIGNED ) ) as min_price, max( CAST( price_meta.meta_value AS UNSIGNED ) ) as max_price FROM {$wpdb->posts} ";
            $sql .= " LEFT JOIN {$wpdb->postmeta} as price_meta ON {$wpdb->posts}.ID = price_meta.post_id " . $tax_query_sql['join'] . $meta_query_sql['join'];
            $sql .= " 	WHERE {$wpdb->posts}.post_type = 'product'
					AND {$wpdb->posts}.post_status = 'publish'
					AND price_meta.meta_key IN ('" . implode("','", array_map('esc_sql', apply_filters('woocommerce_price_filter_meta_keys', array('_price')))) . "')
					AND price_meta.meta_value > '' ";
            $sql .= $tax_query_sql['where'] . $meta_query_sql['where'];

            return $wpdb->get_row($sql);
        }
    }
}