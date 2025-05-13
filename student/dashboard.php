<?php
// db connection settings
$host = "localhost";
$user = "root";
$password = "";
$database = "must_registration"; // change this if your DB name is different

// connect to DB
$conn = new mysqli($host, $user, $password, $database);

// check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// fetch students
$sql = "SELECT * FROM students"; // replace 'students' with your actual table name
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
    <style>
        body { font-family: Arial; padding: 20px; background-color: #f0f0f0; }
        table { border-collapse: collapse; width: 100%; background-color: #fff; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #ccc; }
        th { background-color: #007BFF; color: white; }
    </style>
</head>
<body>

    <h2>Registered Students</h2>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Fullname</th>
                <th>Email</th>
                <th>Course</th>
                <th>Registration Date</th>
            </tr>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row["id"] ?></td>
                    <td><?= $row["name"] ?></td>
                    <td><?= $row["email"] ?></td>
                    <td><?= $row["course"] ?></td>
                    <td><?= $row["created_at"] ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No students found.</p>
    <?php endif; ?>

</body>
</html>

<?php $conn->close(); ?>
