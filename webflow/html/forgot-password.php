<?php
session_start();
$error = '';
if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Forgot Password - Udaan</title>
    <link rel="stylesheet" href="../css/login.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="login-container">
        <img src="../../images/logo.png" alt="Udaan Logo" class="logo" />
        <h2 class="title">Forgot Password</h2>
        <p class="subtitle">Enter your email to receive a password reset OTP.</p>

        <?php if (!empty($error)): ?>
            <p style="color: #e4379a; margin-bottom: 20px; font-weight: 500;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form class="form active" method="POST" action="send-otp.php">
            <div class="form-group">
                <label>Email address *</label>
                <input type="email" name="email" required />
            </div>
            <button type="submit" class="btn">Send OTP</button>
        </form>

        <p class="account-link">Remember your password? <a href="login.php">Login</a></p>
    </div>

    <div class="background-circles">
        <div class="circle circle1"></div>
        <div class="circle circle2"></div>
        <div class="circle circle3"></div>
    </div>
</body>
</html>