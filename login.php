<?php
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include("config.php");

$error_msg = '';

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $enum = trim($_POST['enum'] ?? '');
    $pass = trim($_POST['pass'] ?? '');

    if (empty($enum) || empty($pass)) {
        $error_msg = "Please enter your email/mobile and password.";
    } else {
        // Check in admins table first
        $admin_stmt = $con->prepare("SELECT * FROM admins WHERE (username = ? AND password = ?) OR (email = ? AND password = ?)");
        $admin_stmt->bind_param("ssss", $enum, $pass, $enum, $pass);
        $admin_stmt->execute();
        $admin_result = $admin_stmt->get_result();

        // Check in users table
        $user_stmt = $con->prepare("SELECT * FROM users WHERE (email = ? OR Mobile = ?) AND password = ?");
        $user_stmt->bind_param("sss", $enum, $enum, $pass);
        $user_stmt->execute();
        $user_result = $user_stmt->get_result();

        if ($admin_result->num_rows > 0) {
            $admin_data = $admin_result->fetch_assoc();
            $_SESSION['id']           = $admin_data['id'];
            $_SESSION['name']         = $admin_data['name'];
            $_SESSION['username']     = $admin_data['username'];
            $_SESSION['email']        = $admin_data['email'];
            $_SESSION['office']       = 1; // Admin flag
            $_SESSION['is_admin']     = true;
            $_SESSION['profile_img']  = $admin_data['profile_img'] ?? 'user_profile.jpg';

            header('Location: admin/index.php');
            exit;
        } elseif ($user_result->num_rows > 0) {
            $user_data = $user_result->fetch_assoc();
            $_SESSION['id']           = $user_data['id'];
            $_SESSION['name']         = $user_data['name'];
            $_SESSION['email']        = $user_data['email'];
            $_SESSION['Mobile']       = $user_data['Mobile'];
            $_SESSION['office']       = $user_data['office'] ?? 2;
            $_SESSION['username']     = $user_data['username'];
            $_SESSION['profile_img']  = $user_data['profile_img'] ?? 'user_profile.jpg';
            $_SESSION['address']      = $user_data['address'] ? trim($user_data['address'] . ', ' . $user_data['city'] . ' - ' . $user_data['zip']) : '';
            $_SESSION['is_admin']     = ($user_data['office'] == 1);

            // Merge guest cart & wishlist with user account
            $session_id = session_id();
            $user_id = $user_data['id'];
            @mysqli_query($con, "UPDATE user_cart SET user_id = $user_id WHERE session_id = '$session_id'");
            @mysqli_query($con, "UPDATE user_wishlist SET user_id = $user_id WHERE session_id = '$session_id'");

            header('Location: index.php');
            exit;
        } else {
            $error_msg = "Invalid email, mobile number or password.";
        }

        $admin_stmt->close();
        $user_stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign In - Pehunt</title>
  <link rel="icon" type="image/png" href="images/icons/favicon.png" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; }
  </style>
</head>
<body class="bg-slate-900 min-h-screen flex items-center justify-center p-4 sm:p-6">
  <div class="w-full max-w-md bg-white rounded-3xl shadow-2xl p-8 sm:p-10 border border-slate-100">
    <!-- Brand Header -->
    <div class="text-center mb-8">
      <a href="index.php" class="inline-block mb-3">
        <img src="images/icons/logo-pehunt-dark.png" alt="PEHUNT" class="h-10 mx-auto" style="height: 40px; width: auto; object-fit: contain;">
      </a>
      <h1 class="text-xl font-bold text-slate-900 mt-2">Welcome Back</h1>
      <p class="text-xs text-slate-500 mt-1">Sign in to manage orders, wishlist and profile</p>
    </div>

    <?php if ($error_msg): ?>
      <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-semibold flex items-center space-x-2">
        <span>&times;</span>
        <span><?php echo htmlspecialchars($error_msg); ?></span>
      </div>
    <?php endif; ?>

    <!-- Login Form -->
    <form method="POST" class="space-y-5">
      <div>
        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2" for="email_field">Email or Mobile Number</label>
        <div class="relative">
          <input 
            type="text" 
            name="enum" 
            id="email_field" 
            value="<?php echo htmlspecialchars($_POST['enum'] ?? ''); ?>"
            placeholder="name@example.com or phone number" 
            required
            class="w-full px-4 py-3.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm outline-none transition bg-slate-50/50"
          >
        </div>
      </div>

      <div>
        <div class="flex items-center justify-between mb-2">
          <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider" for="password_field">Password</label>
        </div>
        <div class="relative">
          <input 
            type="password" 
            name="pass" 
            id="password_field" 
            placeholder="Enter your password" 
            required
            class="w-full px-4 py-3.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm outline-none transition bg-slate-50/50"
          >
        </div>
      </div>

      <button 
        type="submit" 
        class="w-full py-4 px-6 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm transition shadow-xl shadow-indigo-600/25 flex items-center justify-center space-x-2 mt-2"
      >
        <span>Sign In to Account</span>
        <span>&rarr;</span>
      </button>
    </form>


    <!-- Registration Link -->
    <div class="mt-6 text-center text-xs text-slate-500">
      Don't have an account? 
      <a href="signup.php" class="font-bold text-indigo-600 hover:text-indigo-700 underline">Create one now</a>
    </div>

    <div class="mt-4 text-center">
      <a href="index.php" class="text-xs text-slate-400 hover:text-slate-600">
        &larr; Return to Storefront
      </a>
    </div>
  </div>
</body>
</html>