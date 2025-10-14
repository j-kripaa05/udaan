<?php
include '../../../db_connect.php';

// Check if the required parameters are set
if (!isset($_GET['action']) || !isset($_GET['type']) || !isset($_GET['id'])) {
    // Redirect back to the dashboard or send an error message
    header("Location: dashboard.php?error=Missing parameters");
    exit();
}

$action = $_GET['action']; // e.g., 'approve', 'reject', 'suspend', 'delete'
$type = $_GET['type'];     // e.g., 'worker', 'employer'
$id = (int)$_GET['id'];    // The primary key ID

// Define the table and ID column based on the type
$tableName = ($type === 'worker') ? 'workers' : (($type === 'employer') ? 'employers' : null);
$idColumn = ($type === 'worker') ? 'worker_id' : (($type === 'employer') ? 'employer_id' : null);
$deletedTableName = ($type === 'worker') ? 'deletedworker' : (($type === 'employer') ? 'deletedemployer' : null);


// Validate table name
if (!$tableName || $id === 0) {
    header("Location: dashboard.php?error=Invalid type or ID");
    exit();
}

$redirectPage = ($type === 'worker') ? 'userList.php' : 'companyList.php';

$success = false;
$status_update = '';

// --- Handle Actions ---
if ($action === 'approve') {
    $status_update = 'APPROVED';
    $sql = "UPDATE {$tableName} SET is_approved = 1, status = ? WHERE {$idColumn} = ?";
} elseif ($action === 'reject') {
    $status_update = 'REJECTED';
    $sql = "UPDATE {$tableName} SET is_approved = 0, status = ? WHERE {$idColumn} = ?";
} elseif ($action === 'suspend') {
    $status_update = 'SUSPENDED';
    $sql = "UPDATE {$tableName} SET is_approved = 0, status = ? WHERE {$idColumn} = ?";
} elseif ($action === 'delete') {
    
    // --- DELETE LOGIC: SELECT -> INSERT -> DELETE ---
    $conn->begin_transaction();
    
    try {
        // 1. SELECT all data from the row before deletion
        $select_sql = "SELECT * FROM {$tableName} WHERE {$idColumn} = ?";
        $stmt_select = $conn->prepare($select_sql);
        $stmt_select->bind_param("i", $id);
        $stmt_select->execute();
        $result = $stmt_select->get_result();
        $row_to_delete = $result->fetch_assoc();
        $stmt_select->close();
        
        if ($row_to_delete) {
            
            if ($type === 'worker') {
                // 2a. INSERT worker data into deletedWorker table
                $insert_sql = "INSERT INTO {$deletedTableName} (worker_id, full_name, email, password_hash, phone_number, location, education, skills, death_certificate_path, aadhar_card_path, is_approved, status, registration_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt_insert = $conn->prepare($insert_sql);
                $stmt_insert->bind_param("issssssssssis", 
                    $row_to_delete['worker_id'], 
                    $row_to_delete['full_name'], 
                    $row_to_delete['email'], 
                    $row_to_delete['password_hash'], 
                    $row_to_delete['phone_number'], 
                    $row_to_delete['location'], 
                    $row_to_delete['education'], 
                    $row_to_delete['skills'], 
                    $row_to_delete['death_certificate_path'], 
                    $row_to_delete['aadhar_card_path'], 
                    $row_to_delete['is_approved'], 
                    $row_to_delete['status'],
                    $row_to_delete['registration_date']
                );
            } else { // employer
                // 2b. INSERT employer data into deletedEmployer table
                $insert_sql = "INSERT INTO {$deletedTableName} (employer_id, company_name, email, password_hash, phone_number, industry, location, description, is_approved, status, registration_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt_insert = $conn->prepare($insert_sql);
                $stmt_insert->bind_param("issssssssis", 
                    $row_to_delete['employer_id'], 
                    $row_to_delete['company_name'], 
                    $row_to_delete['email'], 
                    $row_to_delete['password_hash'], 
                    $row_to_delete['phone_number'], 
                    $row_to_delete['industry'], 
                    $row_to_delete['location'], 
                    $row_to_delete['description'], 
                    $row_to_delete['is_approved'], 
                    $row_to_delete['status'],
                    $row_to_delete['registration_date']
                );
            }
            
            $stmt_insert->execute();
            $stmt_insert->close();

            // 3. DELETE from original table
            $delete_sql = "DELETE FROM {$tableName} WHERE {$idColumn} = ?";
            $stmt_delete = $conn->prepare($delete_sql);
            $stmt_delete->bind_param("i", $id);
            $stmt_delete->execute();
            $stmt_delete->close();

            $conn->commit();
            $success = true; // Transaction complete
            
        } else {
            throw new Exception("Record not found.");
        }
        
    } catch (Exception $e) {
        $conn->rollback();
        $errorMessage = "Transaction failed: " . $e->getMessage();
    }
    
} 
// End of DELETE logic

// Prepare and execute statement for Approve/Reject/Suspend
if (isset($sql)) {
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("si", $status_update, $id);
        $success = $stmt->execute();
        $stmt->close();
    }
}


// Redirect back with status message
if ($success) {
    header("Location: {$redirectPage}?status=success&action={$action}&type={$type}");
} else {
    // Use stored error message if transaction failed, otherwise get last MySQL error
    $finalErrorMessage = isset($errorMessage) ? $errorMessage : ($conn->error ? $conn->error : "Action '{$action}' failed for {$type} ID {$id}.");
    header("Location: {$redirectPage}?status=error&message=" . urlencode($finalErrorMessage));
}
exit();
?>