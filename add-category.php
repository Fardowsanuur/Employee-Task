<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "admin") {
  
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Add Category</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<input type="checkbox" id="checkbox">
	<?php include "inc/header.php" ?>
	<div class="body">
		<?php include "inc/nav.php" ?>
		<section class="section-1">
			<h4 class="title">Add Category <a href="category.php">Categories</a></h4>
			<form class="form-1"
			      method="POST"
			      action="app/add-category.php">
			      <?php if (isset($_GET['error'])) {?>
      	  	<div class="danger" role="alert">
				  <?php echo htmlspecialchars($_GET['error']); ?>
				</div>
      	  <?php } ?>

      	  <?php if (isset($_GET['success'])) {?>
      	  	<div class="success" role="alert">
				  <?php echo htmlspecialchars($_GET['success']); ?>
				</div>
      	  <?php } ?>
				<div class="input-holder">
					<label>Category Name</label>
					<input type="text" name="name" class="input-1" placeholder="Category Name" required><br>
				</div>
				<div class="input-holder">
					<label>Notes</label>
					<textarea name="notes" class="input-1" placeholder="Additional Notes" rows="4"></textarea><br>
				</div>
				<button class="edit-btn">Add</button>
			</form>
		</section>
	</div>

<script type="text/javascript">
	var active = document.querySelector("#navList li:nth-child(2)");
	active.classList.add("active");
</script>
</body>
</html>
<?php } else { 
   $em = "Please log in first.";
   header("Location: login.php?error=" . urlencode($em));
   exit();
}
?>
