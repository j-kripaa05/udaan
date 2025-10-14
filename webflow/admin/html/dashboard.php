<?php 
include '../../../db_connect.php';

// --- 1. Fetch Total Job Seekers (from 'workers' table) ---
$sql_workers = "SELECT COUNT(worker_id) AS total_workers FROM workers";
$result_workers = $conn->query($sql_workers);
$total_workers = ($result_workers && $row = $result_workers->fetch_assoc()) ? $row['total_workers'] : 0;


// --- 2. Fetch Total Companies (from 'employers' table) ---
$sql_employers = "SELECT COUNT(employer_id) AS total_employers FROM employers";
$result_employers = $conn->query($sql_employers);
$total_employers = ($result_employers && $row = $result_employers->fetch_assoc()) ? $row['total_employers'] : 0;


// --- 3. Fetch Active Jobs (ASSUMPTION: Count of Approved Companies/Employers) ---
$sql_active_jobs = "SELECT COUNT(employer_id) AS active_jobs FROM employers WHERE status = 'APPROVED'";
$result_active_jobs = $conn->query($sql_active_jobs);
$active_jobs = ($result_active_jobs && $row = $result_active_jobs->fetch_assoc()) ? $row['active_jobs'] : 0;


// --- 4. Fetch Total Applications Received (Count all registrations across tables) ---
// Used for the 'App. Received' card total.
$count_tables = [
    'workers', 'employers', 'deletedWorker', 'deletedEmployer'
];
$total_applications = 0;

foreach ($count_tables as $table) {
    $sql_count = "SELECT COUNT(*) AS count FROM {$table}";
    $result_count = $conn->query($sql_count);
    if ($result_count && $row = $result_count->fetch_assoc()) {
        $total_applications += $row['count'];
    }
}


// --- 5. Dynamic Graph Data Fetch (Updated Logic for 8 rolling months based on App. Received logic) ---
function getMonthlyRegistrationData($conn) {
    
    $labels = []; // To store month names (Mar, Apr, ..., Oct)
    $data_map = []; // To store count per month key (e.g., '08' => 5)
    $currentYear = date('Y');
    
    // Initialize data map for the last 8 months (keys '01', '02', etc.)
    for ($i = 7; $i >= 0; $i--) {
        // Calculate the month key and name for the last 8 months
        $timestamp = strtotime("-$i months");
        $month_key = date('m', $timestamp);
        $month_name = date('F', $timestamp);
        
        // Add label chronologically
        $labels[] = $month_name;
        // Initialize count for this month key to 0
        $data_map[$month_key] = 0;
    }
    
    // SQL query to combine registration dates from ALL four tables
    // Note: This query uses 'registration_date' for active users and 'deleted_at' for archived users
    $sql_query = "
        SELECT MONTH(reg_date) AS reg_month_key, COUNT(*) AS count 
        FROM (
            SELECT registration_date AS reg_date FROM workers WHERE YEAR(registration_date) = ?
            UNION ALL
            SELECT registration_date AS reg_date FROM employers WHERE YEAR(registration_date) = ?
            UNION ALL
            SELECT registration_date AS reg_date FROM deletedWorker WHERE YEAR(registration_date) = ?
            UNION ALL
            SELECT registration_date AS reg_date FROM deletedEmployer WHERE YEAR(registration_date) = ?
        ) AS all_registrations 
        GROUP BY reg_month_key
    ";

    $stmt = $conn->prepare($sql_query);
    
    if ($stmt) {
        $stmt->bind_param("ssss", $currentYear, $currentYear, $currentYear, $currentYear);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $month_key = str_pad((string)$row['reg_month_key'], 2, '0', STR_PAD_LEFT);
            if (array_key_exists($month_key, $data_map)) {
                $data_map[$month_key] = (int)$row['count'];
            }
        }
        $stmt->close();
    }
    
    // Extract ordered data values corresponding to the 8 labels
    $ordered_data = [];
    foreach ($labels as $month_name) {
        $month_key = date('m', strtotime($month_name . ' 1, ' . $currentYear));
        // Use the count from the map, defaulting to 0 if no data was found
        $ordered_data[] = $data_map[$month_key] ?? 0;
    }

    return ['labels' => $labels, 'data' => $ordered_data];
}

