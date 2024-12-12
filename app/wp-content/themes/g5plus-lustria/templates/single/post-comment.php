<?php
/**
 * The template for displaying post-comment.php
 */
if ( comments_open() || get_comments_number() ) {
	comments_template();
}