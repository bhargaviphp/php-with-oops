<?php include('header.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<div  class="container">
		<div class="col-md-offset-4 col-md-4 margin-top-100 center text-danger">
			<?php if(isset($_SESSION['temp_data'])){
				echo $_SESSION['temp_data'];
				unset($_SESSION['temp_data']);
				} ?>
		</div>
		<div class="col-md-offset-4 col-md-4 div-login">
			<form id="signupForm" method="post" action="login.php">
				<table>
					<thead>
						<th colspan="3" class="center padding-20">Login</th>
					</thead>
					<tbody>
						<tr>
							<td class="padding-20">Username</td><td>:</td><td><input type="text" name="user_name" id="user_name" required></td>
						</tr>
						<tr>
							<td class="padding-20">Password</td><td>:</td><td><input type="password" name="password" id="password" required></td>
						</tr>
						<tr>
							<td colspan="3" class="right padding-20"><input type="submit" class="btn btn-primary" name="log_sub" value="Login"></td>
						</tr>
					</tbody>
				</table>
			</form>
		</div>
	</div>
	<script>
	/*$.validator.setDefaults({
		submitHandler: function() {
			alert("submitted!");
		}
	});*/

	$().ready(function() {		
		// validate signup form on keyup and submit
		$("#signupForm").validate({
			rules: {
				user_name: {
					required: true,
					minlength: 2
				},
				password: {
					required: true,
					minlength: 2
				}
			},
			messages: {
				user_name: {
					required: "Please enter a username",
					minlength: "Your username must consist of at least 2 characters"
				},
				password: {
					required: "Please provide a password",
					minlength: "Your password must be at least 5 characters long"
				}
			}
		});
	});
	</script>
</body>
</html>