<?php
include('header.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);
$id = $_GET['id'];
if(($id !='') && (isset($_SESSION['username']))){
	include('database.class.php');
	include('table.class.php');
	include('user.class.php');

	$dbo = database::getInstance();
	$dbo->connect('localhost','root','3mdigital','php_with_oops');

	$user = new user();
	$user->load($id);
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<title>Edit User</title>
	</head>
	<body>
	<div class="container">
		<div class="col-md-offset-4 col-md-4 margin-top-100 center text-danger">
			<?php if(isset($_SESSION['temp_data'])){
				echo $_SESSION['temp_data'];
				unset($_SESSION['temp_data']);
				} ?>
		</div>
		<div class="col-md-offset-4 col-md-4 div-login">
			<form id="editUserForm" method="post" action="home.php" enctype="multipart/form-data">
				<table>
					<thead>
						<th colspan="3" class="center padding-20">Edit User</th>
					</thead>
					<tbody>
						<tr>
							<td class="padding-20">Name</td>	<td>:</td>	<td><input type="text" value="<?= isset($user->final_result[0]['name'])?$user->final_result[0]['name']:''; ?>" name="name" id="name"></td>
						</tr>
						<tr>
							<td class="padding-20">Phone</td>	<td>:</td>	<td><input type="text" maxlength="10" value="<?= isset($user->final_result[0]['phone'])?$user->final_result[0]['phone']:''; ?>" name="phone" id="phone"></td>
						</tr>
						<tr>
							<td class="padding-20">Email</td>	<td>:</td>	<td><input type="text" value="<?= isset($user->final_result[0]['email'])?$user->final_result[0]['email']:''; ?>" name="email" id="email"></td>
						</tr>
						<tr>
							<td class="padding-20">Avatar</td>	<td>:</td>	<td><input type="file" name="avatar" id="avatar" class="border-none"></td>
						</tr>
						<tr>
							<input type="hidden" name="id" value="<?= isset($user->final_result[0]['id'])?$user->final_result[0]['id']:''; ?>">
							<td colspan="3" class="center padding-20"><input type="submit" name="edit_user" value="Edit User" class="btn btn-primary"></td>
						</tr>
					</tbody>
				</table>
			</form>
		</div>
	</div>
	<script type="text/javascript">
	$().ready(function() {		
		// validate signup form on keyup and submit
		$("#editUserForm").validate({
			rules: {				
				name: {
					required: true
				},
				email: {
					required: true,
					email: true
				},
				phone: {
					required: true,
	                minlength: 10,
	                number:true
	                // maxlength:10,
	                // pattern: /^[7-9][0-9]{9}$/
	                /*remote:{
	                    url:window.path+"Super/superadmin/check_phone",
	                    type:"post",
	                    data:{
	                        mobno:function(){
	                            return $("#mobno").val();
	                        }
	                    }
	                }*/
				}
			},
			messages: {
				name: {
					required: "Please provide name"
				},
				email: {
					required: "Please provide an email",
					email: "Please enter a valid email address"
				},
				phone: {
					required: "Please Provide mobile number",
	                minlength: "Your mobile Number must be 10 number",
	                number: "Please provide valid mobile number"
	                // maxlength: "Your mobile Number must be 10 number",
	                // pattern: "Invalide Mobile Number Digits Please Enter Valid Number"
				}
			},
			submitHandler: function(form) {
	            form.submit();
	        }
		});
	});
	</script>
	</body>
	</html>
<?php
}else{
	header("Location:home.php");
}
?>