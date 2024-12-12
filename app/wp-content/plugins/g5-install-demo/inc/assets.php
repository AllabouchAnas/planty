<?php
add_action('init', 'gid_register_assets');
function gid_register_assets() {
	wp_register_style(GID()->assets_handle('admin'), GID()->asset_url('assets/css/admin.min.css'), array(), GID()->plugin_ver());
	wp_register_script(GID()->assets_handle('admin'), GID()->asset_url('assets/js/admin.min.js'), array('jquery'), GID()->plugin_ver(), true);
}

add_action('admin_enqueue_scripts', 'gid_admin_enqueue_script' );
function gid_admin_enqueue_script() {
	if (isset($_GET['page']) && ($_GET['page']  === 'gid_install_demo')) {
		wp_enqueue_script(GID()->assets_handle('admin'));
		wp_enqueue_style(GID()->assets_handle('admin'));
	}
}