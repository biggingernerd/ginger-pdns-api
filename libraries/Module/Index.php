<?php

class Module_Index extends Module 
{
	public function indexAction()
	{
		return array("index" => "index");	
	}
	
	public function getAction()
	{
		return array("get" => "get");
	}
	
	public function postAction()
	{
		return array("post" => Request::getParams());
	}

	public function putAction()
	{
		return array("put" => Request::getParams());
	}
	
	public function deleteAction()
	{
		return array("delete" => Request::getParams());
	}
	
	public function headAction()
	{
		return array("head" => Request::getParams());
	}
}