<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
$plugins = G5P()->core()->dashboard()->plugins()->get_plugins();
?>
<div class="gsf-message-box">
    <h4 class="gsf-heading"><?php esc_html_e('Premium and Included Plugins','lustria-framework') ?></h4>
    <p><?php esc_html_e('Install the included plugins with ease using this panel. All the plugins are well tested to work with the theme and we keep them up to date. The themes comes packed with the following plugins:', 'lustria-framework') ?></p>
</div>
<div class="gsf-plugins-section gsf-row">
    <?php foreach($plugins as $plugin): ?>
        <?php
            if ($plugin['slug'] === 'magpro-framework') continue;
            $plugin_classes = array(
                'gsf-col',
                'gsf-col-4'
            );
            if (G5P()->core()->dashboard()->plugins()->is_plugin_installed($plugin['slug'])) {
                if (G5P()->core()->dashboard()->plugins()->is_plugin_active($plugin['slug'])) {
                    if (G5P()->core()->dashboard()->plugins()->does_plugin_have_update($plugin['slug'])) {
                        $plugin['status'] = 'update';
                    } else {
                        $plugin['status'] = 'activate';
                    }
                } else {
                    $plugin['status'] = 'deactived';
                }
            } else {
                $plugin['status'] = 'not-installed';
            }

            $plugin['img'] = G5P()->pluginDir("/assets/images/plugins/{$plugin['slug']}.jpg");
            if (!file_exists($plugin['img'])) {
                $plugin['img'] = G5P()->pluginUrl('assets/images/plugin-default.jpg');
            } else {
                $plugin['img'] = G5P()->pluginUrl("/assets/images/plugins/{$plugin['slug']}.jpg");
            }


            $plugin_classes[] = $plugin['status'];
            $plugin_class = implode(' ', $plugin_classes);
        ?>
        <div class="<?php echo esc_attr($plugin_class); ?>">
            <div class="gsf-box">
                <?php if ($plugin['required']): ?>
                    <label class="gsf-ribbon required"><?php esc_html_e('Required','lustria-framework') ?></label>
                <?php endif; ?>
                <?php if ($plugin['status'] === 'activate'): ?>
                    <label class="gsf-ribbon status"><?php esc_html_e('active','lustria-framework'); ?></label>
                <?php endif; ?>
                <figure>
                    <img src="<?php echo esc_url($plugin['img']) ?>" alt="<?php echo esc_attr($plugin['name']) ?>">
                </figure>
                <div class="gsf-box-body">
                    <div class="gsf-box-content">
                        <h4><?php echo esc_html($plugin['name']) ?> <span class="version"><?php echo esc_html($plugin['version'])?></span></h4>
                        <?php if ($plugin['status'] === 'not-installed'): ?>
                            <a href="<?php echo esc_url(G5P()->core()->dashboard()->plugins()->get_actions_link('install',$plugin['slug'])) ?>" class="button button-large button-primary"><?php esc_html_e('Install','lustria-framework') ?></a>
                        <?php endif; ?>
                        <?php if ($plugin['status'] === 'deactived'): ?>
                            <a href="<?php echo esc_url(G5P()->core()->dashboard()->plugins()->get_actions_link('activate',$plugin['slug'])) ?>" class="button button-large button-primary"><?php esc_html_e('Activate','lustria-framework') ?></a>
                        <?php endif; ?>
                        <?php if ($plugin['status'] === 'activate'): ?>
                            <a href="<?php echo esc_url(G5P()->core()->dashboard()->plugins()->get_actions_link('deactived',$plugin['slug'])) ?>" class="button button-large button-secondary"><?php esc_html_e('Deactivate','lustria-framework') ?></a>
                        <?php endif; ?>
                        <?php if ($plugin['status'] === 'update'): ?>
                            <a href="<?php echo esc_url(G5P()->core()->dashboard()->plugins()->get_actions_link('update',$plugin['slug'])) ?>" class="button button-large button-primary"><?php esc_html_e('Update','lustria-framework') ?></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>