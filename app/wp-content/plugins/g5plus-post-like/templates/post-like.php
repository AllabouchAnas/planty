<?php
/**
 * The template for displaying post-like.php
 *
 * @package WordPress
 * @subpackage emo
 * @since emo 1.0
 */
$post_liked = GPL()->get_post_liked();
$like_count = number_format_i18n(GPL()->get_like_count());
$icon_class = $post_liked === true ? 'fa fa-heart' : 'fa fa-heart-o';
$nonce = wp_create_nonce(GPL()->key);
$spinner_color = GPL()->get_spinner_color();
$options = array(
	'action' => 'gpl_post_like',
	'id' => get_the_ID(),
	'status' => $post_liked,
	'nonce' => $nonce
);
?>
<a data-spinner-color="<?php echo esc_attr($spinner_color); ?>"
   data-style="zoom-in"
   data-spinner-size="20"
   class="ladda-button gf-post-like"
   data-post-like="true"
   data-options='<?php echo json_encode($options); ?>'
   href="javascript:;">
	<i class="<?php echo esc_attr($icon_class)?>"></i> <span class="post-like-count"><?php echo esc_html($like_count); ?></span>
</a>


