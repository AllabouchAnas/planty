<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
$current_theme = wp_get_theme();
$features = G5P()->core()->dashboard()->welcome()->get_features();
?>
<div class="gsf-message-box">
    <h1 class="welcome"><?php esc_html_e('Welcome to', 'lustria-framework') ?> <span
                class="gsf-theme-name"><?php echo esc_html($current_theme['Name']) ?></span> <span
                class="gsf-theme-version">v<?php echo esc_html($current_theme['Version']) ?></span></h1>
    <p class="about"><?php esc_html_e('Thank you for choosing the best theme we have ever build! we did a lot of pressure to release this great product and we will offer our 5 star support to this theme for fixing all the issues and adding more features.', 'lustria-framework'); ?></p>
</div>

<div class="gsf-message-box" style="border-bottom: none;">
    <h3 class="welcome" style="font-size: 28px;"><?php esc_html_e('Quick Start','lustria-framework') ?></h3>
    <p><?php echo wp_kses_post(sprintf(__('You can start using theme simply by installing Visual Composer plugin. Also there is more plugins for social counter, post views, ads manager ... that you can install them from our <a href="%s">plugin installer</a>.','lustria-framework'),admin_url('admin.php?page=gsf_plugins'))) ?></p>
    <p><?php echo wp_kses_post(sprintf(__('If you need setup your site like %s demos, you can use the <a href="%s">Demo Installer</a> that can do it for you with only <em>one click</em>','lustria-framework'),$current_theme['Name'],admin_url('admin.php?page=gsf_install_demo'))) ?></p>
</div>
<div class="gsf-feature-section gsf-row">
    <?php foreach($features as $feature): ?>
        <div class="gsf-feature-box gsf-col-6">
            <div class="gsf-box">
                <div class="gsf-box-head">
                    <?php if (isset($feature['icon']) && !empty($feature['icon'])): ?>
                        <i class="<?php echo esc_attr($feature['icon']) ?>"></i>
                    <?php endif; ?>
                    <span><?php echo esc_html($feature['label'])?></span>
                </div>
                <div class="gsf-box-body">
                    <?php echo esc_html($feature['description']); ?>
                </div>
                <div class="gsf-box-footer">
                    <a href="<?php echo esc_url($feature['button_url']) ?>" class="button button-large button-primary" target="_blank"><?php echo esc_html($feature['button_text'])?></a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
