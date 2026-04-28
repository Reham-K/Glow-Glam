<?php 
include('includes/db_connect.php'); 
include('includes/header.php'); 

$past_item = isset($_COOKIE['last_purchased_name']) ? $_COOKIE['last_purchased_name'] : null;
?>

<div class="container">
    <div style="margin-top:100px;">
        <h1><i class="fas fa-history"></i> Your Shopping History</h1>
        <p style="color:#666; margin-bottom:40px;">Cookies are used to remember your recent beauty picks.</p>

        <?php if ($past_item): ?>
            <div class="history-card">
                <div style="background:var(--accent); width:80px; height:80px; border-radius:15px; display:flex; align-items:center; justify-content:center;">
                    <i class="fas fa-spa" style="color:var(--primary); font-size:2rem;"></i>
                </div>
                <div>
                    <span style="font-size:0.8rem; color:var(--primary); font-weight:bold; text-transform:uppercase;">Last Purchased</span>
                    <h2 style="margin:5px 0;"><?php echo htmlspecialchars($past_item); ?></h2>
                    <p style="color:#888;">Thank you for trusting Glow & Glam with your skin!</p>
                </div>
                <div style="margin-left:auto;">
                    <a href="index.php" class="btn-view" style="padding:10px 30px;">
                        <i class="fas fa-shopping-bag"></i> Shop Similar
                    </a>
                </div>
            </div>

            <h3 style="margin-top:60px; margin-bottom:30px; text-align:center;">Handpicked Recommendations</h3>
            <div class="product-grid">
                <?php
                $recommend_sql = "SELECT * FROM products WHERE name != '$past_item' ORDER BY RAND() LIMIT 3";
                $rec_res = $conn->query($recommend_sql);
                while($rec = $rec_res->fetch_assoc()) {
                    ?>
                    <div class="card">
                        <img src="assets/uploads/<?php echo $rec['image_name']; ?>" alt="Recommendation">
                        <div class="card-info">
                            <h3><?php echo $rec['name']; ?></h3>
                            <p class="price">$<?php echo number_format($rec['price'], 2); ?></p>
                            <a href="product_details.php?id=<?php echo $rec['product_id']; ?>" class="btn-add">View More</a>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>

        <?php else: ?>
            <div style="text-align:center; padding:100px 0; background:white; border-radius:20px;">
                <i class="fas fa-cookie-bite" style="font-size:4rem; color:#eee; margin-bottom:20px;"></i>
                <h2>No previous orders found in this browser.</h2>
                <p style="margin:20px 0; color:#888;">Start your beauty journey today and your history will appear here.</p>
                <a href="index.php" class="btn-view" style="padding:15px 40px;">Browse Collection</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include('includes/footer.php'); ?>