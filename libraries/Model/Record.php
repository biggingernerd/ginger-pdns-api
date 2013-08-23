<?php

class Model_Record extends Model {
	
	public function __construct()
	{
		$this->_tableName = 'records';

		$this->setOrderBy('id');
		parent::__construct();
	}
	
}