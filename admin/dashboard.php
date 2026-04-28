<?php 
session_start();
if (!isset($_SESSION['admin_id'])) { header("Location: login.php"); exit; }
include('../includes/db_connect.php'); 

$search = "";
if (isset($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard | Makeup Store</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<nav class="navbar">
    <div class="logo">Admin Dashboard | <?php echo $_SESSION['admin_id']; ?></div>
    <ul class="nav-links">
        <li><a href="dashboard.php"><i class="fas fa-th-list"></i> Products</a></li>
        <li><a href="add_product.php"><i class="fas fa-plus-circle"></i> Add New</a></li>
        <li><a href="search_admin.php"><i class="fas fa-search"></i> Search</a></li>

        <li><a href="logout.php" style="color:red;"><i class="fas fa-sign-out-alt"></i></a></li>
    </ul>
</nav>

<div class="container">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-top:40px;">
        <h1><i class="fas fa-boxes"></i> Product Management</h1>
        
        <form method="GET" action="dashboard.php" style="display:flex; gap:10px;">
            <input type="text" name="search" placeholder="Search product..." value="<?php echo $search; ?>" 
                   style="padding:10px; border-radius:20px; border:1px solid #ddd; width:250px;">
            <button type="submit" style="background:var(--dark); color:black; border: 1px solid #ccc; padding:10px 20px; border-radius:50px; cursor:pointer;">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>

        <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM products WHERE name LIKE '%$search%' ORDER BY product_id DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
    echo "<tr>
        <td data-label=\"ID\">#{$row['product_id']}</td>
        <td data-label=\"Image\"><img src=\"../assets/uploads/{$row['image_name']}\" class=\"cart-img\"></td>
        <td>{$row['name']}</td>
        <td>\${$row['price']}</td>
        <td>{$row['stock']} units</td>
        <td>
            <a href='edit_product.php?id={$row['product_id']}' style='color:blue; margin-right:15px;'><i class='fas fa-edit'></i></a>
            <a href='delete_product.php?id={$row['product_id']}' onclick='return confirm(\"Are you sure?\")' style='color:red;'><i class='fas fa-trash'></i></a>
        </td>
    </tr>";
                }
            } else {
                echo "<tr><td colspan='6' style='text-align:center;'>No products found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>