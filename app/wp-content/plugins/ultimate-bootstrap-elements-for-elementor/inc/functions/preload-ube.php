<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
function ube_required_elementor_active() {
    $screen = get_current_screen();
    if ( isset( $screen->parent_file ) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id ) {
        return;
    }

    $plugin = 'elementor/elementor.php';
    $installed_plugins = get_plugins();

    if (isset($installed_plugins[$plugin])) {
        if ( ! current_user_can( 'activate_plugins' ) ) {
            return;
        }

        $activation_url = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $plugin . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $plugin );
        $message = '<p>' . esc_html__( 'UBE is not working because you need to activate the Elementor plugin.', 'ube' ) . '</p>';
        $message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $activation_url, __( 'Activate Elementor Now', 'ube' ) ) . '</p>';
    }
    else {
        if ( ! current_user_can( 'install_plugins' ) ) {
            return;
        }

        $install_url = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ), 'install-plugin_elementor' );
        $message = '<div style="display: flex">';
        $message .= '<p>' . __( 'UBE is not working because you need to install the Elementor plugin.', 'ube' ) . '</p>';
        $message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $install_url, __( 'Install Elementor Now', 'ube' ) ) . '</p>';
        $message .= '</div>';
    }

    echo '<div class="notice notice-warning is-dismissible">' . wp_kses_post($message) . '</div>';
}