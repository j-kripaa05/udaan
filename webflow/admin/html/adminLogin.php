<?php
include '../../../db_connect.php'; 
session_start();

$error = '';
$email = ''; // Initialize email for form persistence

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and trim inputs
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = 'admin'; // Fixed role for admin login

    if (empty($email) || empty($password)) {
        $error = "Please enter both email and password.";
    } else {
        // 1. Determine the tables and the ID column for the admin role
        $tableName = 'admins';
        $idColumn = 'admin_id';
        
        $user_data = null;
        
        // --- 2. Check for the email in the 'admins' table ---
        $sql_specific = "SELECT {$idColumn}, password_hash FROM {$tableName} WHERE email = ?";
        $stmt_specific = $conn->prepare($sql_specific);
        
        if ($stmt_specific) {
            $stmt_specific->bind_param("s", $email);
            $stmt_specific->execute();
            $result_specific = $stmt_specific->get_result();
            $user_data = $result_specific->fetch_assoc();
            $stmt_specific->close();
            
            if ($user_data) {
                // --- Case A: Email Found in the 'admins' table. Verify Password. ---
                if (password_verify($password, $user_data['password_hash'])) {
                    
                    // Success: Set session variables and log in
                    $_SESSION['user_id'] = $user_data[$idColumn]; // Store ID
                    $_SESSION['user_email'] = $email;
                    $_SESSION['user_role'] = $role; 
                    
                    // Redirect to the Admin Dashboard
                    header("Location: admin_dashboard.php");
                    exit();
                    
                } else {
                    // Scenario: Password is wrong. Use generic message for security.
                    $error = "Invalid email or password.";
                }
                
            } else {
                // --- Case B: Email NOT found in the 'admins' table. ---
                // Use generic message for security (prevents user enumeration).
                $error = "Invalid email or password.";
            }
        } else {
            // Error in preparing the main query
            $error = "An internal database error occurred. Please contact support.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Login</title>
  <link rel="stylesheet" href="../css/adminLogin.css" /> 
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
  <div class="login-container">
    <div class="logo">
        <img src="../../../images/logo.png" alt="Udaan Logo">
    </div>
    <h2 class="title">Admin Login</h2>
    <p class="subtitle">Please enter your admin credentials to continue.</p>
    
    <?php if (!empty($error)): ?>
        <p style="color: #e4379a; margin-bottom: 20px; font-weight: 500;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form id="adminLoginForm" class="form active" method="POST" action="admin_login.php">
      <div class="form-group">
        <label>Email address *</label>
        <input type="email" name="email" required value="<?php echo htmlspecialchars($email); ?>" />
      </div>
      <div class="form-group">
        <label>Password *</label>
        <input type="password" name="password" required />
      </div>
      <button type="submit" class="btn">Login</button>
    </form>
    
    <p class="account-link">Go back to <a href="login.php">user login</a></p>
  </div>

  <div class="background-circles">
    <div class="circle circle1"></div>
    <div class="circle circle2"></div>
    <div class="circle circle3"></div>
  </div>

  <script src="../js/adminLogin.js"></script> 
</body>
</html>