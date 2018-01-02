<?php
header('Content-Type: text/plain');

$database_file = 'wordpress-tags-database.sqlite';
$dbh = new PDO("sqlite:{$database_file}");

/**
 * Sort by popularity
 */
$statement = $dbh->query("SELECT * FROM tags ORDER BY tag_popularity DESC;", PDO::FETCH_ASSOC);
echo "## Sorted by Popularity\r\n\r\n";
echo "Tag Name         | Popularity | Tag Link\r\n";
echo "-----------------|-----------:|---------\r\n";
while($row=$statement->fetch()) {
	echo sprintf("%-16s | %10s | [%s](%s)", $row['tag_name'], $row['tag_popularity'], $row['tag_link'], $row['tag_link']);
	echo "\r\n";
}

/**
 * Sort by name
 */
echo "\r\n\r\n\r\n";
echo "## Sorted by Tag Name\r\n\r\n";
echo "Tag Name         | Popularity | Tag Link\r\n";
echo "-----------------|-----------:|---------\r\n";
$statement = $dbh->query("SELECT * FROM tags ORDER BY tag_name ASC;", PDO::FETCH_ASSOC);
while($row=$statement->fetch()) {
	echo sprintf("%-16s | %10s | [%s](%s)", $row['tag_name'], $row['tag_popularity'], $row['tag_link'], $row['tag_link']);
	echo "\r\n";
}
