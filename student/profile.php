<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: auth/login.php");
    exit();
}

// Dummy data — replace with real session or database values
$student_name = $_SESSION['student_name'] ?? 'John Doe';
$student_email = $_SESSION['student_email'] ?? 'john@example.com';
$student_id = $_SESSION['student_id'] ?? '12345';

include 'header.php';
?>

<div style="
  max-width: 600px;
  margin: 50px auto;
  background: #fff;
  padding: 30px;
  border-radius: 10px;
  box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
  font-family: 'Segoe UI', sans-serif;
">
  <h2 style="text-align: center; color: #0072ff; margin-bottom: 25px;">My Profile</h2>
  <p style="font-size: 16px; color: #333;"><strong style="color:#0072ff;">Full Name:</strong> <?php echo htmlspecialchars($student_name); ?></p>
  <p style="font-size: 16px; color: #333;"><strong style="color:#0072ff;">Email:</strong> <?php echo htmlspecialchars($student_email); ?></p>
  <p style="font-size: 16px; color: #333;"><strong style="color:#0072ff;">Student ID:</strong> <?php echo htmlspecialchars($student_id); ?></p>

  <a href="edit_profile.php" style="
    display: inline-block;
    margin-top: 20px;
    padding: 10px 20px;
    background: #0072ff;
    color: white;
    text-decoration: none;
    border-radius: 6px;
    font-weight: bold;
  ">Edit Profile</a>
</div>

<?php include 'footer.php'; ?>
