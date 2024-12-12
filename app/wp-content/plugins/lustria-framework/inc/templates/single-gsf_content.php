<?php
/**
 * The template for displaying single-xxx.php
 *
 */
$options = &GSF()->adminThemeOption()->getOptions(G5P()->getOptionName());
$options['sidebar_layout'] = 'none';
$options['content_padding'] = array('left' => '', 'right' => '','top' => '50', 'bottom' => '50');
$options['content_full_width'] = 'on';
get_header();
	while (have_posts()) : the_post();?>
		<article id="post-<?php the_ID(); ?>" <?php post_class('page'); ?>>
			<div class="gf-entry-content clearfix">
				<?php the_content(); ?>
			</div>
		</article>
	<?php
	endwhile;
get_footer();