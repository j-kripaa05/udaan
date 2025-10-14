<?php
// Include the database connection and start session
// NOTE: Assuming db_connect.php successfully establishes $conn
include '../../db_connect.php'; 
session_start();

$error = '';
// Default to worker form active for persistence
$role = 'worker'; // Initialize role
$worker_checked = 'checked';
$employer_checked = '';
$email = ''; // Initialize email for form persistence

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and trim inputs
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    // Role selected by the hidden input field, default to 'worker'
    $role = $_POST['role'] ?? 'worker'; 

    // Set persistence for the role radio button (used in HTML below)
    if ($role === 'employer') {
        $worker_checked = '';
        $employer_checked = 'checked';
    } else {
        $worker_checked = 'checked';
        $employer_checked = '';
    }

    if (empty($email) || empty($password)) {
        $error = "Please enter both email and password.";
    } else {
        // 1. Determine the tables and the ID column based on the selected role
        $tableName = ($role === 'worker') ? 'workers' : 'employers';
        $idColumn = ($role === 'worker') ? 'worker_id' : 'employer_id';
        
        $user_data = null;
        
        // --- 2. Check for the email in the SELECTED table, fetching is_approved AND status ---
        $sql_specific = "SELECT {$idColumn}, password_hash, is_approved, status FROM {$tableName} WHERE email = ?";
        $stmt_specific = $conn->prepare($sql_specific);
        
        if ($stmt_specific) {
            $stmt_specific->bind_param("s", $email);
            $stmt_specific->execute();
            $result_specific = $stmt_specific->get_result();
            $user_data = $result_specific->fetch_assoc();
            $stmt_specific->close();
            
            if ($user_data) {
                // --- Case A: Email Found in SELECTED table. Verify Password and Approval. ---
                if (password_verify($password, $user_data['password_hash'])) {
                    
                    // NEW CHECK LOGIC: Use the status column for precise error messages
                    if ($user_data['is_approved'] == 1 && $user_data['status'] === 'APPROVED') {
                        // Success: Set session variables and log in
                        $_SESSION['user_id'] = $user_data[$idColumn]; // Store ID
                        $_SESSION['user_email'] = $email;
                        $_SESSION['user_role'] = $role; 
                        
                        // Redirect to the Home Page
                        header("Location: home.php");
                        exit();
                    } else {
                        // Account is NOT approved. Check specific status for feedback.
                        switch ($user_data['status']) {
                            case 'SUSPENDED':
                                $error = "Account is suspended. Please contact administration for assistance.";
                                break;
                            case 'REJECTED':
                                $error = "Application was rejected. Please contact administration for details.";
                                break;
                            case 'PENDING':
                            default:
                                $error = "Account not verified yet. Please wait for admin approval.";
                                break;
                        }
                    }
                    
                } else {
                    // Scenario: Password is wrong. Use generic message for security.
                    $error = "Invalid email or password.";
                }
                
            } else {
                // --- Case B: Email NOT found in SELECTED table. ---
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
  <title>Udaan Login</title>
  <link rel="stylesheet" href="../css/login.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
  <div class="login-container">
    <img src="../../images/logo.png" alt="Udaan Logo" class="logo" />
    <h2 class="title">Login</h2>
    <p class="subtitle">Welcome back! Please login to continue.</p>

    <div class="radio-group">
      <label><input type="radio" value="worker" <?php echo $worker_checked; ?>> Ready to work</label>
      <label><input type="radio" value="employer" <?php echo $employer_checked; ?>> Want to hire</label>
    </div>
    
    <?php if (!empty($error)): ?>
        <p style="color: #e4379a; margin-bottom: 20px; font-weight: 500;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form id="loginForm" class="form active" method="POST" action="login.php">
      <input type="hidden" name="role" value="<?php echo htmlspecialchars($role); ?>" id="hidden-role">
      
      <div class="form-group">
        <label>Email address *</label>
        <input type="email" name="email" required value="<?php echo htmlspecialchars($email); ?>" />
      </div>
      <div class="form-group">
        <label>Password *</label>
        <input type="password" name="password" required />
      </div>
      <div class="link-group">
        <a href="forgot-password.php" class="link">Forgot Password?</a>
      </div>
      <button type="submit" class="btn">Login</button>
    </form>

    <p class="account-link">Don't have an account? <a href="signup.php">Create one</a></p>
  </div>

  <div class="background-circles">
    <div class="circle circle1"></div>
    <div class="circle circle2"></div>
    <div class="circle circle3"></div>
  </div>

  <script>
    // Ensures the hidden role field is updated when a radio button is clicked
    document.querySelectorAll('.radio-group input[type="radio"]').forEach(radio => {
      radio.addEventListener('change', () => {
        document.getElementById('hidden-role').value = radio.value;
      });
    });
  </script>
  <script src="../js/login.js"></script> 
</body>
</html>