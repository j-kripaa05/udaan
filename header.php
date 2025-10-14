<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Include the database connection for fetching the user name
include 'db_connect.php'; 

// Function to determine if a link is active based on the current page's filename
function isActive($link_basename) {
    // basename($_SERVER['PHP_SELF']) returns the current file name (e.g., 'home.php')
    $current_page_basename = basename($_SERVER['PHP_SELF']);
    return (strtolower($link_basename) == strtolower($current_page_basename)) ? 'class="active"' : '';
}

// --- LOGGED-IN USER LOGIC ---
$loggedInUserName = null;
$userRole = $_SESSION['user_role'] ?? null;
$profileLink = null;

if (isset($_SESSION['user_email']) && isset($_SESSION['user_role'])) {
    $email = $_SESSION['user_email'];
    $role = $_SESSION['user_role'];
    
    $tableName = ($role === 'worker') ? 'workers' : 'employers';
    $nameColumn = ($role === 'worker') ? 'full_name' : 'company_name';
    
    // Fetch the user's name (full_name for worker, company_name for employer)
    $sql = "SELECT {$nameColumn} AS user_name FROM {$tableName} WHERE email = ?";
    
    // Use a try-catch or explicit check to handle potential DB errors
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        
        if ($user) {
            // Use the full name/company name
            $loggedInUserName = htmlspecialchars($user['user_name']);
            
            // Set the profile link if the user is an employer
            if ($role === 'employer') {
                // The current file location is usually /udaan_frontend/header.php
                // The target is /udaan_frontend/webflow/html/companyProfile.php
                $profileLink = '../html/companyProfile.php';
            }
        }
    }
}
?>
<header class="navbar">
    <div class="logo">
        <!-- Logo link needs adjustment if header.php is included in different directories -->
        <a href="../html/home.php"><img src="../../images/logo.png" alt="Udaan Logo"></a>
    </div>

    <nav class="nav-menu">
        <ul class="nav-links">
            <li><a href="home.php" <?php echo isActive('home.php'); ?>>Home</a></li>
            <li><a href="aboutus.php" <?php echo isActive('aboutus.php'); ?>>About Us</a></li>
            <li><a href="women.php" <?php echo isActive('women.php'); ?>>Women</a></li>
            <li><a href="opportunities.php" <?php echo isActive('opportunities.php'); ?>>Opportunities</a></li>
        </ul>
    </nav>

    <div class="nav-right">
        <?php if ($loggedInUserName): ?>
            <!-- NEW PROFILE LINK LOGIC -->
            <span class="user-name">
                Hello, 
                <?php if ($profileLink): ?>
                    <!-- If it's an employer, wrap the name in a link -->
                    <a href="<?php echo $profileLink; ?>" class="profile-link">
                        <?php echo htmlspecialchars(explode(' ', $loggedInUserName)[0]); ?>!
                    </a>
                <?php else: ?>
                    <!-- For workers, just display the first name -->
                    <?php echo htmlspecialchars(explode(' ', $loggedInUserName)[0]); ?>!
                <?php endif; ?>
            </span>
            <a href="logout.php" class="btn-outline">Logout</a>
        <?php else: ?>
            <select class="lang">
                <option>EN English</option>
                <option>हि हिन्दी</option>
                <option>ગુ ગુજરાતી</option>
            </select>
            <a href="login.php" class="btn-outline">Log In</a>
            <a href="signup.php" class="btn-primary-header">Sign Up</a>
        <?php endif; ?>
    </div>
</header>
