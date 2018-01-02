<?php
/**
 * Converts the date placeholder into current date
 */
$footer = file_get_contents('footer.md');
$footer = preg_replace('/[\d]{4}-[\d]{2}-[\d]{2}/', date('Y-m-d'), $footer);
echo $footer;
