<?php

class Validator extends Gump
{

	public function validate_checkIfDomainNameIsFree($field, $input, $param = null)
	{
		if(!isset($input[$field]) || empty($input[$field]))
		{
			return;
		}
		
		$model = new Model_Domain();
		$results = $model->getByQuery('name = ?', $input[$field]);
		
		if(count($results) != 0)
		{
			return array(
				'field' => $field,
				'value' => $input[$field],
				'rule'	=> __FUNCTION__,
				'param' => $param				
			);
		}
	}

	public function validate_checkIfDomainNameExists($field, $input, $param = null)
	{
		if(!isset($input[$field]) || empty($input[$field]))
		{
			return;
		}
		
		$model = new Model_Domain();
		$results = $model->getByQuery('name = ?', $input[$field]);
		
		if(count($results) == 0)
		{
			return array(
				'field' => $field,
				'value' => $input[$field],
				'rule'	=> __FUNCTION__,
				'param' => $param				
			);
		}
	}
	
	public function validate_checkIfDomainIdExists($field, $input, $param = null)
	{
		if(!isset($input[$field]) || empty($input[$field]))
		{
			return;
		}
		
		$model = new Model_Domain();
		$results = $model->getByQuery('id = ?', $input[$field]);
		
		if(count($results) == 0)
		{
			return array(
				'field' => $field,
				'value' => $input[$field],
				'rule'	=> __FUNCTION__,
				'param' => $param				
			);
		}
	}
	
	public function validate_checkIfRecordIdExists($field, $input, $param = null)
	{
		if(!isset($input[$field]) || empty($input[$field]))
		{
			return;
		}
		
		$model = new Model_Record();
		$results = $model->getByQuery('id = ?', $input[$field]);
		
		if(count($results) == 0)
		{
			return array(
				'field' => $field,
				'value' => $input[$field],
				'rule'	=> __FUNCTION__,
				'param' => $param				
			);
		}
	}

/*
    public function filter_myfilter($value)
    {
        ...
    }
*/

/*
    public function validate_myvalidator($field, $input, $param = NULL)
    {
        ...
    }
*/

} 