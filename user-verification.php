<!DOCTYPE html>
<html lang="en">

<head>
    <?php
        session_start();
        include('config.php');

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
            <input required="required" maxlength="1" type="text" name="otp1" class="otp-input" id="otp-input1">
            <input required="required" maxlength="1" type="text" name="otp2" class="otp-input" id="otp-input2">
            <input required="required" maxlength="1" type="text" name="otp3" class="otp-input" id="otp-input3">
            <input required="required" maxlength="1" type="text" name="otp4" class="otp-input" id="otp-input4">

        </div>
        <button class="verifyButton" type="submit" name="verified">Verify</button>
        <p class="resendNote">Didn't receive the code? <button class="resendBtn">Resend Code</button></p>

    </form>
</body>

</html>