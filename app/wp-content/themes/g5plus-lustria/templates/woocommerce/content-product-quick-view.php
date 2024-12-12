<?php
/**
 * The template for displaying product quick-views
 *
 */
global $product;
remove_action('woocommerce_after_add_to_cart_button', array(G5Plus_Lustria()->templates(),'shop_single_function'));
?>
<div id="popup-product-quick-view-wrapper" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <a class="popup-close fas fa-times" data-dismiss="modal" href="javascript:;"></a>
            <div class="modal-body">
                <div class="woocommerce">
                    <div itemscope
                         id="product-<?php the_ID(); ?>" <?php wc_product_class('quick-view-product-image product product-single-layout-01', $product); ?>>
                        <?php
                        /**
                         * Hook: woocommerce_before_single_product_summary.
                         *
                         * @hooked woocommerce_show_product_sale_flash - 10
                         * @hooked woocommerce_show_product_images - 20
                         */
                        do_action( 'woocommerce_before_single_product_summary' );
                        ?>
                        <div class="summary entry-summary">
                            <?php
                            $product_add_to_cart_enable = G5Plus_Lustria()->options()->get_product_add_to_cart_enable();
                            if ('on' !== $product_add_to_cart_enable) {
                                remove_action('woocommerce_quick_view_product_summary','woocommerce_template_single_add_to_cart',30);
                            }
                            ?>
                            <?php
                            /**
                             * Hook: woocommerce_single_product_summary.
                             *
                             * @hooked quick_view_rating - 4
                             * @hooked shop_quick_view_product_title - 5
                             * @hooked woocommerce_template_single_price - 10
                             * @hooked woocommerce_template_single_excerpt - 20
                             * @hooked woocommerce_template_single_add_to_cart - 30
                             * @hooked woocommerce_template_single_meta - 40
                             * @hooked woocommerce_template_single_sharing - 50
                             * @hooked WC_Structured_Data::generate_product_data() - 60
                             */
                            do_action('woocommerce_quick_view_product_summary');
                            ?>
                        </div><!-- .summary -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>