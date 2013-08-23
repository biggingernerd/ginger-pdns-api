<?php

class Module_Domain extends Module 
{
	public function indexAction()
	{
/* 		return array("index" => "b"); */
	}
	
	public function getAction()
	{
		return array("get" => Request::getParams());
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