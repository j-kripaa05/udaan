<?php 
include '../../db_connect.php'; 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Udaan - Empowering Women</title>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
    <?php include '../../header.php'; ?>

    <section class="hero">
        <div class="hero-text">
            <h1>
                Empowering <span class="highlight">Women</span>,<br>
                Changing <span class="highlight">Futures</span>
            </h1>
            <p>
                Discover countless opportunities and connect with top employers.
                Start your journey towards a fulfilling career today.
                Connect with employers who value your unique talents and aspirations.
            </p>
            <div class="hero-buttons">
                <a href="opportunities.php" class="btn-primary">See Opportunities ➜</a>
                <a href="story.php" class="btn-outline">Explore Our Stories</a>
            </div>
        </div>

        <div class="hero-image">
            <img src="../../images/Group 67.png" alt="Hero Illustration">
            <div class="trust-box">
                <p># Trusted by over <strong>50K+ users</strong></p>
            </div>
        </div>
    </section>

    <section class="about">
        <h2>Few words about <br> <span>WHAT WE DO</span></h2>
        <ul>
            <li>We empower widows to rebuild their lives with dignity, confidence, and independence. Through skill
                development programs, employment opportunities, and community support, we help women turn challenges
                into new beginnings.</li>
            <li>Our initiatives focus on practical training, mentorship, and connecting women to sustainable income
                sources, ensuring they not only earn a living but also regain their self-worth. We also create safe
                spaces where women can heal emotionally, share their experiences, and draw strength from community
                support.</li>
            <li>Alongside this, we provide financial literacy and digital skills training to prepare women for modern
                opportunities, while collaborating with local businesses and organizations to open doors for
                internships, apprenticeships, and long-term employment.</li>
            <li>By celebrating women’s success stories and amplifying their voices, UDAAN not only transforms individual
                journeys but also builds a collective movement of hope, resilience, and change.</li>
        </ul>
    </section>

    <section class="mission">
        <h2>
            We believe every woman deserves the chance to
            <span class="highlight">thrive.</span>
        </h2>
        <p>UDAAN is a platform where widows find hope, skills, and the support needed to start fresh.</p>

        <div class="mission-grid">
            <div class="mission-item tall">
                <img src="../../images/img3.png" alt="Training">
            </div>
            <div class="mission-item">
                <img src="../../images/img2.png" alt="Digital Work">
            </div>
            <div class="mission-item">
                <img src="../../images/img1.png" alt="Tailoring">
            </div>
        </div>
    </section>


    <section class="impact">
        <h2>Our Impact In Number</h2>
        <p>A huge opportunity to change your life and career.</p>

        <div class="impact-boxes">
            <div class="box">
                <i class="fa-solid fa-users"></i>
                <h3><span class="counter" data-target="50">0</span>k+</h3>
                <p>Women Trained</p>
                <small>Successfully completed our comprehensive training programs and secured employment</small>
            </div>
            <div class="box">
                <i class="fa-solid fa-chart-line"></i>
                <h3><span class="counter" data-target="40">0</span>%</h3>
                <p>Avg. Income Increased</p>
                <small>Successfully completed our comprehensive training programs and secured employment</small>
            </div>
            <div class="box">
                <i class="fa-solid fa-handshake"></i>
                <h3><span class="counter" data-target="20">0</span>+</h3>
                <p>Community Partners</p>
                <small>Successfully completed our comprehensive training programs and secured employment</small>
            </div>
        </div>

        <div class="impact-buttons">
            <a href="signup.php" class="btn-primary">Start your journey today</a>
         
        </div>
    </section>


    <section class="join">
        <div class="join-content">
            <h2>Join Us Now</h2>
            <p>Take the first step towards transforming your life. Join thousands of women on their journey to financial
                independence.</p>
            <a href="#" class="btn-primary">Register now</a>
        </div>
        <div class="join-img">
            <img src="../../images/joinus.png" alt="Hero Illustration">
        </div>
    </section>
    <!-- Footer -->
    <?php include '../../footer.php'; ?>
    
    <script src="../js/home.js"></script>
</body>
</html>