<?php 
include('includes/db_connect.php'); 
include('includes/header.php'); 

if (empty($_SESSION['cart'])) {
    header("Location: index.php");
    exit;
}

$order_placed = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['place_order'])) {
    $customer_email = $conn->real_escape_string($_POST['email']);
    $customer_name = $conn->real_escape_string($_POST['fullname']);
    $customer_address = $conn->real_escape_string($_POST['address']);
    $last_purchased_name = "";

    foreach ($_SESSION['cart'] as $id => $qty) {
        $res = $conn->query("SELECT name, stock, price FROM products WHERE product_id = $id");
        $product = $res->fetch_assoc();
        $last_purchased_name = $product['name'];

        $new_stock = $product['stock'] - $qty;
        $conn->query("UPDATE products SET stock = $new_stock WHERE product_id = $id");

        $unit_price = $product['price'];
        $total = $unit_price * $qty;
        $pname = $conn->real_escape_string($product['name']);
        $cname = $conn->real_escape_string($customer_name);
        $cemail = $conn->real_escape_string($customer_email);
        $caddr = $conn->real_escape_string($_POST['address']);
        $conn->query("INSERT INTO orders (customer_name, customer_email, customer_address, product_id, product_name, quantity, unit_price, total_price) 
                  VALUES ('$cname', '$cemail', '$caddr', $id, '$pname', $qty, $unit_price, $total)");
}
    setcookie('last_purchased_name', $last_purchased_name, time() + (86400 * 30), "/");

    unset($_SESSION['cart']);
    $order_placed = true;
}
?>

<div class="container check-out">
    <?php if (!$order_placed): ?>
        <h1 style="margin-top:40px;"><i class="fas fa-credit-card"></i> Checkout</h1>
        
        <div class="checkout-grid">
            <div class="checkout-card">
                <h2><i class="fas fa-user-edit"></i> Shipping Details</h2>
                <form id="checkoutForm" method="POST" action="checkout.php">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="fullname" id="fullname" placeholder="Jane Doe">
                    </div>
                    <div class="form-group">
                        <label>Email Address (For order tracking)</label>
                        <input type="email" name="email" id="email" placeholder="jane@example.com">
                    </div>
                    <div class="form-group">
                        <label>Shipping Address</label>
                        <input type="text" name="address" id="address" placeholder="123 Beauty St, Glow City">
                    </div>
                    
                    <button type="submit" name="place_order" class="btn-confirm">
                        <i class="fas fa-check-circle"></i> Confirm Purchase
                    </button>
                </form>
            </div>

            <div class="checkout-card" style="background: var(--accent);">
                <h2><i class="fas fa-list-ul"></i> Order Summary</h2>
                <?php 
                $grand_total = 0;
                foreach ($_SESSION['cart'] as $id => $qty): 
                    $res = $conn->query("SELECT * FROM products WHERE product_id = $id");
                    $item = $res->fetch_assoc();
                    $subtotal = $item['price'] * $qty;
                    $grand_total += $subtotal;
                ?>
                <div class="summary-item">
                    <span><?php echo $item['name']; ?> (x<?php echo $qty; ?>)</span>
                    <strong>$<?php echo number_format($subtotal, 2); ?></strong>
                </div>
                <?php endforeach; ?>
                
                <hr style="margin: 20px 0; border: 0; border-top: 1px solid #ddd;">
                <div class="summary-item" style="font-size: 1.3rem; color: var(--dark);">
                    <span>Total Amount</span>
                    <strong>$<?php echo number_format($grand_total, 2); ?></strong>
                </div>
            </div>
        </div>

    <?php else: ?>
        <div class="success-box">
            <i class="fas fa-heart"></i>
            <h1>Thank you for your order!</h1>
            <p style="margin:20px 0; color:#666;">Your natural beauty products are being prepared for shipping.</p>
            <p>A confirmation email has been sent to your address.</p>
            <br>
            <a href="index.php" class="btn-view"><i class="fas fa-shopping-bag"></i> Continue Shopping</a>
        </div>
    <?php endif; ?>
</div>

<script>
document.getElementById('checkoutForm').onsubmit = function(e) {
    const name = document.getElementById('fullname').value.trim();
    const email = document.getElementById('email').value.trim();
    const address = document.getElementById('address').value.trim();
    const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;

    if (name === "" || email === "" || address === "") {
        alert("Please fill in all the required fields.");
        return false;
    }

    if (!email.match(emailPattern)) {
        alert("Please enter a valid email address.");
        return false;
    }

    return true; 
};
</script>

<?php include('includes/footer.php'); ?>