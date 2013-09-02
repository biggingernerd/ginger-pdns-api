<?php
/**
 * libraries/Request.php
 * 
 * @author Big Ginger Nerd
 * @package ginger-pdns-api
 */
 
class Request {
	
	private static $_hostname 	= false;
	private static $_uri 		= false;
	private static $_path 		= false;
	private static $_resource	= false;
	private static $_pathParts	= false;
	private static $_params 	= array();
	private static $_method		= false;
	private static $_action 	= false;
	
	
	public function __construct()
	{
		self::setHostname($_SERVER['SERVER_NAME']);
		self::setUri($_SERVER['REQUEST_URI']);
		self::setMethod($_SERVER['REQUEST_METHOD']);
		self::setPath($_SERVER['PATH_INFO']);
		self::loadParams();
	}

	public static function loadParams()
	{
		$path = substr(self::getPath(), strlen(self::$_resource));

		$path = (substr($path, 0, 1) == "/") ? substr($path, 1): $path;
		$path = (substr($path, -1) == "/") ? substr($path, 0, -1): $path;
	
		$parts = self::$_pathParts;

		if(count($parts) > 0)
		{
			foreach($parts as $key => $part)
			{
				if(($key % 2) == 1)
				{
					self::$_params[$parts[$key-1]] = urldecode($part);
				} else {
					if($part != "")
					{
						self::$_params[$part] = "";	
					}
					
				}
			}
		}
		$queryParams = array();
		if(self::getMethod() == "get")
		{
			$queryString = $_SERVER['QUERY_STRING'];
			parse_str($queryString, $queryParams);	
		} elseif(self::getMethod() == "post") {
			$queryParams = $_POST;
		} elseif(self::getMethod() == "put") {
			$queryParams = array();
			parse_raw_http_request($queryParams);
		}
		
		self::$_params = array_merge(self::$_params, $queryParams);
	}

	public static function setAction($action)
	{
		self::$_action = $action;
	}

	public static function getAction()
	{
		if(self::getMethod() == "get" && count(self::getParams()) == 0)
		{
			self::$_action = "index";
		} else {
			self::$_action = self::getMethod();
		}
		
		return self::$_action;
	}

	public static function setMethod($method)
	{
		self::$_method = strtolower($method);
	}
	
	public static function getMethod()
	{
		return self::$_method;
	}
	
	public static function setHostname($hostname)
	{
		self::$_hostname = $hostname;
	}
		
	public static function getHostname()
	{
		return self::$_hostname;
	}
	
	public static function setPath($path)
	{
		if(substr($path, 0, 1) == "/")
		{
			$path = substr($path, 1);
		}
		self::$_path = $path;
		$parts = explode("/", $path);
		if(count($parts) > 0)
		{
			self::$_resource = $parts[0];
			unset($parts[0]);
			$parts = array_values($parts);
			self::$_pathParts = $parts;
		}
	}
	
	public static function getPath()
	{
		return self::$_path;
	}
	
	public static function getResource()
	{
		if(self::$_resource == "")
		{
			self::$_resource = "index";
		}

		return self::$_resource;
	}
	
	public static function setUri($uri)
	{
		self::$_uri = $uri;
	}
	
	public static function getUri()
	{
		return self::$_uri;
	}
	
	public static function getParams()
	{
		return self::$_params;
	}
	
	public static function getParam($key)
	{
		if(isset(self::$_params[$key]))
		{
			return self::$_params[$key];
		} else {
			return false;
		}
	}
	
}
