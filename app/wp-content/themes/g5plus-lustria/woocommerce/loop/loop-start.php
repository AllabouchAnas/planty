<?php
/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
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
 * @version     3.3.0
 */
$post_settings = &G5Plus_Lustria()->blog()->get_layout_settings();
$post_layout = isset($post_settings['post_layout'] ) ? $post_settings['post_layout'] : 'grid';
$layout_matrix = G5Plus_Lustria()->blog()->get_layout_matrix( $post_layout );
$wrapper_attributes = array();

$inner_attributes = array();
$inner_classes = array(
    'gf-blog-inner',
    'clearfix',
    "layout-{$post_layout}"
);

if ( isset( $post_settings['carousel'] ) ) {
    $inner_classes[] = 'owl-carousel owl-theme';
    if (isset($post_settings['carousel_class'])) {
        $inner_classes[] = $post_settings['carousel_class'];
    }
    $inner_attributes[] = "data-owl-options='" . json_encode( $post_settings['carousel'] ) . "'";
} else {
    if ( isset( $layout_matrix['columns_gutter'] ) ) {
        $inner_classes[] = "gf-gutter-{$layout_matrix['columns_gutter']}";
    } else {
        $inner_classes[] = 'row';
    }

    if ( isset( $layout_matrix['isotope'] ) ) {
        if($post_layout !== 'list') {
            $inner_classes[] = 'isotope';
        }
        $inner_attributes[] = "data-isotope-options='" . json_encode( $layout_matrix['isotope'] ) . "'";
        $wrapper_attributes[] = 'data-isotope-wrapper="true"';
    }
}

if (isset($post_settings['isMainQuery']))  {
    $wrapper_attributes[] = 'data-archive-wrapper';
}

$settingId = isset($post_settings['settingId']) ? $post_settings['settingId'] : mt_rand();
$post_settings['settingId'] = $settingId;
$wrapper_attributes[] = sprintf('data-items-wrapper="%s"',$settingId) ;
$inner_attributes[] = 'data-items-container="true"';
$inner_class = implode( ' ', array_filter( $inner_classes ) );
?>
<div <?php echo implode( ' ', $wrapper_attributes ); ?> class="products clearfix">
    <?php
    // You can use this for adding codes before the main loop
    do_action( 'g5plus_before_archive_wrapper' );
    ?>
    <div <?php echo implode( ' ', $inner_attributes ); ?> class="<?php echo esc_attr( $inner_class ); ?>">
