<?php
/**
 * The template for displaying load-more.php
 *
 * @var $settingId
 * @var $pagenum_link
 * @var $isMainQuery
 */
$paged =  G5Plus_Lustria()->query()->query_var_paged();
$max_num_pages = G5Plus_Lustria()->query()->get_max_num_pages();
$next_link = $isMainQuery ?  get_next_posts_page_link($max_num_pages) : '#';
$paged = intval($paged) + 1;
if ($paged > $max_num_pages) return;
$accent_color = G5Plus_Lustria()->options()->get_accent_color();
?>
<div data-items-paging="load-more" class="gf-paging load-more clearfix text-center" data-id="<?php echo esc_attr($settingId) ?>">
    <a data-paged="<?php echo esc_attr($paged); ?>" data-style="zoom-in" data-spinner-size="20" data-spinner-color="<?php echo esc_attr($accent_color); ?>" class="no-animation btn btn-gray  btn-outline btn-square btn-icon btn-icon-left" href="<?php echo esc_url($next_link); ?>">
        <i class="fal fa-plus"></i> <?php esc_html_e('More', 'g5plus-lustria') ?>
    </a>
</div>
