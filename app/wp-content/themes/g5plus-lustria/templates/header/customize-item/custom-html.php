<?php
/**
 * The template for displaying custom-html
 *
 * @var $customize_location
 */
$custom_html = G5Plus_Lustria()->options()->getOptions("header_customize_{$customize_location}_custom_html");
echo wp_kses_post($custom_html);