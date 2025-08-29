<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

$user_id = $_SESSION['user_id'];

// Get current user info
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Save updates
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $full_name = trim($_POST['full_name']);
  $phone = trim($_POST['phone']);
  $bio = trim($_POST['bio']);
  $skills = trim($_POST['skills']);
  $location = trim($_POST['location']);
  $photo_path = $user['profile_photo'];

  if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === 0) {
    $upload_dir = "uploads/";
    if (!is_dir($upload_dir)) mkdir($upload_dir);
    $filename = basename($_FILES['profile_photo']['name']);
    $photo_path = $upload_dir . time() . "_" . $filename;
    move_uploaded_file($_FILES['profile_photo']['tmp_name'], $photo_path);
  }

  $update = $conn->prepare("UPDATE users SET full_name = ?, phone = ?, bio = ?, skills = ?, location = ?, profile_photo = ? WHERE id = ?");
  if (!$update) {
    die("Prepare failed: " . $conn->error);
  }
  $update->bind_param("ssssssi", $full_name, $phone, $bio, $skills, $location, $photo_path, $user_id);
  $update->execute();

  header("Location: profile.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Profile</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f5f5f5;
      margin: 0;
      padding: 20px;
    }

    .container {
      max-width: 600px;
      margin: auto;
      background: white;
      padding: 25px;
      border-radius: 10px;
      box-shadow: 0 0 5px rgba(0,0,0,0.1);
    }

    input[type="text"], textarea {
      width: 100%;
      padding: 10px;
      margin-top: 8px;
      margin-bottom: 15px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }

    button {
      background: #003366;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
    }

    label {
      font-weight: bold;
    }

    a {
      text-decoration: none;
      color: #003366;
    }

    .back {
      text-align: center;
      margin-top: 15px;
    }
  </style>
</head>
<body>

<div class="container">
  <h2>Edit My Profile</h2>

  <form method="POST" enctype="multipart/form-data">
    <label for="full_name">Full Name:</label>
    <input type="text" name="full_name" value="<?= htmlspecialchars($user['full_name']) ?>" required>

    <label for="phone">Phone Number:</label>
    <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>" required>

    <label for="bio">Bio:</label>
    <textarea name="bio" rows="4"><?= htmlspecialchars($user['bio']) ?></textarea>

    <label for="skills">Skills (comma-separated):</label>
    <input type="text" name="skills" value="<?= htmlspecialchars($user['skills']) ?>">

    <label for="location">Location:</label>
    <input type="text" name="location" value="<?= htmlspecialchars($user['location']) ?>">

    <label for="profile_photo">Profile Photo:</label><br>
    <input type="file" name="profile_photo" accept="image/*"><br><br>

    <button type="submit">Save Changes</button>
  </form>

  <div class="back">
    <a href="profile.php">← Back to Profile</a>
  </div>
</div>

</body>
</html>
