<?php
/**
 * Stark Store - TPIPay UPI QR & Intent Payment Screen
 */
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include('config.php');

$qr_data = $_SESSION['payment_qr_data'] ?? null;
if (!$qr_data) {
    header('Location: checkout.php');
    exit;
}

$apitxnid   = $qr_data['apitxnid'];
$amount     = $qr_data['amount'];
$qr_string  = $qr_data['qr_string'] ?? '';
$qr_image   = $qr_data['qr_image'] ?? '';
$intent_url = $qr_data['intent_url'] ?? $qr_string;

// If we don't have a direct image URL, generate dynamic QR image via Google Charts API
if (empty($qr_image) && !empty($qr_string)) {
    $qr_image = "https://api.qrserver.com/v1/create-qr-code/?size=260x260&data=" . urlencode($qr_string);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete UPI Payment - Stark Store</title>
    <link rel="icon" type="image/png" href="images/icons/favicon.png" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/modern-stark.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .pulse-ring {
            box-shadow: 0 0 0 0 rgba(79, 70, 229, 0.4);
            animation: pulse-ring 2s infinite;
        }
        @keyframes pulse-ring {
            0% { box-shadow: 0 0 0 0 rgba(79, 70, 229, 0.4); }
            70% { box-shadow: 0 0 0 15px rgba(79, 70, 229, 0); }
            100% { box-shadow: 0 0 0 0 rgba(79, 70, 229, 0); }
        }
    </style>
</head>
<body class="bg-slate-50 min-h-screen text-gray-900 font-sans flex flex-col justify-between">
    <!-- Header -->
    <header class="header-v4">
        <div class="container-menu-desktop">
            <div class="wrap-menu-desktop">
                <nav class="limiter-menu-desktop container">
                    <a href="index.php" class="logo d-flex align-items-center">
                        <img src="images/icons/logo-pehunt-dark.png" alt="PEHUNT" style="height: 42px; width: auto; max-width: 175px; object-fit: contain;">
                    </a>
                </nav>
            </div>
        </div>
    </header>

    <div class="max-w-lg mx-auto px-4 py-8 w-full">
        <div class="bg-white rounded-3xl border border-gray-200 shadow-xl overflow-hidden p-6 sm:p-8 text-center">
            
            <!-- Badge -->
            <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-700 text-xs font-bold mb-4">
                <span class="w-2 h-2 rounded-full bg-indigo-600 animate-ping"></span>
                <span>Secure UPI Payment</span>
            </div>

            <h1 class="text-2xl font-black text-gray-900">Scan to Pay</h1>
            <p class="text-xs text-gray-500 mt-1">Scan the QR code with any UPI app on your phone</p>

            <!-- Amount Card -->
            <div class="mt-4 p-4 rounded-2xl bg-gradient-to-r from-gray-900 to-indigo-950 text-white shadow-lg">
                <span class="text-xs text-gray-300 font-medium">Total Amount Due</span>
                <p class="text-3xl font-black tracking-tight mt-0.5">₹<?php echo number_format($amount, 2); ?></p>
                <div class="mt-2 pt-2 border-t border-white/10 flex justify-between text-[11px] text-gray-300">
                    <span>Txn ID: <span class="font-mono font-bold text-white"><?php echo htmlspecialchars($apitxnid); ?></span></span>
                    <span id="countdownTimer" class="font-bold text-amber-300">05:00</span>
                </div>
            </div>

            <!-- QR Container -->
            <div class="mt-6 flex flex-col items-center justify-center">
                <div class="p-3 bg-white rounded-2xl border-2 border-indigo-500/30 shadow-md pulse-ring relative">
                    <?php if (!empty($qr_image)): ?>
                        <img src="<?php echo htmlspecialchars($qr_image); ?>" alt="Scan to pay" class="w-56 h-56 rounded-xl object-contain">
                    <?php else: ?>
                        <div class="w-56 h-56 flex items-center justify-center bg-gray-50 rounded-xl text-gray-400 text-xs">
                            Generating QR Code...
                        </div>
                    <?php endif; ?>
                </div>

                <!-- UPI Logos -->
                <div class="mt-4 flex items-center justify-center space-x-3 text-xs text-gray-500 font-semibold">
                    <span class="px-2 py-1 bg-gray-100 rounded-md">Google Pay</span>
                    <span class="px-2 py-1 bg-gray-100 rounded-md">PhonePe</span>
                    <span class="px-2 py-1 bg-gray-100 rounded-md">Paytm</span>
                    <span class="px-2 py-1 bg-gray-100 rounded-md">BHIM</span>
                </div>
            </div>

            <!-- Mobile Intent Button -->
            <?php if (!empty($intent_url)): ?>
                <div class="mt-6 sm:hidden">
                    <a href="<?php echo htmlspecialchars($intent_url); ?>" class="w-full py-3.5 px-6 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm shadow-lg shadow-indigo-600/25 flex items-center justify-center space-x-2">
                        <i class="zmdi zmdi-smartphone-iphone text-lg"></i>
                        <span>Pay Directly with UPI App</span>
                    </a>
                </div>
            <?php endif; ?>

            <!-- Live Status Indicator -->
            <div class="mt-6 p-3 bg-gray-50 rounded-xl border border-gray-100 flex items-center justify-center space-x-2 text-xs text-gray-500">
                <div class="w-3 h-3 border-2 border-indigo-600 border-t-transparent rounded-full animate-spin"></div>
                <span id="pollingStatus">Waiting for payment confirmation...</span>
            </div>

            <!-- Cancel Button -->
            <div class="mt-4">
                <a href="checkout.php" class="text-xs text-gray-400 hover:text-gray-600 font-medium transition">
                    Cancel & Return to Checkout
                </a>
            </div>
        </div>
    </div>

    <!-- Polling & Timer Script -->
    <script>
        var apitxnid = "<?php echo addslashes($apitxnid); ?>";
        var timeLeft = 300; // 5 minutes
        var timerEl = document.getElementById('countdownTimer');
        var statusEl = document.getElementById('pollingStatus');

        // Timer
        var countdown = setInterval(function() {
            timeLeft--;
            if (timeLeft <= 0) {
                clearInterval(countdown);
                if (timerEl) timerEl.innerText = "Expired";
                if (statusEl) statusEl.innerText = "Payment session expired. Please retry.";
                alert("Payment session expired. Returning to checkout.");
                window.location.href = "checkout.php";
                return;
            }
            var m = Math.floor(timeLeft / 60);
            var s = timeLeft % 60;
            if (timerEl) {
                timerEl.innerText = (m < 10 ? '0' : '') + m + ":" + (s < 10 ? '0' : '') + s;
            }
        }, 1000);

        // Status Polling
        var pollInterval = setInterval(function() {
            fetch('check_payment_status.php?apitxnid=' + encodeURIComponent(apitxnid))
                .then(function(res) { return res.json(); })
                .then(function(data) {
                    if (data && data.is_completed) {
                        clearInterval(pollInterval);
                        clearInterval(countdown);
                        if (statusEl) {
                            statusEl.innerHTML = '<span class="text-emerald-600 font-bold"><i class="fa fa-check-circle"></i> Payment confirmed! Redirecting...</span>';
                        }
                        setTimeout(function() {
                            window.location.href = data.redirect || 'order.php';
                        }, 1200);
                    }
                })
                .catch(function(err) {
                    console.log('Status check error:', err);
                });
        }, 2500);
    </script>
</body>
</html>
