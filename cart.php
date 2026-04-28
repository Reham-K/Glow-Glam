<?php 
include('includes/db_connect.php'); 
include('includes/header.php'); 

if (isset($_GET['action'])) {
    $id = (int)$_GET['id'];
    
    if ($_GET['action'] == 'delete') {
        unset($_SESSION['cart'][$id]);
    }
    
    if ($_GET['action'] == 'clear') {
        unset($_SESSION['cart']);
    }
    
    header("Location: cart.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_cart'])) {
    foreach ($_POST['quantity'] as $id => $qty) {
        $qty = (int)$qty;
        
        $res = $conn->query("SELECT stock FROM products WHERE product_id = $id");
        $product = $res->fetch_assoc();
        
        if ($qty > 0 && $qty <= $product['stock']) {
            $_SESSION['cart'][$id] = $qty;
        } elseif ($qty > $product['stock']) {
            echo "<script>alert('Error: Not enough stock for some items.');</script>";
        }
    }
}
?>

<div class="container cart" >
    <h1 style="margin-top:40px;"><i class="fas fa-shopping-bag"></i> Your Shopping Bag</h1>

    <?php if (!empty($_SESSION['cart'])): ?>
        <form action="cart.php" method="POST">
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $grand_total = 0;
                    foreach ($_SESSION['cart'] as $id => $qty): 
                        $res = $conn->query("SELECT * FROM products WHERE product_id = $id");
                        $item = $res->fetch_assoc();
                        $subtotal = $item['price'] * $qty;
                        $grand_total += $subtotal;
                    ?>
                    <tr>
                        <td>
                            <div style="display:flex; align-items:center; gap:15px;">
                                <img src="assets/uploads/<?php echo $item['image_name']; ?>" class="cart-img">
                                <strong><?php echo $item['name']; ?></strong>
                            </div>
                        </td>
                        <td>$<?php echo number_format($item['price'], 2); ?></td>
                        <td>
                            <input type="number" name="quantity[<?php echo $id; ?>]" value="<?php echo $qty; ?>" min="1" class="qty-input" style="width:60px;">
                        </td>
                        <td>$<?php echo number_format($subtotal, 2); ?></td>
                        <td>
                            <a href="cart.php?action=delete&id=<?php echo $id; ?>" class="btn-delete" title="Remove">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="cart-summary">
                <p style="font-size:1.2rem; margin-bottom:10px;">Total Items: <strong><?php echo count($_SESSION['cart']); ?></strong></p>
                <h2>Grand Total: $<?php echo number_format($grand_total, 2); ?></h2>
                
                <div style="margin-top:30px;">
                    <button type="submit" name="update_cart" class="btn-clear update_cart" >
                        <i class="fas fa-sync-alt"></i> Update Cart
                    </button>
                    
                    <a href="cart.php?action=clear" class="btn-clear">
                        <i class="fas fa-eraser"></i> Empty Bag
                    </a>
                    
                    <a href="checkout.php" class="btn-checkout">
                        Proceed to Checkout <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </form>

    <?php else: ?>
        <div class="empty-cart">
            <i class="fas fa-shopping-basket"></i>
            <h2>Your bag is currently empty.</h2>
            <p style="text-align:center;">Looking for that perfect glow? Browse our shop for natural beauty essentials.</p>
            <a href="index.php" class="btn-view">Continue Shopping</a>
        </div>
    <?php endif; ?>
</div>

<?php include('includes/footer.php'); ?>