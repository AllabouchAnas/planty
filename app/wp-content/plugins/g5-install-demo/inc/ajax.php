<?php
add_action( 'wp_ajax_gid_install_demo_data', 'gid_install_demo_data' );
function gid_install_demo_data() {
	if ( ! isset( $_POST['nonce'] )
	     || ! wp_verify_nonce( $_POST['nonce'], 'gid_install_demo_data_action' )
	) {
		wp_send_json_error( esc_html__( 'Access Deny! Refresh website and try again!', 'gid' ) );
	}

	$step = $_POST['step'];
	$demo = $_POST['demo'];

	if ( ! defined( 'WP_LOAD_IMPORTERS' ) ) {
		define( 'WP_LOAD_IMPORTERS', true );
	}

	switch ( $step ) {
		case 'init':
			{
				gid_installing_demo_init( $demo );
				break;
			}
		case 'data':
			{
				gid_installing_demo_data($demo);
				break;
			}
		case 'slider':
			{
				gid_installing_demo_slider( $demo );
				break;
			}
		case 'prepare':
			{
				gid_installing_prepare_data($demo);
				break;
			}
	}
}

add_action( 'wp_ajax_gid_install_demo_setting', 'gid_install_demo_setting' );
function gid_install_demo_setting() {
	if ( ! isset( $_POST['nonce'] )
	     || ! wp_verify_nonce( $_POST['nonce'], 'gid_install_demo_data_action' )
	) {
		wp_send_json_error( esc_html__( 'Access Deny! Refresh website and try again!', 'gid' ) );
	}

	$step = $_POST['step'];
	$demo = $_POST['demo'];

	if ( ! defined( 'WP_LOAD_IMPORTERS' ) ) {
		define( 'WP_LOAD_IMPORTERS', true );
	}

	switch ( $step ) {
		case 'init':
			{
				gid_installing_demo_init( $demo, false );
				break;
			}
		case 'data':
			{
				gid_installing_demo_data_for_setting($demo);
				break;
			}
		case 'prepare':
			{
				gid_installing_prepare_data($demo);
				break;
			}
	}
}

function gid_clear_database_for_install() {
	/**
	 * Delete import log
	 */
	delete_option('gid_import_log_data');

	/**
	 * Clear All Post & Page
	 */

	global $wpdb;

	$current_blog_id = get_current_blog_id();
	$target_table_prefix =  $wpdb->get_blog_prefix( $current_blog_id );

	$wpdb->query( "DELETE FROM {$target_table_prefix}postmeta" );
	$wpdb->query( "DELETE FROM {$target_table_prefix}posts" );
	$wpdb->query( "DELETE FROM {$target_table_prefix}termmeta" );
	$wpdb->query( "DELETE FROM {$target_table_prefix}term_taxonomy" );
	$wpdb->query( "DELETE FROM {$target_table_prefix}term_relationships" );
	$wpdb->query( "DELETE FROM {$target_table_prefix}terms" );
}

function gid_installing_demo_init( $demo, $is_demo_all_data = true  ) {
	/**
	 * Check demo file exists
	 */
	$current_demo = gid_get_current_demo( $demo);
	if ( ! isset( $current_demo['dir'] ) ) {
		wp_send_json_error( esc_html__( 'Demo to install not found!', 'gid' ) );
	}
	$demo_dir = $current_demo['dir'];

	$files_import_required = array('demo-data.xml', 'setting.json');

	foreach ($files_import_required as $f) {
		if ( ! is_readable( "{$demo_dir}/{$f}" ) ) {
			wp_send_json_error( esc_html__( 'Demo to install not found!', 'gid' ) );
		}
	}

	if ($is_demo_all_data) {
		gid_clear_database_for_install();
	}

	/**
	 * Save setting to option
	 */
	gid_import_setting_file( $demo, $is_demo_all_data );

	wp_send_json_success( array(
		'step'    => 'data',
		'demo'    => $demo,
		'message' => esc_html__( 'Start Install Post', 'gid' )
	) );
}

