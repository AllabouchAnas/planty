<?php
/**
 * The template for displaying social-networks
 *
 * @var $customize_location
 */
$social_networks =  G5Plus_Lustria()->options()->getOptions("header_customize_{$customize_location}_social_networks");
G5Plus_Lustria()->templates()->social_networks($social_networks,'classic');

