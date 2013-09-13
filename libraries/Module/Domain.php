<?php

class Module_Domain extends Module 
{
	private $_validationRules = array(
		"name"				=>	"required|checkIfDomainNameIsFree",
		"master" 			=>	"valid_ip",
		"last_check"		=>	"numeric",
		"type"				=>	"required|contains,MASTER SLAVE",
		"notified_serial"	=>	"alpha_numeric",
		"account"			=>	"alpha_dash"
	);
	
	private $_filterRules = array(
		"type"				=>	"strtoupper"
	);

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
		$params = Request::getParams();
	
		$validator = new Validator(); 
		$params = $validator->sanitize($params);
		
		$validator->validation_rules($this->_validationRules);
		$validator->filter_rules($this->_filterRules);
		
		$validated_data = $validator->run($params);
		
		
		if($validated_data === false) {
		    Response::setStatus(400);
		    $returnArray = array(	
		    						"error" => "Invalid data was sent",
		    						"messages" => $validator->get_readable_errors()
		    						);
		} else {
			if(!isset($validated_data['notified_serial']))
			{
				$validated_data['notified_serial'] = (int)date('Ymd')."0".rand(1,9);
			}
			
			$model = new Model_Domain();
			$save = $model->insert($validated_data);
		
			Response::setStatus(201);
		    $returnArray = array(	
		    						"location" => "http://".$_SERVER['SERVER_NAME']."/domain/id/".$save
		    						);
		}

	
		return $returnArray;
	}

	public function putAction()
	{
		return array("put" => Request::getParams());
	}
	
	public function deleteAction()
	{
		$params = Request::getParams();
	
		$validator = new Validator(); 
		$params = $validator->sanitize($params);
		
		$validator->validation_rules(array("id" => "required|numeric|checkIfDomainIdExists"));
		
		$validated_data = $validator->run($params);
		
		if($validated_data === false) {
		    Response::setStatus(404);
		    $returnArray = array(	
		    						"error" => "Invalid data was sent",
		    						"messages" => $validator->get_readable_errors()
		    						);
		} else {
			$model = new Model_Domain();
			$model->delete($params['id']);
			
			Response::setStatus(204);
		    $returnArray = array();
		}

	
		return $returnArray;
	}
	
	public function headAction()
	{
		return array("head" => Request::getParams());
	}
}