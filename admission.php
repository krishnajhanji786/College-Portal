<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
session_start();
require_once("config.php");

$success = "";
$error = "";

if (isset($_POST['apply'])) {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $course = trim($_POST['course']);

    $valid_courses = ["B.Tech", "MBA", "BCA", "MCA", "BBA"];

    // VALIDATION
    if (!preg_match("/^[A-Za-z ]{3,}$/", $name)) {
        $error = "Invalid name!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email!";
    } elseif (!preg_match("/^[0-9]{10}$/", $phone)) {
        $error = "Phone must be 10 digits!";
    } elseif (!in_array($course, $valid_courses)) {
        $error = "Invalid course selected!";
    } else {
        $stmt = $conn->prepare("INSERT INTO admissions (name, email, phone, course) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $phone, $course);

        try {
            $stmt->execute();
            header("Location: admission.php?success=1");
            exit();
        } catch (mysqli_sql_exception $e) {

            if ($e->getCode() == 1062) {
                $error = "You have already applied with this email and phone!";
            } else {
                $error = "Something went wrong!";
            }
        }
    }
}
if (isset($_GET['success'])) {
    $success = "Application submitted successfully!";
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Admission Form</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f6f9;
        }

        .container {
            width: 420px;
            margin: 60px auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 10px;
        }

        .success {
            color: green;
            text-align: center;
            margin-bottom: 15px;
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-size: 0.9rem;
            margin-bottom: 5px;
            display: block;
            color: #333;
        }

        input {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            transition: 0.3s;
        }

        input:focus {
            border-color: #1e3a5f;
            outline: none;
            box-shadow: 0 0 5px rgba(30, 58, 95, 0.3);
        }

        button {
            width: 100%;
            padding: 12px;
            background: #1e3a5f;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #16324a;
        }

        select {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            background: white;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Admission Form</h2>

        <?php if ($success): ?>
            <p class="success"><?php echo $success; ?></p>
        <?php endif; ?>

        <?php if ($error): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <form method="POST">

            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" required pattern="[A-Za-z ]{3,}">
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>

            <div class="form-group">
                <label>Phone Number</label>
                <input type="tel" name="phone" required pattern="[0-9]{10}">
            </div>

            <div class="form-group">
                <label>Course Interested In</label>
                <select name="course" required>
                    <option value="">Select Course</option>
                    <option value="B.Tech">B.Tech</option>
                    <option value="MBA">MBA</option>
                    <option value="BCA">BCA</option>
                    <option value="MCA">MCA</option>
                    <option value="BBA">BBA</option>
                </select>
            </div>

            <button type="submit" name="apply">Apply Now</button>

        </form>
    </div>

</body>

</html>