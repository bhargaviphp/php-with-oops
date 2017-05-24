<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('database.class.php');
include('table.class.php');
include('authenticate.class.php');

$dbo = database::getInstance();
$dbo->connect('localhost','root','3mdigital','php_with_oops');

$authenticate = new authenticate();

$user_name = $_POST['user_name'];
$password = md5($_POST['password']);
$authenticate->login($user_name,$password);

$result = $authenticate->final_result;
if(count($result)>0){
	if($result[0]['active']==1){
		$_SESSION['username'] = $result[0]['username'];
		$_SESSION['permissions'] = $result[0]['permissions'];
		header("Location:home.php");
		return;
	}else{
		$_SESSION['temp_data'] = "Authenication failed";
		header("Location:index.php");
		return;
	}
}else{
	$_SESSION['temp_data'] = "Authenication failed";
	header("Location:index.php");
	return;
}
// end of login file