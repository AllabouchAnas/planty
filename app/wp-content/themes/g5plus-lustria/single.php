<?php
/**
 * The template for displaying single
 *
 */
$single_post_layout = G5Plus_Lustria()->options()->get_single_post_layout();
$layout_allow = array('layout-1');
if (function_exists('G5P')) {
    $layout_allow = array_keys(G5P()->settings()->get_single_post_layout());
}
if (in_array($single_post_layout,$layout_allow)) {
    G5Plus_Lustria()->helper()->getTemplate("single/{$single_post_layout}/layout");
}




