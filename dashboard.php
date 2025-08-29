<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT * FROM users WHERE id = $user_id");
$user = $result->fetch_assoc();
$my_community = $user['community_code'];
$first_name = explode(" ", $user['full_name'])[0];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard - Neighbory</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
    body {
      margin: 0;
      font-family: 'Arial', sans-serif;
      background: #f7f9fc;
      padding-top: 70px;
      color: #333;
    }

    .topbar {
      position: fixed;
      top: 0;
      width: 100%;
      background: linear-gradient(135deg, #0077cc, #00aaff);
      padding: 15px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      z-index: 1000;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
      animation: slideIn 0.5s ease-out forwards;
    }

    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translateY(-20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .logo-container {
      display: flex;
      align-items: center;
    }

    .logo {
      font-size: 24px;
      font-family: 'Georgia', serif;
      font-weight: bold;
      color: #fff;
      letter-spacing: 1px;
      transition: transform 0.3s ease;
    }

    .logo:hover {
      transform: scale(1.05);
    }

    .nav-icons {
      display: flex;
      align-items: center;
      gap: 20px;
    }

    .nav-icons a {
      margin: 0 10px;
      transition: transform 0.3s ease;
      position: relative;
    }

    .nav-icons a:hover {
      transform: scale(1.3) rotate(5deg);
      animation: bounce 0.3s ease;
    }

    @keyframes bounce {
      0%, 100% {
        transform: scale(1.3) rotate(5deg);
      }
      50% {
        transform: scale(1.4) rotate(-5deg);
      }
    }

    .nav-icons img {
      height: 32px;
      filter: brightness(0) invert(1);
    }

    .right {
      display: flex;
      align-items: center;
      gap: 18px;
      margin-right: 50px;
      max-width: 400px;
      flex-shrink: 1;
      overflow: hidden;
      white-space: nowrap;
    }

    .right img {
      height: 24px;
      width: 24px;
      object-fit: contain;
      flex-shrink: 0;
      transition: transform 0.3s ease;
    }

    .right img:hover {
      transform: scale(1.2);
    }

    .profile {
      display: flex;
      align-items: center;
      gap: 10px;
      font-weight: bold;
      color: #fff;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
      max-width: 180px;
      transition: transform 0.3s ease;
    }

    .profile img {
      border-radius: 50%;
      height: 32px;
      width: 32px;
      animation: pulse 2s infinite ease-in-out;
    }

    @keyframes pulse {
      0%, 100% {
        transform: scale(1);
      }
      50% {
        transform: scale(1.1);
      }
    }

    .profile:hover {
      transform: scale(1.05);
    }

    .notification-badge {
      position: absolute;
      top: -5px;
      right: -5px;
      background: #ff4444;
      color: white;
      border-radius: 50%;
      padding: 4px 8px;
      font-size: 12px;
      font-weight: bold;
      animation: pulseBadge 1.5s infinite ease-in-out;
    }

    @keyframes pulseBadge {
      0%, 100% {
        transform: scale(1);
      }
      50% {
        transform: scale(1.15);
      }
    }

    .community-id {
      padding: 8px 16px;
      font-size: 14px;
      font-weight: 600;
      background: linear-gradient(135deg, #ffffff33, #ffffff66);
      color: #fff;
      border-radius: 6px;
      cursor: default;
      transition: all 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
      position: relative;
      overflow: hidden;
    }

    .community-id:hover {
      background: linear-gradient(135deg, #ffffff66, #ffffff99);
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .community-id::after {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      width: 0;
      height: 0;
      background: rgba(255, 255, 255, 0.3);
      border-radius: 50%;
      transform: translate(-50%, -50%);
      transition: width 0.4s ease, height 0.4s ease;
    }

    .community-id:hover::after {
      width: 150px;
      height: 150px;
    }

    .community-id::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
      transition: 0.5s;
    }

    .community-id:hover::before {
      left: 100%;
    }

    .sidebar {
      position: fixed;
      top: 70px;
      left: 0;
      width: 220px;
      height: calc(100vh - 70px);
      background: #fff;
      padding: 20px;
      box-shadow: 2px 0 8px rgba(0, 0, 0, 0.1);
      overflow-y: auto;
      transition: transform 0.3s ease;
    }

    .sidebar a {
      display: block;
      margin: 15px 0;
      text-decoration: none;
      color: #333;
      font-weight: 600;
      padding: 10px;
      border-radius: 6px;
      transition: all 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
      position: relative;
      overflow: hidden;
    }

    .sidebar a:hover {
      background: #e6f0ff;
      color: #0077cc;
      transform: translateX(5px);
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }

    .sidebar a::after {
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

    .sidebar a:hover::after {
      width: 200px;
      height: 200px;
    }

    .right-panel {
      position: fixed;
      top: 70px;
      right: 0;
      width: 300px;
      height: calc(100vh - 70px);
      background: #fff;
      padding: 20px;
      border-left: 1px solid #e0e0e0;
      overflow-y: auto;
    }

    .right-panel h4 {
      color: #0077cc;
      font-size: 18px;
      margin-bottom: 15px;
      font-weight: 700;
      animation: fadeIn 0.5s ease-in;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .right-panel .event {
      padding: 12px;
      margin-bottom: 12px;
      border-radius: 8px;
      background: linear-gradient(135deg, #f0faff, #e6f0ff);
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
      animation: slideInRight 0.5s ease-out forwards;
    }

    @keyframes slideInRight {
      from {
        transform: translateX(20px);
        opacity: 0;
      }
      to {
        transform: translateX(0);
        opacity: 1;
      }
    }

    .right-panel .event:hover {
      transform: scale(1.02);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .right-panel .event strong {
      color: #2c5282;
      font-weight: 600;
    }

    .right-panel .event a {
      color: #0077cc;
      text-decoration: none;
      font-weight: 500;
      transition: color 0.3s ease, transform 0.2s ease;
    }

    .right-panel .event a:hover {
      color: #005fa3;
      transform: scale(1.1);
    }

    .right-panel .event::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 4px;
      height: 100%;
      background: #2ecc71;
      border-radius: 4px 0 0 4px;
    }

    .right-panel .contact {
      padding: 12px;
      margin-bottom: 12px;
      border-radius: 8px;
      background: linear-gradient(135deg, #f9fff0, #e6f3d6);
      display: flex;
      justify-content: space-between;
      align-items: center;
      transition: all 0.3s ease;
      animation: slideInRight 0.6s ease-out forwards;
      animation-delay: 0.2s;
      cursor: pointer;
      position: relative;
      overflow: hidden;
    }

    .right-panel .contact:hover {
      transform: scale(1.05);
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    }

    .right-panel .contact.active {
      background: linear-gradient(135deg, #d4f7c4, #e6f3d6);
    }

    .right-panel .contact span {
      font-size: 12px;
      padding: 2px 8px;
      border-radius: 50%;
      font-weight: 600;
    }

    .right-panel .contact span.green {
      color: #27ae60;
      background: rgba(39, 174, 96, 0.2);
    }

    .right-panel .contact span.red {
      color: #e74c3c;
      background: rgba(231, 76, 60, 0.2);
    }

    .right-panel .contact span.gray {
      color: #7f8c8d;
      background: rgba(127, 140, 141, 0.2);
    }

    .right-panel .contact-details {
      display: none;
      padding: 10px;
      margin-top: 5px;
      background: #f0fff4;
      border-radius: 6px;
      font-size: 14px;
      color: #2c5282;
      animation: fadeInDetails 0.4s ease-in-out;
    }

    .right-panel .contact-details.active {
      display: block;
    }

    @keyframes fadeInDetails {
      from {
        opacity: 0;
        transform: translateY(5px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .right-panel .contact::before {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      width: 0;
      height: 0;
      background: rgba(255, 255, 255, 0.3);
      border-radius: 50%;
      transform: translate(-50%, -50%);
      transition: width 0.6s ease, height 0.6s ease;
      z-index: 0;
    }

    .right-panel .contact:hover::before {
      width: 250px;
      height: 250px;
      animation: ripplePulse 1.5s infinite;
    }

    @keyframes ripplePulse {
      0%, 100% {
        transform: translate(-50%, -50%) scale(1);
      }
      50% {
        transform: translate(-50%, -50%) scale(1.1);
      }
    }

    .right-panel .contact:hover {
      animation: bounceEffect 0.8s ease;
    }

    @keyframes bounceEffect {
      0%, 100% { transform: scale(1.05); }
      50% { transform: scale(1.08); }
    }

    .main {
      margin-left: 240px;
      margin-right: 320px;
      padding: 30px;
    }

    .feed {
      max-width: 100%;
    }

    .post {
      background: #fff;
      padding: 20px;
      margin-bottom: 25px;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      position: relative;
      animation: fadeIn 0.5s ease-in;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .post:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
    }

    .post img,
    .post video {
      max-width: 100%;
      margin-top: 15px;
      border-radius: 10px;
      object-fit: cover;
    }

    .comment {
      margin-top: 12px;
      padding-left: 20px;
      font-size: 14px;
      color: #555;
    }

    .like-comment-form {
      margin-top: 15px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .like-comment-form input[type="text"] {
      width: 80%;
      padding: 10px;
      border-radius: 6px;
      border: 1px solid #ddd;
      font-size: 14px;
      transition: border-color 0.3s ease;
    }

    .like-comment-form input[type="text"]:focus {
      border-color: #0077cc;
      outline: none;
    }

    .like-comment-form button {
      padding: 10px 20px;
      font-size: 14px;
      background: #0077cc;
      color: #fff;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: all 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
      position: relative;
      overflow: hidden;
    }

    .like-comment-form button:hover {
      background: #005fa3;
      transform: scale(1.1);
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }

    .like-comment-form button:active {
      transform: scale(0.95);
    }

    .like-comment-form button::after {
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

    .like-comment-form button:hover::after {
      width: 200px;
      height: 200px;
    }

    .post-actions {
      position: absolute;
      top: 15px;
      right: 15px;
    }

    .post-actions a {
      margin-left: 12px;
      text-decoration: none;
      color: #0077cc;
      font-size: 14px;
      font-weight: 600;
      transition: color 0.3s ease, transform 0.2s ease;
    }

    .post-actions a:hover {
      color: #005fa3;
      transform: scale(1.1);
    }

    .footer {
      text-align: center;
      margin: 30px 0;
      color: #777;
      font-size: 14px;
    }

    .post form textarea {
      width: 100%;
      height: 120px;
      padding: 15px;
      border-radius: 12px;
      border: 2px solid #e0e0e0;
      font-size: 16px;
      resize: none;
      box-sizing: border-box;
      background: #fafafa;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
      transition: all 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease, transform 0.3s ease;
    }

    .post form textarea:focus {
      border-color: #0077cc;
      box-shadow: 0 0 12px rgba(0, 119, 204, 0.3);
      transform: scale(1.02);
      outline: none;
      animation: glowBorder 1.5s infinite ease-in-out;
    }

    @keyframes glowBorder {
      0%, 100% {
        box-shadow: 0 0 12px rgba(0, 119, 204, 0.3);
      }
      50% {
        box-shadow: 0 0 18px rgba(0, 119, 204, 0.5);
      }
    }

    .post form button {
      padding: 12px 24px;
      font-size: 16px;
      font-weight: 600;
      background: linear-gradient(135deg, #0077cc, #00aaff);
      color: #fff;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: all 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
      position: relative;
      overflow: hidden;
      margin-top: 10px;
    }

    .post form button:hover {
      background: linear-gradient(135deg, #005fa3, #0088cc);
      transform: translateY(-2px);
      box-shadow: 0 6px 12px rgba(0, 119, 204, 0.3);
    }

    .post form button:active {
      transform: scale(0.95);
    }

    .post form button::after {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      width: 0;
      height: 0;
      background: rgba(255, 255, 255, 0.3);
      border-radius: 50%;
      transform: translate(-50%, -50%);
      transition: width 0.4s ease, height 0.4s ease;
    }

    .post form button:hover::after {
      width: 250px;
      height: 250px;
    }

    .post form button::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
      transition: 0.5s;
    }

    .post form button:hover::before {
      left: 100%;
    }

    .post form .file-upload {
      position: relative;
      display: inline-block;
      margin-top: 10px;
    }

    .post form input[type="file"] {
      display: none;
    }

    .post form .file-upload-label {
      padding: 10px 20px;
      font-size: 14px;
      font-weight: 600;
      background: linear-gradient(135deg, #6b7280, #9ca3af);
      color: #fff;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: all 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
      position: relative;
      overflow: hidden;
      display: inline-block;
    }

    .post form .file-upload-label:hover {
      background: linear-gradient(135deg, #4b5563, #6b7280);
      transform: translateY(-2px);
      box-shadow: 0 6px 12px rgba(107, 114, 128, 0.3);
    }

    .post form .file-upload-label:active {
      transform: scale(0.95);
    }

    .post form .file-upload-label::after {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      width: 0;
      height: 0;
      background: rgba(255, 255, 255, 0.3);
      border-radius: 50%;
      transform: translate(-50%, -50%);
      transition: width 0.4s ease, height 0.4s ease;
    }

    .post form .file-upload-label:hover::after {
      width: 200px;
      height: 200px;
    }

    .post form .file-upload-label::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
      transition: 0.5s;
    }

    .post form .file-upload-label:hover::before {
      left: 100%;
    }
  </style>
  <script>
    function toggleContactDetails(contactElement) {
      const details = contactElement.nextElementSibling;
      const isActive = details.classList.contains('active');

      // Hide all contact details
      document.querySelectorAll('.contact-details').forEach(d => d.classList.remove('active'));
      document.querySelectorAll('.contact').forEach(c => c.classList.remove('active'));

      if (!isActive) {
        details.classList.add('active');
        contactElement.classList.add('active');
      }
    }

    // Add click event listeners when the page loads
    document.addEventListener('DOMContentLoaded', () => {
      document.querySelectorAll('.contact').forEach(contact => {
        contact.addEventListener('click', () => toggleContactDetails(contact));
      });
    });
  </script>
</head>
<body>

<div class="topbar">
  <div class="logo-container">
    <div class="logo">Neighbory</div>
  </div>
  <div class="nav-icons">
    <a href="dashboard.php"><img src="images/home.png" alt="Home"></a>
    <a href="help.php"><img src="images/handshake.png" alt="Help"></a>
    <a href="event_listings.php"><img src="images/event.png" alt="Events"></a>
  </div>
  <div class="right">
    <span class="community-id">ID: <?= htmlspecialchars($my_community) ?></span>
    <a href="messages.php"><img src="images/message.png" alt="Messages"></a>
    <?php
$unread_sql = $conn->prepare("SELECT COUNT(*) as total FROM notifications WHERE user_id = ? AND is_read = 0");
$unread_sql->bind_param("i", $user_id);
$unread_sql->execute();
$unread_result = $unread_sql->get_result()->fetch_assoc();
$unread_count = $unread_result['total'];
?>

<div style="position: relative;">
  <a href="notifications.php">
    <img src="images/bell.png" alt="Notifications">
    <?php if ($unread_count > 0): ?>
      <span class="notification-badge"><?= $unread_count ?></span>
    <?php endif; ?>
  </a>
</div>

    <a href="profile.php" style="text-decoration:none; color:inherit;">
      <div class="profile">
        <img src="<?= $user['profile_photo'] ? $user['profile_photo'] : 'images/user.jpg' ?>" alt="Profile">
        <span><?= htmlspecialchars($first_name) ?></span>
        <a href="logout.php" title="Logout">
          <img src="images/logout.png" alt="Logout" style="margin-left: 12px;">
        </a>
      </div>
    </a>
  </div>
</div>

<div class="sidebar">
  <a href="messages.php">Friends</a>
  <a href="group_message.php">Groups</a>
  <a href="local_business.php">Local Business</a>
</div>

<div class="right-panel">
  <h4>Events</h4>
  <?php
$today = date('Y-m-d');
$event_q = $conn->prepare("SELECT * FROM events WHERE community_code = ? AND date >= ? ORDER BY date ASC LIMIT 3");
$event_q->bind_param("ss", $my_community, $today);
$event_q->execute();
$event_r = $event_q->get_result();

if ($event_r->num_rows > 0) {
  while ($event = $event_r->fetch_assoc()) {
    $formatted_date = date('j M', strtotime($event['date']));
    echo '<div class="event"><strong>' . $formatted_date . ':</strong> ' . htmlspecialchars($event['title']) . ' @ ' . htmlspecialchars($event['location']) . ' <a href="event_listings.php">Details</a></div>';
  }
} else {
  echo '<div class="event">No upcoming events</div>';
}
?>
  
  <h4 style="margin-top: 20px;">Contacts</h4>
<?php
$contacts_query = $conn->prepare("SELECT full_name FROM users WHERE community_code = ? AND id != ?");
$contacts_query->bind_param("si", $my_community, $user_id);
$contacts_query->execute();
$contacts_result = $contacts_query->get_result();

while ($contact = $contacts_result->fetch_assoc()):
?>
  <div class="contact">
    <?= htmlspecialchars($contact['full_name']) ?>
    <span class="green">●</span>
  </div>
<?php endwhile; ?>
</div>
<div class="main">
  <div class="feed">
    <div class="post">
      <form action="save_post.php" method="POST" enctype="multipart/form-data">
        <textarea name="content" placeholder="What's on your mind..." required></textarea>
        <div class="file-upload">
          <input type="file" name="media" id="media" accept="image/*,video/*">
          <label for="media" class="file-upload-label">Choose File</label>
        </div>
        <br><br>
        <button type="submit">Post</button>
      </form>
    </div>

    <?php
    $stmt = $conn->prepare("SELECT posts.*, users.full_name FROM posts JOIN users ON posts.user_id = users.id WHERE posts.community_code = ? ORDER BY posts.created_at DESC");
    $stmt->bind_param("s", $my_community);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
      $post_id = $row['id'];
      $media = $row['media'];
      $ext = pathinfo($media, PATHINFO_EXTENSION);
      $post_user_id = $row['user_id'];

      $likes_result = $conn->query("SELECT COUNT(*) as total FROM likes WHERE post_id = $post_id");
      $likes = $likes_result->fetch_assoc()['total'];

      $comments_result = $conn->query("SELECT comments.*, users.full_name FROM comments JOIN users ON comments.user_id = users.id WHERE post_id = $post_id ORDER BY created_at ASC");

      echo '<div class="post">';
      echo '<strong>' . htmlspecialchars($row['full_name']) . '</strong> <small>' . $row['created_at'] . '</small>';
      if ($post_user_id == $user_id) {
        echo '<div class="post-actions">';
        echo '<a href="edit_post.php?id=' . $post_id . '">Edit</a>';
        echo '<a href="delete_post.php?id=' . $post_id . '" onclick="return confirm(\'Delete this post?\')">Delete</a>';
        echo '</div>';
      }

      echo '<p>' . nl2br(htmlspecialchars($row['content'])) . '</p>';

      if (!empty($media)) {
        if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif'])) {
          echo '<img src="' . htmlspecialchars($media) . '" alt="Post Image">';
        } elseif (in_array(strtolower($ext), ['mp4', 'webm', 'ogg'])) {
          echo '<video controls><source src="' . htmlspecialchars($media) . '" type="video/' . $ext . '"></video>';
        }
      }

      echo '<form action="like_comment.php" method="POST" class="like-comment-form">';
      echo '<input type="hidden" name="post_id" value="' . $post_id . '">';
      echo '<button type="submit" name="like">👍 Like (' . $likes . ')</button>';
      echo '</form>';

      echo '<form action="like_comment.php" method="POST" class="like-comment-form">';
      echo '<input type="hidden" name="post_id" value="' . $post_id . '">';
      echo '<input type="text" name="comment_text" placeholder="Write a comment..." required>';
      echo '<button type="submit" name="comment">Post</button>';
      echo '</form>';

      while ($comment = $comments_result->fetch_assoc()) {
        echo '<div class="comment"><strong>' . htmlspecialchars($comment['full_name']) . ':</strong> ' . htmlspecialchars($comment['content']) . '</div>';
      }

      echo '</div>';
    }
    ?>
  </div>
</div>

<div class="footer">
  © 2025 Neighbory
</div>

</body>
</html>