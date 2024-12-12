<?php
/**
 * The template for displaying cat-filter.php
 *
 * @var $settingId
 * @var $pagenum_link
 * @var $filter_vertical
 * @var $post_type
 * @var $category_filter
 * @var $current_cat
 * @var $taxonomy
 */
$args = array(
	'hide_empty'	=> 1,
    'taxonomy' => $taxonomy,
);

if (is_array($category_filter)){
    $args['include'] = $category_filter;
    $args['orderby'] = 'include';
}

$prettyTabsOptions = array(
    'more_text' => wp_kses_post(__('More', 'g5plus-lustria'))
);


$cate_attributes = array();
if($filter_vertical == true) {
    $cate_attributes[] = 'data-filter-vertical=1';
} else {
    $cate_attributes[] = 'data-filter-vertical=0';
}

$categories = get_categories( apply_filters('gsf_category_filter_args',$args, $taxonomy ));
?>
<ul data-id="<?php echo esc_attr($settingId); ?>" data-items-cate class="nav nav-tabs gf-cate-filter <?php echo esc_attr($filter_vertical === true ? '' : 'gsf-pretty-tabs'); ?>" <?php echo implode(' ',$cate_attributes); ?> data-pretty-tabs-options='<?php echo esc_attr(json_encode($prettyTabsOptions)); ?>'>
    <?php
    $cate_link = trailingslashit(get_post_type_archive_link($post_type));
    ?>
    <li class="<?php echo esc_attr(-1 == $current_cat ? ' active' : '') ?>">
        <a data-id="-1" data-name=""
           title="<?php esc_attr_e('All', 'g5plus-lustria') ?>" class="no-animation transition03 gsf-link" href="<?php echo esc_url($cate_link); ?>"><?php esc_html_e('All', 'g5plus-lustria') ?></a>
    </li>
    <?php foreach ($categories as $category):
        $cate_link = trailingslashit(get_term_link($category));
        ?>
        <li class="<?php echo esc_attr($category->cat_ID == $current_cat ? ' active' : '') ?>">
            <a data-id="<?php echo esc_attr($category->cat_ID); ?>"  data-name="<?php echo esc_attr($category->slug); ?>" title="<?php echo esc_attr($category->name) ?>" class="no-animation transition03 gsf-link"
               href="<?php echo esc_url($cate_link) ?>"><?php echo esc_html($category->name)?></a>
        </li>
    <?php endforeach; ?>
</ul>