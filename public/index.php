<?php
/**
 * public/index.php
 * 
 * @author Big Ginger Nerd
 * @package ginger-pdns-api
 */
define("APPLICATION_PATH", realpath(dirname(__FILE__))."/../");
set_include_path(get_include_path() . PATH_SEPARATOR . APPLICATION_PATH);

include("config/config.php");


$request = new Request();

Response::Dispatch();
