<?php
/**
 * The template for displaying sidebar
 * @var $customize_location
 */
$sidebar = G5Plus_Lustria()->options()->getOptions("header_customize_{$customize_location}_sidebar");
if (is_active_sidebar($sidebar)) {
    dynamic_sidebar($sidebar);
}

