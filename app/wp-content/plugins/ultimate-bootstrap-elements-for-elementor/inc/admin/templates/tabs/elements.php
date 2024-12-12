<?php
if (!defined('ABSPATH')) {
    exit;
}
/**
 * @var $tab string
 */

$ube_elements = ube_get_setting_elements();
$document_link = UBE_DEMO_LINK;
?>
<div class="ube-admin-tab-<?php echo esc_attr($tab) ?>">
	<form action="" method="post">
        <?php foreach (ube_get_element_configs() as $group_key => $group_data): ?>
			<h2 class="ube-admin-h2"><?php echo esc_html($group_data['title']) ?></h2>
			<div class="ube-admin-row">
                <?php foreach ($group_data['items'] as $el_key => $el_value): ?>
					<?php
					$el_demo = isset($el_value['demo']) && !empty($el_value['demo'])
						? UBE_DEMO_LINK . '/' . $el_value['demo']  . '/'
						: UBE_DEMO_LINK;

					$el_document = isset($el_value['document']) && !empty($el_value['document']) ? $el_value['document'] : $document_link;
					?>
					<div class="ube-admin-col ube-admin-col-4">
						<div class="ube-admin-el-item">
							<h4><?php echo esc_html($el_value['title']) ?></h4>
							<div class="ube-admin-el-item-link">
								<a target="_blank" href="<?php echo esc_url($el_demo) ?>" title="<?php echo esc_attr__('View Demo', 'ube') ?>">
									<i class="dashicons dashicons-welcome-view-site"></i>
								</a>
								<a target="_blank" href="<?php echo esc_url($el_document) ?>" title="<?php echo esc_attr__('Documentation', 'ube') ?>">
									<i class="dashicons dashicons-external"></i>
								</a>
							</div>
							<label class="ube-admin-el-item-input ube-admin-toggle">
								<input type="checkbox" name="ube_elements[<?php echo esc_attr($el_key) ?>]"
                                    <?php checked(isset($ube_elements[$el_key]) ? $ube_elements[$el_key] : '1', '1') ?>
									   value="1">
								<div data-on="<?php echo esc_attr__('On', 'ube') ?>"
									 data-off="<?php echo esc_attr__('Off', 'ube') ?>">
									<span></span>
								</div>
							</label>
						</div>
					</div>
                <?php endforeach; ?>
			</div>
        <?php endforeach; ?>
		<p class="ube-mt-5">
			<?php wp_nonce_field('save_setting_elements_action', 'save_setting_elements_nonce') ?>
			<button type="submit" class="button button-primary"><?php echo esc_html__('Save Changed', 'ube'); ?></button>
		</p>
	</form>
</div>
