<?php
session_start();
require_once("config.php");

// ================= DELETE ENQUIRY =================
if (isset($_GET['delete'])) {

    // 🔐 Only admin allowed
    if (!isset($_SESSION['admin'])) {
        header("Location: index.php?page=login");
        exit();
    }

    $id = $_GET['delete'];

    $stmt = $conn->prepare("DELETE FROM enquiries WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: index.php?page=dashboard");
    exit();
}

/* =========================
   ROUTING SYSTEM
========================= */
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

/* =========================
   LOGOUT
========================= */
if ($page == "logout") {
    session_destroy();
    header("Location: index.php"); // or ?page=home
    exit();
}

/* =========================
   LOGIN LOGIC
========================= */
$login_error = "";

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT password FROM admins WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($hash);
        $stmt->fetch();

        if (password_verify($password, $hash)) {
            $_SESSION['admin'] = $username;
            header("Location: ?page=dashboard");
            exit();
        } else {
            $login_error = "Wrong Password!";
        }
    } else {
        $login_error = "User not found!";
    }
}

/* =========================
   CONTACT FORM LOGIC
========================= */
$msg = "";

if (isset($_POST['contact'])) {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $subject = $_POST['subject'];
    $message = trim($_POST['message']);

    if ($name && $email && $subject && $message) {

        $stmt = $conn->prepare("INSERT INTO enquiries (name,email,phone,subject,message) VALUES (?,?,?,?,?)");
        $stmt->bind_param("sssss", $name, $email, $phone, $subject, $message);

        if ($stmt->execute()) {
            $msg = "✅ Enquiry Submitted!";
        } else {
            $msg = "❌ Error!";
        }
    } else {
        $msg = "⚠️ Fill all fields!";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>College System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Arial, sans-serif;
            transition: all 0.3s ease;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            background: #f5f5f5;
            overflow-x: hidden;
        }

        /* Navbar */
        header {
            display: flex;
            justify-content: space-between;
            padding: 15px 60px;
            align-items: center;
            background: white;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .logo {
            font-size: 22px;
            font-weight: bold;
            color: #1d3b7a;
        }

        .logo span {
            color: orange;
        }

        nav {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        nav a {
            text-decoration: none;
            color: #333;
            font-size: 14px;
            font-weight: 500;
            padding: 8px 12px;
        }

        nav a.active {
            background: #1d3b7a;
            color: white;
            border-radius: 20px;
        }

        .admin-btn {
            padding: 8px 18px;
            border-radius: 20px;
            border: 2px solid #1d3b7a;
            background: transparent;
            color: #1d3b7a;
            cursor: pointer;
            font-weight: bold;
        }

        .admin-btn:hover {
            background: #1d3b7a;
            color: white;
        }

        /* Hero Section */
        .hero {
            position: relative;
            min-height: 90vh;
            display: flex;
            align-items: center;
            padding: 60px;
            color: white;
            background: url("https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&w=1350&q=80") no-repeat center/cover;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to right, rgba(13, 39, 94, 0.85), rgba(13, 39, 94, 0.4));
        }

        .content {
            position: relative;
            max-width: 650px;
            z-index: 2;
        }

        .tag {
            display: inline-block;
            background: rgba(255, 165, 0, 0.2);
            padding: 8px 16px;
            border-radius: 20px;
            color: orange;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: bold;
            border: 1px solid orange;
        }

        h1 {
            font-size: 56px;
            line-height: 1.1;
            margin-bottom: 20px;
        }

        h1 span {
            color: orange;
        }

        .desc {
            font-size: 18px;
            margin-bottom: 30px;
            line-height: 1.6;
            color: #eee;
        }

        .buttons {
            display: flex;
            gap: 15px;
        }

        .primary {
            background: orange;
            color: #1d3b7a;
            border: none;
            padding: 14px 28px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            font-size: 16px;
        }

        .primary:hover {
            background: #ff9900;
            transform: scale(1.05);
        }

        .secondary {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid white;
            padding: 14px 28px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
        }

        .secondary:hover {
            background: white;
            color: #1d3b7a;
        }

        /* Stats Section */
        .stats {
            display: flex;
            justify-content: center;
            gap: 30px;
            padding: 0 40px;
            flex-wrap: wrap;
            position: relative;
            top: -60px;
            z-index: 10;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            width: 230px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .card .icon {
            font-size: 35px;
            margin-bottom: 15px;
        }

        .card h2 {
            font-size: 32px;
            color: #1d3b7a;
            margin-bottom: 5px;
        }

        /* About Section */
        .about {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 60px;
            gap: 50px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .about-text {
            flex: 1;
        }

        .about-text h2 {
            font-size: 40px;
            color: #1d3b7a;
            margin: 15px 0;
        }

        .about-image {
            flex: 1;
            position: relative;
        }

        .about-image img {
            width: 100%;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }

        .badge {
            position: absolute;
            bottom: -20px;
            left: -20px;
            background: orange;
            padding: 20px;
            border-radius: 15px;
            color: #1d3b7a;
            text-align: center;
        }

        /* CTA Section */
        .cta {
            background: #1d3b7a;
            color: white;
            text-align: center;
            padding: 80px 20px;
            margin-top: 50px;
        }

        /* Footer */
        footer {
            background: #0a1931;
            color: white;
            padding: 60px 60px 20px;
        }

        .footer-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 40px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .footer-col ul {
            list-style: none;
            margin-top: 15px;
        }

        .footer-col ul li {
            margin-bottom: 10px;
            color: #ccc;
            cursor: pointer;
        }

        .footer-col ul li:hover {
            color: orange;
        }

        .footer-bottom {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 14px;
        }

        /* Mobile View */
        @media (max-width: 768px) {
            header {
                padding: 15px 20px;
                flex-direction: column;
            }

            nav {
                margin-top: 15px;
                flex-wrap: wrap;
                justify-content: center;
            }

            .hero {
                padding: 40px 20px;
                text-align: center;
            }

            .buttons {
                justify-content: center;
            }

            h1 {
                font-size: 36px;
            }

            .stats {
                top: 0;
                padding: 40px 20px;
            }

            .about {
                flex-direction: column;
                padding: 40px 20px;
            }
        }

        .footer-col ul {
            list-style: none;
            padding: 0;
        }

        .footer-col ul li {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 8px 0;
        }

        .footer-col a {
            text-decoration: none;
            color: #cbd5e1;
            transition: 0.3s;
        }

        .footer-col a:hover {
            color: orange;
        }

        .footer-col i {
            color: var(--gold);
        }

        body {
            font-family: Arial;
            background: #f4f4f4;
            padding: 20px;
        }

        .box {
            background: white;
            padding: 20px;
            border-radius: 10px;
            width: 400px;
            margin: auto;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
        }

        button {
            padding: 10px;
            background: #1d3b7a;
            color: white;
            border: none;
        }

        a {
            margin-right: 10px;
        }

        table {
            width: 100%;
            background: white;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        th {
            background: #1d3b7a;
            color: white;
        }
    </style>
</head>

<body>
    <header>
        <div class="logo">🎓 Prestige <span>College</span></div>
        <nav>
            <a href="index.php" class="<?= ($page == 'home') ? 'active' : '' ?>">Home</a>
            <a href="course.php" class="<?= ($page == 'courses') ? 'active' : '' ?>">Courses</a>
            <a href="fees.php" class="<?= ($page == 'fees') ? 'active' : '' ?>">Fee Structure</a>
            <a href="gallery.php" class="<?= ($page == 'gallery') ? 'active' : '' ?>">Gallery</a>
            <a href="aboutus.php" class="<?= ($page == 'about') ? 'active' : '' ?>">About</a>
            <a href="contact.php" class="<?= ($page == 'contact') ? 'active' : '' ?>">Contact</a>
            <?php if (isset($_SESSION['admin'])): ?>
                <a href="?page=dashboard">Dashboard</a>
                <a href="?page=logout">Logout</a>
            <?php else: ?>
                <a href="?page=login">Admin Login</a>
            <?php endif; ?>

        </nav>
    </header>

    <!-- ================= HOME ================= -->

    <?php if ($page == "home"): ?>
        <section class="hero" id="home">
            <div class="overlay"></div>
            <div class="content">
                <p class="tag">Admissions Open 2026-27</p>
                <h1>Where Knowledge <br> Meets <span>Excellence</span></h1>
                <p class="desc">Join a legacy of academic brilliance. Discover programs that shape future leaders across
                    science, technology, business, and the arts.</p>
                <div class="buttons">
                    <button class="primary" onclick="window.location.href='course.php'">Explore Courses →</button>
                    <button class="secondary" onclick="window.location.href='contact.php'">Get in Touch</button>
                </div>
            </div>
        </section>

        <section class="stats">
            <div class="card">
                <div class="icon">📘</div>
                <h2>50+</h2>
                <p>Courses Offered</p>
            </div>
            <div class="card">
                <div class="icon">👥</div>
                <h2>8,000+</h2>
                <p>Students Enrolled</p>
            </div>
            <div class="card">
                <div class="icon">🏅</div>
                <h2>40+</h2>
                <p>Years of Excellence</p>
            </div>
            <div class="card">
                <div class="icon">🏫</div>
                <h2>8</h2>
                <p>Departments</p>
            </div>
        </section>

        <section class="about" id="about">
            <div class="about-text">
                <span class="tag">ABOUT US</span>
                <h2>A Legacy of Academic Excellence</h2>
                <p>Founded in 1985, Prestige College has been at the forefront of higher education, providing students with
                    tools to succeed in a global environment.</p>
                <p>Our world-class facilities and expert faculty create an environment where innovation and creativity
                    thrive every single day.</p>
                <button class="primary" style="margin-top: 20px;" onclick="window.location.href='aboutus.php'">Learn More About Us</button>
            </div>
            <div class="about-image">
                <img src="https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=800&q=80"
                    alt="campus">
                <div class="badge">
                    <h3 style="font-size: 24px;">40+</h3>
                    <p>Years of Trust</p>
                </div>
            </div>
        </section>

        <section class="cta" id="contact">
            <h2>Ready to Begin Your Journey?</h2>
            <p>Take the first step towards a brighter future. Explore our programs and connect with us today.</p>
            <div class="buttons" style="justify-content: center; margin-top: 30px;">
                <button class="primary" onclick="window.location.href='admission.php'">
                    Apply Now
                </button>

                <button class="secondary" onclick="window.location.href='contact.php'">
                    Contact Support
                </button>
            </div>
        </section>

        <footer>
            <div class="footer-container">
                <div class="footer-col">
                    <h3>🎓 Prestige College</h3>
                    <p style="margin-top: 15px; color: #ccc;">Empowering minds, shaping futures. Providing world-class
                        education since 1985.</p>
                </div>
                <div class="footer-col">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="admission.php">Admissions</a></li>
                        <li><a href="fees.php">Fee Structure</a></li>
                        <li><a href="gallery.php">Campus Gallery</a></li>
                        <li><a href="privacy.php">Privacy Policy</a></li>
                    </ul>
                </div>
                <div class="footer-col" id="courses">
                    <h4>Contact Info</h4>
                    <ul>
                        <li>
                            <i class="fas fa-map-marker-alt"></i>
                            <a href="https://maps.google.com/?q=123+University+Ave" target="_blank">
                                123 University Ave, City
                            </a>
                        </li>

                        <li><i class="fas fa-phone"></i><a href="tel:+15551234567">+1 (555) 123-4567</a></li>

                        <li>
                            <i class="fas fa-envelope"></i>
                            <a href="mailto:info@prestige.edu">
                                info@prestige.edu
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                &copy; 2026 Prestige College. All rights reserved.
            </div>
        </footer>

    <?php endif; ?>


    <!-- ================= CONTACT ================= -->
    <?php if ($page == "contact"): ?>
        <div class="box">
            <h2>Contact Form</h2>

            <form method="POST">
                <input type="text" name="name" placeholder="Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="text" name="phone" placeholder="Phone">

                <select name="subject" required>
                    <option value="">Select Subject</option>
                    <option>Admission</option>
                    <option>Course</option>
                    <option>General</option>
                </select>

                <textarea name="message" placeholder="Message" required></textarea>

                <button type="submit" name="contact">Submit</button>
            </form>

            <p><?php echo $msg; ?></p>
        </div>
    <?php endif; ?>


    <!-- ================= LOGIN ================= -->
    <?php if ($page == "login"): ?>
        <div class="box">
            <h2>Admin Login</h2>

            <form method="POST">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="login">Login</button>
            </form>

            <p style="color:red;"><?php echo $login_error; ?></p>
        </div>
    <?php endif; ?>


    <!-- ================= DASHBOARD ================= -->
    <?php if ($page == "dashboard"): ?>

        <?php
        if (!isset($_SESSION['admin'])) {
            header("Location: index.php?page=login");
            exit();
        }
        ?>

        <h2>Admin Dashboard</h2>

        <?php
        $result = $conn->query("SELECT * FROM enquiries ORDER BY created_at DESC");
        ?>

        <table>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Subject</th>
                <th>Message</th>
                <th>Date</th>
                <th>Action</th>
            </tr>

            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['phone']) ?></td>
                    <td><?= htmlspecialchars($row['subject']) ?></td>
                    <td><?= htmlspecialchars($row['message']) ?></td>
                    <td><?= $row['created_at'] ?></td>
                    <td>
                        <a href="index.php?page=dashboard&delete=<?= $row['id'] ?>"
                            onclick="return confirm('Are you sure you want to delete this enquiry?')"
                            style="color:red; font-weight:bold;">
                            Delete
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>

        </table>

    <?php endif; ?>

</body>
<script>
    const btn = document.querySelector('.admin-btn');
    if (btn) {
        btn.addEventListener('click', () => {
            window.location.href = "index.php?page=login";
        });
    }
</script>

</html>