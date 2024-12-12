<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function gid_replace_elementor_data($find, $replace, &$data) {
	$data = json_decode($data, true);
	gid_recursive_replace_data($find, $replace, $data);
	return json_encode($data);
}


function gid_replace_elementor_data_post_id_for_setting(&$map_ids, $key, &$value) {
	// Replace Image
	if (is_array($value) && isset($value['url']) && isset($value['id'])) {
		$value['id'] = isset($map_ids[$value['id']]) ? $map_ids[$value['id']] : $value['id'];
	}

	// Replace Widget ID
	if (is_array($value) && isset($value['etype']) && isset($value['ube_dynamic_content_id'])) {
		$value['ube_dynamic_content_id'] = isset($map_ids[$value['ube_dynamic_content_id']])
			? $map_ids[$value['ube_dynamic_content_id']]
			: $value['ube_dynamic_content_id'];
	}

	if (($key === 'ids') && is_array($value)) {
		foreach ($value as $k =>  $v) {
			$value[$k] = isset($map_ids[$v]) ? $map_ids[$v] : $v;
		}
	}

	if (in_array($key,array('id'))) {
		$value = isset($map_ids[$value]) ? $map_ids[$value] : $value;
	}

}

function gid_replace_elementor_data_post_id(&$map_ids, &$data) {
	if (is_array($data)) {
		foreach ($data as &$el) {
			if (isset($el['settings']) && is_array($el['settings'])) {
				foreach ($el['settings'] as $k => &$v) {
					if (($k === 'tabs' || $k === 'items') && is_array($v)) {
						// Replace term id in tabs
						foreach ($v as &$t_v) {
							foreach ($t_v as $tv_k => &$tv_v) {
								gid_replace_elementor_data_post_id_for_setting($map_ids, $tv_k, $tv_v);
							}
						}
					}
					else {
						gid_replace_elementor_data_post_id_for_setting($map_ids, $k, $v);
					}
				}
			}

			if (isset($el['elements'])) {
				gid_replace_elementor_data_post_id($map_ids, $el['elements']);
			}
		}
	}
}

function gid_replace_elementor_data_term_id_for_setting(&$map_ids, $key, &$value) {
	if ((in_array($key,array('cat','category','tag','authors','property_type','property_types','property_status','property_feature','property_city','property_state','property_neighborhood','property_label')))) {
		if (is_array($value)) {
			foreach ($value as $k =>  $v) {
				$value[$k] = isset($map_ids[$v]) ? $map_ids[$v] : $v;
			}
		} else {
			$value = isset($map_ids[$value]) ? $map_ids[$value] : $value;
		}
	}
}

function gid_replace_elementor_data_term_id(&$map_ids, &$data) {
	if (is_array($data)) {
		foreach ($data as &$el) {
			if (isset($el['settings']) && is_array($el['settings'])) {
				foreach ($el['settings'] as $k => &$v) {
					if (($k === 'tabs') && is_array($v)) {
						// Replace term id in tabs
						foreach ($v as &$t_v) {
							foreach ($t_v as $tv_k => &$tv_v) {
								gid_replace_elementor_data_term_id_for_setting($map_ids, $tv_k, $tv_v);
							}
						}
					}
					else {
						gid_replace_elementor_data_term_id_for_setting($map_ids, $k, $v);
					}
				}
			}

			if (isset($el['elements'])) {
				gid_replace_elementor_data_term_id($map_ids, $el['elements']);
			}
		}
	}
}

add_action('gid_installing_prepare_data_success', 'gid_process_elementor_data');
function gid_process_elementor_data($demo) {
	$current_demo = gid_get_current_demo( $demo );
	if (!isset($current_demo['builder']) || ($current_demo['builder'] !== 'elementor') ) {
		return;
	}

	global $wpdb, $terms_id_log, $posts_id_log;

	$current_blog_id = get_current_blog_id();
	$target_table_prefix =  $wpdb->get_blog_prefix( $current_blog_id );

	$rows = $wpdb->get_results( "SELECT ID FROM {$target_table_prefix}posts WHERE post_type <> 'attachment'" );
	foreach ($rows as $row) {
		$data = get_post_meta($row->ID, '_elementor_data', true);

		if ($data !== false) {
			$data = json_decode($data, true);

			if (is_array($data)) {
				gid_replace_elementor_data_post_id($posts_id_log, $data);
				gid_replace_elementor_data_term_id($terms_id_log, $data);

				update_post_meta($row->ID, '_elementor_data', wp_slash(json_encode($data)));
			}
			else {
				update_post_meta($row->ID, '_elementor_data', json_encode(array()));
			}
		}
	}

	// Update options
	$elementor_active_kit = get_option('elementor_active_kit', false);
	if ($elementor_active_kit !== false) {
		$elementor_active_kit = isset($posts_id_log[$elementor_active_kit]) ? $posts_id_log[$elementor_active_kit] : $elementor_active_kit;
		update_option('elementor_active_kit', $elementor_active_kit);
	}

	if (class_exists('Elementor\Plugin')) {
		Elementor\Plugin::$instance->files_manager->clear_cache();
	}
}

add_action('gid_import_insert_post','gid_delete_post_meta',10,4);
function gid_delete_post_meta( $post_id, $original_post_ID, $postdata, $post ) {
	global $wpdb;
	$wpdb->delete($wpdb->postmeta,array('post_id' => $post_id));
}