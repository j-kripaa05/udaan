<?php
// Include the database connection
include '../../db_connect.php'; 
session_start();

// --- Configuration ---
// Path to the uploads folder, relative to the current file (signup.php)
$uploadDir = '../../uploads/';
$worker_active = 'active';
$employer_active = '';
$worker_checked = 'checked';
$employer_checked = '';

// Function to handle file upload and return the relative path for database storage
function handleFileUpload($fileInputName, $targetDir, $conn) {
    if (isset($_FILES[$fileInputName]) && $_FILES[$fileInputName]['error'] == 0) {
        // Ensure the directory exists
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        
        $fileTmpPath = $_FILES[$fileInputName]['tmp_name'];
        $fileName = basename($_FILES[$fileInputName]['name']);
        
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedTypes = ['pdf', 'jpg', 'jpeg', 'png'];
        
        if (!in_array($fileExtension, $allowedTypes)) {
            return false;
        }

        $newFileName = uniqid('file_') . '_' . time() . '.' . $fileExtension;
        $destPath = $targetDir . $newFileName;

        if (move_uploaded_file($fileTmpPath, $destPath)) {
            // Store the path relative to the project root (e.g., 'uploads/...')
            return 'uploads/' . $newFileName; 
        }
    }
    return false;
}

// Check if the form was submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $form_type = $_POST['form_type'] ?? '';
    $is_approved = 0; // NEW: Default to unapproved

    // Get password and hash it for both forms
    $raw_password = $_POST['password'] ?? '';
    $hashed_password = password_hash($raw_password, PASSWORD_DEFAULT);

    if ($form_type === 'worker') {
        // --- Worker Form Submission ---
        
        // 1. Collect data
        $fullName = $_POST['fullName'] ?? '';
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $location = $_POST['location'] ?? '';
        $education = $_POST['education'] ?? '';
        $skills = $_POST['skills'] ?? '';
        
        // 2. Handle File Uploads
        $death_certificate_path = handleFileUpload('death_certificate', $uploadDir, $conn);
        $aadhar_card_path = handleFileUpload('aadhar_card', $uploadDir, $conn);
        
        if ($death_certificate_path && $aadhar_card_path && !empty($raw_password)) {
            // 3. Prepare and Execute SQL (Added password_hash and is_approved)
            $sql = "INSERT INTO workers (full_name, email, password_hash, phone_number, location, education, skills, death_certificate_path, aadhar_card_path, is_approved) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            
            if ($stmt) {
                // Bind the HASHED password and is_approved
                $stmt->bind_param("sssssssssi", $fullName, $email, $hashed_password, $phone, $location, $education, $skills, $death_certificate_path, $aadhar_card_path, $is_approved);

                if ($stmt->execute()) {
                    // Success: Redirect to login.php
                    header("Location: login.php"); 
                    exit();
                } else {
                    echo "<script>alert('Worker registration failed. Database error: " . htmlspecialchars($stmt->error) . "');</script>";
                    $stmt->close();
                }
            } else {
                 echo "<script>alert('SQL prepare failed for worker: " . htmlspecialchars($conn->error) . "');</script>";
            }
        } else {
             // File upload/password Error
            echo "<script>alert('Error: Please ensure password is set, and documents are uploaded correctly and are valid file types.');</script>";
        }

    } elseif ($form_type === 'employer') {
        // --- Employer Form Submission ---
        
        // Persistence Fix: Set flags to keep the employer tab active
        $worker_active = '';
        $employer_active = 'active';
        $worker_checked = '';
        $employer_checked = 'checked';
        
        // 1. Collect data
        $companyName = $_POST['companyName'] ?? '';
        $orgEmail = $_POST['orgEmail'] ?? '';
        $orgPhone = $_POST['orgPhone'] ?? '';
        $industry = $_POST['industry'] ?? '';
        $orgLocation = $_POST['orgLocation'] ?? '';
        $description = $_POST['description'] ?? '';

        if (!empty($raw_password)) {
             // 2. Prepare and Execute SQL (Added password_hash and is_approved)
            $sql = "INSERT INTO employers (company_name, email, password_hash, phone_number, industry, location, description, is_approved) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            
            if ($stmt) {
                // Bind the HASHED password and is_approved
                $stmt->bind_param("sssssssi", $companyName, $orgEmail, $hashed_password, $orgPhone, $industry, $orgLocation, $description, $is_approved);

                if ($stmt->execute()) {
                    // Success: Redirect to login.php
                    header("Location: login.php");
                    exit();
                } else {
                    echo "<script>alert('Employer registration failed. Database error: " . htmlspecialchars($stmt->error) . "');</script>";
                }
                $stmt->close();
            } else {
                 echo "<script>alert('SQL prepare failed for employer: " . htmlspecialchars($conn->error) . "');</script>";
            }
        } else {
             echo "<script>alert('Error: Please ensure the password field is filled.');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Udaan Sign Up</title>
  <link rel="stylesheet" href="../css/signup.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>

  <div class="signup-container">
    <img src="../../images/logo.png" alt="Udaan Logo" class="logo"> 

    <h2 class="title">Sign Up</h2>
    <p class="subtitle">Join us today and unlock your experience!</p>

    <div class="radio-group">
      <label><input type="radio" name="role" value="worker" <?php echo $worker_checked; ?>> Ready to work</label>
      <label><input type="radio" name="role" value="employer" <?php echo $employer_checked; ?>> Want to hire</label>
    </div>

    <form id="workerForm" class="form <?php echo $worker_active; ?>" method="POST" action="signup.php" enctype="multipart/form-data">
      <input type="hidden" name="form_type" value="worker"> 
      <div class="form-grid">
        <div class="form-group">
          <label>Full Name *</label>
          <input type="text" name="fullName" required>
        </div>
        <div class="form-group">
          <label>Email address *</label>
          <input type="email" name="email" required>
        </div>
        <div class="form-group">
          <label>Password *</label>
          <input type="password" name="password" required>
        </div>
        <div class="form-group">
          <label>Phone Number *</label>
          <input type="tel" name="phone" required>
        </div>
        <div class="form-group">
          <label>Location *</label>
          <input type="text" name="location" required>
        </div>
        <div class="form-group">
          <label>Education Background *</label>
          <input type="text" name="education" required>
        </div>
        <div class="form-group full-width">
          <label>Skills & Expertise *</label>
          <input type="text" name="skills" required>
        </div>
      </div>

      <div class="upload-section">
        <p>Documents Upload *</p>
        <div class="upload-grid">
          <div class="upload-box">
            <p>❤️ Husband’s death certificate<br><small>PDF, JPG (max 5MB)</small></p>
            <input type="file" name="death_certificate" required> 
          </div>
          <div class="upload-box">
            <p>📄 Aadhar card copy<br><small>PDF, JPG (max 5MB)</small></p>
            <input type="file" name="aadhar_card" required>
          </div>
        </div>
      </div>

      <button type="submit" class="btn">Create account</button>
    </form>

    <form id="employerForm" class="form <?php echo $employer_active; ?>" method="POST" action="signup.php" enctype="multipart/form-data">
      <input type="hidden" name="form_type" value="employer">
      <div class="form-grid">
        <div class="form-group">
          <label>Company Name *</label>
          <input type="text" name="companyName" required>
        </div>
        <div class="form-group">
          <label>Email address *</label>
          <input type="email" name="orgEmail" required>
        </div>
        <div class="form-group">
          <label>Password *</label>
          <input type="password" name="password" required>
        </div>
        <div class="form-group">
          <label>Phone Number *</label>
          <input type="tel" name="orgPhone" required>
        </div>
        <div class="form-group">
          <label>Industry *</label>
          <input type="text" name="industry" required>
        </div>
        <div class="form-group">
          <label>Location *</label>
          <input type="text" name="orgLocation" required>
        </div>
        <div class="form-group full-width">
          <label>Organization Description *</label>
          <input type="text" name="description" required>
        </div>
      </div>

      <button type="submit" class="btn">Create account</button>
    </form>
  </div>

  <div class="background-circles">
    <div class="circle circle1"></div>
    <div class="circle circle2"></div>
    <div class="circle circle3"></div>
  </div>

  <script src="../js/signup.js"></script> 
</body>
</html>