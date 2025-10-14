<?php 
include '../../db_connect.php';
?>
<html lang="en">

<head>
    <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Our Story - Udaan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/header.css">
  <link rel="stylesheet" href="../css/women.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <?php include '../../header.php'; ?>
   

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-content">
            <h1 class="hero-title">Meet the Women Behind <span class="highlight">UDAAN</span></h1>
            <p class="hero-description">Stories of strength, resilience, and transformation. These remarkable women have
                turned challenges into opportunities, not just for themselves, but for thousands of others.</p>

            <!-- Statistics -->
            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-number">85%</div>
                    <div class="stat-label">Success Rate</div>
                    <p class="stat-description">of our participants find meaningful employment within 6 months</p>
                </div>
                <div class="stat-card">
                    <div class="stat-number">3x</div>
                    <div class="stat-label">Income Growth</div>
                    <p class="stat-description">average income increase after completing our programs</p>
                </div>
                <div class="stat-card">
                    <div class="stat-number">24/7</div>
                    <div class="stat-label">Support System</div>
                    <p class="stat-description">average income increase after completing our programs</p>
                </div>
            </div>
        </div>

        <!-- Floating Profile Images -->
        <div class="floating-profiles">
            <img src="https://static.codia.ai/image/2025-10-11/PP8oFQXLbP.png" alt="Profile 1"
                class="profile-img profile-1">
            <img src="https://static.codia.ai/image/2025-10-11/bmwXoa1JHm.png" alt="Profile 2"
                class="profile-img profile-2">
            <img src="https://static.codia.ai/image/2025-10-11/6rOy78NtOy.png" alt="Profile 3"
                class="profile-img profile-3">
            <img src="https://static.codia.ai/image/2025-10-11/4URChtPdmH.png" alt="Profile 4"
                class="profile-img profile-4">
        </div>
    </section>

    <!-- Video Section -->
    <section class="video-section">
        <h2 class="section-title">Their Story In Motion</h2>
        <p class="section-description">Watch how these incredible women transformed their lives and became leaders in
            their communities</p>
        <div class="video-container">
            <div class="video-placeholder">
                <video class = "video-adv" width="1248" height="500" controls autoplay muted loop>
                    <source src="../../images/video.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
    </section>

    <!-- Why They Matter Section -->
    <section class="why-section">
        <h2 class="section-title">WHY THEY MATTERS</h2>
        <p class="section-description">Every woman has a story worth telling. At UDAAN, we celebrate the journeys of
            widows who, despite challenges, dared to rise, rebuild, and reclaim their dignity. Their resilience inspires
            us to keep creating opportunities that change lives.</p>
        <div class="impact-image">
            <img src="https://static.codia.ai/image/2025-10-11/h5EOSRjVnM.png" alt="Impact Image">
        </div>
    </section>

    <!-- Featured Stories Section -->
    <section class="stories-section">
        <div class="section-header">
            <h2 class="section-title">FEATURED STORIES</h2>
            <div class="title-underline"></div>
        </div>
        <p class="section-description">Meet the extraordinary women who have transformed their lives and are now
            empowering others in their communities</p>

        <div class="stories-container">
            <!-- Story 1 -->
            <div class="story-card">
                <div class="story-image">
                    <img src="../../images/joinus.png" alt="Meera Chauhan">
                </div>
                <div class="story-content">
                    <div class="success-badge">Success Story</div>
                    <div class="story-header">
                        <h3 class="story-name">Meera Chauhan</h3>
                        <div class="story-meta">
                            <div class="skill-tag">
                                <img src="https://static.codia.ai/image/2025-10-11/HPkeDzD3sO.png" alt="skill icon">
                                <span>Tailoring & Stitching</span>
                            </div>
                            <div class="location-tag">
                                <img src="https://static.codia.ai/image/2025-10-11/nkeMzZSPTx.png" alt="location icon">
                                <span>Ahmedabad, Gujarat</span>
                            </div>
                        </div>
                    </div>
                    <div class="story-text">
                        <p>After losing her husband at a young age, Meera struggled to provide for her two children.
                            With determination, she learned tailoring and soon turned her small stitching work into a
                            steady livelihood. Today, she not only supports her family but also trains other women in
                            her community to become financially independent.</p>
                        <button class="read-more-btn"><a href="story.php">Read full story</a></button>
                    </div>
                </div>
            </div>

            <!-- Story 2 -->
            <div class="story-card">
                <div class="story-image">
                    <img src="../../images/story2.png" alt="Hero Illustration">
                </div>
                <div class="story-content">
                    <div class="success-badge">Success Story</div>
                    <div class="story-header">
                        <h3 class="story-name">Vinita Kher</h3>
                        <div class="story-meta">
                            <div class="skill-tag">
                                <img src="https://static.codia.ai/image/2025-10-11/HPkeDzD3sO.png" alt="skill icon">
                                <span>Tutor</span>
                            </div>
                            <div class="location-tag">
                                <img src="https://static.codia.ai/image/2025-10-11/nkeMzZSPTx.png" alt="location icon">
                                <span>Bidar, Karnataka</span>
                            </div>
                        </div>
                    </div>
                    <div class="story-text">
                        <p>After losing her husband at a young age, Meera struggled to provide for her two children.
                            With determination, she learned tailoring and soon turned her small stitching work into a
                            steady livelihood. Today, she not only supports her family but also trains other women in
                            her community to become financially independent.</p>
                        <button class="read-more-btn"><a href="story.php">Read full story</a></button>
                    </div>
                </div>
            </div>
            <!-- Floating Profile Images -->
            <div class="floating-profiles">
                <img src="https://static.codia.ai/image/2025-10-11/PP8oFQXLbP.png" alt="Profile 1"
                    class="profile-img profile-1">
                <img src="https://static.codia.ai/image/2025-10-11/bmwXoa1JHm.png" alt="Profile 2"
                    class="profile-img profile-2">
                <img src="https://static.codia.ai/image/2025-10-11/6rOy78NtOy.png" alt="Profile 3"
                    class="profile-img profile-3">
                <img src="https://static.codia.ai/image/2025-10-11/4URChtPdmH.png" alt="Profile 4"
                    class="profile-img profile-4">
            </div>
            <!-- Story 3 -->
            <div class="story-card">
                <div class="story-image">
                    <img src="../../images/story3.png" alt="Hero Illustration">
                </div>
                <div class="story-content">
                    <div class="success-badge">Success Story</div>
                    <div class="story-header">
                        <h3 class="story-name">Parveen Kaur</h3>
                        <div class="story-meta">
                            <div class="skill-tag">
                                <img src="https://static.codia.ai/image/2025-10-11/HPkeDzD3sO.png" alt="skill icon">
                                <span>Tailoring & Stitching</span>
                            </div>
                            <div class="location-tag">
                                <img src="https://static.codia.ai/image/2025-10-11/nkeMzZSPTx.png" alt="location icon">
                                <span>Ludhiana, Punjab</span>
                            </div>
                        </div>
                    </div>
                    <div class="story-text">
                        <p>After losing her husband at a young age, Meera struggled to provide for her two children.
                            With determination, she learned tailoring and soon turned her small stitching work into a
                            steady livelihood. Today, she not only supports her family but also trains other women in
                            her community to become financially independent.</p>
                        <button class="read-more-btn"><a href="story.php">Read full story</a></button>
                    </div>
                </div>
            </div>

            <!-- Story 4  -->
            <div class="story-card">
                <div class="story-image">
                    <img src="../../images/story4.png" alt="Hero Illustration">
                </div>
                <div class="story-content">
                    <div class="success-badge">Success Story</div>
                    <div class="story-header">
                        <h3 class="story-name">Savitri Bai</h3>
                        <div class="story-meta">
                            <div class="skill-tag">
                                <img src="https://static.codia.ai/image/2025-10-11/HPkeDzD3sO.png" alt="skill icon">
                                <span>Artisan</span>
                            </div>
                            <div class="location-tag">
                                <img src="https://static.codia.ai/image/2025-10-11/nkeMzZSPTx.png" alt="location icon">
                                <span>Alwar, Rajasthan</span>
                            </div>
                        </div>
                    </div>
                    <div class="story-text">
                        <p>After losing her husband at a young age, Meera struggled to provide for her two children.
                            With determination, she learned tailoring and soon turned her small stitching work into a
                            steady livelihood. Today, she not only supports her family but also trains other women in
                            her community to become financially independent.</p>
                        <button class="read-more-btn"><a href="story.php">Read full story</a></button>
                    </div>
                </div>
            </div>
        </div>
    </section>

     <!-- Footer -->
    <?php include '../../footer.php'; ?>
    
    <script src="../js/women.js"></script>
</body>

</html>