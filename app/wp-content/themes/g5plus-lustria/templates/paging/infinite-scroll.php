<?php
/**
 * The template for displaying infinite-scroll.php
 * @var $settingId
 * @var $isMainQuery
 */
$paged   =  G5Plus_Lustria()->query()->query_var_paged();
$max_num_pages = G5Plus_Lustria()->query()->get_max_num_pages();
$paged = intval($paged) + 1;
if ($paged > $max_num_pages) return;
$next_link = $isMainQuery ?  get_next_posts_page_link($max_num_pages) : '#';
if (empty($next_link)) return;
?>
<div data-items-paging="infinite-scroll" class="gf-paging infinite-scroll clearfix text-center" data-id="<?php echo esc_attr($settingId) ?>">
	<a data-paged="<?php echo esc_attr($paged); ?>" class="no-animation transition03 gsf-link" href="<?php echo esc_url($next_link); ?>"></a>
</div>
