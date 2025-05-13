<?php
session_start();
require_once '../config/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

// Get user information
$user_id = $_SESSION['user_id'];
$full_name = $_SESSION['full_name'] ?? 'Student';

// Fetch student data
try {
    $stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
    $stmt->execute([$user_id]);
    $student = $stmt->fetch();
    
    // Fetch registered courses
    $stmt = $pdo->prepare("
        SELECT c.* FROM courses c
        JOIN registrations r ON c.id = r.course_id
        WHERE r.user_id = ?
    ");
    $stmt->execute([$user_id]);
    $courses = $stmt->fetchAll();
    
} catch (PDOException $e) {
    error_log("Dashboard error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <style>
        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        
        .header {
            background: #0072ff;
            color: white;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .header h1 {
            margin: 0;
            font-size: 1.5rem;
        }
        
        .nav {
            display: flex;
            gap: 1rem;
        }
        
        .nav a {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: background 0.2s;
        }
        
        .nav a:hover {
            background: rgba(255,255,255,0.1);
        }
        
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        
        .welcome-card {
            background: white;
            border-radius: 8px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }
        
        .card {
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        
        .card h2 {
            color: #2c3e50;
            margin-top: 0;
            font-size: 1.25rem;
            border-bottom: 1px solid #eee;
            padding-bottom: 0.75rem;
        }
        
        .courses-list {
            list-style: none;
            padding: 0;
        }
        
        .courses-list li {
            padding: 0.75rem 0;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .courses-list li:last-child {
            border-bottom: none;
        }
        
        .btn {
            display: inline-block;
            background: #0072ff;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s;
        }
        
        .btn:hover {
            background: #005fcc;
        }
        
        .footer {
            text-align: center;
            padding: 2rem 0;
            color: #666;
            border-top: 1px solid #eee;
            margin-top: 2rem;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Student Portal</h1>
        <div class="nav">
            <a href="dashboard.php">Dashboard</a>
            <a href="profile.php">Profile</a>
            <a href="../auth/logout.php">Logout</a>
        </div>
    </div>
    
    <div class="container">
        <div class="welcome-card">
            <h2>Welcome, <?= htmlspecialchars($full_name) ?>!</h2>
            <p>This is your student dashboard. Here you can manage your courses and view your academic information.</p>
        </div>
        
        <div class="dashboard-grid">
            <div class="card">
                <h2>My Courses</h2>
                <?php if (!empty($courses)): ?>
                    <ul class="courses-list">
                        <?php foreach ($courses as $course): ?>
                            <li><?= htmlspecialchars($course['course_code']) ?> - <?= htmlspecialchars($course['course_name']) ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>You are not registered for any courses yet.</p>
                <?php endif; ?>
                <a href="register_course.php" class="btn">Register for Courses</a>
            </div>
            
            <div class="card">
                <h2>Quick Links</h2>
                <ul class="courses-list">
                    <li><a href="profile.php">Update Profile</a></li>
                    <li><a href="view_courses.php">View All Courses</a></li>
                    <li><a href="#">Academic Calendar</a></li>
                    <li><a href="#">Exam Schedule</a></li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="footer">
        &copy; <?= date('Y') ?> Mbeya University Student Portal. All rights reserved.
    </div>
</body>
</html>