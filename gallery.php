<?php
session_start();
require_once("config.php");

/* =========================
   FETCH IMAGES
========================= */
$result = $conn->query("SELECT * FROM gallery ORDER BY id DESC");
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prestige College | Gallery</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --navy: #1a237e;
            --navy-dark: #121858;
            --gold: #fbc02d;
            --filter-bg: #f1f5f9;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
            scroll-behavior: smooth;
        }

        body {
            color: #334155;
            line-height: 1.6;
            background: #fff;
        }

        /* --- NAVBAR --- */
        header {
            background: #fff;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .logo {
            display: flex;
            align-items: center;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--navy);
            text-decoration: none;
        }

        .logo-icon {
            background: var(--navy);
            color: #fff;
            padding: 5px 10px;
            border-radius: 8px;
            margin-right: 12px;
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 20px;
        }

        .nav-links a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            transition: 0.3s;
        }

        .nav-links a:hover {
            color: var(--gold);
        }

        .active-btn {
            background: var(--navy);
            color: #fff !important;
            padding: 8px 18px;
            border-radius: 20px;
        }

        /* --- GALLERY HERO --- */
        .gallery-hero {
            background: var(--navy);
            color: #fff;
            text-align: center;
            padding: 100px 20px;
        }

        .gallery-hero h1 {
            font-size: 4rem;
            font-family: 'Georgia', serif;
            font-weight: 400;
            margin-bottom: 15px;
        }

        .gallery-hero p {
            font-size: 1.2rem;
            opacity: 0.8;
        }

        /* --- FILTER BUTTONS --- */
        .filter-wrapper {
            text-align: center;
            margin-top: -30px;
            margin-bottom: 50px;
        }

        .filter-container {
            background: var(--filter-bg);
            display: inline-flex;
            padding: 8px;
            border-radius: 50px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            gap: 5px;
        }

        .filter-btn {
            padding: 10px 25px;
            border: none;
            background: transparent;
            border-radius: 25px;
            cursor: pointer;
            font-weight: 600;
            color: #64748b;
            transition: 0.3s;
        }

        .filter-btn.active {
            background: #fff;
            color: var(--navy);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* --- GALLERY GRID --- */
        .gallery-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px 20px 80px;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
        }

        .gallery-item {
            border-radius: 15px;
            overflow: hidden;
            height: 300px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: 0.5s ease;
        }

        .gallery-item:hover img {
            transform: scale(1.1);
        }

        .hide {
            display: none;
        }

        /* --- FOOTER --- */
        footer {
            background: var(--navy-dark);
            color: #cbd5e1;
            padding: 70px 20px 20px;
        }

        .footer-grid {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 40px;
        }

        .footer-col h4 {
            color: white;
            margin-bottom: 25px;
        }

        .footer-col li {
            list-style: none;
            margin-bottom: 12px;
            font-size: 0.9rem;
        }

        .footer-col i {
            color: var(--gold);
            margin-right: 10px;
        }

        .footer-bottom {
            text-align: center;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: 50px;
            padding-top: 25px;
            font-size: 0.85rem;
        }

        .footer-col ul li a {
            color: #ccc;
            text-decoration: none;
        }

        .footer-col ul li a:hover {
            color: orange;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 8px 0;
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
    </style>
</head>

<body>

    <header>
        <div class="navbar">
            <a href="#" class="logo">
                <div class="logo-icon"><i class="fas fa-graduation-cap"></i></div>
                Prestige <span style="color:var(--gold)">College</span>
            </a>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="course.php">Courses</a></li>
                <li><a href="fees.php">Fee Structure</a></li>
                <li><a href="gallery.php" class="active-btn">Gallery</a></li>
                <li><a href="aboutus.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="index.php?page=login">Admin Login</a></li>
            </ul>
        </div>
    </header>

    <main>
        <div class="gallery-hero">
            <h1>Gallery</h1>
            <p>Explore moments from our vibrant campus life.</p>
        </div>

        <div class="filter-wrapper">
            <div class="filter-container">
                <button class="filter-btn active" data-name="all">All</button>
                <button class="filter-btn" data-name="campus">Campus</button>
                <button class="filter-btn" data-name="labs">Labs</button>
                <button class="filter-btn" data-name="library">Library</button>
                <button class="filter-btn" data-name="graduation">Graduation</button>
            </div>
        </div>

        <div class="gallery-content">
            <div class="gallery-grid">

                <?php while ($row = $result->fetch_assoc()): ?>

                    <div class="gallery-item" data-name="<?= $row['category'] ?>">
                        <img src="<?= htmlspecialchars($row['image_url']) ?>" alt="">
                    </div>

                <?php endwhile; ?>

            </div>
        </div>
    </main>

    <footer>
        <div class="footer-grid">
            <div class="footer-col">
                <h4 style="display:flex; align-items:center;"><i class="fas fa-graduation-cap"></i> Prestige College</h4>
                <p>Providing world-class education since 1985. Join us to build your career.</p>
            </div>
            <div class="footer-col">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="course.php">Courses</a></li>
                    <li><a href="gallery.php">Gallery</a></li>
                    <li><a href="aboutus.php">About Us</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Contact Info</h4>
                <ul>
                    <li><i class="fas fa-map-marker-alt"></i> <a href="https://maps.google.com/?q=123+University+Ave" target="_blank">
                            123 University Ave, City
                        </a></li>
                    <li><i class="fas fa-phone"></i><a href="tel:+15551234567">+1 (555) 123-4567</a></li>
                    <li><i class="fas fa-envelope"></i><a href="mailto:info@college.edu">info@college.edu</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">&copy; 2026 Prestige College. All rights reserved.</div>
    </footer>
    <script>
        const filterBtns = document.querySelectorAll(".filter-btn");

        filterBtns.forEach(btn => {
            btn.addEventListener("click", () => {
                filterBtns.forEach(b => b.classList.remove("active"));
                btn.classList.add("active");

                const target = btn.getAttribute("data-name");
                const items = document.querySelectorAll(".gallery-item");

                items.forEach(item => {
                    if (target === "all" || item.getAttribute("data-name") === target) {
                        item.classList.remove("hide");
                    } else {
                        item.classList.add("hide");
                    }
                });
            });
        });
    </script>
    <script>
        const btn = document.querySelector('.admin-btn');
        if (btn) {
            btn.onclick = () => {
                window.location.href = "index.php?page=login";
            }
        }
    </script>
</body>

</html>