<?php
session_start();
include("config.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $enum = $_POST['enum'];
  $pass = $_POST['pass'];

  // Using prepared statements to prevent SQL injection
  // Check in users table
  $user_stmt = $con->prepare("SELECT * FROM users WHERE (email = ? OR Mobile = ?) AND password = ?");
  $user_stmt->bind_param("sss", $enum, $enum, $pass);
  $user_stmt->execute();
  $user_result = $user_stmt->get_result();

  // Check in admins table
  $admin_stmt = $con->prepare("SELECT * FROM admins WHERE (username = ? AND password = ?) OR (email = ? AND password = ?)");
  $admin_stmt->bind_param("ssss", $enum, $pass, $enum, $pass);
  $admin_stmt->execute();
  $admin_result = $admin_stmt->get_result();

  if ($user_result->num_rows > 0) {
    $user_data = $user_result->fetch_assoc();

    // Store user data in session
    foreach (['id', 'name', 'email', 'Mobile', 'password', 'profile_img', 'department', 'office', 'username', 'wishlist', 'cart'] as $key) {
      $_SESSION[$key] = $user_data[$key];
    }

    // Automatically update wishlist if condition is met
    if ($_SESSION['wishlist'] == 'user_wishlist') {
      $id = $_SESSION['id'];
      $name = $_SESSION['name'];
      $wish = '_wishlist';

      // Prepare an update statement for the wishlist
      $update_stmt = $con->prepare("UPDATE users SET wishlist = ? WHERE id = ?");
      $new_wishlist = $id . $name . $wish;
      $update_stmt->bind_param("si", $new_wishlist, $id);
      $update_stmt->execute();
      $update_stmt->close();

      // Update the session variable with the new wishlist value
      $_SESSION['wishlist'] = $new_wishlist;
    }

    if ($_SESSION['cart'] == 'user_cart') {
      $id = $_SESSION['id'];
      $name = $_SESSION['name'];
      $cart = '_cart';

      // Prepare an update statement for the wishlist
      $update_stmt = $con->prepare("UPDATE users SET cart = ? WHERE id = ?");
      $new_cart = $id . $name . $cart;
      $update_stmt->bind_param("si", $new_cart, $id);
      $update_stmt->execute();
      $update_stmt->close();

      // Update the session variable with the new wishlist value
      $_SESSION['cart'] = $new_cart;
    }

    header('location: index.php');
    exit();
  } elseif ($admin_result->num_rows > 0) {
    $admin_data = $admin_result->fetch_assoc();

    // Store admin data in session
    foreach (['id', 'name', 'username', 'email', 'mobile', 'password', 'profile_img', 'office', 'address', 'city', 'country', 'pincode', 'about'] as $key) {
      $_SESSION[$key] = $admin_data[$key];
    }
    header('location: admin/index.php');
    exit();
  } else {
    // Handle invalid login
    echo "Invalid login credentials.";
  }

  // Close the prepared statements
  $user_stmt->close();
  $admin_stmt->close();
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="css/login.css">
</head>

<body>
  <form class="form_container" method="POST">
    <div class="logo_container">
      <!-- <img src="https://i.ibb.co/strrDmp/logo-01.png" alt=""> -->
    </div>
    <div class="title_container">
      <p class="title">Login to your Account</p>
      <span class="subtitle">Get started with our app, just create an account and enjoy the experience.</span>
    </div>
    <div class="input_container">
      <label class="input_label" for="email_field">Email</label>
      <svg fill="none" viewBox="0 0 24 24" height="24" width="24" xmlns="http://www.w3.org/2000/svg" class="icon">
        <path stroke-linejoin="round" stroke-linecap="round" stroke-width="1.5" stroke="#141B34" d="M7 8.5L9.94202 10.2394C11.6572 11.2535 12.3428 11.2535 14.058 10.2394L17 8.5"></path>
        <path stroke-linejoin="round" stroke-width="1.5" stroke="#141B34" d="M2.01577 13.4756C2.08114 16.5412 2.11383 18.0739 3.24496 19.2094C4.37608 20.3448 5.95033 20.3843 9.09883 20.4634C11.0393 20.5122 12.9607 20.5122 14.9012 20.4634C18.0497 20.3843 19.6239 20.3448 20.7551 19.2094C21.8862 18.0739 21.9189 16.5412 21.9842 13.4756C22.0053 12.4899 22.0053 11.5101 21.9842 10.5244C21.9189 7.45886 21.8862 5.92609 20.7551 4.79066C19.6239 3.65523 18.0497 3.61568 14.9012 3.53657C12.9607 3.48781 11.0393 3.48781 9.09882 3.53656C5.95033 3.61566 4.37608 3.65521 3.24495 4.79065C2.11382 5.92608 2.08114 7.45885 2.01576 10.5244C1.99474 11.5101 1.99475 12.4899 2.01577 13.4756Z"></path>
      </svg>
      <input placeholder="Email or Mobile No." title="Inpit title" name="enum" type="text" class="input_field" id="email_field">
    </div>
    <div class="input_container">
      <label class="input_label" for="password_field">Password</label>
      <svg fill="none" viewBox="0 0 24 24" height="24" width="24" xmlns="http://www.w3.org/2000/svg" class="icon">
        <path stroke-linecap="round" stroke-width="1.5" stroke="#141B34" d="M18 11.0041C17.4166 9.91704 16.273 9.15775 14.9519 9.0993C13.477 9.03404 11.9788 9 10.329 9C8.67911 9 7.18091 9.03404 5.70604 9.0993C3.95328 9.17685 2.51295 10.4881 2.27882 12.1618C2.12602 13.2541 2 14.3734 2 15.5134C2 16.6534 2.12602 17.7727 2.27882 18.865C2.51295 20.5387 3.95328 21.8499 5.70604 21.9275C6.42013 21.9591 7.26041 21.9834 8 22"></path>
        <path stroke-linejoin="round" stroke-linecap="round" stroke-width="1.5" stroke="#141B34" d="M6 9V6.5C6 4.01472 8.01472 2 10.5 2C12.9853 2 15 4.01472 15 6.5V9"></path>
        <path fill="#141B34" d="M21.2046 15.1045L20.6242 15.6956V15.6956L21.2046 15.1045ZM21.4196 16.4767C21.7461 16.7972 22.2706 16.7924 22.5911 16.466C22.9116 16.1395 22.9068 15.615 22.5804 15.2945L21.4196 16.4767ZM18.0228 15.1045L17.4424 14.5134V14.5134L18.0228 15.1045ZM18.2379 18.0387C18.5643 18.3593 19.0888 18.3545 19.4094 18.028C19.7299 17.7016 19.7251 17.1771 19.3987 16.8565L18.2379 18.0387ZM14.2603 20.7619C13.7039 21.3082 12.7957 21.3082 12.2394 20.7619L11.0786 21.9441C12.2794 23.1232 14.2202 23.1232 15.4211 21.9441L14.2603 20.7619ZM12.2394 20.7619C11.6914 20.2239 11.6914 19.358 12.2394 18.82L11.0786 17.6378C9.86927 18.8252 9.86927 20.7567 11.0786 21.9441L12.2394 20.7619ZM12.2394 18.82C12.7957 18.2737 13.7039 18.2737 14.2603 18.82L15.4211 17.6378C14.2202 16.4587 12.2794 16.4587 11.0786 17.6378L12.2394 18.82ZM14.2603 18.82C14.8082 19.358 14.8082 20.2239 14.2603 20.7619L15.4211 21.9441C16.6304 20.7567 16.6304 18.8252 15.4211 17.6378L14.2603 18.82ZM20.6242 15.6956L21.4196 16.4767L22.5804 15.2945L21.785 14.5134L20.6242 15.6956ZM15.4211 18.82L17.8078 16.4767L16.647 15.2944L14.2603 17.6377L15.4211 18.82ZM17.8078 16.4767L18.6032 15.6956L17.4424 14.5134L16.647 15.2945L17.8078 16.4767ZM16.647 16.4767L18.2379 18.0387L19.3987 16.8565L17.8078 15.2945L16.647 16.4767ZM21.785 14.5134C21.4266 14.1616 21.0998 13.8383 20.7993 13.6131C20.4791 13.3732 20.096 13.1716 19.6137 13.1716V14.8284C19.6145 14.8284 19.619 14.8273 19.6395 14.8357C19.6663 14.8466 19.7183 14.8735 19.806 14.9391C19.9969 15.0822 20.2326 15.3112 20.6242 15.6956L21.785 14.5134ZM18.6032 15.6956C18.9948 15.3112 19.2305 15.0822 19.4215 14.9391C19.5091 14.8735 19.5611 14.8466 19.5879 14.8357C19.6084 14.8273 19.6129 14.8284 19.6137 14.8284V13.1716C19.1314 13.1716 18.7483 13.3732 18.4281 13.6131C18.1276 13.8383 17.8008 14.1616 17.4424 14.5134L18.6032 15.6956Z"></path>
      </svg>
      <input placeholder="Password" title="Inpit title" name="pass" type="password" class="input_field" id="password_field">
    </div>
    <button title="Sign In" type="submit" name="logsub" class="sign-in_btn">
      <span>Sign In</span>
    </button>

    <div class="separator">
      <hr class="line">
      <span>Or</span>
      <hr class="line">
    </div>
    <a href="signup.php" class="create-account">
      Create a new account
    </a>
    <div class="auth-login">
    <a href="google_auth.php" title="Sign In" type="submit" class="sign-in_ggl">
      <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20" viewBox="0 0 48 48">
        <path fill="#fbc02d" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12	s5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24s8.955,20,20,20	s20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"></path>
        <path fill="#e53935" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039	l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"></path>
        <path fill="#4caf50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36	c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"></path>
        <path fill="#1565c0" d="M43.611,20.083L43.595,20L42,20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571	c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"></path>
      </svg>
      <span>Google</span>
    </a>
    <a href="#" title="Sign In" type="submit" class="sign-in_apl">
      <svg preserveAspectRatio="xMidYMid" version="1.1" viewBox="0 0 256 315" height="20px" width="16px" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg">
        <g>
          <path fill="#ffffff" d="M213.803394,167.030943 C214.2452,214.609646 255.542482,230.442639 256,230.644727 C255.650812,231.761357 249.401383,253.208293 234.24263,275.361446 C221.138555,294.513969 207.538253,313.596333 186.113759,313.991545 C165.062051,314.379442 158.292752,301.507828 134.22469,301.507828 C110.163898,301.507828 102.642899,313.596301 82.7151126,314.379442 C62.0350407,315.16201 46.2873831,293.668525 33.0744079,274.586162 C6.07529317,235.552544 -14.5576169,164.286328 13.147166,116.18047 C26.9103111,92.2909053 51.5060917,77.1630356 78.2026125,76.7751096 C98.5099145,76.3877456 117.677594,90.4371851 130.091705,90.4371851 C142.497945,90.4371851 165.790755,73.5415029 190.277627,76.0228474 C200.528668,76.4495055 229.303509,80.1636878 247.780625,107.209389 C246.291825,108.132333 213.44635,127.253405 213.803394,167.030988 M174.239142,50.1987033 C185.218331,36.9088319 192.607958,18.4081019 190.591988,0 C174.766312,0.636050225 155.629514,10.5457909 144.278109,23.8283506 C134.10507,35.5906758 125.195775,54.4170275 127.599657,72.4607932 C145.239231,73.8255433 163.259413,63.4970262 174.239142,50.1987249"></path>
        </g>
      </svg>
      <span>Apple</span>
    </a>
    </div>
    <a href="terms-of-use-and-condition.php" class="note">Terms of use &amp; Conditions</a>
  </form>
</body>

</html>