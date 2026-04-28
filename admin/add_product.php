<?php 
session_start();
if (!isset($_SESSION['admin_id'])) { header("Location: login.php"); exit; }
include('../includes/db_connect.php'); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $desc = $conn->real_escape_string($_POST['description']);
    $skin = $_POST['skin_type'];

    $img_name = $_FILES['product_image']['name'];
    $img_tmp = $_FILES['product_image']['tmp_name'];
    $img_folder = "../assets/uploads/" . $img_name;

    if (move_uploaded_file($img_tmp, $img_folder)) {
        $sql = "INSERT INTO products (name, price, stock, description, skin_type, image_name) 
                VALUES ('$name', '$price', '$stock', '$desc', '$skin', '$img_name')";
        
        if ($conn->query($sql)) {
            header("Location: dashboard.php");
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Product | Glow & Glam</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<nav class="navbar">
    <div class="logo">Admin Dashboard</div>
    <ul class="nav-links">
        <li><a href="dashboard.php"><i class="fas fa-arrow-left"></i> Dashboard</a></li>
        <li><a href="add_product.php"><i class="fas fa-plus-circle"></i> Add</a></li>
        <li><a href="search_admin.php"><i class="fas fa-search"></i> Search</a></li>
        <li><a href="logout.php" style="color:red;"><i class="fas fa-sign-out-alt"></i></a></li>
    </ul>
</nav>

<div class="admin-container">
    <div class="admin-form-card">
        <h2><i class="fas fa-plus-circle"></i> Add New Makeup Item</h2>
        <form method="POST" enctype="multipart/form-data" onsubmit="return validateProductForm()">
            <div class="form-group">
                <label>Product Name</label>
                <input type="text" name="name" required>
            </div>
            <div class="form-group" style="display:flex; gap:20px;">
                <div style="flex:1;">
                    <label>Price ($)</label>
                    <input type="number" step="0.01" name="price" required>
                </div>
                <div style="flex:1;">
                    <label>Initial Stock</label>
                    <input type="number" name="stock" required>
                </div>
            </div>
            <div class="form-group">
                <label>Skin Type</label>
                <input type="text" name="skin_type" placeholder="e.g. All Skins, Oily, Sensitive">
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" style="width:100%; height:100px; border-radius:10px; border:1px solid #ddd; padding:10px;"></textarea>
            </div>
            <div class="form-group">
                <label>Product Image</label>
                <input type="file" name="product_image" required>
            </div>
            <button type="submit" class="btn-confirm">Upload & Save Product</button>
        </form>
        <br>
        <a href="dashboard.php" style="color:#666; text-decoration:none;"><i class="fas fa-times"></i> Cancel</a>
    </div>
</div>
<script src="../assets/js/validation.js"></script>
</body>
</html>