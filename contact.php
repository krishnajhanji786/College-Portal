<?php
session_start();
require_once("config.php");

/* =========================
   CSRF TOKEN
========================= */
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$success = "";
$error = "";

/* =========================
   FORM SUBMIT
========================= */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // CSRF CHECK
    if (
        !isset($_POST['csrf_token']) ||
        !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
    ) {
        die("Invalid request");
    }

    // INPUT SANITIZE
    $name    = htmlspecialchars(trim($_POST['name']));
    $email   = htmlspecialchars(trim($_POST['email']));
    $phone   = htmlspecialchars(trim($_POST['phone']));
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars(trim($_POST['message']));

    // VALIDATION
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $error = "⚠️ Please fill all required fields!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "⚠️ Invalid email format!";
    } elseif (strlen($name) < 3) {
        $error = "⚠️ Name must be at least 3 characters!";
    } elseif (strlen($message) < 10) {
        $error = "⚠️ Message too short!";
    } else {

        // INSERT
        $stmt = $conn->prepare(
            "INSERT INTO enquiries (name, email, phone, subject, message) 
             VALUES (?, ?, ?, ?, ?)"
        );

        if ($stmt) {
            $stmt->bind_param("sssss", $name, $email, $phone, $subject, $message);

            if ($stmt->execute()) {
                $success = "✅ Your enquiry has been submitted successfully!";
            } else {
                $error = "❌ Failed to save data!";
            }

            $stmt->close();
        } else {
            $error = "❌ Database error!";
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Contact</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --navy: #1a237e;
            --navy-dark: #121858;
            --gold: #fbc02d;
            --text-dark: #333;
            --text-muted: #666;
            --bg-light: #f8fafc;
            --border: #e2e8f0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            background-color: white;
            color: var(--text-dark);
            line-height: 1.6;
        }

        /* Navbar (Same as About page) */
        header {
            background: #fff;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
            position: sticky;
            top: 0;
            z-index: 1000;
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
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--navy);
            text-decoration: none;
        }

        .logo-icon {
            background: var(--navy);
            color: #fff;
            padding: 5px 8px;
            border-radius: 6px;
            margin-right: 10px;
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
            font-size: 0.95rem;
        }

        .btn-contact {
            background: var(--navy);
            color: #fff !important;
            padding: 8px 18px;
            border-radius: 20px;
        }

        .btn-admin {
            border: 1px solid #ccc;
            padding: 6px 15px;
            border-radius: 6px;
            font-size: 0.85rem;
        }

        /* Hero Section */
        .hero {
            background: var(--navy);
            color: white;
            text-align: center;
            padding: 80px 20px;
        }

        .hero h1 {
            font-size: 3rem;
            margin-bottom: 15px;
        }

        .hero p {
            max-width: 600px;
            margin: 0 auto;
            color: #cbd5e1;
            font-size: 1.1rem;
        }

        /* Contact Content Area */
        .contact-container {
            max-width: 1200px;
            margin: -60px auto 80px;
            padding: 0 20px;
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 30px;
        }

        /* Left Side: Info Cards */
        .info-sidebar {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .info-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            display: flex;
            align-items: flex-start;
            gap: 20px;
        }

        .icon-circle {
            background: #f1f5f9;
            color: var(--navy);
            width: 45px;
            height: 45px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .info-card h4 {
            margin-bottom: 5px;
            font-size: 1.1rem;
        }

        .info-card p {
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        /* Right Side: Form */
        .form-card {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .form-card h2 {
            margin-bottom: 30px;
            font-size: 1.8rem;
            color: var(--navy);
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group.full {
            grid-column: span 2;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 1rem;
            outline: none;
            transition: 0.3s;
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: var(--navy);
            box-shadow: 0 0 0 3px rgba(26, 35, 126, 0.1);
        }

        textarea {
            height: 150px;
            resize: none;
        }

        .submit-btn {
            background: var(--navy);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1rem;
            transition: 0.3s;
        }

        .submit-btn:hover {
            background: var(--navy-dark);
            transform: translateY(-2px);
        }

        /* Footer (Same as About page) */
        footer {
            background: var(--navy-dark);
            color: #cbd5e1;
            padding: 60px 20px 20px;
            margin-top: 50px;
        }

        .footer-grid {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1.5fr 1fr 1.2fr 1.2fr;
            gap: 40px;
        }

        .footer-col h4 {
            color: white;
            margin-bottom: 20px;
        }

        .footer-col ul {
            list-style: none;
        }

        .footer-col a {
            color: #cbd5e1;
            text-decoration: none;
            display: block;
            margin-bottom: 10px;
            font-size: 0.9rem;
        }

        .footer-bottom {
            text-align: center;
            border-top: 1px solid #2d3748;
            margin-top: 40px;
            padding-top: 20px;
            font-size: 0.85rem;
        }

        @media (max-width: 900px) {
            .contact-container {
                grid-template-columns: 1fr;
                margin-top: 20px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-group.full {
                grid-column: span 1;
            }

            .footer-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        html {
            scroll-behavior: smooth;
        }

        .footer-col a:hover {
            color: orange;
        }

        .footer-col p {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 6px 0;
        }
    </style>

</head>

<body>

    <header>
        <nav class="navbar">
            <a href="#" class="logo">
                <div class="logo-icon"><i class="fas fa-graduation-cap"></i></div>
                <span>Prestige <span style="color:var(--gold)">College</span></span>
            </a>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="course.php">Courses</a></li>
                <li><a href="fees.php">Fee Structure</a></li>
                <li><a href="gallery.php">Gallery</a></li>
                <li><a href="aboutus.php">About</a></li>
                <li><a href="contact.php" class="btn-contact">Contact</a></li>
                <li><a href="index.php?page=login">Admin Login</a></li>
            </ul>
        </nav>
    </header>

    <section class="hero">
        <h1>Contact Us</h1>
        <p>Have a question? We'd love to hear from you. Send us an enquiry and we'll respond promptly.</p>
    </section>

    <main class="contact-container">
        <div class="info-sidebar">
            <div class="info-card">
                <div class="icon-circle"><i class="fas fa-map-marker-alt"></i></div>
                <div>
                    <h4>Visit Us</h4>
                    <p>123 University Avenue<br>Academic City, ST 12345</p>
                </div>
            </div>
            <div class="info-card">
                <div class="icon-circle"><i class="fas fa-phone-alt"></i></div>
                <div>
                    <h4>Call Us</h4>
                    <p>+1 (555) 123-4567<br>+1 (555) 765-4321</p>
                </div>
            </div>
            <div class="info-card">
                <div class="icon-circle"><i class="fas fa-envelope"></i></div>
                <div>
                    <h4>Email Us</h4>
                    <p>info@prestigecollege.edu<br>admissions@prestigecollege.edu</p>
                </div>
            </div>
        </div>

        <div class="form-card">
            <h2>Send an Enquiry</h2>
            <?php if ($error): ?>
                <p style="color:red"><?= $error ?></p>
            <?php endif; ?>

            <?php if ($success): ?>
                <p style="color:green"><?= $success ?></p>
            <?php endif; ?>
            <form method="POST">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Full Name *</label>
                        <input type="text" name="name" placeholder="John Doe" required>
                    </div>
                    <div class="form-group">
                        <label>Email *</label>
                        <input type="email" name="email" placeholder="john@example.com" required>
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="tel" name="phone" placeholder="+1 (555) 000-0000">
                    </div>
                    <div class="form-group">
                        <label>Subject *</label>
                        <select name="subject" required>
                            <option value="">Select subject</option>
                            <option value="admission">Admissions</option>
                            <option value="courses">Course Information</option>
                            <option value="general">General Enquiry</option>
                        </select>
                    </div>
                    <div class="form-group full">
                        <label>Message *</label>
                        <textarea name="message" placeholder="Write your enquiry here..." required></textarea>
                    </div>
                </div>
                <button type="submit" class="submit-btn">
                    <i class="fas fa-paper-plane"></i> Send Enquiry
                </button>
            </form>
        </div>
    </main>

    <footer>
        <div class="footer-grid">
            <div class="footer-col">
                <div class="logo" style="color:white; margin-bottom:15px;">
                    <span style="background:var(--gold); padding:4px 7px; border-radius:4px; margin-right:8px;"><i
                            class="fas fa-graduation-cap" style="color:var(--navy)"></i></span>
                    Prestige College
                </div>
                <p>Empowering minds, shaping futures. Providing world-class education since 1985.</p>
            </div>
            <div class="footer-col">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="course.php">Courses</a></li>
                    <li><a href="fees.php">Fee Structure</a></li>
                    <li><a href="gallery.php">Gallery</a></li>
                    <li><a href="aboutus.php">About</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Contact Info</h4>
                <p>
                    <i class="fas fa-map-marker-alt" style="color:var(--gold); margin-right:10px;"></i>
                    <a href="https://maps.google.com/?q=123+University+Ave" target="_blank">
                        123 University Ave
                    </a>
                </p>

                <p>
                    <i class="fas fa-phone" style="color:var(--gold); margin-right:10px;"></i>
                    <a href="tel:+15551234567">
                        +1 (555) 123-4567
                    </a>
                </p>

                <p>
                    <i class="fas fa-envelope" style="color:var(--gold); margin-right:10px;"></i>
                    <a href="mailto:info@prestigecollege.edu">
                        info@prestigecollege.edu
                    </a>
                </p>
            </div>
            <div class="footer-col">
                <h4>Office Hours</h4>
                <p><strong>Mon – Fri:</strong> 8:00 AM – 5:00 PM</p>
                <p><strong>Saturday:</strong> 9:00 AM – 1:00 PM</p>
                <p><strong>Sunday:</strong> Closed</p>
            </div>
        </div>
        <div class="footer-bottom">
            &copy; 2026 Prestige College. All rights reserved.
        </div>
    </footer>
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