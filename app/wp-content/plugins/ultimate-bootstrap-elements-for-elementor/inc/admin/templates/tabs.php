<?php
if (!defined('ABSPATH')) {
    exit;
}
/**
 * @var $tab string
 */
$setting_url = admin_url('admin.php?page=ube-settings');
?>
<nav class="nav-tab-wrapper">
	<?php foreach (ube_get_admin_setting_tabs() as $key => $value): ?>
		<a href="<?php echo esc_url(add_query_arg('_tab', $key, $setting_url)) ?>" class="nav-tab <?php echo ($tab === $key) ? 'nav-tab-active' : '' ?>">
            <?php echo esc_html($value) ?>
		</a>
	<?php endforeach; ?>
</nav>