<?php
/**
 * library/Rest/Response/Status.php 
 * 
 * @author Martijn van Maasakkers, martijn@vanmaasakkers.net
 */


/**
 * Rest_Response_Status class.
 * 
 * @package NI Api
 * @subpackage Rest
 */
class Response_Status
{
	
	/**
	 * _list
	 * 
	 * @var mixed
	 * @access private
	 * @static
	 */
	private static $_list = array(
										200 => "OK",
										201 => "Created",
										202 => "Accepted",
										// 203 => "",
										204 => "No Content",
										
										300 => "Multiple Choices",
										301 => "Moved Permanently",
										302 => "Found",
										303 => "See Other",
										304 => "Not Modified",
    									305 => "Use Proxy",
										
										400 => "Bad Request",
										401 => "Unauthorized",
										402 => "Payment Required",
										403 => "Forbidden",
										404 => "Not Found",
										405 => "Method Not Allowed",
										406 => "No Acceptable",
										407 => "Proxy Authentication Required",
    									408 => "Request Timeout",
    									409 => "Conflict",
										410 => "Gone",
										418 => "I'm a teapot",
										420 => "Enhance Your Calm",
										
										500 => "Internal Server Error",
										501 => "Not Implemented",
										502 => "Bad Gateway",
										503 => "Service Unavailable",
										);
	
	
	/**
	 * getMessage function.
	 * 
	 * @access public
	 * @static
	 * @param mixed $code
	 * @return string
	 */
	public static function getMessage($code)
	{
		if(!isset(self::$_list[$code]))
		{
			$code = 200;
		}
		
		return self::$_list[$code];
	}
	
	
	/**
	 * getHeader function.
	 * 
	 * @access public
	 * @static
	 * @param mixed $code
	 * @return string
	 */
	public static function getHeader($code)
	{
		if(!isset(self::$_list[$code]))
		{
			$code = 200;
		}
		
		$message = self::$_list[$code];
		
		return sprintf("HTTP/1.1 %d %s", $code, $message);		
	}
	
}
