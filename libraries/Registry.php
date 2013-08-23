<?php
/**
 * library/Registry.php 
 * 
 * @author Martijn van Maasakkers, martijn@vanmaasakkers.net
 */
 
/**
 * A "global" registry handler.
 *
 * @package Dashboard 
 * @subpackage System
 */
class Registry
{
	/**
	 * namespace
	 * 
	 * (default value: "netvlies")
	 * 
	 * @var string
	 * @access private
	 * @static
	 */
	private static $namespace = "blue42";
		
	/**
	 * get function.
	 * 
	 * @access public
	 * @static
	 * @param string $key
	 * @return mixed
	 */
	public static function get($key)
	{
		self::init();
		return (isset($GLOBALS[self::$namespace][$key])) ? $GLOBALS[self::$namespace][$key] : false;
	}
	
	/**
	 * set function.
	 * 
	 * @access public
	 * @static
	 * @param string $key
	 * @param mixed $value
	 * @return void
	 */
	public static function set($key, $value)
	{
		self::init();
		$GLOBALS[self::$namespace][$key] = $value;
	}

	/**
	 * exists function.
	 * 
	 * @access public
	 * @static
	 * @param string $key
	 * @return boolean
	 */
	public static function exists($key)
	{
		self::init();
		return (isset($GLOBALS[self::$namespace][$key])) ? true : false;
	}
	
	/**
	 * init function.
	 * 
	 * @access public
	 * @static
	 * @return void
	 */
	public static function init()
	{
		if(!isset($GLOBALS[self::$namespace]))
		{
			$GLOBALS[self::$namespace] = array();
		}	
	}
}