<?php 
session_start();
include('../includes/db_connect.php'); 

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password']; 
    $sql = "SELECT * FROM admins WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['admin_id'] = $username;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid Username or Password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login | Glow & Glam</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .login-box {
            max-width: 400px; margin: 100px auto; padding: 40px;
            background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            text-align: center;
        }
        .btn-login {
            width: 100%; padding: 12px; background: var(--primary); color: white;
            border: none; border-radius: 25px; cursor: pointer; font-weight: bold;
        }
    </style>
</head>
<body style="background: var(--accent);">

<body class="login-wrapper">
<div class="login-box">
    <h1 style="color:var(--primary);"><i class="fas fa-user-shield"></i></h1>
    <h2>Manager Login</h2>
    <p style="margin-bottom:20px; color:#666;">Enter your credentials to manage the shop.</p>

    <?php if($error): ?>
        <p style="color:red; margin-bottom:15px;"><i class="fas fa-exclamation-circle"></i> <?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST" action="login.php" onsubmit="return validateLoginForm()">
        <div class="form-group" style="text-align:left;">
            <label><i class="fas fa-user"></i> Username</label>
            <input type="text" name="username" required>
        </div>
        <div class="form-group" style="text-align:left;">
            <label><i class="fas fa-lock"></i> Password</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit" class="btn-login">Login <i class="fas fa-sign-in-alt"></i></button>
    </form>
    <br>
    <a href="../index.php" style="text-decoration:none; color:#888; font-size:0.9rem;"><i class="fas fa-arrow-left"></i> Back to Shop</a>
</div>
</div>
<script src="../assets/js/validation.js"></script>
</body>
</html>