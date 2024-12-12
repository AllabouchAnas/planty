<?php
add_action('admin_menu', 'gid_add_menu_install_data');
function gid_add_menu_install_data() {
	add_submenu_page(
		GID()->demo_menu_parent(),
		esc_html__( 'Install Demo', 'gid' ),
		esc_html__( 'Install Demo', 'gid' ),
		'manage_options',
		'gid_install_demo',
		'gid_install_demo_template');
}
function gid_install_demo_template() {
	GID()->get_template('install-page.php');
}