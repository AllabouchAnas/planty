<?php
/**
 * Created by PhpStorm.
 * User: MyPC
 * Date: 07/08/2017
 * Time: 8:11 SA
 */

global $wp_registered_sidebars;

$woocommerce_customize_sidebar = G5Plus_Lustria()->options()->get_woocommerce_customize_sidebar();
if (is_active_sidebar($woocommerce_customize_sidebar)){
    dynamic_sidebar($woocommerce_customize_sidebar);
}