<?php
if (!defined('ABSPATH')) {
	exit;
}

/**
 * @var $element UBE_Element_Vertical_Menu
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
	'fallback_cb' => 'UBE_Walker_Bootstrap_Nav::fallback',
	'walker' => new UBE_Walker_Bootstrap_Nav(),
];

$menu_classes = array(
	'ube-vertical-menu',
	'navbar',
	$settings['menu_toggle_schame'],
);

if ($settings['menu_border'] === 'yes') {
	$menu_classes[] = "has-border";
}

if ($settings['menu_always_show'] === '') {
	$args['container_class'] = 'collapse navbar-collapse';
}

$menu_html = wp_nav_menu($args);

if ($settings['menu_toggle_button'] === 'yes') {
	$element->add_render_attribute(
		[
			'navbar_toggler_attr' => [
				'class' => 'elementor-menu-toggle navbar-toggler',
				'type' => 'button',
				'data-toggle' => 'collapse',
				'data-target' => '#' . $menu_container_id,
				'aria-controls' => $menu_container_id,
				'aria-expanded' => 'false',
				'aria-label' => 'Toggle navigation',
			],
		]
	);
}

$element->add_render_attribute('menu_classes', 'class', $menu_classes);

?>
<nav <?php echo $element->get_render_attribute_string('menu_classes'); ?>>
	<?php if ($settings['menu_toggle_button'] === 'yes'): ?>
        <button <?php echo $element->get_render_attribute_string('navbar_toggler_attr') ?>>
            <i class="fas fa-bars"></i>
        </button>
	<?php endif; ?>
	<?php echo wp_kses_post($menu_html); ?>
</nav>
