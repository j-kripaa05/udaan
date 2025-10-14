<?php
session_start();
include '../../db_connect.php';
$error = '';
$success = '';

if (!isset($_SESSION['email'])) {
    header("Location: forgot-password.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $otp_entered = $_POST['otp'];
    $new_password = $_POST['new_password'];

    if ($otp_entered == $_SESSION['otp']) {
        // OTP is correct, update the password
        $email = $_SESSION['email'];
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Determine if the user is a worker or an employer
        $sql_worker = "SELECT * FROM workers WHERE email = ?";
        $stmt_worker = $conn->prepare($sql_worker);
        $stmt_worker->bind_param("s", $email);
        $stmt_worker->execute();
        $result_worker = $stmt_worker->get_result();

        if ($result_worker->num_rows > 0) {
            $table = 'workers';
        } else {
            $table = 'employers';
        }

        // Update the password in the correct table
        $sql_update = "UPDATE $table SET password_hash = ? WHERE email = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("ss", $hashed_password, $email);
        $stmt_update->execute();

        // Unset session variables and redirect to login
        unset($_SESSION['otp']);
        unset($_SESSION['email']);

        $_SESSION['success'] = "Your password has been reset successfully. You can now log in.";
        header("Location: login.php");
        exit();

    } else {
        $error = "Invalid OTP. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Reset Password - Udaan</title>
    <link rel="stylesheet" href="../css/login.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="login-container">
        <img src="../../images/logo.png" alt="Udaan Logo" class="logo" />
        <h2 class="title">Reset Password</h2>
        <p class="subtitle">Enter the OTP sent to your email and your new password.</p>

        <?php if (!empty($error)): ?>
            <p style="color: #e4379a; margin-bottom: 20px; font-weight: 500;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form class="form active" method="POST" action="reset-password.php">
            <div class="form-group">
                <label>Enter OTP *</label>
                <input type="text" name="otp" required />
            </div>
            <div class="form-group">
                <label>New Password *</label>
                <input type="password" name="new_password" required />
            </div>
            <button type="submit" class="btn">Reset Password</button>
        </form>
    </div>

    <div class="background-circles">
        <div class="circle circle1"></div>
        <div class="circle circle2"></div>
        <div class="circle circle3"></div>
    </div>
</body>
</html>