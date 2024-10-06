<!DOCTYPE html>
<html lang="en">

<head>
    <?php
        session_start();
        include('config.php');
        if(empty($_SESSION['OTP'])){

        if(isset($_POST['verified'])){
            $otp = $_POST['otp1'].$_POST['otp2'].$_POST['otp3'].$_POST['otp4'];
             
            if($_SESSION['OTP']==$otp){
                unset($_SESSION['OTP']);
                header('location: user-data-send.php');
            }else{
                echo "<script>alert('Incorrect OTP!')</script>";
            }
        }
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="css/verification.css">
</head>

<body>
    <form class="otp-Form" method="POST">

        <span class="mainHeading">Enter OTP</span>
        <p class="otpSubheading">We have sent a verification code to your mobile number</p>
        <div class="inputContainer">
            <input type="tel" inputmode="numeric" required="required" maxlength="1" type="text" name="otp1" class="otp-input" id="otp-input1" autocomplete="off">
            <input type="tel" inputmode="numeric" required="required" maxlength="1" type="text" name="otp2" class="otp-input" id="otp-input2" autocomplete="off">
            <input type="tel" inputmode="numeric" required="required" maxlength="1" type="text" name="otp3" class="otp-input" id="otp-input3" autocomplete="off">
            <input type="tel" inputmode="numeric" required="required" maxlength="1" type="text" name="otp4" class="otp-input" id="otp-input4" autocomplete="off">

        </div>
        <button class="verifyButton" type="submit" name="verified">Verify</button>
        <p class="resendNote">Didn't receive the code? <button class="resendBtn">Resend Code</button></p>

    </form>
    <?php
        }else{
            header('signup.php');
        }
    ?>
<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<script src="vendor/animsition/js/animsition.min.js"></script>
<script src="js/main.js"></script>
</body>

</html>