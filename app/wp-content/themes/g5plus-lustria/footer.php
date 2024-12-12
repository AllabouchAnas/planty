<?php
/**
 * The template for displaying footer.php
 *
 */
/**
 * @hooked - G5Plus_Lustria()->templates()->content_wrapper_end() - 1
 **/
do_action('g5plus_main_wrapper_content_end');
?>
</div><!-- Close Wrapper Content -->
<?php
/**
 * @hooked - G5Plus_Lustria()->templates()->footer() - 5
 */
do_action('g5plus_after_page_wrapper_content');
?>
</div><!-- Close Wrapper -->
<?php
/**
 * @hooked - G5Plus_Lustria()->templates()->back_to_top() - 5
 **/
do_action('g5plus_after_page_wrapper');
?>
<?php wp_footer(); ?>
</body>
</html> <!-- end of site. what a ride! -->

