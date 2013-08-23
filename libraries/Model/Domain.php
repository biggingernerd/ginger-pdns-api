<?php

class Model_Domain extends Model {
	
	public function __construct()
	{
		$this->_tableName = 'domains';

		$this->setOrderBy('id');
		parent::__construct();
	}
	
}