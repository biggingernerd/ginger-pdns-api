<?php

class Model_Supermaster extends Model {
	
	public function __construct()
	{
		$this->_tableName = 'supermasters';

		$this->setOrderBy('id');
		parent::__construct();
	}
	
}