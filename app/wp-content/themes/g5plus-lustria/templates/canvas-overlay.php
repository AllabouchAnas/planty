<?php
/**
 * The template for displaying canvas-overlay.php
 */
$image_url = G5Plus_Lustria()->themeUrl('assets/images/close.png');
$custom_css = <<<CSS
	.canvas-overlay {
		cursor: url({$image_url}) 15 15, default;
	}
CSS;
G5Plus_Lustria()->custom_css()->addCss($custom_css,'canvas_overlay');

?>
<div class="canvas-overlay"></div>
