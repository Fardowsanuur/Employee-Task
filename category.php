
<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "admin") {
    include "DB_connection.php";
    include "app/Model/Category.php";

    $categories = get_all_categories($conn);
  
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Manage Categories</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<input type="checkbox" id="checkbox">
	<?php include "inc/header.php" ?>
	<div class="body">
		<?php include "inc/nav.php" ?>
		<section class="section-1">
			<h4 class="title">Manage Categories <a href="add-category.php" class="add-btn">Add Category</a></h4>
			<?php if (isset($_GET['success'])) {?>
      		<div class="success" role="alert">
			  <?php echo htmlspecialchars($_GET['success']); ?>
			</div>
		<?php } ?>
			<?php if ($categories != 0) { ?>
			<table class="main-table">
				<thead>
					<tr>
						<th>#</th>
						<th>Name</th>
						<th>Notes</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
				<?php $i=0; foreach ($categories as $category) { ?>
				<tr>
					<td><?=++$i?></td>
					<td><?=htmlspecialchars($category['name'])?></td>
					<td><?=htmlspecialchars($category['notes'])?></td>
					<td>
						<a href="edit-category.php?id=<?=htmlspecialchars($category['id'])?>" class="edit-btn">Edit</a>
						<form action="delete-category.php" method="POST" style="display: inline;">
							<input type="hidden" name="id" value="<?=htmlspecialchars($category['id'])?>">
							<button type="submit" class="delete-btn" style="border: none; cursor: pointer;">Delete</button>
						</form>
					</td>
				</tr>
			   <?php } ?>
			   </tbody>
			</table>
			<?php } else { ?>
				<h3>No categories found.</h3>
			<?php } ?>
		</section>
	</div>

<script type="text/javascript">
	document.querySelector("#navList li:nth-child(2)").classList.add("active");
</script>
</body>
</html>
<?php } else { 
   $em = "Please log in first.";
   header("Location: login.php?error=" . urlencode($em));
   exit();
}
?>
