<?php
/**
 * The template for displaying post-title.php
 *
 */
global $show_post_title;
if ($show_post_title) return;
?>
<h2 class="gf-post-title heading-color"><?php the_title() ?></h2>
