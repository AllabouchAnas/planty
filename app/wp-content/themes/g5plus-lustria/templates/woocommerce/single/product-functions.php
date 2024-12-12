<?php
/**
 * Template display single product wishlist and compare
 *
 */
$active_plugins = apply_filters('active_plugins', get_option('active_plugins'));
?>
<div class="single-product-function">
    <?php
        if (function_exists('YITH_WCWL_Frontend')) {
	        YITH_WCWL_Frontend()->print_button();
        }

    if ((in_array('yith-woocommerce-compare/init.php', apply_filters('active_plugins', get_option('active_plugins')))
            || in_array('yith-woocommerce-compare-premium/init.php', apply_filters('active_plugins', get_option('active_plugins'))))
        && get_option('yith_woocompare_compare_button_in_products_list') == 'yes') {
        if (!shortcode_exists('yith_compare_button') && class_exists('YITH_Woocompare') && function_exists('yith_woocompare_constructor')) {
            $context = isset($_REQUEST['context']) ? $_REQUEST['context'] : null;
            $_REQUEST['context'] = 'frontend';
            yith_woocompare_constructor();
            $_REQUEST['context'] = $context;
        }

        if (shortcode_exists('yith_compare_button')) {
            echo do_shortcode('[yith_compare_button container="false" type="link"]');
        }
    }
    ?>
</div>
