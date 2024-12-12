<?php
if (!defined('ABSPATH')) {
    exit;
}
/**
 * @var $tab string
 */
?>
<div class="ube-admin-tab-<?php echo esc_attr($tab) ?>">
    <form action="" method="post">
		<?php foreach (ube_get_api_configs() as $site_id => $config): ?>
			<h2><?php echo esc_html($config['label']) ?></h2>
			<table class="form-table">
				<tbody>
				<?php foreach ($config['fields'] as $id => $label): ?>
				<?php $field_id = "{$site_id}_{$id}"; ?>
					<tr>
						<th class="row">
							<label for="<?php echo esc_attr($field_id) ?>">
								<?php echo esc_html($label) ?>
							</label>
						</th>
						<td>
							<input id="<?php echo esc_attr($field_id) ?>" type="text" class="regular-text"
								   name="ube_api[<?php echo esc_attr($field_id) ?>]"
								   value="<?php echo esc_attr(ube_get_setting_integrated_api($field_id)) ?>">
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
			<?php if (!empty($config['desc'])): ?>
				<p class="description"><?php echo wp_kses_post($config['desc']) ?></p>
			<?php endif; ?>
		<?php endforeach; ?>

        <p class="ube-mt-5">
            <?php wp_nonce_field('save_setting_api_action', 'save_setting_api_nonce') ?>
            <button type="submit" class="button button-primary"><?php echo esc_html__('Save Changed', 'ube'); ?></button>
        </p>
    </form>
</div>
