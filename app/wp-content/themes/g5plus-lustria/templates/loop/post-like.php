<?php
/**
 * The template for displaying post-like.php
 *
 */
if (shortcode_exists('g5plus-post-like')) {
    echo '<li class="meta-like">';
    echo do_shortcode('[g5plus-post-like]');
    echo '</li>';
}
