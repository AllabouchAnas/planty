<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$tab = isset($_REQUEST['_tab']) ? sanitize_text_field($_REQUEST['_tab']) : 'welcome';

$available_tabs = array('welcome', 'elements', 'ui-style');
if (!in_array($tab, array_keys(ube_get_admin_setting_tabs()))) {
	$tab = 'welcome';
}
?>
<div class="wrap">
    <h1><?php echo esc_html__('UBE Settings', 'ube') ?></h1>
	<?php ube_get_admin_template('tabs.php', array('tab' => $tab)); ?>
	<div class="ube-admin-wrap">
        <?php ube_get_admin_template('tabs/' . $tab . '.php', array('tab' => $tab)); ?>
	</div>
</div>