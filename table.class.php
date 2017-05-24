<?php
/**
* 
*/
class Table
{
	protected $id = null;
	protected $table = null;	
	
	function __construct()
	{
		
	}

	public function bind($data)
	{
		foreach ($data as $key => $value) {
			$this->$key = $value;
		}
	}

	public function load($id='')
	{
		$this->id = isset($id)?$id:'';
		$dbo = database::getInstance();
		$sql = $this->buildQuery('load');
		$dbo->doQuery($sql);
		$row = $dbo->loadObjectList();
		$this->final_result = $row;
		// echo '<pre>'; print_r($this->final_result);
		// echo count($row); echo '<br>';
		/*if(count($row)>0){
			if(count($row)==1){
				foreach ($row as $key => $value) {
					foreach ($value as $key1 => $value1) {
						if($key1 == "id")
						{
							continue;
						}
						$this->$key1 = $value;
					}
					// echo'<pre>'; print_r($value); echo '<br>';					
				}
			}else{

			}			
		}*/
		// die;
	}

	public function store()
	{
		$dbo = database::getInstance();
		$sql = $this->buildQuery('store');
		if($dbo->doQuery($sql)){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	public function remove($id)
	{
		$this->id = $id;
		$dbo = database::getInstance();
		$sql = $this->buildQuery('remove');
		if($dbo->doQuery($sql)){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	public function login($user_name,$password){
		$this->username = $user_name;
		$this->password = $password;
		$dbo = database::getInstance();
		$sql = $this->buildQuery('login');
		$dbo->doQuery($sql);
		$row = $dbo->loadObjectList();
		$this->final_result = $row;
	}

	protected function buildQuery($task){
		$sql = "";
		if($task == 'store'){
			if($this->id == ""){
				$keys = "";
				$values = "";
				$classVars = get_class_vars(get_class($this));
				$sql .= "Insert into {$this->table} ";
				foreach ($classVars as $key => $value) {
					if($key == "id" || $key == "table" || $key == "final_result")
					{
						continue;
					}
					$keys .= "{$key},";
					$values .="'{$this->$key}',";
				}
				$sql .= "(".substr($keys, 0, -1).") Values(".substr($values, 0, -1).")";
			}else{
				$classVars = get_class_vars(get_class($this));
				$sql .="Update {$this->table} set ";
				foreach ($classVars as $key => $value) {
					if($key == "id" || $key == "table" || $key == "final_result"){
						continue;
					}
					$sql .= "{$key} = '{$this->$key}', ";
				}
				$sql = substr($sql,0,-2)." where id = '{$this->id}'";
			}
		}elseif($task == 'load'){
			if($this->id == ""){
				$sql = "select * from {$this->table} where type = '{$this->type}'";
			}else{
				$sql = "select * from {$this->table} where id = '{$this->id}' AND type = '{$this->type}'";
			}
		}elseif($task == 'remove'){
			$sql = "delete from {$this->table} where id = '{$this->id}'";
		}elseif($task == 'login'){
			$sql = "select * from {$this->table} where BINARY username = '{$this->username}' AND password = '{$this->password}' AND active = '{$this->active}'";
		}
		// echo $sql; die;
		return $sql;
	}
}
//end of table class