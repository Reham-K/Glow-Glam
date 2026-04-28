<?php 
include('includes/header.php'); 

$last_bought = isset($_COOKIE['last_purchased_name']) ? $_COOKIE['last_purchased_name'] : null;
?>

<section class="hero">
    <div class="hero-content">
        <p>Expertly Crafted For Your Smile</p>
        <h1>Pure Lip Luxury</h1>
        <a href="#shop-now" class="btn-view" style="color:white; border-color:white;">Explore Collection</a>
    </div>
</section>

<div class="container" id="shop-now">
    
    <?php if ($last_bought): ?>
        <div style="background: var(--accent); padding: 20px; border-radius: 8px; margin-bottom: 40px; margin-top: 40px; text-align: center;">
            <p>Welcome back, Glow-Getter! 💖 Still loving your <strong><?php echo htmlspecialchars($last_bought); ?></strong>? Check out our newest additions below.</p>
        </div>
    <?php endif; ?>

    <div class="section-title">
        <h2>The Signature Collection</h2>
        <p>Organic. Cruelty-Free. Timeless.</p>
    </div>

    <section class="product-grid">
        <?php
        $sql = "SELECT p.*, c.category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.category_id 
                ORDER BY p.product_id DESC";
        $res = $conn->query($sql);

        if ($res->num_rows > 0):
            while($item = $res->fetch_assoc()):
        ?>
            <div class="product-card" id="collection">
                <div class="card-img-wrapper">
                    <?php if($item['category_name']): ?>
                        <span class="category-label"><?php echo $item['category_name']; ?></span>
                    <?php endif; ?>
                    <img src="assets/uploads/<?php echo $item['image_name']; ?>" alt="<?php echo $item['name']; ?>">
                </div>
                
                <div class="card-content">
                    <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                    <p class="price">$<?php echo number_format($item['price'], 2); ?></p>
                    <a href="product_details.php?id=<?php echo $item['product_id']; ?>" class="btn-view">View Details</a>
                </div>
            </div>
        <?php 
            endwhile; 
        else:
            echo "<p>No products found in the collection.</p>";
        endif; 
        ?>
    </section>
</div>

<?php include('includes/footer.php'); ?>