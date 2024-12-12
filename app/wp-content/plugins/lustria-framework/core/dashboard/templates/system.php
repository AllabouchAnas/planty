<?php
/**
 * The template for displaying system-report
 *
 * @package WordPress
 * @subpackage lustria
 * @since lustria 1.0
 */

$settings = G5P()->core()->dashboard()->system_status()->get_settings();
?>
<div class="gsf-box gsf-copy-system-status">
	<div class="gsf-box-head">
		<?php esc_html_e('Get System Report', 'lustria-framework') ?>
	</div>
	<ul class="gsf-system-status-list gsf-clearfix">
		<li class="gsf-clearfix gsf-system-status-info">
			<div class="gsf-clearfix gsf-system-info">
				<div class="gsf-label"><a href="#" class="button-primary gsf-debug-report"><?php esc_html_e('Get System Report', 'lustria-framework') ?></a></div>
				<div class="gsf-info"><?php esc_html_e('Click the button to produce a report, then copy and paste into your support ticket.', 'lustria-framework') ?></div>
			</div>
			<div class="gsf-system-report">
				<textarea rows="20" id="system-report" name="system-report"></textarea>
				<a href="javascript:;" class="button-primary gsf-copy-system-report"><?php esc_html_e('Copy for Support', 'lustria-framework') ?></a>
			</div>
		</li>
	</ul>
</div>
<?php foreach ($settings as $setting): ?>
	<div class="gsf-box">
		<?php if (isset($setting['label']) && (!empty($setting['label']))): ?>
			<div class="gsf-box-head">
				<?php echo esc_html($setting['label']) ?>
			</div>
		<?php endif; ?>
		<?php if (isset($setting['fields']) && is_array($setting['fields'])): ?>
			<ul class="gsf-system-status-list gsf-clearfix">
				<?php foreach ($setting['fields'] as $field): ?>
					<?php if (isset($field['content']) && !empty($field['content'])): ?>
						<li class="gsf-clearfix">
							<?php if (isset($field['label']) && !empty($field['label'])): ?>
								<div class="gsf-label"><?php echo wp_kses_post($field['label']) ?></div>
							<?php endif; ?>
							<div class="gsf-info">
								<?php
								$icons = 'dashicons-editor-help';
								if (isset($field['content']['status'])) {
									if ($field['content']['status'] === false) {
										$icons = 'dashicons-dismiss';
									}
								}
								if (isset($field['content']['html'])) {
									$field['content'] = $field['content']['html'];
								}
								?>
								<?php if (isset($field['help']) && !empty($field['help'])): ?>
									<a href="#" class="gsf-help gsf-tooltip dashicons <?php echo esc_attr($icons) ?>" title="<?php echo esc_attr($field['help']) ?>"></a>
								<?php endif; ?>
								<?php echo wp_kses_post($field['content']); ?>
							</div>
						</li>
					<?php endif; ?>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>
<?php endforeach; ?>


