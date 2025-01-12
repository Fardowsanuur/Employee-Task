<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id'])) {

if (isset($_POST['id']) && 
    isset($_POST['title']) && 
    isset($_POST['description']) && 
    isset($_POST['assigned_to']) && 
    isset($_POST['category_id']) &&  // Added category check
    $_SESSION['role'] == 'admin' && 
    isset($_POST['due_date'])) {
    
    include "../DB_connection.php";

    function validate_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $title = validate_input($_POST['title']);
    $description = validate_input($_POST['description']);
    $assigned_to = validate_input($_POST['assigned_to']);
    $category_id = validate_input($_POST['category_id']); // Added category
    $id = validate_input($_POST['id']);
    $due_date = validate_input($_POST['due_date']);

    if (empty($title)) {
        $em = "Title is required";
        header("Location: ../edit-task.php?error=$em&id=$id");
        exit();
    }else if (empty($description)) {
        $em = "Description is required";
        header("Location: ../edit-task.php?error=$em&id=$id");
        exit();
    }else if ($assigned_to == 0) {
        $em = "Select User";
        header("Location: ../edit-task.php?error=$em&id=$id");
        exit();
    }else if ($category_id == 0) {  // Added category validation
        $em = "Select Category";
        header("Location: ../edit-task.php?error=$em&id=$id");
        exit();
    }else {
        include "Model/Task.php";

        $data = array($title, $description, $assigned_to, $due_date, $category_id, $id);
        update_task($conn, $data);

        $em = "Task updated successfully";
        header("Location: ../edit-task.php?success=$em&id=$id");
        exit();
    }
}else {
   $em = "Unknown error occurred";
   header("Location: ../edit-task.php?error=$em");
   exit();
}

}else{ 
   $em = "First login";
   header("Location: ../login.php?error=$em");
   exit();
}