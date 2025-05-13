<?php
session_start();
require '../config/db.php';

$user_id = $_SESSION['user_id'];

$sql = "SELECT c.course_name, c.course_code FROM courses c 
        JOIN registrations r ON c.id = r.course_id 
        WHERE r.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

echo "<h2>Your Registered Courses:</h2>";
while ($row = $result->fetch_assoc()) {
    echo "<p>{$row['course_code']} - {$row['course_name']}</p>";
}
