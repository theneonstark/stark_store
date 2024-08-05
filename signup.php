<?php
session_start();
  require_once "config.php";
  if(isset($_POST['sub'])){
    $name = $_POST['fname'];
    $email = $_POST['mail'];
    $num = $_POST['number'];
    $password = $_POST['pass'];
    $uname = substr($name,0,3);
    $umail = substr($email, 0,5);
    $upass = substr($password,0,2);
    $unum = substr($num,0,2);
    $username = $uname.$umail.$upass.$unum;
    // if(isset($_POST['sub'])){
    
    $_SESSION['user_table'] = $username;
    $query = mysqli_query($con, "insert into users (name, email, Mobile, password, username) values ('$name','$email','$num','$password', '$username')");
    $table_query = mysqli_query($conn, "CREATE TABLE IF NOT EXISTS $username (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        data TEXT NOT NULL
    )");
  }
?>
<!-- <form class="otp-Form">
 
  <span class="mainHeading">Enter OTP</span>
  <p class="otpSubheading">We have sent a verification code to your mobile number</p>
  <div class="inputContainer">
   <input required="required" maxlength="1" type="text" class="otp-input" id="otp-input1">
   <input required="required" maxlength="1" type="text" class="otp-input" id="otp-input2">
   <input required="required" maxlength="1" type="text" class="otp-input" id="otp-input3">
   <input required="required" maxlength="1" type="text" class="otp-input" id="otp-input4"> 
   
  </div>
   <button class="verifyButton" type="submit">Verify</button>
     <button class="exitBtn">×</button>
     <p class="resendNote">Didn't receive the code? <button class="resendBtn">Resend Code</button></p>
     
</form> -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/signup.css">
    <link rel="stylesheet" href="css/verification.css">
</head>
<body>
    <div class="form-box">
        <form class="form" method="POST">
            <span class="title">Sign up</span>
            <span class="subtitle">Create a free account with your email.</span>
            <div class="form-container">
              <input type="text" class="input" name="fname" placeholder="Full Name" required>
                    <input type="email" class="input" name="mail" placeholder="Email" required>
                    <input type="text" class="input" name="number" placeholder="Mobile No." required>
                    <input type="password" class="input" name="pass" placeholder="Password" required>
            </div>
            <button name="sub">Sign up</button>
        </form>
        <div class="form-section">
          <p>Have an account? <a href="">Log in</a> </p>
        </div>
        </div>
      <script>
        if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
        }
      </script>
</body>
</html>