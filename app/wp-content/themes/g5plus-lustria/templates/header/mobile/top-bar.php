<?php
/**
 * The template for displaying top-bar
 *
 */
$top_bar_enable = G5Plus_Lustria()->options()->get_mobile_top_bar_enable();
if ($top_bar_enable !== 'on') return;
$content_block = G5Plus_Lustria()->options()->get_mobile_top_bar_content_block();
if (empty($content_block)) return;
?>
<div class="mobile-top-bar">
    <?php echo G5Plus_Lustria()->helper()->content_block($content_block);?>
</div>
