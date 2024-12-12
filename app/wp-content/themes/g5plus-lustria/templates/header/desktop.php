<?php
/**
 * The template for displaying desktop
 *
 */
$header_layout = G5Plus_Lustria()->options()->get_header_layout();
$header_float_enable = G5Plus_Lustria()->options()->get_header_float_enable();
$header_border = G5Plus_Lustria()->options()->get_header_border();
$header_content_full_width = G5Plus_Lustria()->options()->get_header_content_full_width();
$header_sticky = G5Plus_Lustria()->options()->get_header_sticky();
$page_menu = '';
if (is_singular()) {
    $page_menu = G5Plus_Lustria()->metaBox()->get_page_menu();
}

$header_responsive_breakpoint = G5Plus_Lustria()->options()->get_header_responsive_breakpoint();

$header_classes = array(
    'main-header',
    $header_layout
);
if ($header_float_enable === 'on' && !in_array($header_layout, array('header-8', 'header-9','header-11', 'header-12'))) {
    $header_classes[] = 'header-float';
}

if (in_array($header_layout, array('header-8', 'header-9'))) {
    $header_classes[] = 'header-vertical';
} elseif (in_array($header_layout, array('header-11', 'header-12'))) {
    $header_classes[] = 'header-vertical header-menu-vertical';
}



/*if ($header_border == 'full') {
	$header_classes[] = 'gf-border-bottom';
}*/
$nav_spacing = G5Plus_Lustria()->options()->get_navigation_spacing();
$header_attributes = array(
    'data-layout="' . esc_attr($header_layout) . '"',
    'data-responsive-breakpoint="' . esc_attr($header_responsive_breakpoint) . '"',
    'data-navigation="' . esc_attr($nav_spacing) . '"',
);
if (($header_sticky !== '') && !in_array($header_layout, array('header-8', 'header-9','header-11', 'header-12'))) {
    $header_attributes[] = 'data-sticky-type="'. $header_sticky .'"';
}
$header_class = implode(' ', array_filter($header_classes));
$header_allow = array('header-1');
if (function_exists('G5P')) {
    $header_allow = array_keys(G5P()->settings()->get_header_layout());
}
?>
<header <?php echo implode(' ', $header_attributes) ?> class="<?php echo esc_attr($header_class); ?>">
    <?php if (!in_array($header_layout, array('header-8', 'header-9','header-11', 'header-12'))) {
        G5Plus_Lustria()->helper()->getTemplate('header/desktop/top-bar');
    } ?>
    <?php
        if (in_array($header_layout,$header_allow)) {
            G5Plus_Lustria()->helper()->getTemplate("header/desktop/{$header_layout}", array(
                'header_layout' => $header_layout,
                'header_float_enable' => $header_float_enable,
                'header_border' => $header_border,
                'header_content_full_width' => $header_content_full_width,
                'header_sticky' => $header_sticky,
                'page_menu' => $page_menu
            ));
        }
     ?>
</header>
