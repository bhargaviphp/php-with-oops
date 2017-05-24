<?php
session_start();
if(isset($_SESSION['username'])){
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	include('database.class.php');
	include('table.class.php');
	include('user.class.php');

	$dbo = database::getInstance();
	$dbo->connect('localhost','root','3mdigital','php_with_oops');

	$user = new user();

	// to insert in db
	if(isset($_POST['id'])){
		$id = $_POST['id'];
		$del = $user->remove($id);
		if($del){
			echo "true";
		}else{
			echo "false";
		}
	}
}else{
	return FALSE;
}
?>