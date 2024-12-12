<?php
/**
 * The template for displaying menu.php
 *
 */
$theme_location = 'primary';
if (has_nav_menu( 'mobile' )) {
	$theme_location = 'mobile';
}

$wrapper_classes = array(
	'mobile-navigation-wrapper',
	'canvas-sidebar-wrapper'
);

$inner_classes = array(
	'canvas-sidebar-inner'
);

$page_menu_mobile = '';
if (is_singular()) {
	$page_menu_mobile = G5Plus_Lustria()->metaBox()->get_page_mobile_menu();
	if (!$page_menu_mobile) {
		$page_menu = G5Plus_Lustria()->metaBox()->get_page_menu();
		$page_menu_mobile = $page_menu;
	}
}

$wrapper_class = implode(' ',array_filter($wrapper_classes));
$inner_class = implode(' ',array_filter($inner_classes));
?>
<div id="mobile-navigation-wrapper" class="<?php echo esc_attr($wrapper_class); ?>">
	<div class="<?php echo esc_attr($inner_class)?>">
		<?php get_search_form(); ?>
		<?php if (has_nav_menu($theme_location) || $page_menu_mobile): ?>
			<?php
			$arg_menu = array(
				'menu_id' => 'mobile-menu',
				'container' => '',
				'theme_location' => $theme_location,
				'menu_class' => 'mobile-menu gf-menu-vertical',
				'is_mobile_menu' => true,
			);
            if (!empty($page_menu_mobile)) {
                $arg_menu['menu'] = $page_menu_mobile;
            }
			wp_nav_menu( $arg_menu );
			?>
		<?php endif;?>
	</div>
</div>
