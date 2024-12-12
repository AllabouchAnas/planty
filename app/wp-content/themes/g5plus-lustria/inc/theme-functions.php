<?php
/**
 * The template for displaying theme-functions.php
 *
 */
if (!function_exists('g5plus_comments_callback')) {
	function g5plus_comments_callback($comment, $args, $depth) {
		G5Plus_Lustria()->helper()->getTemplate('comments',array(
			'comment' => $comment,
			'args' => $args,
			'depth' => $depth
		));
	}
}


if (!function_exists('g5plus_maintenance_mode')) {
	function g5plus_maintenance_mode() {
		if (is_user_logged_in() && current_user_can( 'edit_themes' )) {
			return;
		}

		$maintenance_mode = intval(G5Plus_Lustria()->options()->get_maintenance_mode());

		switch ($maintenance_mode) {
			case 1 :
				wp_die( '<p style="text-align:center">' . esc_html__( 'We are currently in maintenance mode, please check back shortly.', 'g5plus-lustria' ) . '</p>', get_bloginfo( 'name' ) );
				break;
			case 2:
				$maintenance_mode_page = G5Plus_Lustria()->options()->get_maintenance_mode_page();
				if (empty($maintenance_mode_page)) {
					wp_die( '<p style="text-align:center">' . esc_html__( 'We are currently in maintenance mode, please check back shortly.', 'g5plus-lustria' ) . '</p>', get_bloginfo( 'name' ) );
				} else {
					$maintenance_mode_page_url = get_permalink($maintenance_mode_page);
					if (is_page()) {
						if (get_the_ID() != $maintenance_mode_page) {
							wp_redirect($maintenance_mode_page_url);
						}
					} else {
						wp_redirect($maintenance_mode_page_url);
					}
				}
				break;
		}
	}
	add_action( 'get_header', 'g5plus_maintenance_mode' );
}