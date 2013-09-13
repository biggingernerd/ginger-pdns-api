<?php
  /**
   * library/Model.php 
   * 
   * @author Big Ginger Nerd
   */

  /**
   * This is the Model class
   *
   * @package Dashboard 
   * @subpackage Model
   */
  class Model
  {

    /**
     * _tableName
     * 
     * @var string
     * @access protected
     */
    protected $_tableName;

    /**
     * _allowedParams
     * 
     * @var array
     * @access protected
     */
    protected $_allowedParams;

    /**
     * _connection
     * 
     * @var PDO
     * @access protected
     */
    protected $_connection;

    /**
     * _offset
     * 
     * (default value: 0)
     * 
     * @var int
     * @access private
     */
    private $_offset = 0;

    /**
     * _limit
     * 
     * (default value: 10)
     * 
     * @var int
     * @access private
     */
    private $_limit = 10;

    /**
     * _orderby
     * 
     * (default value: false)
     * 
     * @var bool
     * @access private
     */
    protected $_orderby = "id";

    /**
     * _orderbyDirection
     * 
     * (default value: "ASC")
     * 
     * @var string
     * @access private
     */
    protected $_orderbyDirection = "ASC";

    /**
     * _idColumn
     *  (default value "id")
     * 
     * @var string
     * @access protected 
     */
    protected $_idColumn = "id";

    
    /**
     * _allowDebug
     * ( default value false)
     * 
     * @var boolean 
     * @access protected
     */
    protected $_allowDebug = false;
    
    public $errors = false;
    public $errorMessage = false;
    /**
     * __construct function.
     *
     * Get PDO object and store it internally
     * 
     * @access public
     * @return void
     */
    public function __construct()
    {
      $this->_connection = Registry::get('DB');
    }

    /**
     * get function.
     * 
     * Get all 
     *
     * @access public
     * @return void
     */
    public function get()
    {
      $items = array();
      $stmt = $this->_connection->prepare("SELECT * FROM " . $this->_tableName . " ORDER BY " . $this->getOrderBy() . " LIMIT " . $this->getOffset() . "," . $this->getLimit());
      if($stmt->execute())
      {
        $items = $stmt->fetchAll();
        return $items;
      }
      else
      {
        $this->logError($stmt);
        return false;
      }
    }
    
    public function getCount()
	{
		$items = array();
      $stmt = $this->_connection->prepare("SELECT COUNT(*) AS amount FROM " . $this->_tableName . " ORDER BY " . $this->getOrderBy() . " LIMIT " . $this->getOffset() . "," . $this->getLimit());
      if($stmt->execute())
      {
        $items = $stmt->fetch();
        return $items;
      }
      else
      {
        $this->logError($stmt);
        return false;
      }
	}

    /**
     * getById function.
     * 
     * @access public
     * @param mixed $id
     * @return void
     */
    public function getById($id)
    {
      $stmt = $this->_connection->prepare("SELECT * FROM " . $this->_tableName . " 
                                           WHERE " . $this->_idColumn . " = :id 
                                           ORDER BY " . $this->getOrderBy() . " LIMIT 1");
      $stmt->bindValue(':id', $id);
      
      
      if($stmt->execute())
      {
        $item = $stmt->fetch();
        return $item;
      }
      else
      {
        $this->logError($stmt);
        return false;
      }
        
    }

    /**
     * filterParams function.
     * 
     * @access public
     * @param array $params (default: array())
     * @return void
     */
    public function filterParams($params = array())
    {
      $aParams = array();

      foreach($params as $key => $param)
      {
        if(in_array($key, $this->_allowedParams))
        {
          $aParams[trim($key)] = $param;
        }
      }
      return $aParams;
    }
    
    
    public function getByParams($params)
    {
		$q = array();
		
		
		
		
		foreach($params as $key => $val)
		{
			if(is_numeric($val))
			{
				$q[] = " ".$key." = ? "; 	
			} else {
				$q[] = " ".$key." LIKE ? "; 
			}
			
			
			$params[$key] = str_replace("*", "%", $val);
		}
		
		$values = array_values($params);
		
		$stmt = $this->_connection->prepare("SELECT * FROM " . $this->_tableName . " 
                                           WHERE " . implode(" AND ", $q) . " 
                                           ORDER BY " . $this->getOrderBy() . " 
                                           LIMIT " . $this->getOffset() . "," . $this->getLimit());
      
      	
		if($stmt->execute($values))
		{
			$items = $stmt->fetchAll();
			return $items;
		} else {
			$this->logError($stmt);
			return false;
		}
		
    }

    /**
     * getByQuery function.
     * 
     * when called with more than 1 argument, 
     * the 2nd and further are values to replace de ?-marks in de first argument.
     * The number of extra arguments should match the number of questionmarks in argument 1
     * 
     * @access public
     * @param string $q
     * @param optional
     * @return mixed
     */
    public function getByQuery($q)
    {
      $aParameters = array();
      if(func_num_args() > 1)
      {
        $aParameters = func_get_args();
        array_shift($aParameters);
      }

      $stmt = $this->_connection->prepare("SELECT * FROM " . $this->_tableName . " 
                                           WHERE " . $q . " 
                                           ORDER BY " . $this->getOrderBy() . " 
                                           LIMIT " . $this->getOffset() . "," . $this->getLimit());
      
      
      if($stmt->execute($aParameters))
      {
        $this->debugQuery($stmt);
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $items;
      }
      else
      {
        $this->debugQuery($stmt);
        $this->logError($stmt);
        return false;
      }
    }

    /**
     * insert function.
     * 
     * @access public
     * @param mixed $data
     * @return void
     */
    public function insert($data)
    {
    	$fields = array_keys($data);
      
      $stmtFields = array();
      foreach($fields as $field)
      {
        $stmtFields[] = ":" . $field;
      }

      $query = "INSERT INTO " . $this->_tableName . " (" . implode(",", $fields) . ") VALUES (" . implode(",", $stmtFields) . ") ";
      $stmt = $this->_connection->prepare($query);
      
      foreach($data as $key => $value)
      {
        $stmt->bindValue(':' . $key, trim($value));
      }

      if(!$stmt->execute())
      {
      	
      	$this->logError($stmt);
        return false;
      }
      else
      {
        return $this->_connection->lastInsertId();
      }
    }

    /**
     * update function.
     * 
     * @access public
     * @param mixed $id
     * @param mixed $data
     * @return void
     */
    public function update($id, $data)
    {
      $fields = array_keys($data);

      $stmtFields = array();
      foreach($fields as $field)
      {
        if($field != "id")
        {
          $stmtFields[] = $field . " = :" . $field;
        }
      }

      $stmt = $this->_connection->prepare("UPDATE " . $this->_tableName . " 
                                         SET " . implode(",", $stmtFields) . " 
                                         WHERE " . $this->_idColumn . " = :id");

      $stmt->bindValue(':id', trim($id));
      foreach($data as $key => $value)
      {
        $stmt->bindValue(':' . $key, trim($value));
      }

      if(!$stmt->execute())
      {
        $this->logError($stmt);
        return false;
      }
      else
      {
        return $this->_connection->lastInsertId();
      }
    }

    /**
     * delete function.
     * 
     * @access public
     * @param mixed $id
     * @return void
     */
    public function delete($id)
    {

        $stmt = $this->_connection->prepare("DELETE FROM " . $this->_tableName . " WHERE " . $this->_idColumn . " = :id");
      $stmt->bindValue(':id', $id);

      if(!$stmt->execute())
      {
        $this->logError($stmt);
      }

      return $res;
    }

    /**
     * setLimit function.
     * 
     * @access public
     * @param int $limit (default: 10)
     * @return void
     */
    public function setLimit($limit = 10)
    {
      $this->_limit = $limit;
    }

    /**
     * getLimit function.
     * 
     * @access public
     * @return int
     */
    public function getLimit()
    {
      return $this->_limit;
    }

    /**
     * setOffset function.
     * 
     * @access public
     * @param int $offset (default: 0)
     * @return void
     */
    public function setOffset($offset = 0)
    {
      $this->_offset = $offset;
    }

    /**
     * getOffset function.
     * 
     * @access public
     * @return int
     */
    public function getOffset()
    {
      return $this->_offset;
    }

    /**
     * getOrderBy function.
     * 
     * @access public
     * @return string
     */
    public function getOrderBy()
    {
      return $this->_orderby . " " . $this->_orderbyDirection;
    }

    /**
     * setOrderBy function.
     * 
     * @access public
     * @param mixed $field
     * @param string $direction (default: "ASC")
     * @return void
     */
    public function setOrderBy($field, $direction = "ASC")
    {
      $this->_orderby = $field;
      $this->_orderbyDirection = $direction;
    }

    /**
     * setIdColumn
     * 
     * @access public
     * @param string $sName
     * @return void 
     */
    public function setIdColumn($sName)
    {
      $this->_idColumn = $sName;
    }

    /**
     * logError
     * Write an error to stderr.
     * 
     * @param PDOStatement $stmt
     */
    protected function logError(PDOStatement $stmt)
    {
      $sMessage = $stmt->errorInfo();
/*  		$sMessage = $sMessage[2];      */
      ob_start();
      $stmt->debugDumpParams();
      $sParameters = ob_get_clean();

	  $this->errors = $sParameters;
	  $this->errorMessage = $sMessage;
/*       error_log($sMessage . PHP_EOL . $sParameters); */
    }

    protected function debugQuery(PDOStatement $stmt)
    {
      if($this->_allowDebug)
        $stmt->debugDumpParams();
    }
  
  }

  