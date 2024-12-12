<?php
/**
 * The template for displaying Header 9
 *
 * @var $header_layout
 * @var $header_float_enable
 * @var $header_border
 * @var $header_content_full_width
 * @var $header_sticky
 * @var $page_menu
 */
?>
<div class="header-above">
    <?php G5Plus_Lustria()->helper()->getTemplate('header/desktop/logo',array('header_layout' => $header_layout)); ?>
</div>
    <div class="gf-toggle-icon gf-menu-canvas" href="#popup-canvas-menu"><span></span></div>
<?php add_action('wp_footer',array(G5Plus_Lustria()->templates(),'canvas_menu'),10); ?>
<?php G5Plus_Lustria()->helper()->getTemplate('header/header-customize', array('customize_location' => 'nav', 'canvas_position' => 'right')); ?>