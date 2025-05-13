<?php
require '../config/db.php';
session_start();

// Security headers
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: DENY");

$error = '';
$inputs = ['full_name' => '', 'email' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $inputs['full_name'] = filter_input(INPUT_POST, 'full_name', FILTER_SANITIZE_STRING);
        $inputs['email'] = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        // Validate
        if (empty($inputs['full_name']) || empty($inputs['email']) || empty($password)) {
            throw new Exception("All fields are required");
        }

        if ($password !== $confirm_password) {
            throw new Exception("Passwords do not match");
        }

        // Check if email exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$inputs['email']]);
        if ($stmt->fetch()) {
            throw new Exception("Email already registered");
        }

        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert user
        $stmt = $pdo->prepare("
            INSERT INTO users (email, password, role) 
            VALUES (?, ?, 'student')
        ");
        $stmt->execute([$inputs['email'], $hashed_password]);

        // Insert student
        $user_id = $pdo->lastInsertId();
        $stmt = $pdo->prepare("
            INSERT INTO students (id, full_name) 
            VALUES (?, ?)
        ");
        $stmt->execute([$user_id, $inputs['full_name']]);

        header("Location: login.php");
        exit();

    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <style>
        /* Consistent with login style */
        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background: #f8f9fa;
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        h1 {
            color: #2c3e50;
            margin: 0 0 2rem 0;
            font-weight: 600;
            text-align: center;
            font-size: 1.8rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #4a5568;
            font-weight: 500;
        }

        input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            font-size: 1rem;
            box-sizing: border-box;
        }

        input:focus {
            outline: none;
            border-color: #4299e1;
            box-shadow: 0 0 0 2px rgba(66, 153, 225, 0.2);
        }

        button {
            width: 100%;
            padding: 0.75rem;
            background: #4299e1;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
            margin-top: 0.5rem;
        }

        button:hover {
            background: #3182ce;
        }

        .alert {
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-radius: 4px;
            background: #fed7d7;
            color: #c53030;
        }

        .login-link {
            text-align: center;
            margin-top: 1.5rem;
            color: #4a5568;
        }

        .login-link a {
            color: #4299e1;
            text-decoration: none;
            font-weight: 500;
        }

        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Student Registration</h1>
        
        <?php if ($error): ?>
            <div class="alert"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" 
                       name="full_name" 
                       value="<?= htmlspecialchars($inputs['full_name']) ?>" 
                       required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" 
                       name="email" 
                       value="<?= htmlspecialchars($inputs['email']) ?>" 
                       required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" 
                       name="password" 
                       required
                       minlength="8">
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" 
                       name="confirm_password" 
                       required
                       minlength="8">
            </div>

            <button type="submit">Register</button>
        </form>

        <div class="login-link">
            Already have an account? <a href="login.php">Login here</a>
        </div>
    </div>
</body>
</html>