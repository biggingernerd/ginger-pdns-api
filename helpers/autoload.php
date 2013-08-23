<?php

/**
 * __autoload function.
 * 
 * @access public
 * @param string $class_name
 * @return void
 */
function __autoload($class_name) {
	$class_name = str_ireplace('_', '/', $class_name);
    include LIBRARIES_PATH. $class_name . '.php';
}

