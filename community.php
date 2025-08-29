<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}
include 'db.php';

$user_id = $_SESSION['user_id'];
$query = $conn->prepare("SELECT community_code FROM users WHERE id = ?");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();

if (!empty($user['community_code'])) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Join or Create Community - Neighbory</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #f9f9f9;
    }
    .header {
      background-color: #dde5ff;
      padding: 15px 30px;
      font-size: 24px;
      font-weight: bold;
      font-family: 'Segoe UI';
    }

    .form-section {
      background: white;
      width: 80%;
      max-width: 600px;
      margin: 30px auto;
      padding: 30px;
      border-radius: 25px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      text-align: center;
    }

    h2 {
      margin-bottom: 10px;
    }

    input[type="text"] {
      padding: 10px;
      width: 80%;
      margin: 10px auto;
      border-radius: 5px;
      border: 1px solid #ccc;
      font-size: 16px;
    }

    .button {
      padding: 10px 25px;
      border: none;
      border-radius: 25px;
      font-size: 16px;
      margin-top: 10px;
      cursor: pointer;
      box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    }

    .btn-blue {
      background-color: #7fc8f8;
      color: white;
    }

    .btn-red {
      background-color: #fcbaba;
      color: black;
    }

    .divider {
      text-align: center;
      font-weight: bold;
      margin: 20px 0;
    }

    .input-group {
      display: flex;
      justify-content: space-between;
      gap: 10px;
      flex-wrap: wrap;
    }

    .input-group input {
      width: 100%;
      flex: 1;
    }

    @media screen and (max-width: 600px) {
      .input-group {
        flex-direction: column;
      }
    }
  </style>
</head>
<body>
  <div class="header">Neighbory</div>

  <div class="form-section">
    <h2>Explore Your Community</h2>
    <p>Get the most out of your neighborhood with Neighbory</p>

    <form action="community_process.php" method="POST">
      <input type="text" name="join_code" placeholder="Invite Code" required><br>
      <button type="submit" name="action" value="join" class="button btn-blue">Continue</button>
    </form>
  </div>

  <div class="divider">OR</div>

  <div class="form-section">
    <form action="community_process.php" method="POST">
      <div class="input-group">
        <input type="text" name="new_name" placeholder="Community Name" required>
        <input type="text" name="new_location" placeholder="Location" required>
        <input type="text" name="new_code" placeholder="Unique Code" required>
      </div>
      <button type="submit" name="action" value="create" class="button btn-red">Create Community</button>
    </form>
  </div>
</body>
</html>
