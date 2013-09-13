<?php

class Module_Record extends Module 
{
	private $_validationRules = array(
		"domain_id"			=>	"required|checkIfDomainIdExists",
		"name"				=>	"required|checkIfDomainNameIsFree",
		"type"				=>	"required|contains,SOA A NS MX CNAME AAAA TXT SPF",
		"content"			=>	"required",
		"ttl"				=>	"required|numeric",
		"change_date"		=>	"required|numeric",
		"prio"				=>	"numeric"

	);
	
	private $_filterRules = array(
		"type"				=>	"strtoupper"
	);

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
			
			$model = new Model_Record();
			$save = $model->insert($validated_data);
		
			Response::setStatus(201);
		    $returnArray = array(	
		    						"location" => "http://".$_SERVER['SERVER_NAME']."/record/id/".$save
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
		
		$validator->validation_rules(array("id" => "required|numeric|checkIfRecordIdExists"));
		
		$validated_data = $validator->run($params);
		
		if($validated_data === false) {
		    Response::setStatus(404);
		    $returnArray = array(	
		    						"error" => "Invalid data was sent",
		    						"messages" => $validator->get_readable_errors()
		    						);
		} else {
			$model = new Model_Record();
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