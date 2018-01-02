<?php
header('Content-Type: text/plain');

$heatmap_file = 'heatmap-'.date('Y-m-d').'.html';
if(!is_file($heatmap_file))
{
	echo "\r\nUsing live\r\n";
	$tags_html = file_get_contents('https://wordpress.org/plugins/tags/');
	file_put_contents($heatmap_file, $tags_html);
}
else
{
	echo "\r\nUsing local\r\n";
	$tags_html = file_get_contents($heatmap_file);
}

/**
 * @todo Pattern may change
 */
$pattern = "#<a href='(.*?)' title='(.*?) topics' rel='tag' style='.*?'>(.*?)</a>#is";

$tags = array();
preg_match_all($pattern, $tags_html, $tags, PREG_SET_ORDER);

$database_file = 'wordpress-tags-database.sqlite';
if(is_file($database_file))
{
	unlink($database_file);
}
$dbh = new PDO("sqlite:{$database_file}");

$dbh->query('PRAGMA auto_vacuum = FULL;');
$dbh->query('DROP TABLE tags;');
$dbh->query('CREATE TABLE tags (
	tag_name VARCHAR(255),
	tag_popularity INTEGER,
	tag_link VARCHAR(255)
);');
foreach($tags as $t => $tag)
{
	$tag = array_map('html_entity_decode', $tag);
	$tag = array_map('addslashes', $tag);
	$dbh->query("INSERT INTO tags VALUES('{$tag[3]}', '{$tag[2]}', '{$tag[1]}');");
}
$dbh->query('VACUUM tags;');
