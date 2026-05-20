-- =========================
-- DATABASE SETUP
-- =========================
CREATE DATABASE IF NOT EXISTS college_db 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE college_db;

-- =========================
-- ADMIN TABLE
-- =========================
CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- SAFE INSERT ADMIN (password = admin123)
INSERT INTO admins (username, password)
VALUES ('admin', '$2y$10$wH8QJ3Xx6lQ6mW1Xz9l7Xu9T2g3pTz9x7cV7n5Q5XrK9Zk3YpJ7l2')
ON DUPLICATE KEY UPDATE password = VALUES(password);

-- =========================
-- COURSES TABLE
-- =========================
CREATE TABLE IF NOT EXISTS courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    category VARCHAR(50) NOT NULL,
    type ENUM('Bachelor','Master','Diploma') NOT NULL,
    description TEXT,
    duration VARCHAR(50),
    seats INT,
    eligibility TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- SAMPLE COURSES
INSERT INTO courses (title, category, type, description, duration, seats, eligibility) VALUES
('B.Tech Computer Science', 'Computer Science', 'Bachelor', 'Algorithms, AI, software engineering', '4 Years', 120, '10+2 with PCM'),
('MBA Business Admin', 'Business', 'Master', 'Leadership & management skills', '2 Years', 60, 'Bachelor + Entrance'),
('B.Sc Physics', 'Science', 'Bachelor', 'Physics concepts and research', '3 Years', 80, '10+2 with PCM'),
('Diploma in Web Dev', 'Computer Science', 'Diploma', 'HTML, CSS, JS, React', '1 Year', 40, '10+2 any stream');

-- =========================
-- FEES TABLE
-- =========================
CREATE TABLE IF NOT EXISTS fees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_name VARCHAR(100) NOT NULL,
    tuition DECIMAL(10,2) NOT NULL,
    admission DECIMAL(10,2) NOT NULL,
    lab_fee DECIMAL(10,2) DEFAULT 0,
    library_fee DECIMAL(10,2) DEFAULT 0,
    other_fee DECIMAL(10,2) DEFAULT 0,
    total DECIMAL(10,2) NOT NULL,
    year VARCHAR(20) NOT NULL,
    scholarship BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- SAMPLE FEES
INSERT INTO fees (course_name, tuition, admission, lab_fee, library_fee, other_fee, total, year, scholarship) VALUES
('B.Tech Computer Science', 8500, 1200, 800, 300, 400, 11200, '2025-2026', TRUE),
('MBA Business Administration', 12000, 1500, 0, 400, 600, 14500, '2025-2026', TRUE),
('B.Sc Physics', 5500, 800, 600, 250, 300, 7450, '2025-2026', FALSE),
('BA English Literature', 4500, 700, 0, 250, 200, 5650, '2025-2026', FALSE),
('M.Tech Artificial Intelligence', 10000, 1500, 1200, 350, 500, 13550, '2025-2026', TRUE);

-- =========================
-- GALLERY TABLE
-- =========================
CREATE TABLE IF NOT EXISTS gallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100),
    image_url TEXT NOT NULL,
    category VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- SAMPLE GALLERY
INSERT INTO gallery (title, image_url, category) VALUES
('Campus View', 'https://images.unsplash.com/photo-1562774053-701939374585?w=600', 'campus'),
('Computer Lab', 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=600', 'labs'),
('Library Hall', 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?w=600', 'library'),
('Graduation Day', 'https://images.unsplash.com/photo-1523580494863-6f3031224c94?w=600', 'graduation');

-- =========================
-- ENQUIRIES TABLE
-- =========================
CREATE TABLE IF NOT EXISTS enquiries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    subject VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    status ENUM('new','read','replied') DEFAULT 'new',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_status (status)
);

-- SAMPLE ENQUIRIES
INSERT INTO enquiries (name, email, phone, subject, message) VALUES
('Rahul Sharma', 'rahul@gmail.com', '9876543210', 'Admission', 'I want to know about B.Tech admission'),
('Priya Singh', 'priya@gmail.com', '9123456780', 'Fees', 'Please share fee details for MBA');

-- =========================
-- VIEW
-- =========================
CREATE OR REPLACE VIEW enquiry_summary AS
SELECT id, name, email, subject, status, created_at
FROM enquiries;

-- =========================
-- STORED PROCEDURE
-- =========================

-- =========================
-- ADMISSIONS TABLE
-- =========================
CREATE TABLE IF NOT EXISTS admissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    course VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_user (email, phone)
);