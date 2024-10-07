<?php
session_start();
require_once "config.php";
$name = $_SESSION['name'];
$email = $_SESSION['email'];
$num = $_SESSION['num'];
$password = $_SESSION['pass'];

$uname = substr($name, 0, 3);
$umail = substr($email, 0, 5);
$upass = substr($password, 0, 2);
$unum = substr($num, 0, 2);
$username = $uname . $umail . $upass . $unum;
header('location: index.php');

    $query = mysqli_query($con, "INSERT INTO users (name, email, Mobile, password, username) VALUES ('$name','$email','$num','$password', '$username')");

    if ($query) {
        $fetch_details = mysqli_query($con, "SELECT * FROM users WHERE email = '$email'");
        
        if ($fetch = mysqli_fetch_array($fetch_details)) {
            foreach (['id', 'name', 'email', 'Mobile', 'password', 'profile_img', 'department', 'office', 'username', 'wishlist', 'cart'] as $key) {
                $_SESSION[$key] = $fetch[$key];
            }

            if ($_SESSION['wishlist'] == 'user_wishlist') {
              $id = $_SESSION['id'];
              $name = $_SESSION['name'];
              $wish = '_wishlist';
  
              $update_stmt = $con->prepare("UPDATE users SET wishlist = ? WHERE id = ?");
              $new_wishlist = $id . $name . $wish;
              $update_stmt->bind_param("si", $new_wishlist, $id);
              $update_stmt->execute();
              $update_stmt->close();
  
              $_SESSION['wishlist'] = $new_wishlist;
          }

          if ($_SESSION['cart'] == 'user_cart') {
            $id = $_SESSION['id'];
            $name = $_SESSION['name'];
            $cart = '_cart';

            $update_stmt = $con->prepare("UPDATE users SET cart = ? WHERE id = ?");
            $new_cart = $id . $name . $cart;
            $update_stmt->bind_param("si", $new_cart, $id);
            $update_stmt->execute();
            $update_stmt->close();

            $_SESSION['cart'] = $new_cart;
        }
        }
        exit(); 
    }