<?php
session_start();
require_once("config.php");

/* =========================
   FETCH FEES DATA
========================= */
$result = $conn->query("SELECT * FROM fees ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prestige College - Fee Structure & Portal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --primary-blue: #1e355d;
            --accent-gold: #f59e0b;
            --bg-gray: #f3f4f6;
            --white: #ffffff;
            --text-gray: #6b7280;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-gray);
        }

        h1,
        h2,
        h3,
        .logo-text,
        .footer-col h4 {
            font-family: 'Playfair Display', serif;
        }

        /* --- Navbar --- */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 5%;
            background: var(--white);
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.4rem;
            font-weight: 700;
        }

        .logo-icon {
            background: var(--primary-blue);
            color: var(--white);
            padding: 6px 10px;
            border-radius: 8px;
        }

        .logo-text span {
            color: var(--accent-gold);
        }

        .nav-links {
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: #555;
            font-size: 0.95rem;
            font-weight: 500;
            padding: 10px 20px;
            transition: 0.3s;
        }

        /* Active Class Logic */
        .nav-links a.active {
            background-color: var(--primary-blue);
            color: var(--white);
            border-radius: 40px;
        }

        .btn-admin {
            border: 1px solid #ddd;
            padding: 8px 18px;
            border-radius: 40px;
            background: var(--white);
            cursor: pointer;
        }

        /* --- Hero --- */
        .hero {
            background-color: var(--primary-blue);
            color: var(--white);
            text-align: center;
            padding: 80px 20px 120px;
        }

        .hero h1 {
            font-size: 3.5rem;
            margin-bottom: 15px;
        }

        .hero p {
            font-size: 1.1rem;
            opacity: 0.8;
            max-width: 600px;
            margin: 0 auto;
        }

        /* --- Table --- */
        .table-container {
            max-width: 1200px;
            margin: -60px auto 60px;
            padding: 0 20px;
        }

        .fee-card {
            background: white;
            border-radius: 15px;
            overflow-x: auto;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.95rem;
            min-width: 900px;
        }

        th {
            background: #f9fafb;
            padding: 20px;
            text-align: left;
            color: #4b5563;
            font-weight: 600;
            border-bottom: 2px solid #edf2f7;
        }

        td {
            padding: 18px 20px;
            border-bottom: 1px solid #edf2f7;
            color: #374151;
        }

        tr:hover {
            background-color: #f8fafc;
        }

        .course-name {
            font-weight: 600;
            color: var(--primary-blue);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .total-bold {
            font-weight: 800;
            color: #000;
        }

        .scholar-badge {
            background: #fffbeb;
            color: #b45309;
            border: 1px solid #fde68a;
            font-size: 0.7rem;
            padding: 4px 10px;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        /* --- Footer --- */
        .footer {
            background-color: var(--primary-blue);
            color: var(--white);
            padding: 80px 5% 40px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 40px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .footer-col h4 {
            font-size: 1.4rem;
            margin-bottom: 25px;
            color: var(--white);
        }

        .footer-col ul {
            list-style: none;
        }

        .footer-col ul li {
            margin-bottom: 12px;
            opacity: 0.8;
            cursor: pointer;
            transition: 0.3s;
        }

        .footer-col ul li:hover {
            color: var(--accent-gold);
            opacity: 1;
        }

        .info-item {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            opacity: 0.8;
        }

        .info-item i {
            color: var(--accent-gold);
            margin-top: 4px;
        }

        .footer-bottom {
            text-align: center;
            margin-top: 60px;
            padding-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 0.9rem;
            opacity: 0.6;
        }

        .footer-col a {
            color: #ccc;
            text-decoration: none;
        }

        .footer-col a:visited {
            color: white;
            /* removes purple */
        }

        .footer-col a:hover {
            color: orange;
        }
    </style>
</head>

<body>

    <nav class="navbar">
        <div class="logo">
            <div class="logo-icon"><i class="fa-solid fa-graduation-cap"></i></div>
            <div class="logo-text">Prestige <span>College</span></div>
        </div>
        <div class="nav-links" id="mainNav">
            <a href="index.php" id="homeLink">Home</a>
            <a href="course.php" id="coursesLink">Courses</a>
            <a href="fees.php" class="active" id="feeLink">Fee Structure</a>
            <a href="gallery.php">Gallery</a>
            <a href="aboutus.php">About</a>
            <a href="contact.php">Contact</a>
            <a href="index.php?page=login">Admin Login</a>
        </div>
    </nav>

    <header class="hero">
        <h1 id="headerTitle">Fee Structure</h1>
        <p>Transparent and competitive pricing for all our programs.</p>
    </header>

    <main class="table-container">
        <div class="fee-card">
            <table>
                <thead>
                    <tr>
                        <th>Course</th>
                        <th>Tuition</th>
                        <th>Admission</th>
                        <th>Lab Fee</th>
                        <th>Library</th>
                        <th>Other</th>
                        <th>Total</th>
                        <th>Year</th>
                    </tr>
                </thead>
                <tbody id="feeTableBody">

                    <?php while ($row = $result->fetch_assoc()): ?>

                        <tr>
                            <td>
                                <div class="course-name">
                                    <?= htmlspecialchars($row['course_name']) ?>

                                    <?php if ($row['scholarship']): ?>
                                        <span class="scholar-badge">✨ Scholarship</span>
                                    <?php endif; ?>
                                </div>
                            </td>

                            <td>$<?= $row['tuition'] ?></td>
                            <td>$<?= $row['admission'] ?></td>
                            <td>$<?= $row['lab_fee'] ?></td>
                            <td>$<?= $row['library_fee'] ?></td>
                            <td>$<?= $row['other_fee'] ?></td>
                            <td class="total-bold">$<?= $row['total'] ?></td>
                            <td><?= $row['year'] ?></td>
                        </tr>

                    <?php endwhile; ?>

                </tbody>
            </table>
        </div>
    </main>

    <footer class="footer">
        <div class="footer-grid">
            <div class="footer-col">
                <div class="logo">
                    <div class="logo-icon" style="background: var(--accent-gold); color: var(--primary-blue);"><i
                            class="fa-solid fa-graduation-cap"></i></div>
                    <div class="logo-text" style="color: white;">Prestige <span
                            style="color: var(--accent-gold);">College</span></div>
                </div>
                <p>Empowering minds, shaping futures. Providing world-class education since 1985.</p>
            </div>
            <div class="footer-col">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="course.php">Courses</a></li>
                    <li><a href="fees.php">Fee Structure</a></li>
                    <li><a href="gallery.php">Gallery</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Contact Info</h4>
                <div class="info-item"><i class="fa-solid fa-phone"></i><a href="tel:+15551234567">+1 (555) 123-4567</a></div>
                <div class="info-item"><i class="fa-solid fa-envelope"></i><a href="mailto:info@prestigecollege.edu">info@prestigecollege.edu</a></div>
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
</body>

</html>