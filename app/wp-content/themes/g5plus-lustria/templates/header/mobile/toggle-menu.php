<?php
/**
 * The template for displaying menu.php
 * @var $canvas_position
 */
add_action('wp_footer', array(G5Plus_Lustria()->templates(), 'mobile_navigation'), 10);
add_action('wp_footer', array(G5Plus_Lustria()->templates(), 'canvas_overlay'), 10);
?>
<div class="mobile-header-menu">
	<div data-off-canvas="true" data-off-canvas-target="#mobile-navigation-wrapper" data-off-canvas-position="<?php echo esc_attr($canvas_position); ?>"
	     class="gf-toggle-icon"><span></span></div>
</div>
