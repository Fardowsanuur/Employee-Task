<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id'])) {

if (isset($_POST['name']) && isset($_POST['notes']) && isset($_POST['id']) && $_SESSION['role'] == 'admin') {
	include "../DB_connection.php";

    function validate_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}

	$name = validate_input($_POST['name']);
	$notes = validate_input($_POST['notes']);
	$id = validate_input($_POST['id']);

	if (empty($name)) {
		$em = "Category name is required";
	    header("Location: ../edit-category.php?error=$em&id=$id");
	    exit();
	} else {
    
       include "Model/Category.php";

       $data = array($name, $notes, $id);
       update_category($conn, $data);

       $em = "Category updated successfully";
	    header("Location: ../edit-category.php?success=$em&id=$id");
	    exit();

    
	}
} else {
   $em = "Unknown error occurred";
   header("Location: ../edit-category.php?error=$em");
   exit();
}

} else { 
   $em = "Please log in first.";
   header("Location: ../edit-category.php?error=$em");
   exit();
}
