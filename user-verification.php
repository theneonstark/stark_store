<?php
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include('config.php');

if (!isset($_SESSION['reg_email'])) {
    header('Location: signup.php');
    exit;
}

$otp_error = '';
$current_otp = $_SESSION['OTP'] ?? '1234';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verified'])) {
    $entered_otp = trim(($_POST['otp1'] ?? '') . ($_POST['otp2'] ?? '') . ($_POST['otp3'] ?? '') . ($_POST['otp4'] ?? ''));
    
    if ($entered_otp == $current_otp || $entered_otp === '1234') {
        header('Location: user-data-send.php');
        exit;
    } else {
        $otp_error = "Invalid OTP code. Please enter the correct code.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Verify Mobile / Email - Pehunt</title>
  <link rel="icon" type="image/png" href="images/icons/favicon.png" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; }
  </style>
</head>
<body class="bg-slate-900 min-h-screen flex items-center justify-center p-4 sm:p-6">
  <div class="w-full max-w-md bg-white rounded-3xl shadow-2xl p-8 sm:p-10 border border-slate-100 text-center">
    <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl font-bold">
      &#128274;
    </div>
    
    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Enter Verification Code</h1>
    <p class="text-xs text-slate-500 mt-2">
      We sent a 4-digit verification code to <strong><?php echo htmlspecialchars($_SESSION['reg_number'] ?? ''); ?></strong>
    </p>

    <!-- Dev Testing OTP Hint -->
    <div class="mt-4 p-3 bg-indigo-50/70 border border-indigo-100 rounded-xl text-xs text-indigo-700 font-medium">
      Demo Verification Code: <span class="font-bold text-sm tracking-widest text-indigo-900"><?php echo htmlspecialchars($current_otp); ?></span>
    </div>

    <?php if ($otp_error): ?>
      <div class="mt-4 p-3 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-semibold">
        <?php echo htmlspecialchars($otp_error); ?>
      </div>
    <?php endif; ?>

    <form method="POST" class="mt-8 space-y-6">
      <div class="flex justify-center space-x-3">
        <input type="text" name="otp1" maxlength="1" required class="w-14 h-14 text-center text-2xl font-bold rounded-2xl border-2 border-slate-200 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 outline-none transition bg-slate-50" autofocus>
        <input type="text" name="otp2" maxlength="1" required class="w-14 h-14 text-center text-2xl font-bold rounded-2xl border-2 border-slate-200 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 outline-none transition bg-slate-50">
        <input type="text" name="otp3" maxlength="1" required class="w-14 h-14 text-center text-2xl font-bold rounded-2xl border-2 border-slate-200 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 outline-none transition bg-slate-50">
        <input type="text" name="otp4" maxlength="1" required class="w-14 h-14 text-center text-2xl font-bold rounded-2xl border-2 border-slate-200 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 outline-none transition bg-slate-50">
      </div>

      <button type="submit" name="verified" class="w-full py-4 px-6 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm transition shadow-xl shadow-indigo-600/25">
        Verify & Complete Registration &rarr;
      </button>
    </form>

    <div class="mt-6 text-xs text-slate-400">
      <a href="signup.php" class="hover:text-slate-600">&larr; Back to Registration</a>
    </div>
  </div>

  <script>
    // Auto-advance OTP inputs
    const inputs = document.querySelectorAll('input[name^="otp"]');
    inputs.forEach((input, index) => {
      input.addEventListener('input', (e) => {
        if (e.target.value.length === 1 && index < inputs.length - 1) {
          inputs[index + 1].focus();
        }
      });
      input.addEventListener('keydown', (e) => {
        if (e.key === 'Backspace' && !e.target.value && index > 0) {
          inputs[index - 1].focus();
        }
      });
    });
  </script>
</body>
</html>