<?php

class Module_Supermaster extends Module 
{
	public function indexAction()
	{
		$model = new Model_Supermaster();
		$items = $model->get();
		
		return array("supermasters" => $items);	
	}
	
	public function getAction()
	{
		$params = Request::getParams();

		$model = new Model_Supermaster();
		$items = $model->getByParams($params);

		return array("supermasters" => $items);
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