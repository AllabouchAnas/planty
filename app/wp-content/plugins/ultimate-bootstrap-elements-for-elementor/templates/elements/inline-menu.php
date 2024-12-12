<?php
if (!defined('ABSPATH')) {
	exit;
}
/**
 * @var $element UBE_Element_Inline_Menu
 */

$available_menus = $element->get_available_menus();

if (!$available_menus) {
	return;
}

$settings = $element->get_settings_for_display();

$menu_container_id = 'navbarToggleExternalContent-' . $element->get_id();
$args = [
	'echo' => false,
	'menu' => $settings['menu'],
	'depth' => 10,
	'container' => 'div',
	'container_class' => 'collapse navbar-collapse show',
	'container_id' => $menu_container_id,
	'menu_class' => 'nav navbar-nav',
	'fallback_cb' => 'WP_Bootstrap_Navwalker::fallback',
];

$menu_classes = array(
	'ube-inline-menu',
	'ube-main-menu',
	'navbar',
	"submenu-event-{$settings['menu_events_submenu']}",
	"ube-inline-dropdown-direction-{$settings['menu_dropdown_direction']}",
);

if ($settings['menu_color_scheme'] !== '') {
	$colors = ube_color_schemes_configs();
	$text_color = ube_color_contrast($colors[$settings['menu_color_scheme']]['color'], 'white', 'dark');
	$menu_classes[] = 'bg-' . $settings['menu_color_scheme'];
	$menu_classes[] = 'text-' . $text_color;
}

if ($settings['menu_style_hover'] !== '') {
	$menu_classes[] = 'has-hover-style';
	$menu_classes[] = "hover-style-{$settings['menu_style_hover']}";
}

$element->add_render_attribute('menu_classes', 'class', $menu_classes);

if ($settings['menu_events_submenu'] === 'click') {
	$args['walker'] = new UBE_Walker_Bootstrap_Nav();
} else {
	$args['walker'] = new UBE_Walker_Bootstrap_Nav_Not_Dropdown();
}

if ($settings['menu_align_items'] !== 'between') {
	$args['container_class'] .= ' justify-content-' . $settings['menu_align_items'];
} else {
	$args['menu_class'] .= ' justify-content-' . $settings['menu_align_items'];
}

$menu_html = wp_nav_menu($args);

?>
<nav <?php echo $element->get_render_attribute_string('menu_classes'); ?>>
	<?php echo wp_kses_post($menu_html); ?>
</nav>


