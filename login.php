<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login - Neighbory</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
    body {
      margin: 0;
      padding: 0;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      background-image: url('images/bg.jpg');
      background-size: cover;
      background-position: center;
      font-family: Arial, sans-serif;
    }

    .login-container {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 20px;
    }

    .logo {
      font-size: 48px;
      font-weight: bold;
      color: #332D56;
      text-transform: uppercase;
      letter-spacing: 3px;
      position: relative;
      animation: fadeIn 1s ease-in-out;
      text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
      margin-bottom: 20px;
    }

    .logo::before {
      content: '';
      position: absolute;
      bottom: -5px;
      left: 0;
      width: 0;
      height: 3px;
      background: linear-gradient(to right, #332D56, #4a4470);
      animation: underline 2s ease-in-out infinite;
    }

    @keyframes fadeIn {
      0% { opacity: 0; transform: translateY(-20px); }
      100% { opacity: 1; transform: translateY(0); }
    }

    @keyframes underline {
      0% { width: 0; }
      50% { width: 100%; }
      100% { width: 0; }
    }

    .login-box {
      background: rgba(255, 255, 255, 0.9);
      padding: 30px 40px;
      border-radius: 10px;
      max-width: 400px;
      width: 100%;
      box-shadow: 0 0 10px rgba(0,0,0,0.2);
      text-align: center;
    }

    .login-box h2 {
      margin-bottom: 20px;
    }

    .login-box input[type="email"],
    .login-box input[type="password"] {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 16px;
    }

    .login-box button {
      width: 100%;
      padding: 10px;
      background-color: #27ae60;
      color: white;
      border: none;
      font-size: 16px;
      border-radius: 5px;
      cursor: pointer;
      margin-top: 10px;
      transition: background 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
      position: relative;
      overflow: hidden;
      font-weight: 600;
    }

    .login-box button:hover {
      background: #219150;
      transform: scale(1.05);
      box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    }

    .login-box button:active {
      transform: scale(0.95);
      box-shadow: 0 1px 3px rgba(0,0,0,0.2);
    }

    .login-box button::after {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      width: 0;
      height: 0;
      background: rgba(255,255,255,0.2);
      border-radius: 50%;
      transform: translate(-50%, -50%);
      transition: width 0.3s ease, height 0.3s ease;
    }

    .login-box button:hover::after {
      width: 200px;
      height: 200px;
    }

    .login-box p {
      margin-top: 15px;
    }

    .login-box a {
      color: #27ae60;
      text-decoration: none;
      font-weight: 600;
      transition: color 0.3s ease, transform 0.2s ease;
    }

    .login-box a:hover {
      color: #219150;
      text-decoration: underline;
      transform: scale(1.05);
    }
  </style>
</head>
<body>
  <div class="login-container">
    <div class="login-box">
      <div class="logo">Neighbory</div>
      <h2>Login</h2>
      <form action="login_process.php" method="POST">
        <input type="email" name="email" placeholder="Email address" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Continue</button>
      </form>
      <p>Don’t have an account? <a href="signup.php">Sign Up</a></p>
    </div>
  </div>
</body>
</html>