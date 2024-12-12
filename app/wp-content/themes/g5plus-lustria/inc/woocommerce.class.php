<?php
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
if (!class_exists('G5Plus_Lustria_Woocommerce')) {
    class G5Plus_Lustria_Woocommerce {
        private static $_instance;
        public static function getInstance()
        {
            if (self::$_instance == NULL) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        public function init(){
            $this->filter();
            add_action('init',array($this,'remove_hook'));
            add_action('load-post.php',array($this,'remove_hook'));
	        add_action('init',array($this,'hook'));
	        add_action('init',array($this,'legacy_widget_preview'));
	        add_action('init',array($this,'change_compare_button_position'),30);
        }

	    public function change_compare_button_position() {
		    global $yith_woocompare;
		    if ( isset($yith_woocompare) && isset($yith_woocompare->obj)) {
			    remove_action( 'woocommerce_after_shop_loop_item', array($yith_woocompare->obj,'add_compare_link'), 20 );
			    remove_action( 'woocommerce_single_product_summary', array( $yith_woocompare->obj, 'add_compare_link' ), 35 );
		    }
	    }

	    public function legacy_widget_preview(){
		    if ( empty( $_GET['legacy-widget-preview'] ) ) {
			    return;
		    }

		    if ( ! current_user_can( 'edit_theme_options' ) ) {
			    return;
		    }


		    if ( ! class_exists( 'WC_Frontend_Scripts' ) ) {
			    if ( ! defined( 'WC_ABSPATH' ) || ! file_exists( WC_ABSPATH . 'includes/class-wc-frontend-scripts.php' ) ) {
				    return;
			    }
			    include_once WC_ABSPATH . 'includes/class-wc-frontend-scripts.php';
		    }

	    }

        public function filter() {
            add_filter('gsf_shorcodes', array($this, 'register_shortcode'));

            //page title
            add_filter('g5plus_page_title',array($this,'page_title'));

            add_filter('g5plus_post_layout_matrix',array($this,'layout_matrix'));

            // remove shop page title
            add_filter('woocommerce_show_page_title','__return_false');

            add_filter('woocommerce_product_description_heading','__return_false');
            add_filter('woocommerce_product_additional_information_heading','__return_false');
            add_filter('woocommerce_product_review_heading','__return_false');

            add_filter('woocommerce_review_gravatar_size', array($this,'review_gravatar_size'));

            add_filter('gsf_page_setting_post_type',array($this,'page_setting'));

            add_filter( 'product_attributes_type_selector', array( $this, 'type_selector' ) );
            $attribute_taxonomies = wc_get_attribute_taxonomies();
            foreach ( $attribute_taxonomies as $attribute_taxonomy ) {
                add_filter("manage_edit-pa_{$attribute_taxonomy->attribute_name}_columns", array(
                    $this,
                    'swatches_custom_columns'
                ));
                add_filter("manage_pa_{$attribute_taxonomy->attribute_name}_custom_column", array(
                    $this,
                    'swatches_custom_columns_content'
                ), 10, 3);
            }
            // single product related
            add_filter('woocommerce_output_related_products_args', array($this, 'product_related_products_args'));
            add_filter('woocommerce_product_related_posts_relate_by_category',array($this, 'product_related_posts_relate_by_category'));
            add_filter('woocommerce_product_related_posts_relate_by_tag',array($this, 'product_related_posts_relate_by_tag'));

            add_filter('woocommerce_upsells_total', array($this, 'product_up_sells_posts_per_page'));

            add_filter('woocommerce_cart_item_thumbnail', array($this, 'product_cart_item_thumbnail'), 10, 3);
            // Cross sells
            add_filter('woocommerce_cross_sells_total', array($this, 'product_cross_sells_posts_per_page'));
            add_filter('woocommerce_single_product_image_thumbnail_html', array($this, 'gallery_thumbnail_src'), 10, 2);

            add_filter('woocommerce_available_variation', array($this, 'change_variation_thumb_src'), 10, 3);

            add_filter('yith_wcwl_loop_positions',array($this, 'change_yith_wcwl_positions'));
	        add_filter('yith_wcwl_positions',array($this, 'change_yith_wcwl_positions'));
        }

        public function remove_hook() {
            // remove woocommerce sidebar
            remove_action('woocommerce_sidebar','woocommerce_get_sidebar',10);

            // remove Breadcrumb
            remove_action('woocommerce_before_main_content','woocommerce_breadcrumb',20);

            // remove archive description
            remove_action('woocommerce_archive_description','woocommerce_taxonomy_archive_description',10);
            remove_action('woocommerce_archive_description','woocommerce_product_archive_description',10);

            // remove result count and catalog ordering
            remove_action('woocommerce_before_shop_loop','woocommerce_result_count',20);
            remove_action('woocommerce_before_shop_loop','woocommerce_catalog_ordering',30);

            // remove pagination
            //remove_action('woocommerce_after_shop_loop','woocommerce_pagination',10);

            // remove product link close
            remove_action('woocommerce_after_shop_loop_item','woocommerce_template_loop_product_link_close',5);
            remove_action('woocommerce_before_shop_loop_item','woocommerce_template_loop_product_link_open',10);

            //remove add to cart
            remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

            // remove product thumb
            remove_action('woocommerce_before_shop_loop_item_title','woocommerce_template_loop_product_thumbnail',10);

            // remove product title
            remove_action('woocommerce_shop_loop_item_title','woocommerce_template_loop_product_title',10);

            // remove product price
            /*remove_action('woocommerce_after_shop_loop_item_title','woocommerce_template_loop_price',10);*/

            // remove product rating
            remove_action('woocommerce_after_shop_loop_item_title','woocommerce_template_loop_rating',5);

            // single product
            remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
            $product_add_to_cart_enable = G5Plus_Lustria()->options()->get_product_add_to_cart_enable();
            if ('on' !== $product_add_to_cart_enable) {
                remove_action('woocommerce_single_product_summary','woocommerce_template_single_add_to_cart',30);
            }




            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating',10);

            // variations single
            $swatches_enable = G5Plus_Lustria()->options()->get_product_single_swatches_enable();
            if ( 'on' === $swatches_enable ) {
                remove_action( 'woocommerce_variable_add_to_cart', 'woocommerce_variable_add_to_cart', 30 );
            }
        }

        public function hook() {



            add_action('pre_get_posts',array($this,'changePostPerPage'),7);

            add_action( 'woocommerce_product_option_terms', array( $this, 'option_terms' ), 10, 2 );

            add_action( 'woocommerce_after_shop_loop_item_title', array( G5Plus_Lustria()->templates(), 'shop_swatches_loop' ), 20 );
            // product cat
            add_action('woocommerce_shop_loop_item_title',array(G5Plus_Lustria()->templates(),'shop_loop_product_cat'),10);

            // product title
            add_action('woocommerce_shop_loop_item_title',array(G5Plus_Lustria()->templates(),'shop_loop_product_title'),15);


            // product rating
            add_action('woocommerce_after_shop_loop_item_title','woocommerce_template_loop_rating',15);


            // Sale count down
            add_action('woocommerce_before_shop_loop_item_title',array(G5Plus_Lustria()->templates(),'shop_loop_sale_count_down'),10);

            // product add to cart
            add_action('g5plus_woocommerce_product_actions',array(G5Plus_Lustria()->templates(),'shop_loop_grid_add_to_cart'),10);

            // product actions
            add_action('g5plus_woocommerce_product_actions',array(G5Plus_Lustria()->templates(),'shop_loop_quick_view'),15);

            // product wishlist
            add_action('g5plus_woocommerce_product_actions',array(G5Plus_Lustria()->templates(),'shop_loop_wishlist'),10);

            add_action('g5plus_woocommerce_product_actions',array(G5Plus_Lustria()->templates(),'shop_loop_compare'),20);




            add_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_loop_sale_flash', 10);



            add_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating',1);
            add_action('woocommerce_single_product_summary',array(G5Plus_Lustria()->templates(),'shop_single_loop_sale_count_down'),15);


            // variations single
            $swatches_enable = G5Plus_Lustria()->options()->get_product_single_swatches_enable();
            if ( 'on' === $swatches_enable ) {
                add_action( 'woocommerce_variable_add_to_cart', array( G5Plus_Lustria()->templates(), 'swatches_single' ) );
            }

            // Quick view
            add_action( 'wp_footer', array( $this, 'quick_view' ));

            add_action('woocommerce_quick_view_product_summary',array(G5Plus_Lustria()->templates(),'quick_view_rating'),4);
            add_action('woocommerce_quick_view_product_summary',array(G5Plus_Lustria()->templates(),'shop_quick_view_product_title'),5);
            add_action('woocommerce_quick_view_product_summary','woocommerce_template_single_price',10);
            add_action('woocommerce_quick_view_product_summary',array(G5Plus_Lustria()->templates(),'shop_single_loop_sale_count_down'),15);
            add_action('woocommerce_quick_view_product_summary','woocommerce_template_single_excerpt',20);
            add_action('woocommerce_quick_view_product_summary','woocommerce_template_single_add_to_cart',30);
            add_action('woocommerce_quick_view_product_summary','woocommerce_template_single_meta',50);
            add_action('woocommerce_quick_view_product_summary','woocommerce_template_single_sharing',60);



            add_action('woocommerce_after_add_to_cart_button', array(G5Plus_Lustria()->templates(),'shop_single_function'));


            add_action('woocommerce_before_product_deal_product',array(G5Plus_Lustria()->templates(),'shop_loop_sale_count_down'),10);
            add_action('woocommerce_product_deal_product','woocommerce_template_loop_price',5);
            add_action('woocommerce_product_deal_product',array(G5Plus_Lustria()->templates(),'shop_loop_rating'),10);
            add_action('woocommerce_product_deal_product',array(G5Plus_Lustria()->templates(),'shop_loop_grid_add_to_cart'),10);

            add_action('woocommerce_before_single_product_summary', array(G5Plus_Lustria()->templates(),'shop_single_video'), 25);

            add_action('gsf_product_singular_actions', 'woocommerce_template_loop_add_to_cart', 15);
        }

        public function get_product_thumb_size() {
            return apply_filters('gf_gallery_thumb_size', array(150, 150));
        }

        public function change_variation_thumb_src($args, $product_variation, $variation) {
            $size = $this->get_product_thumb_size();
            $attach_id = $variation->get_image_id();
            $image_src = G5Plus_Lustria()->image_resize()->resize(array(
                'image_id' => $attach_id,
                'width' => $size[0],
                'height' => $size[1]
            ));
            if (!empty($image_src) && isset($image_src['url'])) {
                $args['image']['gallery_thumbnail_src'] = $image_src['url'];
                $args['image']['gallery_thumbnail_src_w'] = $image_src['width'];
                $args['image']['gallery_thumbnail_src_h'] = $image_src['height'];
            }
            return $args;
        }

        public function gallery_thumbnail_src($html, $attach_id) {
            $size = $this->get_product_thumb_size();
            $image_src = G5Plus_Lustria()->image_resize()->resize(array(
                'image_id' => $attach_id,
                'width' => $size[0],
                'height' => $size[1]
            ));
            if (!empty($image_src) && isset($image_src['url'])) {
                $image_src = $image_src['url'];
            }
            $pattern = '/(data-thumb=[\"|\'])([^\"\']*)([\"|\'])/i';
            $replacement = '$1' . $image_src . '$3';
            return preg_replace($pattern, $replacement, $html);
        }

        public function type_selector( $types ) {
	        global $pagenow;
	        if ( ( $pagenow === 'post-new.php' ) || ( $pagenow === 'post.php' ) || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
		        return $types;
	        }
            $types['select'] = esc_html__( 'Select', 'g5plus-lustria' );
            $types['text']   = esc_html__( 'Text', 'g5plus-lustria' );
            $types['color']  = esc_html__( 'Color', 'g5plus-lustria' );
            $types['image']  = esc_html__( 'Image', 'g5plus-lustria' );

            return $types;
        }

        public function swatches_custom_columns( $columns ) {
            $columns['swatches_value']   = esc_html__('Swatches Value', 'g5plus-lustria');
            return $columns;
        }

        public function swatches_custom_columns_content( $columns, $column, $term_id ) {
            if ( $column == 'swatches_value' ) {
                $term      = get_term( $term_id );
                $attr_id   = wc_attribute_taxonomy_id_by_name( $term->taxonomy );
                $attr_info = wc_get_attribute( $attr_id );
                switch ( $attr_info->type ) {
                    case 'image':
                        $val = G5Plus_Lustria()->termMeta()->get_product_taxonomy_image($term_id);
                        $image_id = isset($val['id']) ? $val['id'] : 0;
                        echo '<img style="display: inline-block; width: 40px; height: 40px; background-color: #eee; box-sizing: border-box; border: 1px solid #eee;" src="' . esc_url( wp_get_attachment_thumb_url( $image_id ) ) . '"/>';
                        break;
                    case 'color':
                        $val = G5Plus_Lustria()->termMeta()->get_product_taxonomy_color($term_id);
                        echo '<span style="display: inline-block; width: 40px; height: 40px; background-color: ' . esc_attr( $val ) . '; box-sizing: border-box; border: 1px solid #eee;"></span>';
                        break;
                    case 'text':
                        $val = G5Plus_Lustria()->termMeta()->get_product_taxonomy_text($term_id);
                        echo '<span style="display: inline-block; height: 40px; line-height: 40px; padding: 0 15px; border: 1px solid #eee; background-color: #fff; min-width: 44px; box-sizing: border-box;">' . esc_html( $val ) . '</span>';
                        break;
                }
            }
        }
        public function option_terms( $tax, $i ) {
            global $thepostid;
            if ( 'select' !== $tax->attribute_type ) {
                $taxonomy = wc_attribute_taxonomy_name( $tax->attribute_name );
                $args     = array(
                    'orderby'    => 'name',
                    'hide_empty' => 0,
                );
                ?>
                <select multiple="multiple"
                        data-placeholder="<?php esc_attr_e( 'Select terms', 'g5plus-lustria' ); ?>"
                        class="multiselect attribute_values wc-enhanced-select"
                        name="attribute_values[<?php echo esc_attr($i); ?>][]">
                    <?php
                    $all_terms = get_terms( $taxonomy, apply_filters( 'woocommerce_product_attribute_terms', $args ) );
                    if ( $all_terms ) :
                        foreach ( $all_terms as $term ) :
                            echo '<option value="' . esc_attr( $term->term_id ) . '" ' . wc_selected( has_term( absint( $term->term_id ), $taxonomy, $thepostid ), true, false ) . '>' . esc_attr( apply_filters( 'woocommerce_product_attribute_term_name', $term->name, $term ) ) . '</option>';
                        endforeach;
                    endif;
                    ?>
                </select>
                <button class="button plus select_all_attributes">
                    <?php esc_html_e( 'Select all', 'g5plus-lustria' ); ?>
                </button>
                <button class="button minus select_no_attributes">
                    <?php esc_html_e( 'Select none', 'g5plus-lustria' ); ?>
                </button>
                <button class="button fr plus add_new_attribute">
                    <?php esc_html_e( 'Add new', 'g5plus-lustria' ); ?>
                </button>
                <?php
            }
        }
        public function register_shortcode($shortcodes) {
            $shortcodes = array_merge($shortcodes, array(
                'gsf_products',
                'gsf_product_category',
                'gsf_product_singular',
                'gsf_product_tabs'
            ));
            sort($shortcodes);
            return $shortcodes;
        }

        public function changePostPerPage($q) {
            if (!is_admin() && $q->is_main_query() && ($q->is_post_type_archive( 'product' ) || $q->is_tax( get_object_taxonomies( 'product' )))) {
                $woocommerce_customize = G5Plus_Lustria()->options()->get_woocommerce_customize();
                if(!isset($woocommerce_customize['Disable']) || !array_key_exists('items-show', $woocommerce_customize['Disable'])) {
                    $product_per_page = G5Plus_Lustria()->options()->get_woocommerce_customize_item_show();
                } else {
                    $product_per_page = G5Plus_Lustria()->options()->get_product_per_page();
                }

                if(!empty($product_per_page)) {
                    $product_per_page_arr = explode(",", $product_per_page);
                } else {
                    $product_per_page_arr = array(intval(get_option( 'posts_per_page')));
                }
                $product_per_page = isset( $_GET['product_per_page'] ) ? wc_clean( $_GET['product_per_page'] ) : $product_per_page_arr[0];

                $q->set('posts_per_page',$product_per_page);
            }
        }

        /**
         * Get Post Layout Settings
         *
         * @return mixed
         */
        public function get_layout_settings()
        {
            $catalog_layout = G5Plus_Lustria()->options()->get_product_catalog_layout();
            return array(
                'post_layout'            => $catalog_layout,
                'post_columns'           => array(
                    'xl' => intval(G5Plus_Lustria()->options()->get_product_columns()),
                    'lg' => intval(G5Plus_Lustria()->options()->get_product_columns_md()),
                    'md' => intval(G5Plus_Lustria()->options()->get_product_columns_sm()),
                    'sm' => intval(G5Plus_Lustria()->options()->get_product_columns_xs()),
                    '' => intval(G5Plus_Lustria()->options()->get_product_columns_mb()),
                ),
                'post_columns_gutter'    => intval(G5Plus_Lustria()->options()->get_product_columns_gutter()),
                'image_size'        => '',//G5Plus_Lustria()->options()->get_product_image_size(),
                'post_paging'            => G5Plus_Lustria()->options()->get_product_paging(),
                'post_animation'         => G5Plus_Lustria()->options()->get_product_animation(),
                'itemSelector'           => 'article',
                'category_filter_enable' => false,
                'post_type' => 'product',
                'taxonomy'               => 'product_cat'
            );
        }


        public function layout_matrix($matrix) {
            $post_settings = G5Plus_Lustria()->blog()->get_layout_settings();
            if ($post_settings['post_type'] !== 'product') {
                $post_settings = G5Plus_Lustria()->woocommerce()->get_layout_settings();
            }
            $columns = isset($post_settings['post_columns']) ? $post_settings['post_columns'] : array(
                'xl' => 3,
                'lg' => 3,
                'md' => 2,
                'sm' => 1,
                '' => 1
            );
            $columns = G5Plus_Lustria()->helper()->get_bootstrap_columns($columns);
            $columns_gutter = intval(isset($post_settings['post_columns_gutter']) ? $post_settings['post_columns_gutter'] : 40);
            $matrix['product'] = array(
                'grid'           => array(
                    'placeholder_enable' => true,
                    'columns_gutter' => $columns_gutter,
                    'image_size' => 'shop_catalog',
                    'layout'         => array(
                        array('columns' => $columns, 'template' => 'content-product')
                    )
                )
            );
            return $matrix;
        }

        public function page_setting($post_type) {
            $post_type[] = 'product';
            return $post_type;
        }

        public function get_product_class() {
            $settings = G5Plus_Lustria()->blog()->get_layout_settings();
            if ($settings['post_type'] !== 'product') {
                $settings = G5Plus_Lustria()->woocommerce()->get_layout_settings();
            }
            $post_classes = array(
                'clearfix',
                'product-item-wrap',
                'product-grid'
            );
            if ( !isset( $settings['carousel'] ) || isset($settings['carousel_rows']) ) {
                if ( isset($settings['columns']) && ($settings['columns'] !== '') && !isset($settings['isMainQuery'])) {
                    $columns_lg = absint($settings['columns']);
                    $columns = array(
                        'xl' => $columns_lg,
                        'lg' => $columns_lg > 4 ? 3 : $columns_lg,
                        'md' => $columns_lg > 2 ? 2 : $columns_lg,
                        'sm' => 1,
                        '' => 1
                    );
                } else {
                    $columns = isset($settings['post_columns']) ? $settings['post_columns'] : array(
                        'xl' => 3,
                        'lg' => 3,
                        'md' => 2,
                        'sm' => 1,
                        '' => 1
                    );
                }
                $columns = G5Plus_Lustria()->helper()->get_bootstrap_columns($columns);
                $post_classes[] = $columns;
            }
            return implode(' ', $post_classes);
        }

        public function get_product_inner_class() {
            $post_settings = G5Plus_Lustria()->blog()->get_layout_settings();
            if ($post_settings['post_type'] !== 'product') {
                $post_settings = G5Plus_Lustria()->woocommerce()->get_layout_settings();
            }
            $post_animation = isset( $post_settings['post_animation'] ) ? $post_settings['post_animation'] : '';

            $post_inner_classes = array(
                'product-item-inner',
                'clearfix',
                G5Plus_Lustria()->helper()->getCSSAnimation( $post_animation )
            );
            return implode( ' ', array_filter( $post_inner_classes ) );
        }

        public function render_product_thumbnail_markup($args = array()){
            $defaults = array(
                'post_id'            => get_the_ID(),
                'image_size'         => 'shop_catalog',
                'placeholder_enable' => true,
                'image_mode'         => 'image',
                'display_permalink' => true,
            );
            $defaults = wp_parse_args($args, $defaults);
            G5Plus_Lustria()->helper()->getTemplate('woocommerce/loop/product-thumbnail', $defaults);
        }


        public function archive_markup($query_args = null, $settings = null) {
            if (isset($_REQUEST['settings']) && !isset($query_args)) {
                $settings = wp_parse_args($_REQUEST['settings'],$settings);
            }

            if (isset($settings['tabs']) && isset($settings['tabs'][0]['query_args'])) {
                $query_args = $settings['tabs'][0]['query_args'];
            }

            if (!isset($query_args)) {
                $settings['isMainQuery'] = true;
            }
            $settings = wp_parse_args($settings,$this->get_layout_settings());
            G5Plus_Lustria()->blog()->set_layout_settings($settings);

            G5Plus_Lustria()->query()->query_posts($query_args);

            if (isset($settings['isMainQuery']) && ($settings['isMainQuery'] == true)) {
                add_action('g5plus_before_archive_wrapper',array(G5Plus_Lustria()->templates(),'shop_catalog_filter'),5);
            }


            if (isset($settings['category_filter_enable']) && $settings['category_filter_enable'] === true) {
                add_action('g5plus_before_archive_wrapper', array(G5Plus_Lustria()->blog(), 'category_filter_markup'));
            }

            if (isset($settings['tabs'])) {
                add_action('g5plus_before_archive_wrapper', array(G5Plus_Lustria()->blog(), 'tabs_markup'));
            }

            //if (have_posts()) {
            if (isset($settings['isMainQuery']) && ($settings['isMainQuery'] == true)) {
                /**
                 * woocommerce_before_shop_loop hook.
                 *
                 * @hooked wc_print_notices - 10
                 */
                do_action( 'woocommerce_before_shop_loop' );
            }

            woocommerce_product_loop_start();

            if (G5Plus_Lustria()->query()->have_posts()) {
                $post_settings = &G5Plus_Lustria()->blog()->get_layout_settings();
                $post_layout = isset( $post_settings['post_layout'] ) ? $post_settings['post_layout'] : 'grid';
                $layout_matrix = G5Plus_Lustria()->blog()->get_layout_matrix( $post_layout );
                $post_paging = isset( $post_settings['post_paging'] ) ? $post_settings['post_paging'] : 'pagination';
                $post_animation = isset( $post_settings['post_animation'] ) ? $post_settings['post_animation'] : '';
                $placeholder_enable = isset( $layout_matrix['placeholder_enable'] ) ? $layout_matrix['placeholder_enable'] : false;
                $paged = G5Plus_Lustria()->query()->query_var_paged();
                $image_size = isset($post_settings['image_size']) && !empty($post_settings['image_size']) ? $post_settings['image_size'] : (isset($layout_matrix['image_size']) && !empty($layout_matrix['image_size']) ? $layout_matrix['image_size'] :  'shop_catalog');
                if ( isset( $layout_matrix['layout'] ) ) {
                    $layout_settings = $layout_matrix['layout'];
                    $index = intval( G5Plus_Lustria()->query()->get_query()->get( 'index', 0 ) );

                    $post_classes = array(
                        'clearfix',
                        'product-item-wrap',
                    );

                    $post_inner_classes = array(
                        'product-item-inner',
                        'clearfix',
                        G5Plus_Lustria()->helper()->getCSSAnimation( $post_animation )
                    );
                    $carousel_index = 0;
                    while ( G5Plus_Lustria()->query()->have_posts() ) : G5Plus_Lustria()->query()->the_post();
                        $index = $index % sizeof( $layout_settings );
                        $current_layout = $layout_settings[$index];
                        $isFirst = isset( $current_layout['isFirst'] ) ? $current_layout['isFirst'] : false;
                        if ( $isFirst && ( $paged > 1 ) && in_array( $post_paging, array( 'load-more', 'infinite-scroll' ) ) ) {
                            if ( isset( $layout_settings[$index + 1] ) ) {
                                $current_layout = $layout_settings[$index + 1];
                            } else {
                                continue;
                            }
                        }

                        $post_columns = $current_layout['columns'];
                        $template = $current_layout['template'];

                        $classes = array(
                            "product-{$template}"
                        );
                        if(isset($settings['carousel_rows']) && $carousel_index == 0) {
                            $owl_item_inner = 'owl-item-inner clearfix';
                            if ( isset( $layout_matrix['columns_gutter'] ) ) {
                                $owl_item_inner .= " gf-gutter-{$layout_matrix['columns_gutter']}";
                            }
                            echo '<div class="'. esc_attr($owl_item_inner) .'">';
                        }
                        if ( !isset( $post_settings['carousel'] ) || isset($settings['carousel_rows']) ) {
                            $classes[] = $post_columns;
                        }
                        $classes = wp_parse_args( $classes, $post_classes );
                        $post_class = implode( ' ', array_filter( $classes ) );
                        $post_inner_class = implode( ' ', array_filter( $post_inner_classes ) );

                        wc_get_template( "{$template}.php", array(
                            'image_size' => $image_size,
                            'post_class' => $post_class,
                            'post_inner_class' => $post_inner_class,
                            'placeholder_enable' => $placeholder_enable,
                        ));

                        if ( $isFirst ) {
                            unset( $layout_settings[$index] );
                            $layout_settings = array_values( $layout_settings );
                        }

                        if ( $isFirst && $paged === 1 ) {
                            $index = 0;
                        } else {
                            $index++;
                        }
                        $carousel_index++;
                        if(isset($settings['carousel_rows']) && $carousel_index == $settings['carousel_rows']['items_show']) {
                            echo '</div>';
                            $carousel_index = 0;
                        }
                    endwhile;
                    if(isset($settings['carousel_rows']) && $carousel_index != $settings['carousel_rows']['items_show'] && $carousel_index != 0) {
                        echo '</div>';
                    }
                }
            } else{
                /**
                 * woocommerce_no_products_found hook.
                 *
                 * @hooked wc_no_products_found - 10
                 */
                do_action( 'woocommerce_no_products_found' );
            }




            woocommerce_product_loop_end();
            if (isset($settings['tabs'])) {
                remove_action('g5plus_before_archive_wrapper', array(G5Plus_Lustria()->blog(), 'tabs_markup'));
            }

            if (isset($settings['category_filter_enable']) && $settings['category_filter_enable'] === true) {
                remove_action('g5plus_before_archive_wrapper', array(G5Plus_Lustria()->blog(), 'category_filter_markup'));
            }

            if (isset($settings['isMainQuery']) && ($settings['isMainQuery'] == true)) {
                remove_action('g5plus_before_archive_wrapper',array(G5Plus_Lustria()->templates(),'shop_catalog_filter'),5);
            }

            G5Plus_Lustria()->blog()->unset_layout_settings();

            G5Plus_Lustria()->query()->reset_query();
        }
        public function page_title($page_title){
            if (is_post_type_archive('product')) {
                $shop_page_id = wc_get_page_id( 'shop' );
                if ($shop_page_id) {
                    if (!$page_title) {
                        $page_title   = get_the_title( $shop_page_id );
                    }
                    $custom_page_title = G5Plus_Lustria()->metaBox()->get_page_title_content($shop_page_id);
                    if ($custom_page_title) {
                        $page_title = $custom_page_title;
                    }
                }
            }
            return $page_title;
        }
        public function quick_view(){
            $product_quick_view = G5Plus_Lustria()->options()->get_product_quick_view_enable();
            if ('on' === $product_quick_view) {
                wp_enqueue_script( 'wc-add-to-cart-variation' );
                if( version_compare( WC()->version, '3.0.0', '>=' ) ) {
                    if( current_theme_supports('wc-product-gallery-zoom') ) {
                        wp_enqueue_script('zoom');
                    }
                    if( current_theme_supports('wc-product-gallery-lightbox') ) {
                        wp_enqueue_script('photoswipe-ui-default');
                        wp_enqueue_style('photoswipe-default-skin');
                        if( has_action('wp_footer', 'woocommerce_photoswipe') === FALSE ) {
                            add_action('wp_footer', 'woocommerce_photoswipe', 15);
                        }
                    }
                    wp_enqueue_script('flexslider');
                    wp_enqueue_script('wc-single-product');
                }
                return true;
            }
        }

        public function product_related_products_args() {
            $products_per_page = intval(G5Plus_Lustria()->options()->get_product_related_per_page());
            $args['posts_per_page'] = $products_per_page;
            return $args;
        }

        public function product_related_posts_relate_by_category() {
            $product_algorithm = G5Plus_Lustria()->options()->get_product_related_algorithm();
            return (in_array($product_algorithm, array('cat', 'cat-tag'))) ? true : false;
        }
        public function product_related_posts_relate_by_tag() {
            $product_algorithm = G5Plus_Lustria()->options()->get_product_related_algorithm();
            return (in_array($product_algorithm, array('tag', 'cat-tag'))) ? true : false;
        }



        public function product_cart_item_thumbnail($image, $cart_item, $cart_item_key)
        {
            if (isset($cart_item['product_id'])) {
	            $product_id = isset($cart_item['variation_id']) && ($cart_item['variation_id'] > 0) ? $cart_item['variation_id'] : $cart_item['product_id'];
                $image_id = get_post_thumbnail_id($product_id);
                $image = G5Plus_Lustria()->image_resize()->resize(array(
                    'image_id' => $image_id,
                    'width' => '85',
                    'height' => '100'
                ));
                $image_attributes = array(
                    'src="' . esc_url($image['url']) . '"',
                    'width="' . esc_attr($image['width']) . '"',
                    'height="' . esc_attr($image['height']) . '"',
                    'title="' . esc_attr(get_the_title($cart_item['product_id'])) . '"'
                );
                $image = '<img ' . implode(' ', $image_attributes) . '>';
            }
            return $image;
        }



        public function product_up_sells_posts_per_page() {
            $up_sells_per_page = G5Plus_Lustria()->options()->get_product_up_sells_per_page();
            return $up_sells_per_page;
        }

        public function product_cross_sells_posts_per_page() {
            $cross_sells_per_page = G5Plus_Lustria()->options()->get_product_cross_sells_per_page();
            return $cross_sells_per_page;
        }

        public function review_gravatar_size() {
            return 100;
        }

        public function change_yith_wcwl_positions() {
        	return array();
        }
    }
}