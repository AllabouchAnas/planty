<?php
/**
 * The template for displaying dashboard
 *
 * @var $current_page
 */
$pages_settings = G5P()->core()->dashboard()->get_config_pages();
$current_theme = wp_get_theme();
?>
<?php if (G5P()->core()->dashboard()->plugins()->do_plugin_install()): ?>
    <script type="text/javascript">
        window.location = "admin.php?page=gsf_plugins";
    </script>
<?php endif; ?>

<div class="gsf-dashboard wrap">
    <h2 class="screen-reader-text"><?php printf(esc_html__('%s Dashboard', 'lustria-framework'), $current_theme['Name']) ?></h2>
	<?php G5P()->helper()->getTemplate('core/dashboard/templates/tabs', array('current_page' => $current_page)); ?>
	<div class="gsf-dashboard-content">
			<?php G5P()->helper()->getTemplate("core/dashboard/templates/{$current_page}") ?>
	</div>
</div>

