<?php
include 'db.php';
session_start();

$full_name = trim($_POST['full_name']);
$email = trim($_POST['email']);
$phone = trim($_POST['phone']);
$location = trim($_POST['location']);
$password_raw = $_POST['password'];

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("❌ Invalid email format.");
}

// Validate phone (exactly 11 digits)
if (!preg_match('/^\d{11}$/', $phone)) {
    die("❌ Phone number must be exactly 11 digits.");
}

// Validate password (8-12 chars, at least one number and one special char)
if (
    strlen($password_raw) < 8 || strlen($password_raw) > 12 ||
    !preg_match('/[0-9]/', $password_raw) ||
    !preg_match('/[\W_]/', $password_raw)
) {
    die("❌ Password must be 8–12 characters and include at least one number and one special character.");
}

$password = password_hash($password_raw, PASSWORD_DEFAULT);

// Insert user (allowing same email/phone for multiple accounts)
$sql = "INSERT INTO users (full_name, email, phone, password_hash, location) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("❌ Database error: " . $conn->error);
}

$stmt->bind_param("sssss", $full_name, $email, $phone, $password, $location);

if ($stmt->execute()) {
    $_SESSION['user_id'] = $stmt->insert_id;
    header("Location: community.php");
    exit();
} else {
    echo "❌ Signup error: " . $stmt->error;
}
?>
