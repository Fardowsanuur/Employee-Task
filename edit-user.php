<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "admin") {
    include "DB_connection.php";
    include "app/Model/User.php";
    
    if (!isset($_GET['id'])) {
    	 header("Location: user.php");
    	 exit();
    }
    $id = $_GET['id'];
    $user = get_user_by_id($conn, $id);

    if ($user == 0) {
    	 header("Location: user.php");
    	 exit();
    }

 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Edit User</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/style.css">

</head>
<body>
	<input type="checkbox" id="checkbox">
	<?php include "inc/header.php" ?>
	<div class="body">
		<?php include "inc/nav.php" ?>
		<section class="section-1">
			<h4 class="title">Edit Users <a href="user.php">Users</a></h4>
			<form class="form-1"
			      method="POST"
			      action="app/update-user.php">
			      <?php if (isset($_GET['error'])) {?>
      	  	<div class="danger" role="alert">
			  <?php echo stripcslashes($_GET['error']); ?>
			</div>
      	  <?php } ?>

      	  <?php if (isset($_GET['success'])) {?>
      	  	<div class="success" role="alert">
			  <?php echo stripcslashes($_GET['success']); ?>
			</div>
      	  <?php } ?>
				<div class="input-holder">
					<lable>Full Name</lable>
					<input type="text" name="full_name" class="input-1" placeholder="Full Name" value="<?=$user['full_name']?>"><br>
				</div>
				<div class="input-holder">
					<lable>Username</lable>
					<input type="text" name="user_name" value="<?=$user['username']?>" class="input-1" placeholder="Username"><br>
				</div>
				<div class="input-holder">
					<lable>Password</lable>
					<input type="password" name="password" class="input-1" placeholder="Leave empty to keep current password"><br>
				</div>
				<div class="input-holder">
					<label for="role">Role</label>
					<select name="role" id="role" class="input-1">
						<option value="employee" <?=$user['role'] == 'employee' ? 'selected' : ''?>>Employee</option>
						<option value="admin" <?=$user['role'] == 'admin' ? 'selected' : ''?>>Admin</option>
					</select><br>
				</div>
				<input type="text" name="id" value="<?=$user['id']?>" hidden>

				<button class="edit-btn">Update</button>
			</form>
			
		</section>
	</div>

<script type="text/javascript">
	var active = document.querySelector("#navList li:nth-child(2)");
	active.classList.add("active");
</script>
</body>
</html>
<?php }else{ 
   $em = "First login";
   header("Location: login.php?error=$em");
   exit();
}
 ?>