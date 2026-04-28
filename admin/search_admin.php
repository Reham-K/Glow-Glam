<?php 
session_start();
if (!isset($_SESSION['admin_id'])) { 
    header("Location: login.php"); 
    exit; 
}

include('../includes/db_connect.php'); 

$query = "";
if (isset($_GET['query'])) {
    $query = $conn->real_escape_string($_GET['query']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Products | Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<nav class="navbar">
    <div class="logo">Admin Dashboard</div>
    <ul class="nav-links">
        <li><a href="dashboard.php"><i class="fas fa-arrow-left"></i> Dashboard</a></li>
        <li><a href="add_product.php"><i class="fas fa-plus-circle"></i> Add</a></li>
        <li><a href="logout.php" style="color:red;"><i class="fas fa-sign-out-alt"></i></a></li>
    </ul>
</nav>

<div class="container">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-top:40px;">
            <div class="search-header">
        <h1><i class="fas fa-search"></i> Advanced Search</h1>
        <p>Find makeup items to modify or remove from the inventory.</p>
    </div>
    
    <form method="GET" action="search_admin.php" class="admin-search-form">
         <div style="display:flex; gap:10px;">
                <input type="text" name="query" placeholder="Enter Product Name or ID..." 
                       value="<?php echo htmlspecialchars($query); ?>" 
                       style="flex:1; padding:15px; border-radius:30px; border:1px solid #ddd; outline:none; font-size:1rem;">
                <button type="submit" style="background:var(--primary); color:white; border:none; padding:15px 30px; border-radius:30px; cursor:pointer;">
                    <i class="fas fa-search"></i> Search
                </button>
            </div>
        </form>
    </div>

    <?php if ($query != ""): ?>
        <h2 class="search-results-title">Results for "<?php echo htmlspecialchars($query); ?>"</h2>
        <table class="cart-table" style="margin-top:30px;">
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
                $sql = "SELECT * FROM products WHERE name LIKE '%$query%' OR product_id = '$query'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td>#<?php echo $row['product_id']; ?></td>
                            <td><img src="../assets/uploads/<?php echo $row['image_name']; ?>" class="cart-img"></td>
                            <td><?php echo $row['name']; ?></td>
                            <td>$<?php echo number_format($row['price'], 2); ?></td>
                            <td>
                                <span style="color: <?php echo ($row['stock'] < 5) ? 'red' : 'inherit'; ?>;">
                                    <?php echo $row['stock']; ?> units
                                </span>
                            </td>
                            <td>
                                <a href="edit_product.php?id=<?php echo $row['product_id']; ?>" style="color:var(--primary); font-size:1.2rem; margin-right:15px;" title="Modify">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="delete_product.php?id=<?php echo $row['product_id']; ?>" 
                                   onclick="return confirm('Delete this makeup item permanently?')" 
                                   style="color:red; font-size:1.2rem;" title="Delete">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='6' style='text-align:center; padding:40px; color:#888;'>No products match your search criteria.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    <?php else: ?>
        <div style="text-align:center; margin-top:80px; color:#ccc;">
            <i class="fas fa-search-plus" style="font-size:4rem;"></i>
            <p style="margin-top:20px;">Waiting for your search query...</p>
        </div>
    <?php endif; ?>
</div>

</body>
</html>