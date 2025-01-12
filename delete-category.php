<?php
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "admin") {
    include "DB_connection.php";
    include "app/Model/Category.php";
    
    // Check if POST request and ID exists
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
        $id = $_POST['id'];
        $category = get_category_by_id($conn, $id);

        if ($category == 0) {
            header("Location: category.php");
            exit();
        }

        delete_category($conn, $id);
        $sm = "Category Deleted Successfully";
        header("Location: category.php?success=" . urlencode($sm));
        exit();
    } else {
        header("Location: category.php");
        exit();
    }
} else { 
    $em = "Please log in first";
    header("Location: login.php?error=" . urlencode($em));
    exit();
}
?>
