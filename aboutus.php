<?php
session_start();
require_once("config.php");
?>

<!DOCTYPE html>
<html>

<head>
    <title>About Us</title>
    <style>
        :root {
            --navy: #1a237e;
            --navy-dark: #0a0e3d;
            --gold: #fbc02d;
            --text-dark: #333;
            --text-muted: #666;
            --bg-light: #f8f9fa;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            color: var(--text-dark);
            line-height: 1.6;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Navbar */
        header {
            background: #fff;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--navy);
        }

        .logo-icon {
            background: var(--navy);
            color: #fff;
            padding: 5px 8px;
            border-radius: 6px;
            margin-right: 10px;
        }

        .gold-text {
            color: var(--gold);
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 20px;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--text-dark);
            font-weight: 500;
            font-size: 0.9rem;
        }

        .btn-about {
            background: var(--navy);
            color: #fff !important;
            padding: 8px 20px;
            border-radius: 25px;
        }

        .btn-admin {
            border: 1px solid #ddd;
            padding: 6px 15px;
            border-radius: 6px;
        }

        /* About Us Banner (Image 2) */
        .hero-banner {
            background: var(--navy);
            color: #fff;
            text-align: center;
            padding: 80px 20px;
        }

        .hero-banner h1 {
            font-size: 3.5rem;
            margin-bottom: 15px;
            font-weight: 700;
        }

        .hero-banner p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        /* Our Story Section (Image 1) */
        .story-section {
            padding: 100px 0;
        }

        .story-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }

        .label {
            color: var(--gold);
            font-weight: 700;
            font-size: 0.7rem;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-bottom: 15px;
            display: block;
        }

        .story-content h2 {
            font-size: 2.2rem;
            margin-bottom: 20px;
            color: #1a1a1a;
        }

        .story-content p {
            color: var(--text-muted);
            margin-bottom: 20px;
            font-size: 1.05rem;
        }

        .story-image-box {
            text-align: right;
        }

        .story-image-box img {
            width: 100%;
            max-width: 450px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        /* Mission & Vision (Image 3) */
        .mission-vision {
            background: var(--bg-light);
            padding: 80px 0;
        }

        .card-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        .mv-card {
            background: #fff;
            padding: 50px 40px;
            border-radius: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .mv-icon {
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            margin-bottom: 25px;
        }

        .icon-blue {
            background: #e8eaf6;
            color: var(--navy);
        }

        .icon-gold {
            background: #fffde7;
            color: var(--gold);
        }

        .mv-card h3 {
            margin-bottom: 15px;
            font-size: 1.5rem;
        }

        .mv-card p {
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        /* Core Values (Image 4) */
        .values-section {
            padding: 100px 0;
            text-align: center;
        }

        .values-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
            margin-top: 50px;
        }

        .value-item i {
            font-size: 2.2rem;
            color: var(--navy);
            margin-bottom: 20px;
            display: block;
        }

        .value-item h4 {
            margin-bottom: 10px;
            font-size: 1.1rem;
        }

        .value-item p {
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        /* Footer (Image 4) */
        footer {
            background: var(--navy-dark);
            color: #fff;
            padding: 80px 0 30px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr 1fr;
            gap: 40px;
            margin-bottom: 50px;
        }

        .footer-col h3 {
            font-size: 1.6rem;
            margin-bottom: 20px;
        }

        .footer-col h4 {
            font-size: 1rem;
            margin-bottom: 25px;
            font-weight: 600;
        }

        .footer-col p {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }

        /* keep links inline */
        .footer-col p a {
            display: inline;
        }

        .footer-bottom {
            text-align: center;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 30px;
            font-size: 0.85rem;
            color: #94a3b8;
        }

        /* Responsive */
        @media (max-width: 768px) {

            .story-grid,
            .card-grid,
            .values-grid,
            .footer-grid {
                grid-template-columns: 1fr;
            }

            .hero-banner h1 {
                font-size: 2.5rem;
            }

            .story-image-box {
                text-align: center;
                margin-top: 30px;
            }
        }

        footer a {
            color: #ccc;
            text-decoration: none;
            display: block;
            margin: 5px 0;
        }

        footer a:visited {
            color: #ccc;
        }

        footer .footer-col a:hover {
            color: orange;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <header>
        <div class="container navbar">
            <div class="logo">
                <div class="logo-icon"><i class="fas fa-graduation-cap"></i></div>
                <span>Prestige <span class="gold-text">College</span></span>
            </div>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="course.php">Courses</a></li>
                <li><a href="fees.php">Fee Structure</a></li>
                <li><a href="gallery.php">Gallery</a></li>
                <li><a href="aboutus.php" class="btn-about">About</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="index.php?page=login">Admin Login</a></li>
            </ul>
        </div>
    </header>

    <section class="hero-banner">
        <div class="container">
            <h1>About Us</h1>
            <p>Learn about our history, mission, and commitment to academic excellence.</p>
        </div>
    </section>

    <div class="container">
        <section class="story-section">
            <div class="story-grid">
                <div class="story-content">
                    <span class="label">OUR STORY</span>
                    <h2>Founded on a Vision of Excellence</h2>
                    <p>Prestige College was established in 1985 by a group of visionary educators. What began as a small institution has grown into a comprehensive college offering over 50 programs.</p>
                    <p>Today, we are recognized as one of the leading institutions, known for rigorous academics and vibrant campus life.</p>
                </div>
                <div class="story-image-box">
                    <img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=800&q=80" alt="Prestige College Lab">
                </div>
            </div>
        </section>
    </div>

    <section class="mission-vision">
        <div class="container card-grid">
            <div class="mv-card">
                <div class="mv-icon icon-blue"><i class="fas fa-bullseye"></i></div>
                <h3>Our Mission</h3>
                <p>To provide transformative education that empowers students with knowledge and skills to excel in their careers.</p>
            </div>
            <div class="mv-card">
                <div class="mv-icon icon-gold"><i class="fas fa-eye"></i></div>
                <h3>Our Vision</h3>
                <p>To be a globally recognized institution of academic excellence, producing ethical leaders and innovators.</p>
            </div>
        </div>
    </section>

    <section class="values-section">
        <div class="container">
            <span class="label">WHAT DRIVES US</span>
            <h2>Our Core Values</h2>
            <div class="values-grid">
                <div class="value-item">
                    <i class="fas fa-certificate"></i>
                    <h4>Excellence</h4>
                    <p>Highest standards in teaching and research.</p>
                </div>
                <div class="value-item">
                    <i class="fas fa-lightbulb"></i>
                    <h4>Innovation</h4>
                    <p>Creative thinking and new approaches.</p>
                </div>
                <div class="value-item">
                    <i class="fas fa-heart"></i>
                    <h4>Inclusivity</h4>
                    <p>Environment where everyone belongs.</p>
                </div>
                <div class="value-item">
                    <i class="fas fa-shield-halved"></i>
                    <h4>Integrity</h4>
                    <p>Honesty and ethical practices.</p>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <h3>Prestige College</h3>
                    <p>Empowering minds since 1985.</p>
                </div>
                <div class="footer-col">
                    <h4>Quick Links</h4>
                    <a href="course.php">Courses</a>
                    <a href="gallery.php">Gallery</a>
                    <a href="contact.php">Contact</a>
                </div>
                <div class="footer-col">
                    <h4>Contact</h4>
                    <p><i class="fas fa-map-marker-alt"></i><a href="https://maps.google.com/?q=123+University+Ave" target="_blank">
                            123 University Ave, City
                        </a></p>
                    <p><i class="fas fa-phone"></i><a href="tel:+1 (555) 123-4567">
                            +1 (555) 123-4567
                        </a></p>
                    <p>
                        <i class="fas fa-envelope"></i><a href="mailto:info@college.edu">
                            info@college.edu
                        </a>
                    </p>
                </div>
                <div class="footer-col">
                    <h4>Office Hours</h4>
                    <p>Mon – Fri: 8:00 AM – 5:00 PM</p>
                    <p>Saturday: 9:00 AM – 1:00 PM</p>
                    <p>Sunday: Closed</p>
                </div>
            </div>
            <div class="footer-bottom">
                &copy; 2026 Prestige College. All rights reserved.
            </div>
        </div>
    </footer>
    <script>
        const btn = document.querySelector('.admin-btn');
        if (btn) {
            btn.addEventListener('click', () => {
                window.location.href = "index.php?page=login";
            });
        }
    </script>
</body>

</html>