$chart_data = getMonthlyRegistrationData($conn);
$chart_labels_json = json_encode($chart_data['labels']);
$dynamic_data_json = json_encode($chart_data['data']);


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard</title>
  <link rel="stylesheet" href="../css/dashboard.css" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  
  <!-- PASS DYNAMIC DATA TO JAVASCRIPT -->
  <script>
    const chartLabels = <?php echo $chart_labels_json; ?>;
    const dynamicChartData = <?php echo $dynamic_data_json; ?>;
  </script>
</head>
<body>
  <div class="dashboard">
    <aside class="sidebar">
      <div class="profile"></div>
      <ul>
        <a href="dashboard.php"><li class="active"><i class="fa-solid fa-chart-line"></i></li></a>
        <a href="companyList.php"><li><i class="fa-solid fa-building" ></i></li></a>
        <a href="userList.php"><li><i class="fa-solid fa-users"></i></li></a>
        <a href="jobListing.php"><li><i class="fa-solid fa-briefcase"></i></li></a>
      </ul>
    </aside>

    <main class="main">
      <header class="header">
        <h1>Dashboard</h1>
        <div class="icons">
          <i class="fa-regular fa-bell"></i>
          <i class="fa-regular fa-user"></i>
        </div>
      </header>
      <section class="cards"> 
        <a href="userList.php" class="link">
        <div class="card purple">
          <p>Total Job Seekers</p>
          <h2><?php echo $total_workers; ?></h2>
          <span>Last 7 days</span>
        </div>
        </a>
        <a href="userList.php" class="link">
          <div class="card orange">
          <p>Total Companies</p>
          <h2><?php echo $total_employers; ?></h2>
          <span>Last 7 days</span>
        </div>
        </a>
        <div class="card blue">
          <p>Active Jobs</p>
          <h2><?php echo $active_jobs; ?></h2>
          <span>Currently Approved</span>
        </div>
        <div class="card yellow">
          <p>App. Received</p>
          <h2><?php echo $total_applications; ?></h2>
          <span>Total Records</span>
        </div>
      </section>

      <section class="charts">
        <div class="chart-box">
          <h3>Applications</h3>
          <canvas id="barChart"></canvas>
        </div>
        <div class="chart-box">
          <h3>Applications</h3>
          <canvas id="pieChart"></canvas>
        </div>
      </section>

      <section class="activity">
        <div class="activity-header">
          <h3>Recent Activity</h3>
          <a href="#">See all</a>
        </div>
        <p class="subtitle">See what's new happening</p>
        <div class="activity-list">
          <div class="activity-item">
            <div class="circle"></div>
            <div class="info">
              <p><b>New user logged in</b></p>
              <span>ORDER ID: #2350544</span>
            </div>
            <small>1 min ago</small>
          </div>

          <div class="activity-item">
            <div class="circle"></div>
            <div class="info">
              <p><b>Latest job posted</b></p>
              <span>ORDER ID: #2350544</span>
            </div>
            <small>3 min ago</small>
          </div>

          <div class="activity-item">
            <div class="circle"></div>
            <div class="info">
              <p><b>New company registered</b></p>
              <span>ORDER ID: #2350544</span>
            </div>
            <small>3 min ago</small>
          </div>

          <div class="activity-item">
            <div class="circle"></div>
            <div class="info">
              <p><b>New user logged in</b></p>
              <span>ORDER ID: #2350544</span>
            </div>
            <small>3 min ago</small>
          </div>

          <div class="activity-item">
            <div class="circle"></div>
            <div class="info">
              <p><b>New job seeker registered</b></p>
              <span>ORDER ID: #2350544</span>
            </div>
            <small>3 min ago</small>
          </div>
        </div>
      </section>
    </main>
  </div>

  <script src="../js/dashboard.js"></script>
</body>
</html>