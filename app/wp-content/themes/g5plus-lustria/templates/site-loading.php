<?php
/**
 * The template for displaying site-loading.php
 */
$loading_animation = G5Plus_Lustria()->options()->get_loading_animation();
if (empty($loading_animation)) return;
$logo_loading = G5Plus_Lustria()->options()->get_loading_logo();
$loading_animation_allow = array();
if (function_exists('G5P')) {
    $loading_animation_allow = array_keys(G5P()->settings()->get_loading_animation());
}
?>
<div class="site-loading">
	<div class="block-center">
		<div class="block-center-inner">
			<?php if (isset($logo_loading['url']) && !empty($logo_loading['url'])): ?>
				<img class="logo-loading" alt="<?php esc_attr_e('Logo Loading','g5plus-lustria') ?>" src="<?php echo esc_url($logo_loading['url']) ?>" />
			<?php endif; ?>
			<?php if (in_array($loading_animation,$loading_animation_allow)) {
                G5Plus_Lustria()->helper()->getTemplate("loading/{$loading_animation}");
            }  ?>
		</div>
	</div>
</div>
