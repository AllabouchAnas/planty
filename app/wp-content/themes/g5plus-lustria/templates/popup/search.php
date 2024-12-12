<?php
/**
 * The template for displaying search
 */
$ajax_nonce = wp_create_nonce("search_popup_nonce");
?>
<div data-search-ajax="true" data-search-ajax-action="search_popup"
     data-search-ajax-nonce="<?php echo esc_attr($ajax_nonce) ?>" id="search-popup"
     class="search-popup-wrap mfp-hide mfp-with-anim">
    <?php $post_type = G5Plus_Lustria()->options()->get_search_popup_post_type();?>
	<form action="<?php echo esc_url(home_url('/')) ?>" method="get" class="search-popup-form clearfix">
		<input data-search-ajax-control="input" name="s" class="search-popup-field" type="search"
		       placeholder="<?php esc_attr_e('Type at least 3 characters to search', 'g5plus-lustria') ?>"
		       autocomplete="off">
        <?php if(count($post_type) == 1 && $post_type[0] == 'product'): ?>
            <input type="hidden" name="post_type" value="product">
        <?php endif; ?>
		<button type="submit" class="search-popup-button" ><i data-search-ajax-control="icon" class="fal fa-search"></i></button>
	</form>
	<div data-search-ajax-control="result" class="search-popup-result"></div>
</div>
