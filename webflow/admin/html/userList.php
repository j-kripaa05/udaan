<?php include '../../../db_connect.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Users</title>
    <link rel="stylesheet" href="../css/userList.css" />
    <script src="https://kit.fontawesome.com/a2e0e9c6ef.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>

<body>
    <div class="dashboard">
        <aside class="sidebar">
            <div class="profile"></div>
            <ul>
                <a href="dashboard.php">
                    <li><i class="fa-solid fa-chart-line"></i></li>
                </a>
                <a href="companyList.php">
                    <li><i class="fa-solid fa-building"></i></li>
                </a>
                <a href="userList.php">
                    <li class="active"><i class="fa-solid fa-users"></i></li>
                </a>
                <a href="jobListing.php">
                    <li><i class="fa-solid fa-briefcase"></i></li>
                </a>
            </ul>
        </aside>

        <main class="main">
            <header class="header">
                <h1>Users</h1>
                <div class="icons">
                    <i class="fa-regular fa-bell"></i>
                    <i class="fa-regular fa-user"></i>
                </div>
            </header>
            <div class="search-box">
                <input type="text" placeholder="Search" id="searchInput" />
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>


            <section class="table-section">
                <div class="table-header">
                    <h3>List of Job Seekers</h3>
                    <p>Showing 9/16</p>
                </div>

                <?php
                if (isset($_GET['status']) && $_GET['status'] == 'success') {
                    $action_name = htmlspecialchars($_GET['action']);
                    echo "<div class='alert-success'>Worker successfully " . $action_name . "d!</div>";
                } elseif (isset($_GET['status']) && $_GET['status'] == 'error') {
                    $error_message = htmlspecialchars($_GET['message']);
                    echo "<div class='alert-error'>Error processing request: " . $error_message . "</div>";
                }
                ?>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Name</th>
                                <th>Email id</th>
                                <th>Contact No.</th>
                                <th>Location</th>
                                <th>Skills</th>
                                <th>Documents</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="userTable">
                            <?php
                            // Fetch data from the workers table
                            $sql = "SELECT worker_id, full_name, email, phone_number, location, skills, death_certificate_path, aadhar_card_path, is_approved, status FROM workers ORDER BY worker_id ASC";
                            $result = $conn->query($sql);

                            if ($result && $result->num_rows > 0) {
                                $count = 1;
                                while($row = $result->fetch_assoc()) {
                                    $current_status = htmlspecialchars($row['status']);
                                    $id = (int)$row['worker_id'];
                                    $type = 'worker';
                                    
                                    // Process skills field: assume comma-separated list
                                    $skill_string = htmlspecialchars($row['skills']);
                                    $skills_array = explode(',', $skill_string);
                                    $skill_tags = '';
                                    foreach ($skills_array as $skill) {
                                        $trimmed_skill = trim($skill);
                                        if (!empty($trimmed_skill)) {
                                            $skill_tags .= "<span class=\"skill-tag\">" . $trimmed_skill . "</span> ";
                                        }
                                    }

                                    // Determine status class for styling
                                    $status_class = 'status-pending';
                                    if ($current_status === 'APPROVED') {
                                        $status_class = 'status-approved';
                                    } elseif ($current_status === 'REJECTED') {
                                        $status_class = 'status-rejected';
                                    } elseif ($current_status === 'SUSPENDED') {
                                        $status_class = 'status-suspended';
                                    }
                                    $status_text = '<span class="' . $status_class . '">' . ucfirst(strtolower($current_status)) . '</span>';
                                    
                                    // Generate secure document links (URL is relative to HTML file)
                                    $death_cert_path = htmlspecialchars($row['death_certificate_path']);
                                    $aadhar_path = htmlspecialchars($row['aadhar_card_path']);
                                    

                                    echo "
                                    <tr>
                                        <td>" . $count++ . "</td>
                                        <td>" . htmlspecialchars($row['full_name']) . "</td>
                                        <td>" . htmlspecialchars($row['email']) . "</td>
                                        <td>" . htmlspecialchars($row['phone_number']) . "</td>
                                        <td>" . htmlspecialchars($row['location']) . "</td>
                                        <td class=\"skills-column\">" . $skill_tags . "</td>
                                        <td class=\"documents-column\">
                                            <a href=\"../../../" . $death_cert_path . "\" target=\"_blank\" class=\"doc-link\" title=\"Death Certificate\">View Cert</a> |
                                            <a href=\"../../../" . $aadhar_path . "\" target=\"_blank\" class=\"doc-link\" title=\"Aadhar Card\">View Aadhar</a>
                                        </td>
                                        <td>" . $status_text . "</td>
                                        <td class=\"actions-icons\">";

                                    // --- CONDITIONAL LOGIC ---
                                    
                                    if ($current_status === 'APPROVED') {
                                        // Approved: Only show SUSPEND and DELETE
                                        echo "<a href=\"handle_admin_action.php?action=suspend&type={$type}&id={$id}\" title=\"Suspend\" class=\"action-icon suspend-icon\"><i class=\"fa-solid fa-ban\"></i></a>";
                                        
                                    } elseif ($current_status === 'SUSPENDED') {
                                        // Suspended: Only show REACTIVATE (Approve) and DELETE
                                        echo "<a href=\"handle_admin_action.php?action=approve&type={$type}&id={$id}\" title=\"Reactivate\" class=\"action-icon accept-icon\"><i class=\"fa-solid fa-arrow-rotate-right\"></i></a>";

                                    } elseif ($current_status === 'PENDING' || $current_status === 'REJECTED') {
                                        // Pending/Rejected: Show ACCEPT and REJECT (or re-reject)
                                        echo "<a href=\"handle_admin_action.php?action=approve&type={$type}&id={$id}\" title=\"Accept\" class=\"action-icon accept-icon\"><i class=\"fa-solid fa-check\"></i></a>";
                                        echo "<a href=\"handle_admin_action.php?action=reject&type={$type}&id={$id}\" title=\"Reject\" class=\"action-icon reject-icon\"><i class=\"fa-solid fa-xmark\"></i></a>";
                                    }

                                    // Delete is always visible
                                    echo "<a href=\"handle_admin_action.php?action=delete&type={$type}&id={$id}\" title=\"Delete\" class=\"action-icon delete-icon\" onclick=\"return confirm('Are you sure you want to delete this worker account?')\"><i class=\"fa-solid fa-trash\"></i></a>";

                                    echo "
                                        </td>
                                    </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='9'>No job seekers found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <div class="pagination">
                    <button class="prev">Prev</button>
                    <button class="page active">1</button>
                    <button class="page">2</button>
                    <button class="page">3</button>
                    <button class="next">Next</button>
                </div>
            </section>
        </main>
    </div>

    <script src="../js/userList.js"></script>
</body>

</html>