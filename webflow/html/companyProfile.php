<?php 
// 1. START SESSION IMMEDIATELY (Fixes the redirect issue)
session_start();
include '../../db_connect.php'; 

// --- 2. Security Check: Must be logged in as an Employer ---
// This check now runs AFTER session_start() has loaded the $_SESSION array.
if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] ?? null) !== 'employer') {
    // Redirect to login page if not logged in or not an employer
    header("Location: login.php");
    exit();
}

$employer_id = $_SESSION['user_id'];
$employer_data = null;
$error = null;

// --- 3. Fetch Employer Data with all required fields ---
$sql = "SELECT employer_id, company_name, email, phone_number, industry, location, description, 
               logo_path, website, founded_year, num_employees 
        FROM employers WHERE employer_id = ?";

$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("i", $employer_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $employer_data = $result->fetch_assoc();
    $stmt->close();
} else {
    $error = "Database error fetching profile: " . $conn->error;
}

// --- 4. Process and Sanitize Data ---
$companyName = htmlspecialchars($employer_data['company_name'] ?? 'N/A');
$industry = htmlspecialchars($employer_data['industry'] ?? 'N/A');
$location = htmlspecialchars($employer_data['location'] ?? 'N/A');
$email = htmlspecialchars($employer_data['email'] ?? 'N/A');
$contact = htmlspecialchars($employer_data['phone_number'] ?? 'N/A');
$description = htmlspecialchars($employer_data['description'] ?? 'No description provided.');

$website = htmlspecialchars($employer_data['website'] ?? 'N/A');
$founded = htmlspecialchars($employer_data['founded_year'] ?? 'N/A');
$employees = htmlspecialchars($employer_data['num_employees'] ?? 'N/A');

$db_logo_path = $employer_data['logo_path'] ?? '';
$logo_path = !empty($db_logo_path) ? '../../' . $db_logo_path : '../../images/profile.png';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $companyName; ?> - Business Profile</title>
    <link rel="stylesheet" href="../css/companyProfile.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <!-- HEADER.PHP MUST NOW NOT CONTAIN session_start() to avoid the NOTICE -->
    <?php include '../../header.php'; ?>
    <div class="container">
        <h1 class="page-title"><i class="fas fa-briefcase"></i> Business Profile</h1>
        
        <?php if ($error): ?>
            <div class='alert-error' style='padding:15px; margin-bottom:20px; color:#991b1b; background:#fee2e2; border-radius:5px;'><?php echo $error; ?></div>
        <?php endif; ?>

        <div class="main-profile-top-section">

            <aside class="sidebar-container">

                <div class="card profile-card-top">
                    <div class="profile-header-side">
                        <!-- DYNAMIC LOGO PATH -->
                        <img src="<?php echo $logo_path; ?>" alt="Profile Avatar" class="profile-avatar">
                        <h2 class="company-name-side"><?php echo $companyName; ?></h2>
                        <p><?php echo $industry; ?></p>
                        <button class="btn btn-edit-profile" id="edit-profile-btn"><i class="fas fa-edit"></i> Edit Profile</button>
                    </div>
                </div>

                <div class="card quick-details-card">
                    <h3>Quick Details</h3>
                    <!-- Dynamic Quick Details -->
                    <div class="detail-item"><span>Industry</span> **<?php echo $industry; ?>**</div>
                    <div class="detail-item"><span>Founded</span> **<?php echo $founded; ?>**</div>
                    <div class="detail-item"><span>Employees</span> **<?php echo $employees; ?>**</div>
                    <div class="detail-item"><span>Location</span> **<?php echo $location; ?>**</div>
                </div>

            </aside>
            <main class="content-area-top">

                <div class="card company-info-card" id="company-info-form">
                    <h4>Company Information</h4>
                    <p class="subtitle">Keep your profile up to date</p>
                    <div class="info-grid">
                        <div class="input-group"><span>Company Name</span><input type="text"
                                value="<?php echo $companyName; ?>" disabled></div>
                        <div class="input-group"><span>Industry Type</span><input type="text"
                                value="<?php echo $industry; ?>" disabled></div>
                        <div class="input-group"><span>Location</span><input type="text"
                                value="<?php echo $location; ?>" disabled></div>
                        <div class="input-group"><span>Website</span><input type="text" value="<?php echo $website; ?>" disabled>
                        </div>
                        <div class="input-group"><span>Contact Number</span><input type="text"
                                value="<?php echo $contact; ?>" disabled></div>
                        <div class="input-group"><span>Email Address</span><input type="text"
                                value="<?php echo $email; ?>" disabled></div>
                        <div class="input-group full-width">
                            <span>Company Description</span>
                            <textarea disabled><?php echo $description; ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="stats-bar">
                    <!-- Static Stats -->
                    <div class="stat-item stat-blue">
                        <i class="fas fa-briefcase"></i>
                        <div class="stat-content">
                            <div class="value">2</div>
                            <div class="label">Active Vacancies</div>
                        </div>
                    </div>
                    <div class="stat-item stat-pink">
                        <i class="fas fa-users"></i>
                        <div class="stat-content">
                            <div class="value">86</div>
                            <div class="label">Total Applicants</div>
                        </div>
                    </div>
                    <div class="stat-item stat-orange">
                        <i class="fas fa-clock"></i>
                        <div class="stat-content">
                            <div class="value">2</div>
                            <div class="label">Pending Reviews</div>
                        </div>
                    </div>
                    <div class="stat-item stat-green">
                        <i class="fas fa-chart-line"></i>
                        <div class="stat-content">
                            <div class="value">88%</div>
                            <div class="label">Success Rate</div>
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <div class="full-width-tabs">
            <!-- Tab Navigation -->
            <div class="content-tab-nav">
                <button class="tab-button active" data-tab="vacancies">Active Vacancies</button>
                <button class="tab-button" data-tab="reviews">Candidate Reviews</button>
                <button class="tab-button" data-tab="analytics">Hiring Performance</button>
            </div>

            <div id="vacancies" class="tab-content active">
                <div class="card vacancy-card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-clipboard-list"></i> Active Job Vacancies (2)</h3>
                        <button class="btn btn-post-job" id="post-job-btn"><i class="fas fa-plus"></i> Post new job</button>
                    </div>
                    <!-- Job List content here -->
                </div>
            </div>

            <div id="reviews" class="tab-content">
                 <!-- Candidate Reviews content here -->
            </div>

            <div id="analytics" class="tab-content">
                 <!-- Hiring Funnel Analysis content here -->
            </div>
        </div>
    </div>

    <div id="job-modal" class="modal-overlay">
        <!-- Modal Content Here -->
    </div>

    <script src="../js/companyProfile.js"></script>
    <?php include '../../footer.php'; ?>
</body>

</html>