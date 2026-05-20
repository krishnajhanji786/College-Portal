<?php
$conn = new mysqli("localhost", "root", "", "college_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->query("
CREATE TABLE IF NOT EXISTS admissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    course VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_user (email, phone)
)");

$conn->query('
INSERT INTO admins (username, password)
VALUES ("admin", "$2y$10$wH8QJ3Xx6lQ6mW1Xz9l7Xu9T2g3pTz9x7cV7n5Q5XrK9Zk3YpJ7l2")
ON DUPLICATE KEY UPDATE password = VALUES(password)
');
?>