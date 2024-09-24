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
if (!$google_user_result->num_rows) {
    $g_user = $con->prepare("INSERT INTO google_user (sub,name,given_name,picture,email,email_verify) VALUES (?,?,?,?,?,?)");
    $g_user->bind_param("ssssss", $sub, $name, $given, $pic, $email, $email_v);
    $g_user->execute();
    $user = $con->prepare("INSERT INTO users (name,profile_img,email) VALUES (?,?,?)");
    $user->bind_param("sss", $name, $pic, $email);
    $user->execute();
    if ($user) {
        $fetch_details = mysqli_query($con, "SELECT * FROM users WHERE email = '$email'");

        if ($fetch = mysqli_fetch_array($fetch_details)) {
            foreach (['id', 'name', 'email', 'Mobile', 'password', 'profile_img', 'office', 'username', 'wishlist', 'cart'] as $key) {
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
            }else{
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
                echo "Data matched";
                header('location: index.php');
            }else{
                $_SESSION['cart'] = $new_cart;
                header('location: index.php');
            }
        }
    }
} else {
    $fetch_details = mysqli_query($con, "SELECT * FROM users WHERE email = '$email'");

        if ($fetch = mysqli_fetch_array($fetch_details)) {
            foreach (['id', 'name', 'email', 'Mobile', 'password', 'profile_img', 'office', 'username', 'wishlist', 'cart'] as $key) {
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
            }else{
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
                echo "Data matched";
                header('location: index.php');
            }else{
                $_SESSION['cart'] = $new_cart;
                echo "Data matched";
                header('location: index.php');
            }
        }
}
