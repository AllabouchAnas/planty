<?php
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'G5P_Widget_Product_Filter_Attribute' ) ) {
    class G5P_Widget_Product_Filter_Attribute extends GSF_Widget {

        /**
         * Use to print or not widget
         */
        public $found = false;
        public function __construct()
        {
            $attribute_array      = array();
            $attribute_taxonomies = wc_get_attribute_taxonomies();
            if ( ! empty( $attribute_taxonomies ) ) {
                foreach ( $attribute_taxonomies as $tax ) {
                    if ( wc_attribute_taxonomy_name( $tax->attribute_name ) ) {
                        $attribute_array[ $tax->attribute_name ] = $tax->attribute_label;
                    }
                }
            }
            $this->widget_cssclass = 'widget-product-filter-attribute woocommerce';
            $this->widget_description = __('Filter the list of products by attribute', 'lustria-framework');
            $this->widget_id = 'gsf-product-filter-attribute';
            $this->widget_name = __('G5Plus: Product Filter by Attribute', 'lustria-framework');
            $this->settings = array(
                'fields' => array(
                    array(
                        'id'      => 'title',
                        'title'   => esc_html__('Title:', 'lustria-framework'),
                        'type'    => 'text',
                        'default' => ''
                    ),
                    array(
                        'id'      => 'type',
                        'title'   => esc_html__('Type:', 'lustria-framework'),
                        'type'    => 'select',
                        'options' => array(
                            'list'   => __( 'List', 'lustria-framework' ),
                            'color'  => __( 'Color', 'lustria-framework' ),
                            'image'  => __( 'Image', 'lustria-framework' ),
                            'label'  => __( 'Label', 'lustria-framework' )
                        ),
                        'default' => 'list'
                    ),
                    array(
                        'id'      => 'query_type',
                        'title'   => esc_html__('Query Type:', 'lustria-framework'),
                        'type'    => 'button_set',
                        'options' => array(
                            'and'   => __( 'AND', 'lustria-framework' ),
                            'or'  => __( 'OR', 'lustria-framework' )
                        ),
                        'default' => 'and'
                    ),
                    array(
                        'id'      => 'attribute',
                        'title'   => esc_html__('Attribute:', 'lustria-framework'),
                        'type'    => 'select',
                        'options' => $attribute_array,
                        'default' => ''
                    ),
                    array(
                        'id'      => 'show_count',
                        'title'   => esc_html__('Show count:', 'lustria-framework'),
                        'type'    => 'switch',
                        'default' => ''
                    )
                )
            );
            parent::__construct();
        }

        function widget( $args, $instance ) {
            extract($args, EXTR_SKIP);
            $title = (!empty($instance['title'])) ? $instance['title'] : '';
            $title = apply_filters('widget_title', $title, $instance, $this->id_base);
            $display_type = isset( $instance['type'] ) ? $instance['type'] : 'list';
            $query_type = isset( $instance['query_type'] ) ? $instance['query_type'] : 'and';
            $attribute = isset( $instance['attribute'] ) ? $instance['attribute'] : '';
            $show_count = isset( $instance['show_count'] ) ? $instance['show_count'] : '';

            if ( !is_post_type_archive( 'product' ) && ! is_tax( get_object_taxonomies( 'product' ) )) {
                return;
            }

            $taxonomy = wc_attribute_taxonomy_name( $attribute );
            if ( ! taxonomy_exists( $taxonomy ) ) {
                return;
            }
            $terms = get_terms($taxonomy);
            if ( count( $terms ) === 0 ) return;
            ob_start();
            echo wp_kses_post($args['before_widget']);
            if ($title) {
                echo wp_kses_post($args['before_title'] . $title . $args['after_title']);
            }
            $wrap_classes = array(
              'gf-attr-filter-wrap',
              "gf-filter-type-{$display_type}"
            );

            if ($display_type === 'list' || $display_type === 'label') {
                $wrap_classes[] = 'widget_product_categories';
            }


            echo '<div class="'. esc_attr(implode(' ', $wrap_classes)) .'">';
            $this->found = false;

            $this->found = $this->layered_nav_list( $terms, $taxonomy, $query_type, $show_count, $display_type );
            if ( ! $this->found ) {
                echo '</div>';
                echo wp_kses_post($args['after_widget']);
                ob_end_clean();
            }
            else {
                echo ob_get_clean();
                echo '</div>';
                echo wp_kses_post($args['after_widget']);
            }
        }

        protected function get_current_term_id() {
            return absint( is_tax() ? get_queried_object()->term_id : 0 );
        }
        protected function get_current_term_slug() {
            return absint( is_tax() ? get_queried_object()->slug : 0 );
        }
        protected function layered_nav_list( $terms, $taxonomy, $query_type, $show_count, $display_type ) {
            echo '<ul class="gf-attr-filter-content">';

            $term_counts        = $this->get_filtered_term_product_counts( wp_list_pluck( $terms, 'term_id' ), $taxonomy, $query_type );
            $_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes();
            $found              = false;

            foreach ( $terms as $term ) {
                $current_values = isset( $_chosen_attributes[ $taxonomy ]['terms'] ) ? $_chosen_attributes[ $taxonomy ]['terms'] : array();
                $option_is_set  = in_array( $term->slug, $current_values );
                $count          = isset( $term_counts[ $term->term_id ] ) ? $term_counts[ $term->term_id ] : 0;

                // Skip the term for the current archive
                if ( $this->get_current_term_id() === $term->term_id ) {
                    continue;
                }

                if ( 0 < $count ) {
                    $found = true;
                } elseif ( 0 === $count && ! $option_is_set ) {
                    continue;
                }

                $filter_name    = 'filter_' . sanitize_title( str_replace( 'pa_', '', $taxonomy ) );
                $current_filter = isset( $_GET[ $filter_name ] ) ? explode( ',', wc_clean( $_GET[ $filter_name ] ) ) : array();
                $current_filter = array_map( 'sanitize_title', $current_filter );

                if ( ! in_array( $term->slug, $current_filter ) ) {
                    $current_filter[] = $term->slug;
                }

                $link = $this->get_page_base_url( $taxonomy, $query_type );
                foreach ( $current_filter as $key => $value ) {
                    if ( $value === $this->get_current_term_slug() ) {
                        unset( $current_filter[ $key ] );
                    }

                    if ( $option_is_set && $value === $term->slug ) {
                        unset( $current_filter[ $key ] );
                    }
                }

                if ( ! empty( $current_filter ) ) {
                    $link = add_query_arg( $filter_name, implode( ',', $current_filter ), $link );

                    // Add Query type Arg to URL
                    if ( 'or' === $query_type && ! ( 1 === sizeof( $current_filter ) && $option_is_set ) ) {
                        $link = add_query_arg( 'query_type_' . sanitize_title( str_replace( 'pa_', '', $taxonomy ) ), 'or', $link );
                    }
                }

                $link = str_replace('%2C', ',', $link);
                $value_el = '';
                switch ($display_type) {
                    case 'color':
                        $color_val = G5P()->termMeta()->get_product_taxonomy_color($term->term_id);
                        $color_val = !empty($color_val) ? $color_val : '#fff';
                        if ($count > 0 || $option_is_set) {
                            $link = esc_url(apply_filters('woocommerce_layered_nav_link', $link, $term, $taxonomy));
                            if ('on' === $show_count) {
                                $term_html = '<a style="color:' . esc_attr($color_val) .'" class="gsf-link transition03 no-animation" href="' . esc_url($link)  . '" data-toggle="tooltip" title="' . esc_html($term->name) . ' (' . absint($count) . ')' . '"></a>';
                            } else {
                                $term_html = '<a style="color:' . esc_attr($color_val) .'" class="gsf-link transition03 no-animation" href="' . esc_url($link) . '" data-toggle="tooltip" title="' . esc_html($term->name). '"></a>';
                            }
                        } else {
                            $link = false;
                            if ('on' === $show_count) {
                                $term_html = '<span style="color:' . esc_attr($color_val) .'"  data-toggle="tooltip" title="' . esc_html($term->name) . ' (' . absint($count) . ')' . '"></span>';
                            } else {
                                $term_html = '<span style="color:' . esc_attr($color_val) .'" data-toggle="tooltip" title="' . esc_html($term->name) . '"></span>';
                            }
                        }
                        break;
                    case 'image':
                        $val = G5P()->termMeta()->get_product_taxonomy_image($term->term_id);
                        $val = !empty($val['id']) ? wp_get_attachment_thumb_url($val['id']) : wc_placeholder_img_src();
                        if ($count > 0 || $option_is_set) {
                            $link = apply_filters('woocommerce_layered_nav_link', $link, $term, $taxonomy);
                            if ('on' === $show_count) {
                                $term_html = '<a style="background-image: url(' . esc_url($val) . ');" class="gsf-link transition03 no-animation" href="' . esc_url($link) . '" data-toggle="tooltip" title="' . esc_html($term->name) . ' (' . absint($count) . ')' . '"></a>';
                            } else {
                                $term_html = '<a style="background-image: url(' . esc_url($val) . ');" class="gsf-link transition03 no-animation" href="' . esc_url($link) . '" data-toggle="tooltip" title="' . esc_html($term->name). '"></a>';
                            }
                        } else {
                            $link = false;
                            if ('on' === $show_count) {
                                $term_html = '<span style="background-image: url(' . esc_url($val) . ');"  data-toggle="tooltip" title="' . esc_html($term->name) . ' (' . absint($count) . ')' . '"></span>';
                            } else {
                                $term_html = '<span style="background-image: url(' . esc_url($val) . ');"  data-toggle="tooltip" title="' . esc_html($term->name) . '"></span>';
                            }
                        }
                        break;
                    default:
                        $term_name = G5P()->termMeta()->get_product_taxonomy_text($term->term_id);
                        $term_name = !empty($term_name) ? $term_name : $term->name;
                        if ($count > 0 || $option_is_set) {
                            $link = apply_filters('woocommerce_layered_nav_link', $link, $term, $taxonomy);
                            if ('on' === $show_count) {
                                $term_html = '<a class="gsf-link transition03 no-animation" href="' . esc_url($link) . '">' . esc_html($term_name) . '</a>' . apply_filters('woocommerce_layered_nav_count', ' <span class="count"> (' . absint($count) . ')</span>', $count, $term);
                            } else {
                                $term_html = '<a class="gsf-link transition03 no-animation" href="' . esc_url($link) . '">' . esc_html($term_name) . '</a>';
                            }
                        } else {
                            $link = false;
                            if ('on' === $show_count) {
                                $term_html = '<span>' . $value_el . esc_html($term_name) . '</span>' . apply_filters('woocommerce_layered_nav_count', ' <span class="count"> (' . absint($count) . ')</span>', $count, $term);
                            } else {
                                $term_html = '<span>' . $value_el . esc_attr($term_name) . '</span>';
                            }
                        }
                        break;
                }
                echo '<li class="wc-layered-nav-term ' . ( $option_is_set ? 'current-cat' : '' ) . '">';
                echo wp_kses_post( apply_filters( 'woocommerce_layered_nav_term_html', $term_html, $term, $link, $count ) );
                echo '</li>';
            }

            echo '</ul>';

            return $found;
        }
        protected function get_filtered_term_product_counts( $term_ids, $taxonomy, $query_type ) {
            global $wpdb;

            $tax_query  = WC_Query::get_main_tax_query();
            $meta_query = WC_Query::get_main_meta_query();

            if ( 'or' === $query_type ) {
                foreach ( $tax_query as $key => $query ) {
                    if ( is_array( $query ) && $taxonomy === $query['taxonomy'] ) {
                        unset( $tax_query[ $key ] );
                    }
                }
            }

            $meta_query      = new WP_Meta_Query( $meta_query );
            $tax_query       = new WP_Tax_Query( $tax_query );
            $meta_query_sql  = $meta_query->get_sql( 'post', $wpdb->posts, 'ID' );
            $tax_query_sql   = $tax_query->get_sql( $wpdb->posts, 'ID' );

            // Generate query
            $query           = array();
            $query['select'] = "SELECT COUNT( DISTINCT {$wpdb->posts}.ID ) as term_count, terms.term_id as term_count_id";
            $query['from']   = "FROM {$wpdb->posts}";
            $query['join']   = "
			INNER JOIN {$wpdb->term_relationships} AS term_relationships ON {$wpdb->posts}.ID = term_relationships.object_id
			INNER JOIN {$wpdb->term_taxonomy} AS term_taxonomy USING( term_taxonomy_id )
			INNER JOIN {$wpdb->terms} AS terms USING( term_id )
			" . $tax_query_sql['join'] . $meta_query_sql['join'];

            $query['where']   = "
			WHERE {$wpdb->posts}.post_type IN ( 'product' )
			AND {$wpdb->posts}.post_status = 'publish'
			" . $tax_query_sql['where'] . $meta_query_sql['where'] . "
			AND terms.term_id IN (" . implode( ',', array_map( 'absint', $term_ids ) ) . ")
		";

            if ( $search = WC_Query::get_main_search_query_sql() ) {
                $query['where'] .= ' AND ' . $search;
            }

            $query['group_by'] = "GROUP BY terms.term_id";
            $query             = apply_filters( 'woocommerce_get_filtered_term_product_counts_query', $query );
            $query             = implode( ' ', $query );
            $results           = $wpdb->get_results( $query );

            return wp_list_pluck( $results, 'term_count', 'term_count_id' );
        }
        protected function get_page_base_url( $taxonomy, $query_type ) {
            global $wp;
            $link = trailingslashit(home_url($wp->request));
            $pos = strpos($link , '/page');
            if($pos) {
                $link = substr($link, 0, $pos);
            }

            $queried_object = get_queried_object();

            // Min/Max
            if ( isset( $_GET['min_price'] ) ) {
                $link = add_query_arg( 'min_price', wc_clean( $_GET['min_price'] ), $link );
            }

            if ( isset( $_GET['max_price'] ) ) {
                $link = add_query_arg( 'max_price', wc_clean( $_GET['max_price'] ), $link );
            }

            // Orderby
            if ( isset( $_GET['orderby'] ) ) {
                $link = add_query_arg( 'orderby', wc_clean( $_GET['orderby'] ), $link );
            }

            if ( isset( $_GET['product_tag'] ) ) {
                $link = add_query_arg( 'product_tag', urlencode( $_GET['product_tag'] ), $link );
            }

            elseif( is_product_tag() && $queried_object ){
                $link = add_query_arg( array( 'product_tag' => $queried_object->slug ), $link );
            }

            if( isset( $_GET['product_cat'] ) ){
                $categories_filter_operator = 'and' == $query_type ? '+' : ',';
                $_chosen_categories = explode( $categories_filter_operator, urlencode( $_GET['product_cat'] ) );
                $link  = add_query_arg(
                    'product_cat',
                    implode( $categories_filter_operator, $_chosen_categories ),
                    $link
                );
            }

            /**
             * Search Arg.
             * To support quote characters, first they are decoded from &quot; entities, then URL encoded.
             */
            if ( get_search_query() ) {
                $link = add_query_arg( 's', rawurlencode( wp_specialchars_decode( get_search_query() ) ), $link );
            }

            // Post Type Arg
            if ( isset( $_GET['post_type'] ) ) {
                $link = add_query_arg( 'post_type', wc_clean( $_GET['post_type'] ), $link );
            }

            // Min Rating Arg
            if ( isset( $_GET['rating_filter'] ) ) {
                $link = add_query_arg( 'rating_filter', wc_clean( $_GET['rating_filter'] ), $link );
            }

            // All current filters
            if ( $_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes() ) {
                foreach ( $_chosen_attributes as $name => $data ) {
                    if ( $name === $taxonomy ) {
                        continue;
                    }
                    $filter_name = sanitize_title( str_replace( 'pa_', '', $name ) );
                    if ( ! empty( $data['terms'] ) ) {
                        $link = add_query_arg( 'filter_' . $filter_name, implode( ',', $data['terms'] ), $link );
                    }
                    if ( 'or' == $data['query_type'] ) {
                        $link = add_query_arg( 'query_type_' . $filter_name, 'or', $link );
                    }
                }
            }

            return $link;
        }
    }
}