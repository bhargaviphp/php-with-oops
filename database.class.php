<?php
/**
* 
*/
class Database
{
	private $host;
	private $userName;
	private $password;
	private $dbName;
	private static $instance;
	private $connection;
	private $results;
	private $numRows;
	
	private function __construct()
	{
		
	}

	static function getInstance()
	{
		if(!self::$instance){
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function connect($host, $userName, $password, $dbName)
	{
		$this->host = $host;
		$this->userName = $userName;
		$this->password = $password;
		$this->dbName = $dbName;
		$this->connection = mysqli_connect($this->host,$this->userName,$this->password,$this->dbName);
	}

	public function doQuery($sql)
	{
		$this->results = mysqli_query($this->connection,$sql) or die(mysqli_error($this->connection));
		return TRUE;
	}

	public function loadObjectList()
	{
		$this->numRows = mysqli_num_rows($this->results);

		$obj = array();
		if($this->results)
		{
			while($obj[] = mysqli_fetch_assoc($this->results)){

			}
		}
		array_pop($obj);
		return $obj;
	}
}
// end of database class