function gid_import_setting_file( $demo, $is_demo_all_data ) {
	global $wpdb;

	$data_process = gid_get_file_content( $demo, 'setting.json' );

	foreach ( $data_process as $key => $value ) {
		if (!$is_demo_all_data) {
			$option_keys_no_import = apply_filters('gid_option_keys_no_import',
				array(
					'show_on_front',
					'page_on_front',
					'page_for_posts',
					'woocommerce_shop_page_id',
					'woocommerce_cart_page_id',
					'woocommerce_checkout_page_id',
					'woocommerce_myaccount_page_id',
					'woocommerce_terms_page_id',
					'yith_wcwl_wishlist_page_id'
				));
			if (in_array($key, $option_keys_no_import)) {
				continue;
			}
		}
		if ( get_option( $key ) === false ) {
			$s_query = $wpdb->prepare( "insert into $wpdb->options(`option_name`, `option_value`, `autoload`) values(%s, %s, %s)", $key, base64_decode( $value["option_value"] ), $value["autoload"] );
		} else {
			$s_query = $wpdb->prepare( "update $wpdb->options set `option_value` = %s , `autoload` = %s where option_name = %s", base64_decode( $value["option_value"] ), $value["autoload"], $key );
		}
		$wpdb->query( $s_query );
	}
}

function gid_installing_demo_data( $demo ) {
	// Register Product Taxonomy
	$gid_wc_attribute_tax = get_option('gid_wc_attribute_tax', array());
	if (!empty($gid_wc_attribute_tax) && function_exists('wc_create_attribute')) {
		foreach ($gid_wc_attribute_tax as $tax) {
			wc_create_attribute(
				array(
					'name'         => $tax['attribute_label'],
					'slug'         => $tax['attribute_name'],
					'type'         => $tax['attribute_type'],
					'order_by'     => $tax['attribute_orderby'],
					'has_archives' => false,
				)
			);
			register_taxonomy('pa_' . $tax['attribute_name'], array('product'));
		}
	}

	$post_types_register = apply_filters('gid_post_types_register_before_install', array('g5core_vc_template'));
	foreach ($post_types_register as $pt) {
		register_post_type($pt, array());
	}

	$tax_register =  apply_filters('gid_taxonomy_register_before_install', array(
		'g5core_vc_template' => 'g5core_vc_template_cat'
	));
	foreach ($tax_register as $pt => $tax) {
		register_taxonomy($tax, $pt);
	}

	$current_demo = gid_get_current_demo( $demo );
	$demo_dir     = $current_demo['dir'];

	$data_file = "{$demo_dir}/demo-data.xml";

	require_once  GID()->plugin_dir('inc/lib/importer.php');

	ob_start();

	$_importer = new GID_Importer();
	$import_result = $_importer->import( $data_file );

	ob_get_clean();

	if ( !$import_result ) {
		wp_send_json_success( array(
			'step'    => 'data',
			'demo'    => $demo,
			'message' => sprintf( esc_html__( 'Installing Post (%s/%s)', 'gid' ), $_importer->start_post_process, count($_importer->posts) ),
		) );
	}
	$rev_sliders      = gid_rev_slider_list( $demo );
	$rev_slider_count = count( $rev_sliders );

	if ( class_exists( 'RevSlider' ) && ( $rev_slider_count > 0 ) ) {
		wp_send_json_success( array(
			'step'    => 'slider',
			'demo'    => $demo,
			'current' => 1,
			'message' => sprintf( esc_html__( 'Installing Slider (%s/%s)', 'gid' ), 1, $rev_slider_count ),
		) );
	} else {
		wp_send_json_success( array(
			'step'    => 'prepare',
			'demo'    => $demo,
			'message' => esc_html__( 'Prepare missing demo data', 'gid' ),
		) );
	}
}

