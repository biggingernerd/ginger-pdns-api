<?php
ini_set('date.timezone', 'UTC');

define("LIBRARIES_PATH", APPLICATION_PATH."libraries/");
define("MODULES_PATH", APPLICATION_PATH."modules/");



include("includes.php");

if(!is_file(APPLICATION_PATH."config/database.php"))
{
	echo "Database config file not found. Use database.php.dist to create one.";
	
	die();
}
include("database.php");
