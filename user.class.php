<?php
/**
* 
*/
class User extends table
{
	
	public $username = null;
	public $password = null;
	public $name = null;
	public $phone = null;
	public $email = null;
	public $type = "user";
	public $permissions = "[]";
	public $active = 1;
	var $table = "user_details";
	var $final_result = array();
	public $avatar = null;
}
//end of user class