function gid_installing_demo_data_for_setting( $demo ) {
	// Register Product Taxonomy
	$gid_wc_attribute_tax = get_option('gid_wc_attribute_tax', array());
	if (!empty($gid_wc_attribute_tax) && function_exists('wc_create_attribute')) {
		foreach ($gid_wc_attribute_tax as $tax) {
			wc_create_attribute(
				array(
					'name'         => $tax['attribute_label'],
					'slug'         => $tax['attribute_name'],
					'type'         => $tax['attribute_type'],
					'order_by'     => $tax['attribute_orderby'],
					'has_archives' => false,
				)
			);
			register_taxonomy('pa_' . $tax['attribute_name'], array('product'));
		}
	}



	$current_demo = gid_get_current_demo( $demo );
	$demo_dir     = $current_demo['dir'];

	$data_file = "{$demo_dir}/demo-data.xml";

	require_once  GID()->plugin_dir('inc/lib/importer.php');

	ob_start();

	$posts_id_allow_install = gid_get_file_content($demo, 'attachment.json');

	$_importer = new GID_Importer();

	$_importer->install_setting_only = true;
	$_importer->post_type_allow_install = apply_filters('gid_post_type_allow_install', array('g5core_content', 'g5core_vc_template', 'g5core_xmenu_mega'));
	$_importer->posts_id_allow_install = apply_filters('posts_id_allow_install', $posts_id_allow_install);

	$import_result = $_importer->import( $data_file );

	ob_get_clean();

	if ( !$import_result ) {
		wp_send_json_success( array(
			'step'    => 'data',
			'demo'    => $demo,
			'message' => sprintf( esc_html__( 'Importing Data (%s/%s)', 'gid' ), $_importer->start_post_process, count($_importer->posts)),
		) );
	}

	wp_send_json_success( array(
		'step'    => 'prepare',
		'demo'    => $demo,
		'message' => esc_html__( 'Prepare missing demo data', 'gid' ),
	) );
}

function gid_svg_mime_types($mimes) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter('mime_types','gid_svg_mime_types');

function gid_installing_demo_slider( $demo ) {
	$current     = intval( $_POST['current'] );
	$rev_sliders = gid_rev_slider_list( $demo );

	$total = count( $rev_sliders );

	$slider_file = $rev_sliders[ $current - 1 ];
	$slider      = new RevSlider();
	$slider->importSliderFromPost( true, true, $slider_file );

	if ( $current < $total ) {
		wp_send_json_success( array(
			'step'    => 'slider',
			'demo'    => $demo,
			'message' => sprintf( esc_html__( 'Installing Slider (%s/%s)', 'gid' ), $current + 1, $total ),
			'current' => $current + 1
		) );
	} else {
		wp_send_json_success( array(
			'step'    => 'prepare',
			'demo'    => $demo,
			'message' => esc_html__( 'Prepare Demo Data', 'gid' ),
		) );
	}
}

