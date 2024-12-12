<?php
/**
 * Single Product Up-Sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/up-sells.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 * @var $upsells
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$product_up_sells_enable = G5Plus_Lustria()->options()->get_product_up_sells_enable();
if('on' !== $product_up_sells_enable) return;

$product_up_sells_gutter = intval(G5Plus_Lustria()->options()->get_product_up_sells_columns_gutter());
$product_columns = intval(G5Plus_Lustria()->options()->get_product_up_sells_columns());
$product_columns_md = intval(G5Plus_Lustria()->options()->get_product_up_sells_columns_md());
$product_columns_sm = intval(G5Plus_Lustria()->options()->get_product_up_sells_columns_sm());
$product_columns_xs = intval(G5Plus_Lustria()->options()->get_product_up_sells_columns_xs());
$product_columns_mb = intval(G5Plus_Lustria()->options()->get_product_up_sells_columns_mb());
$product_animation = G5Plus_Lustria()->options()->get_product_up_sells_animation();

$settings = array(
    'post_layout'            => 'grid',
    'post_columns'           => array(
        'xl' => $product_columns,
        'lg' => $product_columns_md,
        'md' => $product_columns_sm,
        'sm' => $product_columns_xs,
        '' => $product_columns_mb,
    ),
    'post_columns_gutter'    => $product_up_sells_gutter,
    'post_paging'            => 'none',
    'post_animation'         => $product_animation,
    'itemSelector'           => 'article',
    'category_filter_enable' => false,
    'post_type' => 'product'
);

$settings['carousel'] = array(
    'items' => $product_columns,
    'margin' => $product_columns == 1 ? 0 : $product_up_sells_gutter,
    'slideBy' => $product_columns,
    'responsive' => array(
        '1200' => array(
            'items' => $product_columns,
            'margin' => $product_columns == 1 ? 0 : $product_up_sells_gutter,
            'slideBy' => $product_columns,
        ),
        '992' => array(
            'items' => $product_columns_md,
            'margin' => $product_columns_md == 1 ? 0 : $product_up_sells_gutter,
            'slideBy' => $product_columns_md,
        ),
        '768' => array(
            'items' => $product_columns_sm,
            'margin' => $product_columns_sm == 1 ? 0 : $product_up_sells_gutter,
            'slideBy' => $product_columns_sm,
        ),
        '600' => array(
            'items' => $product_columns_xs,
            'margin' => $product_columns_xs == 1 ? 0 : $product_up_sells_gutter,
            'slideBy' => $product_columns_xs,
        ),
        '0' => array(
            'items' => $product_columns_mb,
            'margin' => $product_columns_mb == 1 ? 0 : $product_up_sells_gutter,
            'slideBy' => $product_columns_mb,
        )
    ),
    'autoHeight' => true,
);


G5Plus_Lustria()->blog()->set_layout_settings($settings);
if ( $upsells ) : ?>

	<section class="up-sells upsells products">

		<h2 class="gf-heading-title"><?php esc_html_e( 'You may also like&hellip;', 'woocommerce' ) ?></h2>

		<?php woocommerce_product_loop_start(); ?>

			<?php foreach ( $upsells as $upsell ) : ?>

				<?php
				 	$post_object = get_post( $upsell->get_id() );

					setup_postdata( $GLOBALS['post'] =& $post_object );

					wc_get_template_part( 'content', 'product' ); ?>

			<?php endforeach; ?>

		<?php woocommerce_product_loop_end(); ?>

	</section>

<?php endif;

wp_reset_postdata();
G5Plus_Lustria()->blog()->unset_layout_settings();