<?php
include('header.php');
if(isset($_SESSION['username'])){
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<title>Add User</title>
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
			<form method="post" id="addUserForm" action="home.php" enctype="multipart/form-data">
				<table>
					<thead>
						<th colspan="3" class="center padding-20">Add User</th>
					</thead>
					<tbody>
						<tr>
							<td class="padding-20">Username</td>	<td>:</td>	<td><input type="text" name="username" id="username"></td>
						</tr>
						<tr>
							<td class="padding-20">Password</td>	<td>:</td>	<td><input type="password" name="password" id="password"></td>
						</tr>
						<tr>
							<td class="padding-20">Name</td>	<td>:</td>	<td><input type="text" name="name" id="name"></td>
						</tr>
						<tr>
							<td class="padding-20">Phone</td>	<td>:</td>	<td><input type="text" name="phone" maxlength="10" id="phone"></td>
						</tr>
						<tr>
							<td class="padding-20">Email</td>	<td>:</td>	<td><input type="text" name="email" id="email"></td>
						</tr>
						<tr>
							<td class="padding-20">Avatar</td>	<td>:</td>	<td><input type="file" name="avatar" id="avatar" class="border-none"></td>
						</tr>
						<tr>
							<td colspan="3" class="center padding-20"><input type="submit" class="btn btn-primary" name="add_user" value="Add User"></td>
						</tr>
					</tbody>
				</table>
			</form>
		</div>
	</div>
	<script type="text/javascript">
	$().ready(function() {		
		// validate signup form on keyup and submit
		$("#addUserForm").validate({
			rules: {
				username: {
					required: true,
					minlength: 2
				},
				password: {
					required: true,
					minlength: 5
				},
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
				},
				avatar: "required"
			},
			messages: {
				username: {
					required: "Please enter a username",
					minlength: "Your username must consist of at least 2 characters"
				},
				password: {
					required: "Please provide a password",
					minlength: "Your password must be at least 5 characters long"
				},
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
				},
				avatar: "Please select a profile picture"
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
	header("Location:index.php");
}
?>