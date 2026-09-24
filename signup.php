<?php
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include('config.php');

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname  = trim($_POST['fname'] ?? '');
    $email  = trim($_POST['mail'] ?? '');
    $number = trim($_POST['number'] ?? '');
    $pass   = trim($_POST['pass'] ?? '');

    if (empty($fname) || empty($email) || empty($number) || empty($pass)) {
        $error = "Please fill in all registration fields.";
    } else {
        // Check if email already registered
        $stmt = $con->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            $error = "An account with this email address already exists. Please sign in.";
        } else {
            $_SESSION['reg_name']   = $fname;
            $_SESSION['reg_email']  = $email;
            $_SESSION['reg_number'] = $number;
            $_SESSION['reg_pass']   = $pass;
            $_SESSION['OTP']        = rand(1000, 9999);

            header('Location: user-verification.php');
            exit;
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Account - Pehunt</title>
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
      <h1 class="text-xl font-bold text-slate-900 mt-2">Create New Account</h1>
      <p class="text-xs text-slate-500 mt-1">Join Pehunt for seamless online shopping</p>
    </div>

    <?php if ($error): ?>
      <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-semibold">
        <?php echo htmlspecialchars($error); ?>
      </div>
    <?php endif; ?>

    <form method="POST" class="space-y-4">
      <div>
        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Full Name</label>
        <input 
          type="text" 
          name="fname" 
          placeholder="e.g. Sahil Sharma" 
          value="<?php echo htmlspecialchars($_POST['fname'] ?? ''); ?>"
          required
          class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm outline-none transition bg-slate-50/50"
        >
      </div>

      <div>
        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Email Address</label>
        <input 
          type="email" 
          name="mail" 
          placeholder="e.g. sahil@gmail.com" 
          value="<?php echo htmlspecialchars($_POST['mail'] ?? ''); ?>"
          required
          class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm outline-none transition bg-slate-50/50"
        >
      </div>

      <div>
        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Mobile Number</label>
        <input 
          type="tel" 
          name="number" 
          placeholder="e.g. 9876543210" 
          value="<?php echo htmlspecialchars($_POST['number'] ?? ''); ?>"
          required
          class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm outline-none transition bg-slate-50/50"
        >
      </div>

      <div>
        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Password</label>
        <input 
          type="password" 
          name="pass" 
          placeholder="Create a secure password" 
          required
          class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm outline-none transition bg-slate-50/50"
        >
      </div>

      <button 
        type="submit" 
        class="w-full py-4 px-6 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm transition shadow-xl shadow-indigo-600/25 flex items-center justify-center space-x-2 mt-4"
      >
        <span>Continue to Verification</span>
        <span>&rarr;</span>
      </button>
    </form>

    <div class="mt-6 text-center text-xs text-slate-500">
      Already have an account? 
      <a href="login.php" class="font-bold text-indigo-600 hover:text-indigo-700 underline">Sign In</a>
    </div>
  </div>
</body>
</html>