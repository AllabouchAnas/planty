<?php
/**
 * Get query data
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get post with key value data (id => post_title)
 *
 * @param string $keyword
 * @param int $page
 * @param $args
 * @return array
 *
 * @since 1.0.0
 *
 */
function ube_autocomplete_get_posts($keyword = '', $page = 1, $args = array()) {
    $default_args = array(
        'posts_per_page' => 30,
        'post_type'      => array('post'),
        'post_status'    => 'publish',
        'offset'     => 0,
        'orderby'        => 'post_title',
        'order'          => 'ASC'
    );


    $args = wp_parse_args($args, $default_args);

    $args['s'] = $keyword;

    $has_limit = false;

    if ($args['posts_per_page'] != -1) {
        $args['offset'] = ($page - 1) * $args['posts_per_page'];

        $has_limit = true;
        $args['posts_per_page'] += 1;
    }

    $posts = get_posts($args);

    $data = array(
        'results' => array(),
        'pagination' => array(
            'more' => false
        )
    );

    foreach ($posts as $p) {
        array_push($data['results'], array(
           'id' => $p->ID,
           'text' => $p->post_title
        ));
    }
    if ($has_limit && (count($data) === $args['posts_per_page'])) {
        $data['pagination']['more'] = true;
        array_pop($data['results']);
    }

    return $data;
}

/**
 * Get term with key value data (term_id => name)
 *
 * @param string $keyword
 * @param int $page
 * @param array $args
 *
 * @since 1.0.0
 *
 */
function ube_autocomplete_get_terms($keyword = '', $page = 1, $args = array()) {
    $default_args = array(
        'number' => 50,
        'hierarchical' => false,
        'hide_empty' => false,
        'taxonomy' => 'category',
        'orderby' => 'name',
        'order' => 'ASC',
    );

    $args = wp_parse_args($args, $default_args);

    $args['search'] = $keyword;

    $has_limit = false;
    if ($args['posts_per_page'] != -1) {
        $args['number'] = $args['posts_per_page'];
        $args['offset'] = ($page - 1) * $args['number'];

        $args['number'] += 1;
        $has_limit = true;
    }
    else {
        $args['number'] = '';
    }

    $terms = get_terms($args);

    $data = array(
        'results' => array(),
        'pagination' => array(
            'more' => false
        )
    );

    foreach ($terms as $t) {
        array_push($data['results'], array(
            'id' => $t->term_id,
            'text' => $t->name
        ));
    }

    if ($has_limit && (count($data) === $args['posts_per_page'])) {
        $data['pagination']['more'] = true;
        array_pop($data['results']);
    }

    return $data;
}

function ube_get_query_data_for_autocomplete($type, $keyword, $page = 1, $args = array(), $current_value = -1) {
    if (($current_value !== -1) && !$current_value) {
        return array(
            'results' => array(),
            'pagination' => array(
                'more' => false
            )
        );
    }

    $data = array();

    switch( $type ) {
        case 'post':
            if ($current_value !== -1) {
                $args['include'] = $current_value;
                $args['posts_per_page'] = -1;
            }
            $data = ube_autocomplete_get_posts($keyword, $page, $args);
            break;
        case 'term':
            if ($current_value !== -1) {
                $args['posts_per_page'] = -1;
                $args['include'] = $current_value;
            }
            $data = ube_autocomplete_get_terms($keyword, $page, $args);
            break;
    }

    $data = apply_filters("ube_autocomplete_{$type}", $data, $args);

    return $data;
}