
<?php
session_start();
require_once 'db_connect.php';

$total_items = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $qty) {
        $total_items += $qty;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Glow & Glam | Luxury Lip Care</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,400&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<header class="site-header">
    <div class="container">
        <a href="index.php" class="logo">Glow & Glam</a>
        <?php
function is_active($page) {
    $current = basename($_SERVER['PHP_SELF']);
    return ($current === $page) ? 'active' : '';
}
?>

<nav class="main-nav">
    <ul>
        <li><a href="index.php" class="<?php echo is_active('index.php'); ?>">Home</a></li>
        <li><a href="index.php#collection" >Collection</a></li>
        <li><a href="past_purchases.php" class="<?php echo is_active('past_purchases.php'); ?>">Orders</a></li>
        <li><a href="contact.php" class="<?php echo is_active('contact.php'); ?>">Contact</a></li>
        <li><a href="admin/login.php" class="admin-link">Admin</a></li>
    </ul>
</nav>
        <div class="header-icons">
            <a href="admin/login.php" title="Admin Access"><i class="far fa-user-circle"></i></a>
            <a href="cart.php" class="cart-link">
                <i class="fas fa-shopping-bag"></i>
                <?php if ($total_items > 0): ?>
                    <span class="cart-count-badge"><?php echo $total_items; ?></span>
                <?php endif; ?>
            </a>
        </div>
    </div>
</header>

<main id="main-content">