<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
function ube_get_button_sizes() {
	return apply_filters( 'ube_button_sizes', [
		'xs' => esc_html__( 'Extra Small', 'ube' ),
		'sm' => esc_html__( 'Small', 'ube' ),
		'md' => esc_html__( 'Medium', 'ube' ),
		'lg' => esc_html__( 'Large', 'ube' ),
		'xl' => esc_html__( 'Extra Large', 'ube' ),
	] );
}

function ube_get_button_styles() {
	return apply_filters( 'ube_button_styles', [
		''        => esc_html__( 'Classic', 'ube' ),
		'outline' => esc_html__( 'Outline', 'ube' ),
		'link'    => esc_html__( 'Link', 'ube' ),
		'3d'      => esc_html__( '3D', 'ube' ),
	] );
}

function ube_get_button_shape() {
	return apply_filters( 'ube_button_shape', array(
		'rounded' => esc_html__( 'Rounded', 'ube' ),
		'square'  => esc_html__( 'Square', 'ube' ),
		'round'   => esc_html__( 'Round', 'ube' ),
	) );
}

