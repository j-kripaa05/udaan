<?php include '../../../db_connect.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Job Listing</title>
    <link rel="stylesheet" href="../css/jobListing.css" />
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
                    <li><i class="fa-solid fa-users"></i></li>
                </a>
                <a href="jobListing.php">
                    <li class="active"><i class="fa-solid fa-briefcase"></i></li>
                </a>
            </ul>
        </aside>

        <main class="main">
            <header class="header">
                <h1>Job Listing</h1>
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
                    <h3>List of companies</h3>
                    <p>Showing 9/16</p>
                </div>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Job Title</th>
                                <th>Company</th>
                                <th>Location</th>
                                <th>Type</th>
                                <th>Salary</th>
                                <th>Applicants</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="jobTable">
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

    <script src="../js/jobListing.js"></script>
</body>

</html>