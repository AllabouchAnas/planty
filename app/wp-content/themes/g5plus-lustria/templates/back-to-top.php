<?php
/**
 * The template for displaying back-to-top
 *
 */
$back_to_top = G5Plus_Lustria()->options()->get_back_to_top();
if ($back_to_top !== 'on') return;
?>
<a class="back-to-top" href="javascript:;">
	<i class="fa fa-angle-up"></i>
</a>
