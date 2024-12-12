<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
class UBE_Module_Dynamic_Content extends UBE_Abstracts_Module {
    public function init() {
        add_action('init', array($this, 'register_post_type'));
        add_action('wp_ajax_ube_dynamic_content', array($this, 'process_handler_request'));
        add_action( 'elementor/editor/footer', array( $this, 'modal_template' ) );
    }

    public function register_post_type() {
        $rewrite = array(
            'slug'                  => 'UBE-content',
            'with_front'            => true,
            'pages'                 => false,
            'feeds'                 => false,
        );
        $args = array(
            'label'                 => esc_html__( 'UBE Dynamic Content', 'ube' ),
            'description'           => esc_html__( 'UBE Dynamic Content', 'ube' ),
            'supports'              => array( 'title', 'editor', 'elementor', 'permalink' ),
            'hierarchical'          => true,
            'public'                => true,
            'show_ui'               => false,
            'show_in_menu'          => false,
            'menu_position'         => 5,
            'show_in_admin_bar'     => false,
            'show_in_nav_menus'     => false,
            'can_export'            => true,
            'has_archive'           => false,
            'publicly_queryable' => true,
            'rewrite'               => $rewrite,
            'query_var' => true,
            'exclude_from_search'   => true,
            'capability_type'       => 'page',
            'show_in_rest'          => true,
            'rest_base'             => 'ube-content',
        );
        register_post_type( 'ube_content', $args );
        flush_rewrite_rules();
    }

    public function modal_template() {
        ube_get_template('controls/widget-area-modal.php');
    }

    public function parse_widget_content( $name, $content, $widget_key, $index = 1) {
        return ube_get_template_content('controls/widget-area-content.php', array(
        	'widget_name' => $name,
	        'widget_content' => $content,
	        'widget_key' => $widget_key,
	        'index' => $index
        ));
    }

	public function process_handler_request() {
		if (!isset($_REQUEST['ube_dynamic_content_nonce'])
			|| !wp_verify_nonce(sanitize_text_field($_REQUEST['ube_dynamic_content_nonce']), 'ube_dynamic_content_action')) {
			return;
		}

		$ube_content_id = isset($_REQUEST['ube_content_id']) ? sanitize_text_field($_REQUEST['ube_content_id']) : '';
		$ube_content_id = intval($ube_content_id);

		$content_key  = sanitize_text_field($_REQUEST['key']);
		$builder_post_title = 'dynamic-content-widget-' . $content_key;

		if ($ube_content_id === 0) {
			$builder_post    = get_page_by_title( $builder_post_title, OBJECT, 'ube_content' );
			if ( !is_null( $builder_post ) ) {
				$ube_content_id = $builder_post->ID;
			}
			else {
				$ube_content_id = 0;
			}
		}
		else {
			$builder_post = get_post($ube_content_id);
			if ( !is_null( $builder_post ) ) {
				$ube_content_id = $builder_post->ID;
			}
		}

		if ($ube_content_id === 0) {
			$defaults        = array(
				'post_content' => '',
				'post_title'   => $builder_post_title,
				'post_status'  => 'publish',
				'post_type'    => 'ube_content',
			);
			$ube_content_id = wp_insert_post( $defaults );

			update_post_meta( $ube_content_id, '_wp_page_template', 'elementor_canvas' );
		}

		$url = get_admin_url() . '/post.php?post=' . $ube_content_id . '&action=elementor';
		wp_redirect( $url );
		exit;
	}
}