<?php
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
    $query = mysqli_query($con, "insert into users (fname, email, Mobile, password) values ('$name','$email','$num','$password')");
    $table_query = mysqli_query($conn, "CREATE TABLE IF NOT EXISTS $username (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        data TEXT NOT NULL
    )");
    if($query && $table_query){
     header('location: index.php'); 
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/signup.css">
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