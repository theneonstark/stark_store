<?php
/**
 * Stark Store - User Registration Data Ingestion & Auto-Login
 */
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "config.php";

$name     = $_SESSION['reg_name']   ?? ($_SESSION['name'] ?? '');
$email    = $_SESSION['reg_email']  ?? ($_SESSION['email'] ?? '');
$num      = $_SESSION['reg_number'] ?? ($_SESSION['num'] ?? '');
$password = $_SESSION['reg_pass']   ?? ($_SESSION['pass'] ?? '');

if (empty($name) || empty($email) || empty($password)) {
    header('Location: signup.php');
    exit;
}

stark_ensure_tables($con);

// Generate unique username
$clean_name = preg_replace('/[^a-zA-Z0-9]/', '', $name);
$username = substr($clean_name, 0, 6) . rand(100, 999);

// Check if user already exists
$check = $con->prepare("SELECT id FROM users WHERE email = ?");
$check->bind_param("s", $email);
$check->execute();
$check_res = $check->get_result();

if ($check_res->num_rows > 0) {
    $existing = $check_res->fetch_assoc();
    $user_id = $existing['id'];
} else {
    // Insert new user
    $stmt = $con->prepare("INSERT INTO users (name, email, Mobile, password, username, office, wishlist, cart) VALUES (?, ?, ?, ?, ?, 2, 'user_wishlist', 'user_cart')");
    $stmt->bind_param("sssss", $name, $email, $num, $password, $username);
    $stmt->execute();
    $user_id = $stmt->insert_id;
    $stmt->close();

    // Insert admin notification
    $notify_stmt = $con->prepare("INSERT INTO admin_notify (notify_name, notify_email, notify_username, notify_img, active, notify_active) VALUES (?, ?, ?, 'user_profile.jpg', 1, 1)");
    $notify_stmt->bind_param("sss", $name, $email, $username);
    @$notify_stmt->execute();
    @$notify_stmt->close();
}
$check->close();

// Log user in automatically
$_SESSION['id']          = $user_id;
$_SESSION['name']        = $name;
$_SESSION['email']       = $email;
$_SESSION['Mobile']      = $num;
$_SESSION['office']      = 2;
$_SESSION['username']    = $username;
$_SESSION['profile_img'] = 'user_profile.jpg';
$_SESSION['is_admin']    = false;

// Merge session cart & wishlist items
$session_id = session_id();
@mysqli_query($con, "UPDATE user_cart SET user_id = $user_id WHERE session_id = '$session_id'");
@mysqli_query($con, "UPDATE user_wishlist SET user_id = $user_id WHERE session_id = '$session_id'");

// Clear registration temp sessions
unset($_SESSION['reg_name'], $_SESSION['reg_email'], $_SESSION['reg_number'], $_SESSION['reg_pass'], $_SESSION['OTP']);

// Redirect to home or checkout
header('Location: index.php');
exit;
?>