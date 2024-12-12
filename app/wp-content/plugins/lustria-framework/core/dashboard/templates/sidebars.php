<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
$index = 0;
$sidebars = G5P_Dashboard_Widget_Areas::getInstance()->get_widget_areas();
?>
<div class="gsf-message-box">
	<h4 class="gsf-heading"><?php esc_html_e('Sidebars Management','lustria-framework') ?></h4>
	<p><?php esc_html_e('Manager custom sidebars', 'lustria-framework') ?></p>
</div>
<div class="wrap gsf-sidebars-wrap">
	<div class="gsf-sidebars-row">
		<div class="gsf-sidebars-col-left">
			<div id="gsf-add-widget">
				<div class="sidebar-name">
					<h3><?php esc_html_e('Create Widget Area', 'lustria-framework'); ?></h3>
				</div>
				<div class="sidebar-description">
					<form id="addWidgetAreaForm" action="" method="post">
						<div class="widget-content">
							<input id="gsf-add-widget-input" name="gsf-add-widget-input" type="text" class="regular-text" required="required"
							       title="<?php echo esc_attr(esc_html__('Name','lustria-framework')); ?>"
							       placeholder="<?php echo esc_attr(esc_html__('Name','lustria-framework')); ?>" />
						</div>
						<div class="widget-control-actions">
							<?php wp_nonce_field('gsf_add_sidebar_action', 'gsf_add_sidebar_nonce') ?>
							<input class="gsf-sidebar-add-sidebar button button-primary button-hero" type="submit" value="<?php echo esc_attr(esc_html__('Create Widget Area', 'lustria-framework')); ?>" />
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="gsf-sidebars-col-right">
			<table class="wp-list-table widefat fixed striped table-view-list">
				<thead>
					<tr>
						<th style="width: 50px">#</th>
						<th><?php echo esc_html__('Name','lustria-framework') ?></th>
						<th style="width: 100px"></th>
					</tr>
				</thead>
				<tbody>
					<?php if ($sidebars): ?>
						<?php foreach ($sidebars as $k => $v): $index++; ?>
							<tr>
								<td><?php echo esc_html($index) ?></td>
								<td><?php echo esc_html($v) ?></td>
								<td>
									<button type="button" class="button button-small button-secondary gsf-sidebars-remove-item"
									        data-id="<?php echo esc_attr($k) ?>">
										<?php echo esc_html__('Remove','lustria-framework') ?>
									</button>
								</td>
							</tr>
						<?php endforeach; ?>
					<?php else: ?>
						<tr>
							<td colspan="3">
								<?php echo esc_html__('No Sidebars defined','lustria-framework') ?>
							</td>
						</tr>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>