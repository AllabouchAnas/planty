<?php
$index = 0;
?>
<div class="gsf-fonts-wrapper wrap">
    <div class="gsf-font-header">
        <h1><?php esc_html_e('Fonts Management','lustria-framework'); ?></h1>
    </div>
    <div class="gsf-font-content">
        <div class="gsf-font-listing">
            <h4 class="gsf-title">
                <span><?php esc_html_e('Available Fonts','lustria-framework'); ?></span>
                <input id="search_fonts" type="text" placeholder="<?php esc_attr_e('Search fonts...','lustria-framework'); ?>"/>
            </h4>
            <div class="gsf-font-listing-inner">
                <ul class="gsf-font-type gsf-clearfix">
                    <?php foreach (GSF()->core()->fonts()->getFontSources() as $key => $value): ?>
                        <?php if ($index): ?>
                            <li><a href="#" data-ref="<?php echo esc_attr($key); ?>"><?php echo esc_html($value) ?></a></li>
                        <?php else:; ?>
                            <li class="active"><a href="#" data-ref="<?php echo esc_attr($key); ?>"><?php echo esc_html($value) ?></a></li>
                        <?php endif;?>
                        <?php $index++; ?>
                    <?php endforeach;?>
                </ul>
            </div>
        </div>
        <div class="gsf-font-active">
            <h4 class="gsf-title"><?php esc_html_e('Active Fonts','lustria-framework'); ?> <button class="button gsf-reset-active-fonts" type="button"><i class="fas fa-recycle"></i> <?php esc_html_e('Reset Fonts','lustria-framework'); ?></button></h4>
            <div class="gsf-font-active-listing">

            </div>
        </div>
    </div>
</div>