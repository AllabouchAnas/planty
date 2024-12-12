<?php
/**
 * The template for displaying canvas-sidebar
 *
 * @var $canvas_position
 */
if (!isset($canvas_position)) {
	$canvas_position = 'left';
}
add_action('wp_footer',array(G5Plus_Lustria()->templates(),'canvas_menu'),10);
//add_action('wp_footer',array(G5Plus_Lustria()->templates(),'canvas_overlay'),15);
?>
<div data-off-canvas="true" data-off-canvas-target="#canvas-menu-wrapper" data-off-canvas-position="<?php echo esc_attr($canvas_position); ?>" class="gf-toggle-icon"><span></span></div>
