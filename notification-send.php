<?php
session_start();
require_once "config.php";
$name = $_SESSION['name'];
$email = $_SESSION['email'];
$username = $_SESSION['username'];
$img = $_SESSION['profile_img'];

$notification = mysqli_query($notification, "INSERT INTO admin_notify (notify_name, notify_email, notify_username, notify_img,active, notify_active) VALUES ('$name',' $email', '$username', '$img', '1', '1')");
header('location: index.php');
?>