function gid_installing_prepare_data( $demo ) {
	global $wpdb, $terms_id_log, $posts_id_log;

	$current_demo = gid_get_current_demo( $demo );

	$site_url   = trailingslashit( site_url() );
	$demo_url   = trailingslashit($current_demo['preview']);

	$current_blog_id = get_current_blog_id();
	$main_site_id = get_main_site_id();

	$target_table_prefix =  $wpdb->get_blog_prefix( $current_blog_id );


	$theme_name = $current_demo['theme'];

	$sql_query = $wpdb->prepare( "UPDATE {$target_table_prefix}posts SET guid = replace(guid, %s, %s)", 'http://demo2.woothemes.com/woocommerce', $site_url );
	$wpdb->query( $sql_query );

	/**
	 * Other Update
	 */
	// Update COUNT term_taxonomy
	$sql_query = "UPDATE {$target_table_prefix}term_taxonomy tt SET count = (SELECT count(p.ID) FROM {$target_table_prefix}term_relationships tr LEFT JOIN {$target_table_prefix}posts p ON (p.ID = tr.object_id AND p.post_status = 'publish') WHERE tr.term_taxonomy_id = tt.term_taxonomy_id)";
	$wpdb->query( $sql_query );

	// Update MailChimp
	$rows = $wpdb->get_results( $wpdb->prepare( "SELECT ID FROM {$target_table_prefix}posts WHERE post_type = %s and post_status = 'publish'", 'mc4wp-form' ) );
	if ( count( $rows ) > 0 ) {
		update_option( 'mc4wp_default_form_id', $rows[0]->ID );
	}

	$import_log_data = get_option( 'gid_import_log_data', array() );
	$posts_id_log    = isset( $import_log_data['processed_posts'] ) ? $import_log_data['processed_posts'] : array();
	$terms_id_log    = isset( $import_log_data['processed_terms'] ) ? $import_log_data['processed_terms'] : array();

	// Change nav_menu_location
	$data = get_option( 'theme_mods_' . $theme_name );

	if ( isset( $data['nav_menu_locations'] ) ) {
		foreach ( $data['nav_menu_locations'] as $key => $value ) {
			$data['nav_menu_locations'][ $key ] = isset( $terms_id_log[ $value ] ) ? $terms_id_log[ $value ] : $value;
		}
	}
	update_option( 'theme_mods_' . get_option( "stylesheet" ), $data );

    $opt_widget_sidebars = get_option( 'sidebars_widgets' );
    foreach ($opt_widget_sidebars as $k => $v) {
        if (!is_array($v)) {
            unset($opt_widget_sidebars[$k]);
        }
    }

    // Change theme_mod
    $data['sidebars_widgets'] = array(
        'time' => time(),
        'data' => $opt_widget_sidebars
    );

	if ( is_child_theme() ) {
		update_option( 'theme_mods_' . get_template(), $data );
	} else {
		update_option( 'theme_mods_' . get_option( "stylesheet" ) . '-child', $data );
	}

	// Change nav_menu ID in widget
	$data_nav_menu = get_option( 'widget_nav_menu' );
	if ( isset( $data_nav_menu ) && is_array( $data_nav_menu ) ) {
		foreach ( $data_nav_menu as $key => $value ) {
			if ( is_array( $value ) && isset( $value['nav_menu'] ) ) {
				$data_nav_menu[ $key ]['nav_menu'] = isset( $terms_id_log[ $value['nav_menu'] ] ) ? $terms_id_log[ $value['nav_menu'] ] : $value['nav_menu'];
			}
		}
	}
	update_option( 'widget_nav_menu', $data_nav_menu );

	/**
	 * Change post id in option
	 */
	$options_keys = apply_filters( 'gid_options_key_change_post_id', array(
		'page_on_front' => '=',
		'page_for_posts' => '=',
		'wp_page_for_privacy_policy' => '=',
		'yith_%_page_id' => 'like',
		'woocommerce_%_page_id' => 'like',
	) );
	foreach ( $options_keys as $opt_key => $opt_op) {
		$rows_found = $wpdb->get_results( $wpdb->prepare( "SELECT option_name FROM {$target_table_prefix}options WHERE option_name {$opt_op} %s", $opt_key ) );
		foreach ( $rows_found as $row ) {
			$old_id = get_option( $row->option_name );
			if ( ( $old_id !== false ) && is_numeric( $old_id ) ) {
				$old_id = intval( $old_id );
				update_option( $row->option_name, isset( $posts_id_log[ $old_id ] ) ? $posts_id_log[ $old_id ] : $old_id );
			}
		}
	}

	/**
	 * Change term id in option
	 */
	$options_keys = apply_filters( 'gid_options_key_change_term_id', array() );
	foreach ( $options_keys as $opt_key ) {
		$rows_found = $wpdb->get_results( $wpdb->prepare( "SELECT option_name FROM {$target_table_prefix}options WHERE option_name = %s", $opt_key ) );
		foreach ( $rows_found as $row ) {
			$old_id = get_option( $row->option_name );
			if ( ( $old_id !== false ) && is_numeric( $old_id ) ) {
				$old_id = intval( $old_id );
				update_option( $row->option_name, isset( $terms_id_log[ $old_id ] ) ? $terms_id_log[ $old_id ] : $old_id );
			}
		}
	}

	/**
	 * Change post id in post meta
	 */
	$meta_keys = apply_filters( 'gid_post_meta_change_post_id', array(
		'g5core_footer_content_block',
		'g5core_page_title_content_block'
	) );

	foreach ( $meta_keys as $mt_key ) {
		$rows_found = $wpdb->get_results( $wpdb->prepare( "SELECT post_id, meta_value, meta_key FROM {$target_table_prefix}postmeta WHERE meta_key = %s", $mt_key ) );
		foreach ( $rows_found as $row ) {
			if ( isset( $posts_id_log[ $row->meta_value ] ) ) {
				update_post_meta( $row->post_id, $row->meta_key, $posts_id_log[ $row->meta_value ] );
			}
		}
	}

	/**
	 * Change term id in post meta
	 */
	$meta_keys = apply_filters( 'gid_post_meta_change_term_id', array(
		"g5core_page_menu"        => '=',
		"g5core_page_mobile_menu" => '=',
	) );

	foreach ( $meta_keys as $mt_key => $mt_opt ) {
		$rows_found = $wpdb->get_results( $wpdb->prepare( "SELECT post_id, meta_value, meta_key FROM {$target_table_prefix}postmeta WHERE meta_key {$mt_opt} %s", $mt_key ) );
		foreach ( $rows_found as $row ) {
			if ( isset( $terms_id_log[ $row->meta_value ] ) ) {
				update_post_meta( $row->post_id, $row->meta_key, $terms_id_log[ $row->meta_value ] );
			}
		}
	}

	/**
	 * change post id in term meta
	 */
	$meta_keys = apply_filters( 'gid_term_meta_change_post_id', array(
		"thumbnail_id" => '=',
		'g5core_page_title_content_block' => '='
	) );

	foreach ( $meta_keys as $mt_key => $mt_opt ) {
		$rows_found = $wpdb->get_results( $wpdb->prepare( "SELECT meta_id, term_id, meta_key, meta_value FROM {$target_table_prefix}termmeta WHERE meta_key {$mt_opt} %s", $mt_key ) );
		foreach ( $rows_found as $row ) {
			update_term_meta( $row->term_id, $row->meta_key, isset( $posts_id_log[ $row->meta_value ] ) ? $posts_id_log[ $row->meta_value ] : $row->meta_value );
		}
	}

	/**
	 * Change term id in term meta
	 */
	$meta_keys = apply_filters( 'gid_term_meta_change_term_id', array(
		'property_neighborhood_country',
		'property_neighborhood_state',
		'property_neighborhood_city',
		'property_city_country',
		'property_city_state',
		'property_state_country'
	) );

	foreach ( $meta_keys as $mt_key ) {
		$rows_found = $wpdb->get_results( $wpdb->prepare( "SELECT meta_id, term_id, meta_key, meta_value FROM {$target_table_prefix}termmeta WHERE meta_key = %s", $mt_key ) );
		foreach ( $rows_found as $row ) {
			update_term_meta( $row->term_id, $row->meta_key, isset( $terms_id_log[ $row->meta_value ] ) ? $terms_id_log[ $row->meta_value ] : $row->meta_value );
		}
	}

	/**
	 * Change media field (url, id) in theme-option
	 */
	$options_keys = apply_filters( 'gid_options_key_change_theme_options', array(
		'g5%' => 'like',
		'gsf_preset_options_keys_%' => 'like',
	) );

	foreach ($options_keys as $key => $value) {
		$options = $wpdb->get_results($wpdb->prepare("SELECT option_name FROM {$target_table_prefix}options WHERE option_name {$value} %s",$key));
		foreach ( $options as $option ) {
			$optionValue = get_option( $option->option_name );

			foreach ( $optionValue as $key => &$value ) {
				if ( isset( $value['id'] ) && ( isset( $value['url'] ) || $value['background_image_url'] ) ) {
					$value['id'] = isset( $posts_id_log[ $value['id'] ] ) ? $posts_id_log[ $value['id'] ] : $value['id'];
				}

				if ( is_string( $value ) && ( strpos( $value, '|' ) !== false ) ) {
					$value = explode( '|', $value );
					foreach ( $value as $k => $v ) {
						$value[ $key ] = isset( $posts_id_log[ $v ] ) ? $posts_id_log[ $v ] : $v;
					}
					$value = join( '|', $value );
				}

				if ( in_array( $key, array(
						'maintenance_mode_page',
						'page_404_custom',
						'footer_content_block',
						'page_title_content_block'
					) ) || ( preg_match( '/_(single|archive)__(page_title_content_block|footer_content_block)$/', $key ) ) ) {
					$value = isset( $posts_id_log[ $value ] ) ? $posts_id_log[ $value ] : $value;
				}

				if (in_array($key, array('swatches_taxonomy'))) {
					$value = isset( $terms_id_log[ $value ] ) ? $terms_id_log[ $value ] : $value;
				}
			}
			update_option( $option->option_name, $optionValue );
		}
	}





	// Change url, post_id, gallery in post meta
	$meta_keys = apply_filters( 'gid_post_meta_change_media_field', array(
		'g5blog_format_gallery_images',
		'g5portfolio_single_gallery',
		'real_estate_property_images',
		'real_estate_property_video_image',
		'real_estate_property_attachments',
		'real_estate_property_agent'
	) );

	foreach ( $meta_keys as $mt_key ) {
		$rows_found = $wpdb->get_results( $wpdb->prepare( "SELECT post_id, meta_value, meta_key FROM {$target_table_prefix}postmeta WHERE meta_key = %s", $mt_key ) );
		foreach ( $rows_found as $row ) {
			$meta_value = get_post_meta( $row->post_id, $row->meta_key, true );

			if ( isset( $meta_value['id'] ) && ( isset( $meta_value['url'] ) || $meta_value['background_image_url'] ) ) {
				$meta_value['id'] = isset( $posts_id_log[ $meta_value['id'] ] ) ? $posts_id_log[ $meta_value['id'] ] : $meta_value['id'];
			}
			if ( is_string( $meta_value ) && ( strpos( $meta_value, '|' ) !== false ) ) {
				$meta_value = explode( '|', $meta_value );
				foreach ( $meta_value as $k => $v ) {
					$meta_value[ $k ] = isset( $posts_id_log[ $v ] ) ? $posts_id_log[ $v ] : $v;
				}
				$meta_value = join( '|', $meta_value );
			}

			update_post_meta( $row->post_id, $row->meta_key, $meta_value );
		}
	}

	// Change url, post_id, gallery in term meta
	$meta_keys = apply_filters( 'gid_term_meta_change_media_field', array(
		'g5shop_archive_banner_image',
		'g5shop_archive_banner_gallery',
		'g5shop_product_taxonomy_image',
		'agency_logo',
		'g5ere_marker_image'
	) );

	foreach ( $meta_keys as $mt_key ) {
		$rows_found = $wpdb->get_results( $wpdb->prepare( "SELECT meta_id, term_id, meta_key, meta_value FROM {$target_table_prefix}termmeta WHERE meta_key = %s", $mt_key ) );
		foreach ( $rows_found as $row ) {
			$meta_value = get_term_meta( $row->term_id, $row->meta_key, true );

			if ( isset( $meta_value['id'] ) && ( isset( $meta_value['url'] ) || $meta_value['background_image_url'] ) ) {
				$meta_value['id'] = isset( $terms_id_log[ $meta_value['id'] ] ) ? $terms_id_log[ $meta_value['id'] ] : $meta_value['id'];
			}
			if ( is_string( $meta_value ) && ( strpos( $meta_value, '|' ) !== false ) ) {
				$meta_value = explode( '|', $meta_value );
				foreach ( $meta_value as $k => $v ) {
					$meta_value[ $key ] = isset( $terms_id_log[ $v ] ) ? $terms_id_log[ $v ] : $v;
				}
				$meta_value = join( '|', $meta_value );
			}

			update_term_meta( $row->term_id, $row->meta_key, $meta_value );
		}
	}

	// Change term id, post id in post_content
	$rows = $wpdb->get_results( $wpdb->prepare( "SELECT ID, post_content  FROM {$target_table_prefix}posts WHERE post_status = %s", 'publish' ) );
	foreach ( $rows as $row ) {
		$row->post_content = preg_replace_callback( '/((nav_menu|cat|tag|property_type|property_status|property_feature|property_label|property_state|property_city|property_neighborhood|agency)\=\")(\d+(\,(\d+))*)(\")/', 'gid_replace_term_id_callback', $row->post_content );
		$row->post_content = preg_replace_callback( '/((image|image_hover|avatar|images|ids|id)\=\")(\d+(\,(\d+))*)(\")/', 'gid_replace_post_id_callback', $row->post_content );
		
		$sql_query         = $wpdb->prepare( "UPDATE {$target_table_prefix}posts SET post_content = %s where ID = %d ", $row->post_content, $row->ID );
		$wpdb->query( $sql_query );
	}

	$replace_array = array();
	$replace_array[$demo_url] = $site_url;
	$replace_array[urlencode($demo_url)] = urlencode($site_url);
	$replace_array[urlencode(urlencode($demo_url))] = urlencode(urlencode($site_url));
	$replace_array[str_replace('/', '\\/', $demo_url)] = str_replace('/', '\\/', $site_url);
	$replace_array[str_replace('/', '\\\\/', $demo_url)] = str_replace('/', '\\\\/', $site_url);


	// multisite

	if ($current_blog_id !== $main_site_id) {
		$source_uploads_dir = '/wp-content/uploads/';
		$target_uploads_dir = '/wp-content/uploads/sites/' . $current_blog_id . '/';
		$replace_array[ $source_uploads_dir ] = $target_uploads_dir;
		$replace_array[ urlencode($source_uploads_dir) ] = urlencode($target_uploads_dir);
		$replace_array[ urlencode(urlencode($source_uploads_dir)) ] = urlencode(urlencode($target_uploads_dir));
		$replace_array[ str_replace('/', '\\/', $source_uploads_dir) ] = str_replace('/', '\\/', $target_uploads_dir);
		$replace_array[ str_replace('/', '\\\\/', $source_uploads_dir) ] = str_replace('/', '\\\\/', $target_uploads_dir);
	}

	gid_replace_database($replace_array);

	do_action('gid_installing_prepare_data_success', $demo);

	wp_send_json_success( array(
		'step'    => 'done',
		'demo'    => $demo,
		'message' => esc_html__( 'Install Done', 'gid' ),
	) );
}

