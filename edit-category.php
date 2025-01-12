<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "admin") {
    include "DB_connection.php";
    include "app/Model/Category.php";
    
    if (!isset($_GET['id'])) {
    	header("Location: category.php");
    	exit();
    }
    $id = $_GET['id'];
    $category = get_category_by_id($conn, $id);

    if ($category == 0) {
    	header("Location: category.php");
    	exit();
    }

 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Edit Category</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/style.css">

</head>
<body>
	<input type="checkbox" id="checkbox">
	<?php include "inc/header.php" ?>
	<div class="body">
		<?php include "inc/nav.php" ?>
		<section class="section-1">
			<h4 class="title">Edit Category <a href="category.php">Categories</a></h4>
			<form class="form-1"
			      method="POST"
			      action="app/update-category.php">
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
					<lable>Category Name</lable>
					<input type="text" name="name" class="input-1" placeholder="Category Name" value="<?=$category['name']?>"><br>
				</div>
				<div class="input-holder">
					<lable>Notes</lable>
					<textarea name="notes" class="input-1" placeholder="Notes"><?=$category['notes']?></textarea><br>
				</div>
				<input type="text" name="id" value="<?=$category['id']?>" hidden>

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
