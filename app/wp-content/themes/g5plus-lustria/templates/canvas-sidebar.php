<?php
/**
 * The template for displaying canvas-sidebar
 */
$skin = G5Plus_Lustria()->options()->get_canvas_sidebar_skin();
$wrapper_classes = array(
	'canvas-sidebar-wrapper'
);

$inner_classes = array(
	'canvas-sidebar-inner',
	'sidebar'
);

$skin_classes = G5Plus_Lustria()->helper()->getSkinClass($skin,true);
$wrapper_classes = array_merge($wrapper_classes,$skin_classes);

$wrapper_class = implode(' ',array_filter($wrapper_classes));
$inner_class = implode(' ',array_filter($inner_classes));
?>
<div id="canvas-sidebar-wrapper" class="<?php echo esc_attr($wrapper_class); ?>">
    <a href="javascript:;" class="gsf-link close-canvas" title="<?php esc_attr_e('Close', 'g5plus-lustria'); ?>"><i class="fas fa-times"></i></a>
	<div class="<?php echo esc_attr($inner_class)?>">
		<?php if (is_active_sidebar('canvas')): ?>
			<?php dynamic_sidebar('canvas'); ?>
		<?php else: ?>
			<div class="gf-no-widget-content"> <?php printf(wp_kses_post(__('Please insert widget into sidebar <b>Canvas</b> in Appearance > <a title="manage widgets" href="%s">Widgets</a> ','g5plus-lustria')),admin_url( 'widgets.php' )); ?></div>
		<?php endif; ?>
	</div>
</div>
