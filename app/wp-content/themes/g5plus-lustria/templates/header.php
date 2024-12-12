<?php
/**
 * The template for displaying header
 */
$header_enable = G5Plus_Lustria()->options()->get_header_enable();
if ($header_enable !== 'on') return;
G5Plus_Lustria()->helper()->getTemplate('header/desktop');
G5Plus_Lustria()->helper()->getTemplate('header/mobile');