function gid_rev_slider_list( $demo ) {
	$current_demo = gid_get_current_demo( $demo );
	$demo_dir     = trailingslashit($current_demo['dir']);
	$rs_path      = "{$demo_dir}revslider";

	$rev_sliders = glob( "{$rs_path}/*.zip" );

	return $rev_sliders;
}

function gid_get_file_content( $demo, $file ) {
	$current_demo = gid_get_current_demo( $demo );
	$demo_dir     = $current_demo['dir'];

	$data_file = "{$demo_dir}/{$file}";

	if ( is_readable( $data_file ) ) {
		return json_decode( file_get_contents( $data_file ), true );
	}

	return array();
}

function gid_get_current_demo( $demo ) {
	$demo_list = gid_demo_list();

	return isset( $demo_list[ $demo ] ) ? $demo_list[ $demo ] : array();
}

function gid_replace_term_id_callback($match) {
	global $terms_id_log;
	$ids = explode(',', $match[3]);
	foreach($ids as $k => $id) {
		$ids[$k] = isset($terms_id_log[$id]) ? $terms_id_log[$id] : $id;
	}
	return $match[1] . join(',', $ids) . $match[6];
}

function gid_replace_post_id_callback($match) {
	global $posts_id_log;
	$ids = explode(',', $match[3]);
	foreach($ids as $k => $id) {
		$ids[$k] = isset($posts_id_log[$id]) ? $posts_id_log[$id] : $id;
	}
	return $match[1] . join(',', $ids) . $match[6];
}


