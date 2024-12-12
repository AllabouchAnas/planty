<?php
/**
 * The template for displaying post-view.php
 *
 */
if (shortcode_exists('post-views')) {
    $post_views_counter_settings_display = get_option('post_views_counter_settings_display');
    if (is_array($post_views_counter_settings_display) && isset($post_views_counter_settings_display['position']) && $post_views_counter_settings_display['position'] === 'manual') {
        ?>
        <li class="meta-view">
            <?php
            echo do_shortcode('[post-views]');
            ?>
        </li>
        <?php
    }
}

