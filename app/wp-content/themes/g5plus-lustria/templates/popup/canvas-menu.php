<?php
/**
 * The template for displaying canvas-menu
 */
$page_menu = '';
if (is_singular()) {
    $page_menu = G5Plus_Lustria()->metaBox()->get_page_menu();
}
?>
<div id="popup-canvas-menu" class="mfp-hide mfp-with-anim">
    <nav class="primary-menu">
        <?php if (has_nav_menu('primary') || $page_menu): ?>
            <?php
            $arg_menu = array(
                'menu_id' => 'main-menu',
                'container' => '',
                'theme_location' => 'primary',
                'menu_class' => 'clearfix'
            );
            if (!empty($page_menu)) {
                $arg_menu['menu'] = $page_menu;
            }
            wp_nav_menu($arg_menu);
            ?>
        <?php endif; ?>
    </nav>
</div>
