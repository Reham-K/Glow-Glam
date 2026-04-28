<?php 
include('includes/db_connect.php'); 
include('includes/header.php'); 
?>

<div class="container page-header" style="margin-top: 100px;">
    
    <div class="page-header">
        <h1>Get in Touch</h1>
        <p>Visit our boutique or contact us for personalized beauty advice.</p>
    </div>

    <div class="contact-main-grid">
        
        <div class="contact-info-card">
            <h2><i class="fas fa-info-circle"></i> Contact Details</h2>
            
            <div class="contact-item">
                <i class="fas fa-map-marker-alt"></i>
                <div>
                    <strong>Boutique Address</strong>
                    <p>Building 45, Glamour St, West District<br>Dammam, Saudi Arabia</p>
                </div>
            </div>

            <div class="contact-item">
                <i class="fas fa-phone-alt"></i>
                <div>
                    <strong>Customer Support</strong>
                    <p>+966 13 000 0000</p>
                </div>
            </div>

            <div class="contact-item">
                <i class="fas fa-envelope"></i>
                <div>
                    <strong>Support Email</strong>
                    <p>care@glowglam.com</p>
                </div>
            </div>

            <div class="contact-item">
                <i class="fas fa-clock"></i>
                <div>
                    <strong>Store Hours</strong>
                    <p>Sat - Thu: 09:00 AM - 10:00 PM<br>Friday: 04:00 PM - 11:00 PM</p>
                </div>
            </div>
        </div>

        <div class="contact-form-card">
            <h2><i class="fas fa-paper-plane"></i> Send a Message</h2>
            
            <?php
            $form_message = '';
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $name = trim($_POST['name'] ?? '');
                $email = trim($_POST['email'] ?? '');
                $message = trim($_POST['message'] ?? '');
                
                if ($name && $email && $message) {
                    $form_message = '<div class="alert alert-success">Thank you! We\'ll get back to you soon. 💄</div>';
                } else {
                    $form_message = '<div class="alert alert-error">Please fill in all fields.</div>';
                }
            }
            echo $form_message;
            ?>
            
            <form method="POST" action="contact.php" class="contact-form">
                <div class="form-group">
                    <label for="name">Full Name *</label>
                    <input type="text" id="name" name="name" placeholder="Jane Doe" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email Address *</label>
                    <input type="email" id="email" name="email" placeholder="jane@example.com" required>
                </div>
                
                <div class="form-group">
                    <label for="message">Your Message *</label>
                    <textarea id="message" name="message" rows="5" placeholder="How can we help you?" required></textarea>
                </div>
                
                <button type="submit" class="btn-submit">
                    <i class="fas fa-paper-plane"></i> Send Message
                </button>
            </form>
        </div>
    </div>

    <div class="contact-map-section">
        <h3><i class="fas fa-map-marked-alt"></i> Find Us</h3>
        <div class="map-wrapper">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3575.834789547517!2d50.188734!3d26.371369!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e49e87900000001%3A0x6a086055d0458b9b!2sImam%20Abdulrahman%20Bin%20Faisal%20University!5e0!3m2!1sen!2ssa!4v1700000000000!5m2!1sen!2ssa" 
                width="100%" 
                height="400" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy"
                title="Glow & Glam Boutique Location">
            </iframe>
        </div>
    </div>

</div>

<script>
document.querySelector('.contact-form').onsubmit = function(e) {
    const name = document.getElementById('name').value.trim();
    const email = document.getElementById('email').value.trim();
    const message = document.getElementById('message').value.trim();
    const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,}$/i;
    
    if (name.length < 2) {
        e.preventDefault();
        alert('Please enter your full name.');
        document.getElementById('name').focus();
        return false;
    }
    
    if (!emailPattern.test(email)) {
        e.preventDefault();
        alert('Please enter a valid email address.');
        document.getElementById('email').focus();
        return false;
    }
    
    if (message.length < 10) {
        e.preventDefault();
        alert('Please enter a message with at least 10 characters.');
        document.getElementById('message').focus();
        return false;
    }
    
    const btn = this.querySelector('.btn-submit');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
    
    return true;
};
</script>

<?php include('includes/footer.php'); ?>