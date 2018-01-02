@echo off

echo Building the database
php -f parse.php

echo Writing the .md file
php -f view.php > wordpress-popular-tags-for-plugins.md

echo Putting current date
php -f replace.php >> wordpress-popular-tags-for-plugins.md
