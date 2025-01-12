<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id'])) {

if (isset($_POST['user_name']) && isset($_POST['password']) && isset($_POST['full_name']) && $_SESSION['role'] == 'admin') {
	include "../DB_connection.php";

    function validate_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}

	$user_name = validate_input($_POST['user_name']);
	$password = validate_input($_POST['password']);
	$full_name = validate_input($_POST['full_name']);
	$id = validate_input($_POST['id']);
	$role = validate_input($_POST['role']);


	if (empty($user_name)) {
		$em = "User name is required";
	    header("Location: ../edit-user.php?error=$em&id=$id");
	    exit();
	}else if (empty($full_name)) {
		$em = "Full name is required";
	    header("Location: ../edit-user.php?error=$em&id=$id");
	    exit();
	}else if (!in_array($role, ['admin', 'employee'])) {
	    $em = "Invalid role selected";
	    header("Location: ../edit-user.php?error=$em&id=$id");
	    exit();
	}else {
    
       include "Model/User.php";
       
       // Only hash password if a new one was provided
       if (!empty($password) && $password !== "**********") {
           $password = password_hash($password, PASSWORD_DEFAULT);
           $data = array($full_name, $user_name, $password, $role, $id, $role);
       } else {
           // Skip password update if no new password provided
           $data = array($full_name, $user_name, null, $role, $id, $role);
       }
       
       update_user($conn, $data);

       $em = "User updated successfully";
	    header("Location: ../edit-user.php?success=$em&id=$id");
	    exit();

    
	}
}else {
   $em = "Unknown error occurred";
   header("Location: ../edit-user.php?error=$em");
   exit();
}

}else{ 
   $em = "First login";
   header("Location: ../edit-user.php?error=$em");
   exit();
}