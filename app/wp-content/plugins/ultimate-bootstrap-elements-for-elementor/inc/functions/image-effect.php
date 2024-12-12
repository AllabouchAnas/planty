<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
function ube_get_hover_effect() {
	return apply_filters( 'ube_hover_effect', [
		''           => esc_html__( 'Choose Animation', 'ube' ),
		'gray-scale' => esc_html__( 'Gray Scale', 'ube' ),
		'opacity'    => esc_html__( 'Opacity', 'ube' ),
		'shine'      => esc_html__( 'Shine', 'ube' ),
		'circle'     => esc_html__( 'Circle', 'ube' ),
		'flash'      => esc_html__( 'Flash', 'ube' ),
	] );
}

function ube_get_image_effect() {
	return apply_filters( 'ube_image_effect', [
		''             => esc_html__( 'Choose Animation', 'ube' ),
		'zoom-in'      => esc_html__( 'Zoom In', 'ube' ),
		'zoom-out'     => esc_html__( 'Zoom Out', 'ube' ),
		'rotate'       => esc_html__( 'Rotate', 'ube' ),
		'slide-left'   => esc_html__( 'Slide Left', 'ube' ),
		'slide-right'  => esc_html__( 'Slide Right', 'ube' ),
		'slide-top'    => esc_html__( 'Slide Top', 'ube' ),
		'slide-bottom' => esc_html__( 'Slide Bottom', 'ube' ),
	] );
}