<?php
include('includes/db_connect.php'); 
include('includes/header.php'); 

$product = null;
$success_msg = $error_msg = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $product_id = (int)$_POST['product_id'];
    $quantity = (int)$_POST['quantity'];
    $stock = (int)$_POST['stock_available'];
    
    if ($quantity > 0 && $quantity <= $stock) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] += $quantity;
        } else {
            $_SESSION['cart'][$product_id] = $quantity;
        }
        $product_name = isset($_POST['product_name']) ? $_POST['product_name'] : 'Item';
        setcookie('last_purchased_name', $product_name, time() + (30 * 24 * 60 * 60), '/');
        $success_msg = " Added to your bag!";
    } else {
        $error_msg = " Invalid quantity or out of stock.";
    }
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    }
}

if (!$product) {
    echo "<div class='container'><h1 style='margin: 100px 0; text-align: center;'>Product not found.</h1></div>";
    include('includes/footer.php');
    exit;
}
?>

<div class="container">
    
    <div class="details-container">
        
        <div class="details-image">
            <img src="assets/uploads/<?php echo htmlspecialchars($product['image_name']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
        </div>

        <div class="details-info">
            <h1><?php echo htmlspecialchars($product['name']); ?></h1>
            <p class="price">$<?php echo number_format($product['price'], 2); ?></p>
            
            <div class="stock-status">
                <i class="fas fa-boxes"></i> 
                Stock: <span class="<?php echo ($product['stock'] > 0) ? 'stock-available' : 'stock-low'; ?>">
                    <?php echo ($product['stock'] > 0) ? $product['stock'] . ' units available' : 'Out of Stock'; ?>
                </span>
            </div>

            <p class="product-description">
                <?php echo nl2br(htmlspecialchars($product['description'])); ?>
            </p>

            <form method="POST" id="addToCartForm">
                <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                <input type="hidden" name="stock_available" value="<?php echo $product['stock']; ?>">
                
                <label for="quantity">Quantity:</label>
                <input type="number" name="quantity" id="quantity" class="qty-input" value="1" min="1" max="<?php echo $product['stock']; ?>">
                
                <button type="submit" name="add_to_cart" class="btn-cart" <?php echo ($product['stock'] <= 0) ? 'disabled' : ''; ?>>
                    <i class="fas fa-cart-plus"></i> 
                    <?php echo ($product['stock'] <= 0) ? 'Out of Stock' : 'Add to Shopping Bag'; ?>
                </button>
            </form>

            <hr>

            <button type="button" onclick="openHelp()" class="help-btn">
                <i class="fas fa-info-circle"></i> Need help with this product?
            </button>
    <?php if (isset($success_msg)): ?>
        <div class="alert alert-success"><?php echo $success_msg; ?></div>
    <?php endif; ?>
    <?php if (isset($error_msg)): ?>
        <div class="alert alert-error"><?php echo $error_msg; ?></div>
    <?php endif; ?>
        </div>
        
    </div>
    
</div>

<!-- Help Modal -->
<div id="helpModal" class="modal">
    <div class="modal-content">
        <span class="close-modal" onclick="closeHelp()">&times;</span>
        <h2>How to use?</h2>
        <p>Apply a small amount to clean lips. For best results with <strong><?php echo htmlspecialchars($product['name']); ?></strong>, apply in thin layers and blot gently.</p>
        <p class="modal-note">Dermatologist tested • Safe for sensitive skin</p>
    </div>
</div>

<!-- JavaScript for Validation & Modal -->
<script>
    function openHelp() { document.getElementById('helpModal').style.display = 'flex'; }
    function closeHelp() { document.getElementById('helpModal').style.display = 'none'; }

    // Form Validation
    document.getElementById('addToCartForm').onsubmit = function(e) {
        const qty = parseInt(document.getElementById('quantity').value);
        const stock = <?php echo (int)$product['stock']; ?>;

        if (qty <= 0) {
            e.preventDefault();
            alert("Please enter a valid quantity.");
            return false;
        }
        if (qty > stock) {
            e.preventDefault();
            alert("Only " + stock + " items available in stock.");
            return false;
        }
        return true;
    };

    // Close modal on outside click
    window.onclick = function(event) {
        const modal = document.getElementById('helpModal');
        if (event.target === modal) { closeHelp(); }
    }
</script>

<?php include('includes/footer.php'); ?>