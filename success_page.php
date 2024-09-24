<?php
include('config.php');
session_start();
if (!isset($_SESSION['google_loggedin'])) {
    header('Location: signup.php');
    exit;
}
// Retrieve session variables
$full_details = $_SESSION['full_details'];
$google_loggedin = $_SESSION['google_loggedin'];
$google_email = $_SESSION['google_email'];
$google_name = $_SESSION['google_name'];
$google_picture = $_SESSION['google_picture'];

$sub = $full_details['sub'];
$name = $full_details['name'];
$given = $full_details['given_name'];
$pic = $full_details['picture'];
$email = $full_details['email'];
$email_v = $full_details['email_verified'];

$check_user = $con->prepare("SELECT * FROM google_user WHERE email = ? OR sub = ?");
    $check_user->bind_param("ss", $email, $sub);
    $check_user->execute();
    $google_user_result = $check_user->get_result();
if(!$google_user_result->num_rows){
    $g_user = $con->prepare("INSERT INTO google_user (sub,name,given_name,picture,email,email_verify) VALUES (?,?,?,?,?,?)");
    $g_user->bind_param("ssssss", $sub, $name, $given, $pic, $email, $email_v);
    $g_user->execute();
    $user = $con->prepare("INSERT INTO users (name,profile_img,email) VALUES (?,?,?)");
    $user->bind_param("sss", $name, $pic, $email);
    $user->execute();
    echo "Data matched";
    header('location: index.php');
}else{
    header('location: index.php');
}
    
    
?>