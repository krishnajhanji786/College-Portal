<?php
session_start();
require_once("config.php");

/* =========================
   FETCH COURSES
========================= */
$courses = $conn->query("SELECT * FROM courses");
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prestige College - Functional Courses</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --primary-blue: #1e355d;
            --accent-gold: #f59e0b;
            --bg-gray: #f3f4f6;
            --text-dark: #111827;
            --text-gray: #6b7280;
            --border-color: #e5e7eb;
            --white: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-gray);
            color: var(--text-dark);
            line-height: 1.6;
        }

        h1,
        h2,
        h3,
        h4,
        .logo-text {
            font-family: 'Playfair Display', serif;
        }

        /* Navigation */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 5%;
            background-color: var(--white);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.5rem;
            font-weight: 700;
        }

        .logo-icon {
            background-color: var(--primary-blue);
            color: var(--white);
            padding: 8px;
            border-radius: 6px;
        }

        .logo-text span {
            color: var(--accent-gold);
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
            font-size: 0.95rem;
        }

        .nav-links a.active {
            background-color: var(--primary-blue);
            color: var(--white);
            padding: 8px 16px;
            border-radius: 20px;
        }

        .nav-links a {
            text-decoration: none;
        }

        .btn-admin {
            border: 1px solid var(--border-color);
            padding: 8px 16px;
            border-radius: 20px;
            background: var(--white);
            cursor: pointer;
        }

        /* Hero */
        .hero {
            background-color: var(--primary-blue);
            color: var(--white);
            text-align: center;
            padding: 6rem 2rem 8rem;
        }

        .hero h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        /* Main Container */
        .container {
            max-width: 1200px;
            margin: -3rem auto 4rem;
            padding: 0 20px;
        }

        /* Search & Filter Bar */
        .filter-bar {
            background-color: var(--white);
            padding: 1rem;
            border-radius: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 3rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .search-input {
            display: flex;
            align-items: center;
            border: 1px solid var(--border-color);
            padding: 10px 16px;
            border-radius: 8px;
            width: 300px;
        }

        .search-input input {
            border: none;
            outline: none;
            margin-left: 10px;
            width: 100%;
        }

        .filters {
            display: flex;
            gap: 0.5rem;
            background-color: var(--bg-gray);
            padding: 6px;
            border-radius: 8px;
            flex-wrap: wrap;
        }

        .filter-btn {
            border: none;
            background: transparent;
            padding: 8px 16px;
            border-radius: 6px;
            color: var(--text-gray);
            cursor: pointer;
            font-weight: 500;
            transition: 0.3s;
        }

        .filter-btn.active {
            background-color: var(--white);
            color: var(--text-dark);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        /* Course Cards */
        .course-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 2rem;
        }

        .card {
            background-color: var(--white);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            transition: 0.4s;
        }

        .card.hidden {
            display: none;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }

        .badge {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
            background: #e0e7ff;
            color: var(--primary-blue);
        }

        .badge.master {
            background: #fef3c7;
            color: #b45309;
        }

        .badge.diploma {
            background: #d1fae5;
            color: #065f46;
        }

        .category {
            color: var(--accent-gold);
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .description {
            color: var(--text-gray);
            font-size: 0.95rem;
            flex-grow: 1;
            margin-bottom: 1rem;
        }

        .details-row {
            display: flex;
            gap: 1.5rem;
            color: var(--text-gray);
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .details-row i {
            color: var(--accent-gold);
        }

        .divider {
            height: 1px;
            background: var(--border-color);
            margin: 1rem 0;
        }

        .eligibility {
            color: var(--text-gray);
            font-size: 0.85rem;
            display: flex;
            gap: 8px;
        }

        .eligibility i {
            color: var(--accent-gold);
        }

        /* Footer */
        .footer {
            background-color: var(--primary-blue);
            color: var(--white);
            padding: 4rem 2rem 2rem;
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 3rem;
        }

        .footer-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .footer-logo .logo-icon {
            background-color: var(--accent-gold);
            color: var(--primary-blue);
        }

        .footer-col h4 {
            font-size: 1.2rem;
            margin-bottom: 1.5rem;
        }

        .footer-col ul {
            list-style: none;
        }

        .footer-col ul li {
            margin-bottom: 0.8rem;
            opacity: 0.8;
        }

        .contact-item {
            display: flex;
            gap: 12px;
            margin-bottom: 1.2rem;
            opacity: 0.8;
        }

        .contact-item i {
            color: var(--accent-gold);
        }

        .contact-item a {
            color: #ccc;
            text-decoration: none;
        }

        .contact-item a:visited {
            color: white;
        }

        .contact-item a:hover {
            color: orange;
        }

        .footer-bottom {
            text-align: center;
            margin-top: 3rem;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            opacity: 0.6;
        }

        .footer-col a {
            color: #ccc;
            /* normal color */
            text-decoration: none;
        }

        .footer-col a:visited {
            color: white;
            /* remove purple */
        }

        .footer-col a:hover {
            color: orange;
            /* hover effect */
        }
    </style>
</head>

<body>

    <nav class="navbar">
        <div class="logo">
            <div class="logo-icon"><i class="fa-solid fa-graduation-cap"></i></div>
            <div class="logo-text">Prestige <span>College</span></div>
        </div>
        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="course.php" class="active">Courses</a>
            <a href="fees.php">Fee Structure</a>
            <a href="gallery.php">Gallery</a>
            <a href="aboutus.php">About</a>
            <a href="contact.php">Contact</a>
            <a href="index.php?page=login">Admin Login</a>
        </div>
    </nav>

    <header class="hero">
        <h1>Our Courses</h1>
        <p>Discover a wide range of programs designed to prepare you for a successful career.</p>
    </header>

    <main class="container">
        <div class="filter-bar">
            <div class="search-input">
                <i class="fa-solid fa-search"></i>
                <input type="text" id="searchInput" placeholder="Search courses by name...">
            </div>
            <div class="filters" id="filterButtons">
                <button class="filter-btn active" data-category="all">All</button>
                <button class="filter-btn" data-category="Computer Science">Computer Science</button>
                <button class="filter-btn" data-category="Business">Business</button>
                <button class="filter-btn" data-category="Science">Science</button>
                <button class="filter-btn" data-category="Arts & Humanities">Arts & Humanities</button>
                <button class="filter-btn" data-category="Law">Law</button>
                <button class="filter-btn" data-category="Education">Education</button>
            </div>
        </div>
        <div class="course-grid" id="courseGrid">

            <?php while ($row = $courses->fetch_assoc()): ?>

                <div class="card" data-category="<?= $row['category'] ?>">

                    <div class="card-header">
                        <h3><?= htmlspecialchars($row['title']) ?></h3>
                        <span class="badge"><?= $row['type'] ?></span>
                    </div>

                    <div class="category"><?= $row['category'] ?></div>

                    <p class="description"><?= htmlspecialchars($row['description']) ?></p>

                    <div class="details-row">
                        <div><i class="fa-regular fa-clock"></i> <?= $row['duration'] ?></div>
                        <div><i class="fa-solid fa-user-group"></i> <?= $row['seats'] ?> seats</div>
                    </div>

                    <div class="divider"></div>

                    <div class="eligibility">
                        <i class="fa-solid fa-graduation-cap"></i>
                        <span><?= htmlspecialchars($row['eligibility']) ?></span>
                    </div>

                </div>

            <?php endwhile; ?>

        </div>
    </main>

    <footer class="footer">
        <div class="footer-container">
            <div class="footer-col">
                <div class="footer-logo">
                    <div class="logo-icon"><i class="fa-solid fa-graduation-cap"></i></div>
                    <div>Prestige College</div>
                </div>
                <p>Empowering minds since 1985.</p>
            </div>
            <div class="footer-col">
                <h4>Quick Links</h4>
                <ul>
                    <ul>
                        <li><a href="course.php">Courses</a></li>
                        <li><a href="fees.php">Fee Structure</a></li>
                        <li><a href="aboutus.php">About</a></li>
                        <li><a href="contact.php">Contact</a></li>
                    </ul>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Contact</h4>
                <div class="contact-item"><i class="fa-solid fa-location-dot"></i><a href="https://maps.google.com/?q=123+University+Ave" target="_blank">
                        123 University Ave
                    </a></div>
                <div class="contact-item"><i class="fa-solid fa-phone"></i> <a href="tel:+15551234567">+1 555 123-4567</a></div>
                <div class="contact-item">
                    <i class="fa-solid fa-envelope"></i>
                    <a href="mailto:info@prestigecollege.edu">
                        info@prestigecollege.edu
                    </a>
                </div>
            </div>
            <div class="footer-col">
                <h4>Office Hours</h4>
                <p><strong>Mon – Fri:</strong> 8:00 AM – 5:00 PM</p>
                <p><strong>Saturday:</strong> 9:00 AM – 1:00 PM</p>
                <p><strong>Sunday:</strong> Closed</p>
            </div>
        </div>
        <div class="footer-bottom">&copy; 2026 Prestige College. All rights reserved.</div>
    </footer>
    <script>
        const btn = document.querySelector('.admin-btn');
        if (btn) {
            btn.onclick = () => {
                window.location.href = "index.php?page=login";
            }
        }
    </script>
    <script>
        const searchInput = document.getElementById('searchInput');
        const filterButtons = document.querySelectorAll('.filter-btn');

        function filterCourses() {
            const searchTerm = searchInput.value.toLowerCase();
            const activeCategory = document.querySelector('.filter-btn.active').dataset.category;
            const cards = document.querySelectorAll('.card');

            cards.forEach(card => {
                const title = card.querySelector('h3').innerText.toLowerCase();
                const category = card.dataset.category;

                const matchesSearch = title.includes(searchTerm);
                const matchesCategory = activeCategory === 'all' || category === activeCategory;

                if (matchesSearch && matchesCategory) {
                    card.classList.remove('hidden');
                } else {
                    card.classList.add('hidden');
                }
            });
        }

        searchInput.addEventListener('input', filterCourses);

        filterButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                filterButtons.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                filterCourses();
            });
        });
    </script>
</body>

</html>