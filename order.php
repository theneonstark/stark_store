<?php
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include("config.php");

$order_success = ($_SESSION['success'] ?? '') === "order_success";
$user_id = $_SESSION['id'] ?? null;
$last_order_id = $_SESSION['last_order_id'] ?? null;

if (!$user_id) {
    header('Location: login.php');
    exit;
}

// Fetch the order details
$order = null;
if ($last_order_id) {
    $stmt = $con->prepare("SELECT * FROM user_order WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $last_order_id, $user_id);
    $stmt->execute();
    $order = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

if (!$order) {
    $stmt = $con->prepare("SELECT * FROM user_order WHERE user_id = ? ORDER BY id DESC LIMIT 1");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $order = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

// Clear single-use flash flag
if (isset($_SESSION['success'])) {
    unset($_SESSION['success']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmed - Stark Store</title>
    <link rel="icon" type="image/png" href="images/icons/favicon.png" />
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">
    <header class="header-v4">
        <div class="container-menu-desktop">
            <div class="wrap-menu-desktop">
                <nav class="limiter-menu-desktop container">
                    <a href="index.php" class="logo">
                        <img src="images/icons/logo-01.png" alt="IMG-LOGO">
                    </a>
                    <div class="menu-desktop">
                        <ul class="main-menu">
                            <li><a href="index.php">Home</a></li>
                            <li><a href="product.php">Shop</a></li>
                            <li><a href="orders.php">Your Orders</a></li>
                            <li><a href="contact.php">Contact</a></li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </header>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="bg-white rounded-3xl border border-gray-200 shadow-xl overflow-hidden text-center p-8 sm:p-12">
            <!-- Animated Green Checkmark -->
            <div class="w-20 h-20 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg shadow-emerald-500/20">
                <i class="zmdi zmdi-check text-4xl font-bold"></i>
            </div>

            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Order Confirmed!</h1>
            <p class="text-gray-500 mt-2 text-base">
                Thank you for shopping with Stark Store. Your order has been placed and is currently being processed.
            </p>

            <?php if ($order): ?>
                <div class="mt-8 p-6 bg-gray-50 rounded-2xl border border-gray-200 text-left space-y-4">
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pb-4 border-b border-gray-200 text-xs">
                        <div>
                            <span class="text-gray-400 uppercase font-semibold">Order Reference</span>
                            <p class="font-bold text-gray-900 mt-1 truncate"><?php echo htmlspecialchars($order['razorpay_order_id'] ?: ('ORD-' . $order['id'])); ?></p>
                        </div>
                        <div>
                            <span class="text-gray-400 uppercase font-semibold">Payment</span>
                            <p class="font-bold text-indigo-600 mt-1"><?php echo htmlspecialchars($order['payment_method'] ?? 'Online'); ?></p>
                        </div>
                        <div>
                            <span class="text-gray-400 uppercase font-semibold">Status</span>
                            <p class="font-bold text-emerald-600 mt-1"><?php echo htmlspecialchars($order['status'] ?? 'Processing'); ?></p>
                        </div>
                        <div>
                            <span class="text-gray-400 uppercase font-semibold">Total Amount</span>
                            <p class="font-bold text-gray-900 mt-1">₹<?php echo number_format($order['amount'], 2); ?></p>
                        </div>
                    </div>

                    <div>
                        <span class="text-xs uppercase font-semibold text-gray-400">Delivery Address</span>
                        <p class="text-sm font-medium text-gray-800 mt-1"><?php echo htmlspecialchars($order['address']); ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="orders.php" class="w-full sm:w-auto px-8 py-3.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm transition shadow-lg shadow-indigo-600/20">
                    View Your Orders &rarr;
                </a>
                <a href="product.php" class="w-full sm:w-auto px-8 py-3.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold text-sm transition">
                    Continue Shopping
                </a>
            </div>
        </div>
    </div>
</body>
</html>