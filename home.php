<?php
include('header.php');
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
	if((isset($_POST['add_user'])) || (isset($_POST['edit_user']))){
		$name = isset($_POST['name'])?$_POST['name']:'';
		$phone = isset($_POST['phone'])?$_POST['phone']:'';
		$email = isset($_POST['email'])?$_POST['email']:'';
		
		if(isset($_POST['edit_user'])){
			$user_id = isset($_POST['id'])?$_POST['id']:'';
			$user->load($user_id);
			$profile = $_FILES['avatar']['name'];

			if($profile != ''){
				// check for file size
				if($_FILES['avatar']['size'] > 2097152) { //2 MB (size is also in bytes)
					$_SESSION['temp_data'] = "uploaded file size in too large";
					header("Location:addUser.php");
					return;
				}
				//check for file type
				$accaptable_types = array('image/jpeg','image/jpg','image/gif','image/png');
				if(!in_array($_FILES['avatar']['type'], $accaptable_types)){
					$_SESSION['temp_data'] = "uploaded file type not acceptable";
					header("Location:addUser.php");
					return;
				}
				$new_file_name = time().$_FILES['avatar']['name'];
				if(!move_uploaded_file($_FILES['avatar']['tmp_name'], "uploads/".$new_file_name)){
					$_SESSION['temp_data'] = "Failed to upload file";
					header("Location:addUser.php");
					return;
				}
				unlink("uploads/".$user->final_result[0]['avatar']);
			}else{
				$new_file_name = $user->final_result[0]['avatar'];
			}

			$data = array("username"=>$user->final_result[0]['username'],"password"=>$user->final_result[0]['password'],"name"=>$name, "phone"=>$phone, "email"=>$email,"avatar"=>$new_file_name);
			$user->bind($data);
			$edit = $user->store();
			if($edit){
				$_SESSION['temp_data'] = "Successfully edited";
			}else{
				$_SESSION['temp_data'] = "Failed to edit";
			}
		}else{
			$profile = $_FILES['avatar']['name'];
			// check for file size
			if($_FILES['avatar']['size'] > 2097152) { //2 MB (size is also in bytes)
				$_SESSION['temp_data'] = "uploaded file size in too large";
				header("Location:addUser.php");
				return;
			}
			//check for file type
			$accaptable_types = array('image/jpeg','image/jpg','image/gif','image/png');
			if(!in_array($_FILES['avatar']['type'], $accaptable_types)){
				$_SESSION['temp_data'] = "uploaded file type not acceptable";
				header("Location:addUser.php");
				return;
			}
			$new_file_name = time().$_FILES['avatar']['name'];
			if(!move_uploaded_file($_FILES['avatar']['tmp_name'], "uploads/".$new_file_name)){
				$_SESSION['temp_data'] = "Failed to upload file";
				header("Location:addUser.php");
				return;
			}
			$username = isset($_POST['username'])?$_POST['username']:'';
			$password = isset($_POST['password'])?$_POST['password']:'';
			$md5_pwd = md5($password);
			$data = array("username"=>$username,"password"=>$md5_pwd,"name"=>$name, "phone"=>$phone, "email"=>$email,"avatar"=>$new_file_name);
			$user->bind($data);
			$add = $user->store();
			if($add){
				$_SESSION['temp_data'] = "Successfully added";
			}else{
				$_SESSION['temp_data'] = "Failed to add";
			}
		}
		
		header("Location:home.php");
	}

	// to select from db
	$user->load();

	// echo '<pre>'; print_r($user->final_result);
	//end of index file
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<title>User Listing</title>
	</head>
	<body>
	<div class="container-fluid">
		<div class="row margin-20">
		<div class="col-md-6">
			<a href="http://localhost/project1/addUser.php"><input type="button" class="btn btn-primary" value="Add User"></a>
		</div>
		<div class="col-md-6 right">
			<a href="http://localhost/project1/logout.php"><input type="button" class="btn btn-primary" value="Logout"></a>
		</div>
		</div><br/>
		<div class="table-responsive">
			<table class="table">
				<thead>
					<tr><td>Sno</td><td>Username</td><td>Name</td><td>Phone</td><td>Email</td><td>Profile</td><td>Edit</td>
					<td>Delete</td>
					</tr>
				</thead>
				<tbody>
					<?php
					if(count($user->final_result)>0){
						foreach ($user->final_result as $key => $value) {
						?>
							<tr>
								<td><?= ($key+1); ?></td>
								<td><?= $value['username'] ?></td>
								<td><?= $value['name'] ?></td>
								<td><?= $value['phone'] ?></td>
								<td><?= $value['email'] ?></td>
								<td>
									<?php if($value['avatar']!=''){ ?>
									<img src="uploads/<?= $value['avatar']; ?>" width="70px;">
									<?php }else{ echo "NO Image"; } ?>
								</td>
								<td>
									<a href="editUser.php?id=<?php echo $value['id']; ?>"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
								</td>
								<td>
									<button class="btn btn-primary" onclick="delete_user(this);" id="user_<?php echo $value['id']; ?>"><span class="glyphicon glyphicon-trash"  aria-hidden="true"></span></button>
								</td>
							</tr>
							<?php
						}
					}else{
						echo '<tr><td colspan="8">No Results</td></tr>';
					}
					?>
				</tbody>
			</table>
		</div>
		<div>
			<?php if(isset($_SESSION['temp_data'])){
				echo $_SESSION['temp_data'];
				unset($_SESSION['temp_data']);
				} ?>
		</div>
	</div>
	<script type="text/javascript">
	function delete_user(ref){
		var check = confirm("Press a button!");
		if(check == true){
			// var thisVal = $(this);
			var id = ref.id;
			var id = id.split('_');
			$.ajax({
		        url: "deleteUser.php",
		        method: "POST",
		        data: "id="+id[1],
		        success: function(response){
		        	if(response){
		                $.bootstrapGrowl('Deleted Successfully');
		                $(ref).closest("tr").remove();		                
		                // $(this).closest("tr").toggle();
		                $(ref).closest('tr').find('td').fadeOut(2000,
	                        function() {
	                        	$(ref).parents('tr:first').remove();
	                        });
	                    return false;
		            }else{
		                $.bootstrapGrowl('Failed to delete');
		            }
		        }
		    });
		}
	}
	</script>
	</body>
	</html>
<?php 
}else{
	header("Location:index.php");
}
?>