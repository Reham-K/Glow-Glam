<?php 
session_start();
if (!isset($_SESSION['admin_id'])) { header("Location: login.php"); exit; }
include('../includes/db_connect.php'); 

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    $sql = "DELETE FROM products WHERE product_id = $id";
    
    if ($conn->query($sql)) {
        header("Location: dashboard.php?msg=deleted");
        exit;
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    header("Location: dashboard.php");
    exit;
}
?>