function gid_replace_database($replace_array) {
    global $wpdb;
    $current_blog_id = get_current_blog_id();

    $table_prefix = $wpdb->get_blog_prefix( $current_blog_id );

    $list_tables = $wpdb->get_results( $wpdb->prepare( "SHOW TABLES LIKE %s", $table_prefix . '%' ), ARRAY_N );
    foreach ($list_tables as $tbl) {
        $table_name = $tbl[0];

        $test_row     = $wpdb->get_row( "SELECT * FROM " . $table_name . " LIMIT 1", ARRAY_N );
        $list_column_name = $wpdb->get_col_info( 'name', - 1 );

        // Search for fields we can replace
        $where = '';
        foreach ( $replace_array as $old_value => $new_value ) {
            foreach ( $list_column_name as $column_name ) {
				if ($column_name === 'guid') {
					continue;
				}
                $where .= empty( $where ) ? '' : ' OR ';
                $where .= $wpdb->prepare( "`{$column_name}`" . ' like %s ', '%' . str_replace('\\', '\\\\', $old_value) . '%' );

            }
        }

        $replace_rows = $wpdb->get_results( "SELECT * FROM {$table_name} WHERE " . $where, ARRAY_A );

        if ( ! count( $replace_rows ) ) {
            continue;
        }

        foreach ( $replace_rows as $row ) {
            $query = 'UPDATE ' . $table_name;

            $set   = '';

            $is_execute_query = false;

            foreach ( $row as $col_name => $col_content ) {
                if ( ! is_string( $col_content ) ) {
                    continue;
                }

                $edited_value = $col_content;
                if ( is_serialized( $col_content ) ) {
                    $unserialized = unserialize( $edited_value );
                    foreach ( $replace_array as $old_value => $new_value ) {
                        gid_recursive_replace_data( $old_value, $new_value, $unserialized );
                    }
                    $edited_value = serialize( $unserialized );
                } else {
                    if (is_string($col_content)) {
                        foreach ( $replace_array as $old_value => $new_value ) {
                            $edited_value = str_replace( $old_value, $new_value, $edited_value );
                        }
                    }
                }

                if ( $edited_value != $col_content ) {
                    $set .= empty( $set ) ? '' : ', ';
                    $set .= $wpdb->prepare( $col_name . ' = %s ', $edited_value );
                    $is_execute_query = true;
                }
            }
            $query .= ' SET ' . $set;

            // Form where keys based on the primary keys ('ID' or '*_ID')
            $where_keys = '';
            foreach ( $row as $col_name => $col_content ) {
                if ( strtolower( $col_name ) != 'id' || stripos( strtolower( $col_name ), '_id' ) === false ) {
                    continue;
                }
                $where_keys .= empty( $where_keys ) ? '' : ' AND ';
                $where_keys .= $wpdb->prepare( $col_name . ' = %s ', $col_content );
            }
            // If no where clause yet, use everything
            if ( empty( $where_keys ) ) {
                foreach ( $row as $col_name => $col_content ) {
                    $where_keys .= empty( $where_keys ) ? '' : ' AND ';
                    $where_keys .= $wpdb->prepare( $col_name . ' = %s ', $col_content );
                }
            }
            $query .= ' WHERE ' . $where_keys;

            if ( $is_execute_query ) {
                $wpdb->query( $query );
            }
        }
    }
}

function gid_recursive_replace_data($find, $replace, &$data) {
    if ( is_array( $data ) ) {
        foreach ( $data as $key => $value ) {
            gid_recursive_replace_data( $find, $replace, $data[ $key ] );
        }
    }
    else if (is_object($data)) {
        foreach ( $data as $key => $value ) {
            gid_recursive_replace_data( $find, $replace, $data->{$key} );
        }
    }
    else if (is_string($data)){
        $data = str_replace( $find, $replace, $data );
    }
}