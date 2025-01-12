<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id'])) {

if (isset($_POST['name']) && isset($_POST['notes']) && $_SESSION['role'] == 'admin') {
	include "../DB_connection.php";

    function validate_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}

	$name = validate_input($_POST['name']);
	$notes = validate_input($_POST['notes']);

	if (empty($name)) {
		$em = "Category name is required";
	    header("Location: ../add-category.php?error=$em");
	    exit();
	} else {
    
       include "Model/Category.php";

       $data = array($name, $notes);
       insert_category($conn, $data);

       $em = "Category created successfully";
	    header("Location: ../add-category.php?success=$em");
	    exit();

    
	}
} else {
   $em = "Unknown error occurred";
   header("Location: ../add-category.php?error=$em");
   exit();
}

} else { 
   $em = "Please log in first.";
   header("Location: ../add-category.php?error=$em");
   exit();
}
