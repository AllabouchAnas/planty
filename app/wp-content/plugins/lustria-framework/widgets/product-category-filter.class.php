<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if (!class_exists('G5P_Widget_Product_Category_Filter')) {
    class G5P_Widget_Product_Category_Filter extends GSF_Widget
    {
        /**
         * Category ancestors.
         *
         * @var array
         */
        public $cat_ancestors;

        /**
         * Current Category.
         *
         * @var bool
         */
        public $current_cat;
        /**
         * Constructor
         */
        public function __construct()
        {
            $this->widget_cssclass = 'widget-product-category-filter widget_product_categories';
            $this->widget_description = __('Display a product categories list.', 'lustria-framework');
            $this->widget_id = 'gsf-product-category-filter';
            $this->widget_name = __('G5Plus: Product Category Filter', 'lustria-framework');
            $this->settings = array(
                'fields' => array(
                    array(
                        'id'      => 'title',
                        'title'   => esc_html__('Title:', 'lustria-framework'),
                        'type'    => 'text',
                        'default' => esc_html__('Product categories', 'lustria-framework')
                    ),
                    array(
                        'id' => 'orderby',
                        'type'  => 'select',
                        'default'   => 'name',
                        'title' => __( 'Order by', 'lustria-framework' ),
                        'options' => array(
                            'order' => __( 'Category order', 'lustria-framework' ),
                            'name'  => __( 'Name', 'lustria-framework' )
                        )
                    ),
                    array(
                        'id' => 'count',
                        'type'  => 'switch',
                        'default'   => 'on',
                        'title' => __( 'Show product counts', 'lustria-framework' )
                    ),
                    array(
                        'id' => 'hierarchical',
                        'type'  => 'switch',
                        'default'   => 'on',
                        'title' => __( 'Show hierarchy', 'lustria-framework' )
                    ),
                    array(
                        'id' => 'show_children_only',
                        'type'  => 'switch',
                        'default'   => '',
                        'title' => __( 'Only show children of the current category', 'lustria-framework' )
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
            global $wp_query, $post;
            extract($args, EXTR_SKIP);
            $title = (!empty($instance['title'])) ? $instance['title'] : '';
            $title = apply_filters('widget_title', $title, $instance, $this->id_base);
            $orderby = isset( $instance['orderby'] ) ? $instance['orderby'] : 'name';
            $count = isset( $instance['count'] ) ? $instance['count'] : 'on';
            $hierarchical = isset( $instance['hierarchical'] ) ? $instance['hierarchical'] : 'on';
            $show_children_only = isset( $instance['show_children_only'] ) ? $instance['show_children_only'] : '';

            echo wp_kses_post($args['before_widget']);
            if ($title) {
                echo wp_kses_post($args['before_title'] . $title . $args['after_title']);
            }
            $list_args          = array(
                'is_anchor' => true,
                'show_count'   => 'on' === $count,
                'hierarchical' => 'on' === $hierarchical,
                'taxonomy'     => 'product_cat',
                'hide_empty'   => true,
            );
            if ( 'order' === $orderby ) {
                $list_args['menu_order'] = 'asc';
            } else {
                $list_args['orderby']    = 'title';
            }

            $this->current_cat   = false;
            $this->cat_ancestors = array();

            if ( is_tax( 'product_cat' ) ) {
                $this->current_cat   = $wp_query->queried_object;
                $this->cat_ancestors = get_ancestors( $this->current_cat->term_id, 'product_cat' );

            } elseif ( is_singular( 'product' ) ) {
                $product_category = wc_get_product_terms( $post->ID, 'product_cat', apply_filters( 'woocommerce_product_categories_widget_product_terms_args', array(
                    'orderby' => 'parent',
                ) ) );

                if ( ! empty( $product_category ) ) {
                    $this->current_cat   = end( $product_category );
                    $this->cat_ancestors = get_ancestors( $this->current_cat->term_id, 'product_cat' );
                }
            }

            // Show Siblings and Children Only.
            if ( $show_children_only && $this->current_cat ) {
                if ( $hierarchical ) {
                    $include = array_merge(
                        $this->cat_ancestors,
                        array( $this->current_cat->term_id ),
                        get_terms(
                            'product_cat',
                            array(
                                'fields'       => 'ids',
                                'parent'       => 0,
                                'hierarchical' => true,
                                'hide_empty'   => false,
                            )
                        ),
                        get_terms(
                            'product_cat',
                            array(
                                'fields'       => 'ids',
                                'parent'       => $this->current_cat->term_id,
                                'hierarchical' => true,
                                'hide_empty'   => false,
                            )
                        )
                    );
                    // Gather siblings of ancestors.
                    if ( $this->cat_ancestors ) {
                        foreach ( $this->cat_ancestors as $ancestor ) {
                            $include = array_merge( $include, get_terms(
                                'product_cat',
                                array(
                                    'fields'       => 'ids',
                                    'parent'       => $ancestor,
                                    'hierarchical' => false,
                                    'hide_empty'   => false,
                                )
                            ) );
                        }
                    }
                } else {
                    // Direct children.
                    $include = get_terms(
                        'product_cat',
                        array(
                            'fields'       => 'ids',
                            'parent'       => $this->current_cat->term_id,
                            'hierarchical' => true,
                            'hide_empty'   => false,
                        )
                    );
                } // End if().

                $list_args['include']     = implode( ',', $include );

                if ( empty( $include ) ) {
                    return;
                }
            } elseif ( $show_children_only ) {
                $list_args['depth']            = 1;
                $list_args['child_of']         = 0;
                $list_args['hierarchical']     = 1;
            }

            include_once G5P()->pluginDir('/inc/walker/product-cat-list-walker.class.php');
            $list_args['walker']                     = new GSF_Product_Cat_List_Walker();
            $list_args['menu_order'] = false;
            $list_args['title_li']                   = '';
            $list_args['current_category_ancestors'] = array();
            $list_args['pad_counts']                 = 1;
            $list_args['show_option_none']           = __( 'No product categories exist.', 'lustria-framework' );

            echo '<ul class="product-categories">';
            echo '<li class="cate-item all-cate'.($this->current_cat ? '' : ' current-cat') .'"><a href="'. esc_url(wc_get_page_permalink( 'shop' )).'" class="no-animation gsf-link transition03">' . esc_html__('All Category','lustria-framework') .'</a></li>';
            wp_list_categories( apply_filters( 'woocommerce_product_categories_widget_args', $list_args ) );
            echo '</ul>';
            echo wp_kses_post($args['after_widget']);
        }
    }
}