<?php
/**
 * The template for displaying layout-1
 *
 * @var $header_layout
 * @var $header_float_enable
 * @var $header_border
 * @var $header_content_full_width
 * @var $header_sticky
 * @var $page_menu
 */

$header_classes = array(
    'header-wrap'
);

$header_inner_classes = array(
    'header-inner',
    'x-nav-menu-container',
    'clearfix',
    'd-flex',
    'align-items-center'
);

if ($header_border === 'container') {
    $header_inner_classes[] = 'gf-border-bottom';
    $header_inner_classes[] = 'border-color';
}

if ($header_border == 'full') {
    $header_classes[] = 'gf-border-bottom';
    $header_classes[] = 'border-color';
}

if ($header_sticky !== '') {
    $header_classes[] = 'header-sticky';
}

if ($header_content_full_width === 'on') {
    $header_classes[] = 'header-full-width';
}

$header_class = implode(' ', array_filter($header_classes));
$header_inner_class = implode(' ', array_filter($header_inner_classes));
?>
<div class="<?php echo esc_attr($header_class) ?>">
    <div class="container">
        <div class="<?php echo esc_attr($header_inner_class) ?>">
            <div class="header-no-menu d-flex align-items-center flex-row">
                <?php G5Plus_Lustria()->helper()->getTemplate('header/desktop/logo', array('header_layout' => $header_layout)); ?>
                <?php G5Plus_Lustria()->helper()->getTemplate('header/header-customize', array('customize_location' => 'nav', 'canvas_position' => 'right')); ?>
            </div>
            <div class="gf-toggle-icon gf-menu-canvas" href="#popup-canvas-menu"><span></span></div>
            <?php add_action('wp_footer',array(G5Plus_Lustria()->templates(),'canvas_menu'),10); ?>
        </div>
    </div>
</div>


