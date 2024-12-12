<?php
/**
 * The template for displaying post-title.php
 * @var $post_link
 */

?>
<h4 class="gf-post-title"><a title="<?php the_title_attribute() ?>" href="<?php echo esc_url($post_link); ?>" class="gsf-link"><?php the_title() ?></a></h4>
