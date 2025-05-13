<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Student Registration</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(135deg, #00c6ff, #0072ff);
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .form-container {
      background: #fff;
      padding: 40px 30px;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 400px;
    }

    h2 {
      text-align: center;
      color: #333;
      margin-bottom: 25px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    label {
      display: block;
      font-weight: 600;
      margin-bottom: 8px;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 12px 14px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 16px;
      transition: border-color 0.3s ease;
    }

    input:focus {
      border-color: #0072ff;
      outline: none;
    }

    .btn {
      width: 100%;
      padding: 12px;
      background: #0072ff;
      border: none;
      color: #fff;
      font-size: 16px;
      font-weight: bold;
      border-radius: 6px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .btn:hover {
      background: #005fcc;
    }

    .footer {
      text-align: center;
      margin-top: 15px;
    }

    .footer a {
      color: #0072ff;
      text-decoration: none;
      font-size: 14px;
    }

    .alert {
      padding: 10px;
      background-color: #f44336;
      color: white;
      border-radius: 6px;
      margin-bottom: 15px;
      font-size: 14px;
      text-align: center;
    }
  </style>
</head>
<body>

  <div class="form-container">
    <h2>Student Registration</h2>
    <?php if (isset($_GET['error'])): ?>
      <div class="alert"><?php echo htmlspecialchars($_GET['error']); ?></div>
    <?php endif; ?>
    <form action="auth/register_process.php" method="POST">
      <div class="form-group">
        <label for="name">Fullname</label>
        <input type="text" name="name" required>
      </div>

      <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" name="email" required>
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" required>
      </div>

      <button type="submit" class="btn">Register</button>
    </form>
    <div class="footer">
      <p><a href="index.php">Already have an account? Login</a></p>
    </div>
  </div>

</body>
</html>
