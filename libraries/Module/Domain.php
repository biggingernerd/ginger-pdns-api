<?php

class Module_Domain extends Module 
{
	public function indexAction()
	{
		$model = new Model_Domain();
		$items = $model->get();
		
		return array("domains" => $items);	
	}
	
	public function getAction()
	{
		$params = Request::getParams();

		$model = new Model_Domain();
		$items = $model->getByParams($params);

		return array("domains" => $items);
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