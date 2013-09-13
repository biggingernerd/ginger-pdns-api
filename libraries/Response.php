<?php

class Response {
	
	private static $_status				= 200;
	
	public static function Dispatch()
	{
		$moduleClassName = "Module_".ucfirst(Request::getResource());
		$actionFunctionName = Request::getAction()."Action";

		if(!method_exists($moduleClassName, $actionFunctionName))
		{
			throw new Exception('Resource not found');
		}
		
		$module = new $moduleClassName();
		$module->init();
		$module->preDispatch();
		$retval = $module->$actionFunctionName();
		$module->postDispatch();
		$module->close();
		
		if(!is_array($retval) && !is_object($retval))
		{
			if(is_null($retval))
			{
				$retval = true;				
			}
			$retval = array("data" => $retval);
		}
		
		header(Response_Status::getHeader(self::getStatus()), true, self::getStatus());
		header('Content-Type: application/json; Charset: UTF-8');
		echo json_encode($retval);
	}
	
	public static function setStatus($status = 200)
	{
		self::$_status = $status;
	}
	
	public static function getStatus()
	{
		return self::$_status;
	}
	
}