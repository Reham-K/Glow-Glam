<?php 
session_start();
if (!isset($_SESSION['admin_id'])) { header("Location: login.php"); exit; }
include('../includes/db_connect.php'); 

$id = (int)$_GET['id'];
$sql = "SELECT * FROM products WHERE product_id = $id";
$result = $conn->query($sql);
$product = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $desc = $conn->real_escape_string($_POST['description']);
    $skin = $_POST['skin_type'];
    $img_name = $product['image_name'];

    if (!empty($_FILES['product_image']['name'])) {
        $img_name = $_FILES['product_image']['name'];
        $img_tmp = $_FILES['product_image']['tmp_name'];
        move_uploaded_file($img_tmp, "../assets/uploads/" . $img_name);
    }

    $update_sql = "UPDATE products SET 
                    name='$name', 
                    price='$price', 
                    stock='$stock', 
                    description='$desc', 
                    skin_type='$skin', 
                    image_name='$img_name' 
                   WHERE product_id=$id";
    
    if ($conn->query($update_sql)) {
        header("Location: dashboard.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Product | Glow & Glam</title>
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
<div class="container" style="max-width:600px; margin-top:50px;">
    <div class="checkout-card">
        <h2><i class="fas fa-edit"></i> Edit Product #<?php echo $id; ?></h2>
        <form method="POST" enctype="multipart/form-data" onsubmit="return validateProductForm()">
            <div class="form-group">
                <label>Product Name</label>
                <input type="text" name="name" value="<?php echo $product['name']; ?>" required>
            </div>
            <div class="form-group" style="display:flex; gap:20px;">
                <div style="flex:1;">
                    <label>Price ($)</label>
                    <input type="number" step="0.01" name="price" value="<?php echo $product['price']; ?>" required>
                </div>
                <div style="flex:1;">
                    <label>Stock Quantity</label>
                    <input type="number" name="stock" value="<?php echo $product['stock']; ?>" required>
                </div>
            </div>
            <div class="form-group">
                <label>Skin Type</label>
                <input type="text" name="skin_type" value="<?php echo $product['skin_type']; ?>">
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" style="width:100%; height:100px; border-radius:10px; border:1px solid #ddd; padding:10px;"><?php echo $product['description']; ?></textarea>
            </div>
            
            <div class="form-group">
                <label>Current Image</label><br>
                <img src="../assets/uploads/<?php echo $product['image_name']; ?>" width="100" style="border-radius:10px; margin-bottom:10px;">
                <br>
                <label>Upload New Image (Leave empty to keep current)</label>
                <input type="file" name="product_image">
            </div>

            <button type="submit" class="btn-confirm">
                <i class="fas fa-save"></i> Save Changes
            </button>
        </form>
        <br>
        <a href="dashboard.php" style="color:#666; text-decoration:none;"><i class="fas fa-times"></i> Cancel</a>
    </div>
</div>
<script src="../assets/js/validation.js"></script>
</body>
</html>