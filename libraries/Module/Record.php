<?php

class Module_Record extends Module 
{
	public function indexAction()
	{
		$model = new Model_Record();
		$items = $model->get();
		
		return array("records" => $items);	
	}
	
	public function getAction()
	{
		$params = Request::getParams();

		$model = new Model_Record();
		$items = $model->getByParams($params);

		return array("records" => $items);
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