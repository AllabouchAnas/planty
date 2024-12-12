<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $current_page
 */
$pages_settings = G5P()->core()->dashboard()->get_config_pages();
?>
<div class="gsf-dashboard-tab-wrapper">
	<ul class="gsf-dashboard-tab">
		<?php foreach ($pages_settings as $key => $value): ?>
			<?php
			$href = isset($value['link']) ? $value['link'] :  admin_url("admin.php?page=gsf_{$key}");
			?>
			<li class="<?php echo esc_attr(($current_page === $key) ? 'active' : '') ?>">
				<a href="<?php echo esc_url($href) ?>"><?php echo esc_html($value['menu_title']) ?></a>
			</li>
		<?php endforeach; ?>
	</ul>
</div>