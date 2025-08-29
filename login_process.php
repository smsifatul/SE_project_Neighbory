<?php
session_start();
include 'db.php';

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user && password_verify($password, $user['password_hash'])) {
    $_SESSION['user_id'] = $user['id'];
    
    // ✅ Send to community selection if not yet joined
    if (!empty($user['community_code'])) {
        header("Location: dashboard.php");
    } else {
        header("Location: community.php");
    }
    exit();
} else {
    echo "Invalid credentials. <a href='login.php'>Try again</a>";
}
?>
