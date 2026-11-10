<?php
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include('config.php');

if (!isset($_SESSION['email']) && !isset($_SESSION['google_email'])) {
    header('Location: login.php');
    exit;
}

$user_id    = $_SESSION['id'] ?? null;
$session_id = session_id();

if (!$user_id) {
    header('Location: login.php');
    exit;
}

stark_ensure_tables($con);

// Fetch user address
$user_data = [];
if ($con && $user_id) {
    $addr_query = mysqli_query($con, "SELECT * FROM users WHERE id = " . intval($user_id));
    if ($addr_query && mysqli_num_rows($addr_query) > 0) {
        $user_data = mysqli_fetch_assoc($addr_query) ?: [];
    }
}

$has_address = !empty($user_data['address']) && !empty($user_data['city']);
$full_address = $has_address ? trim(($user_data['address'] ?? '') . ', ' . (!empty($user_data['landmark']) ? $user_data['landmark'] . ', ' : '') . ($user_data['city'] ?? '') . ' - ' . ($user_data['zip'] ?? '') . ', ' . ($user_data['state'] ?? '')) : '';
$_SESSION['address'] = $full_address;

// Determine products in checkout
$checkout_items = [];
$subtotal = 0;

if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST['check_id'])) {
    // Products submitted via form (e.g. from shoping-cart.php or Buy Now)
    $product_ids = (array)$_POST['check_id'];
    foreach ($product_ids as $pid) {
        $pid = intval($pid);
        if ($pid <= 0) continue;
        $qty = 1;
        if ($con) {
            $q_res = mysqli_query($con, "SELECT quantity FROM user_cart WHERE (user_id = $user_id OR session_id = '$session_id') AND product_id = $pid LIMIT 1");
            if ($q_res && $q_row = mysqli_fetch_assoc($q_res)) {
                $qty = max(1, intval($q_row['quantity']));
            }
            $p_res = mysqli_query($con, "SELECT id, product_name, product_price, product_img FROM product_item WHERE id = $pid");
            if ($p_res && $p_row = mysqli_fetch_assoc($p_res)) {
                $checkout_items[] = [
                    'id'       => $p_row['id'],
                    'name'     => $p_row['product_name'],
                    'price'    => intval($p_row['product_price']),
                    'img'      => $p_row['product_img'],
                    'quantity' => $qty
                ];
                $subtotal += intval($p_row['product_price']) * $qty;
            }
        }
    }
} else if ($con) {
    // Fetch directly from user_cart
    $cart_stmt = $con->prepare("
        SELECT uc.product_id, uc.quantity, pi.product_name, pi.product_price, pi.product_img
        FROM user_cart uc
        JOIN product_item pi ON uc.product_id = pi.id
        WHERE uc.user_id = ? OR uc.session_id = ?
    ");
    if ($cart_stmt) {
        $cart_stmt->bind_param("is", $user_id, $session_id);
        $cart_stmt->execute();
        $cart_res = $cart_stmt->get_result();

        while ($c_row = $cart_res->fetch_assoc()) {
            $qty = max(1, intval($c_row['quantity']));
            $checkout_items[] = [
                'id'       => $c_row['product_id'],
                'name'     => $c_row['product_name'],
                'price'    => intval($c_row['product_price']),
                'img'      => $c_row['product_img'],
                'quantity' => $qty
            ];
            $subtotal += intval($c_row['product_price']) * $qty;
        }
        $cart_stmt->close();
    }
}

if (empty($checkout_items)) {
    header('Location: shoping-cart.php');
    exit;
}

// Shipping calculation (free over ₹1500, otherwise ₹50)
$shipping = ($subtotal > 1500 || $subtotal == 0) ? 0 : 50;
$total = $subtotal + $shipping;

// Save session values for payment verification
$_SESSION['total_price'] = $total;
$_SESSION['product_id'] = array_column($checkout_items, 'id');

// Cash on Delivery is active payment method
$payment_method = 'Cash on Delivery';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Checkout - Pehunt</title>
    <link rel="icon" type="image/png" href="images/icons/favicon.png" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600&family=Outfit:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/modern-stark.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <style>
        html, body, .animsition {
            opacity: 1 !important;
            visibility: visible !important;
        }
    </style>
</head>

<body class="bg-gray-50" style="opacity: 1 !important; visibility: visible !important;">

    <!-- Header -->
    <header class="header-v4">
        <div class="container-menu-desktop">
            <div class="top-bar">
                <div class="content-topbar flex-sb-m h-full container dis-flex justify-content-center">
                    <div class="left-top-bar">
                        Free Express Shipping on Orders Over ₹999 &nbsp;|&nbsp; ⚡ 100% Secure Checkout
                    </div>
                </div>
            </div>

            <div class="wrap-menu-desktop">
                <nav class="limiter-menu-desktop container">
                    <a href="index.php" class="logo d-flex align-items-center">
                        <img src="images/icons/logo-pehunt-dark.png" alt="PEHUNT" style="height: 42px; width: auto; max-width: 175px; object-fit: contain;">
                    </a>

                    <div class="menu-desktop">
                        <ul class="main-menu">
                            <li><a href="index.php">Home</a></li>
                            <li><a href="product.php">Shop</a></li>
                            <li class="label1" data-label1="hot"><a href="shoping-cart.php">Your Cart</a></li>
                            <li><a href="contact.php">Contact</a></li>
                        </ul>
                    </div>

                    <div class="wrap-icon-header flex-w flex-r-m">
                        <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 js-show-modal-search">
                            <i class="zmdi zmdi-search"></i>
                        </div>
                        <div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti noti-cart js-show-cart" data-notify="0">
                            <i class="zmdi zmdi-shopping-cart"></i>
                        </div>
                        <div class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti noti-wish js-show-wishlist" data-notify="0">
                            <i class="zmdi zmdi-favorite-outline"></i>
                        </div>
                        <div class="dropdown">
                            <div class="dis-block d-flex align-items-center icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-22 dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="zmdi zmdi-account-circle"></i>
                                <span class="h6 m-0 ml-2"><?php echo htmlspecialchars($_SESSION['name'] ?? 'User'); ?></span>
                            </div>
                            <div class="dropdown-menu border-0 rounded px-3 py-3 shadow" style="background: rgba(255, 255, 255, 0.95); min-width: 180px;">
                                <li><a href="orders.php" class="dropdown-item font-weight-bold">Your Orders</a></li>
                                <li><a href="address.php" class="dropdown-item font-weight-bold">Address Details</a></li>
                                <div class="dropdown-divider"></div>
                                <li><a href="logout.php" class="dropdown-item text-danger font-weight-bold">Logout</a></li>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Checkout Container -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex items-center space-x-2 text-sm text-gray-500 mb-8">
            <a href="index.php" class="hover:text-gray-800">Home</a>
            <span>/</span>
            <a href="shoping-cart.php" class="hover:text-gray-800">Shopping Cart</a>
            <span>/</span>
            <span class="text-gray-900 font-semibold">Checkout</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Left Column: Shipping & Payment Method (7 cols) -->
            <div class="lg:col-span-7 space-y-6">
                <!-- Delivery Address Card -->
                <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
                    <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold">1</div>
                            <h2 class="text-lg font-bold text-gray-900">Delivery Address</h2>
                        </div>
                        <a href="address.php" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800">
                            <?php echo $has_address ? 'Change Address' : '+ Add Address'; ?>
                        </a>
                    </div>

                    <div class="mt-4">
                        <?php if ($has_address): ?>
                            <div class="p-4 rounded-xl bg-gray-50 border border-gray-200">
                                <p class="font-bold text-gray-900"><?php echo htmlspecialchars($user_data['name'] ?? ($_SESSION['name'] ?? 'User')); ?></p>
                                <p class="text-sm text-gray-700 mt-1"><?php echo htmlspecialchars($user_data['address'] ?? ''); ?></p>
                                <?php if (!empty($user_data['landmark'])): ?>
                                    <p class="text-xs text-gray-500">Landmark: <?php echo htmlspecialchars($user_data['landmark']); ?></p>
                                <?php endif; ?>
                                <p class="text-sm font-semibold text-gray-800 mt-1">
                                    <?php echo htmlspecialchars(($user_data['city'] ?? '') . ' - ' . ($user_data['zip'] ?? '') . ', ' . ($user_data['state'] ?? '')); ?>
                                </p>
                                <p class="text-xs text-gray-500 mt-2">Mobile: <?php echo htmlspecialchars($user_data['Mobile'] ?? ($user_data['mobile'] ?? 'N/A')); ?></p>
                            </div>
                        <?php else: ?>
                            <div class="p-5 rounded-xl border border-dashed border-amber-300 bg-amber-50 text-amber-800">
                                <p class="text-sm font-semibold">No delivery address saved!</p>
                                <p class="text-xs mt-1 text-amber-700">Please provide your delivery address before placing an order.</p>
                                <a href="address.php" class="mt-3 inline-block px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-lg text-xs font-bold transition">
                                    Enter Address Now &rarr;
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Payment Method Card (COD + Pay via Online) -->
                <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
                    <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold">2</div>
                            <h2 class="text-lg font-bold text-gray-900">Select Payment Method</h2>
                        </div>
                        <span id="selectedMethodBadge" class="text-xs font-semibold px-2.5 py-1 rounded-full bg-indigo-100 text-indigo-800">
                            Pay via Online Active
                        </span>
                    </div>

                    <div class="mt-4 space-y-3.5">
                        <!-- Option 1: Pay via Online (TPIPay / Apiwala) -->
                        <div id="optionOnline" onclick="selectPaymentMethod('online')" class="p-5 rounded-2xl border-2 border-indigo-600 bg-indigo-50/40 cursor-pointer relative transition duration-200 hover:shadow-md">
                            <div class="flex items-start space-x-4">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-600 to-indigo-500 text-white flex items-center justify-center shadow-md shadow-indigo-500/20 flex-shrink-0 mt-0.5">
                                    <i class="zmdi zmdi-card text-xl font-bold"></i>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-2">
                                            <p class="font-bold text-base text-gray-900">Pay via Online</p>
                                            <span class="inline-flex items-center text-[10px] font-extrabold uppercase tracking-wider text-indigo-700 bg-indigo-100 px-2 py-0.5 rounded-full">
                                                Instant & Secure
                                            </span>
                                        </div>
                                        <span id="badgeOnline" class="inline-flex items-center text-xs font-bold text-indigo-700 bg-white px-2.5 py-1 rounded-full border border-indigo-200 shadow-xs">
                                            <i class="zmdi zmdi-check-circle mr-1 text-sm text-indigo-600"></i> Selected
                                        </span>
                                    </div>
                                    <p class="text-xs text-gray-600 mt-1.5 leading-relaxed">
                                        Pay instantly using UPI (Google Pay, PhonePe, Paytm, BHIM), Credit/Debit Cards, QR Code or Net Banking via secure TPIPay gateway.
                                    </p>
                                    
                                    <!-- Online Highlights -->
                                    <div class="mt-3.5 pt-3 border-t border-indigo-200/60 grid grid-cols-1 sm:grid-cols-3 gap-2 text-xs text-gray-700">
                                        <div class="flex items-center space-x-1.5">
                                            <i class="zmdi zmdi-flash text-indigo-600 text-base"></i>
                                            <span>Instant Confirmation</span>
                                        </div>
                                        <div class="flex items-center space-x-1.5">
                                            <i class="zmdi zmdi-shield-security text-indigo-600 text-base"></i>
                                            <span>256-Bit Encrypted</span>
                                        </div>
                                        <div class="flex items-center space-x-1.5">
                                            <i class="zmdi zmdi-smartphone-iphone text-indigo-600 text-base"></i>
                                            <span>UPI & Cards Accepted</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Option 2: Cash on Delivery (COD) -->
                        <div id="optionCod" onclick="selectPaymentMethod('cod')" class="p-5 rounded-2xl border-2 border-gray-200 bg-white cursor-pointer relative transition duration-200 hover:border-gray-300">
                            <div class="flex items-start space-x-4">
                                <div class="w-10 h-10 rounded-xl bg-gray-100 text-gray-700 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <i class="zmdi zmdi-money text-xl font-bold"></i>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <p class="font-bold text-base text-gray-900">Cash on Delivery (COD)</p>
                                        <span id="badgeCod" class="hidden items-center text-xs font-bold text-emerald-700 bg-white px-2.5 py-1 rounded-full border border-emerald-200 shadow-xs">
                                            <i class="zmdi zmdi-check-circle mr-1 text-sm text-emerald-600"></i> Selected
                                        </span>
                                    </div>
                                    <p class="text-xs text-gray-600 mt-1.5 leading-relaxed">
                                        Pay with cash or UPI directly to the courier agent when your parcel arrives safely at your doorstep. No advance payment needed!
                                    </p>

                                    <!-- COD Highlights -->
                                    <div class="mt-3.5 pt-3 border-t border-gray-100 grid grid-cols-1 sm:grid-cols-3 gap-2 text-xs text-gray-600">
                                        <div class="flex items-center space-x-1.5">
                                            <i class="zmdi zmdi-shield-check text-emerald-600 text-base"></i>
                                            <span>Zero Advance Fee</span>
                                        </div>
                                        <div class="flex items-center space-x-1.5">
                                            <i class="zmdi zmdi-truck text-emerald-600 text-base"></i>
                                            <span>Doorstep Delivery</span>
                                        </div>
                                        <div class="flex items-center space-x-1.5">
                                            <i class="zmdi zmdi-pin-drop text-emerald-600 text-base"></i>
                                            <span>Pay on Arrival</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Place Order Actions -->
                    <div class="mt-6">
                        <?php if ($has_address): ?>
                            <form id="checkoutPaymentForm" action="initiate_tpipay.php" method="POST">
                                <input type="hidden" id="paymentMethodInput" name="payment_method" value="Pay via Online">
                                <input type="hidden" name="total_amount" value="<?php echo $subtotal; ?>">
                                <?php foreach ($checkout_items as $ci): ?>
                                    <input type="hidden" name="check_id[]" value="<?php echo $ci['id']; ?>">
                                <?php endforeach; ?>

                                <button type="submit" id="checkoutSubmitButton" class="w-full py-4 px-6 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-base transition duration-200 shadow-xl shadow-indigo-600/20 flex items-center justify-center space-x-2">
                                    <i class="zmdi zmdi-lock text-xl"></i>
                                    <span id="buttonText">Pay via Online</span>
                                    <span>&bull;</span>
                                    <span>₹<?php echo number_format($total, 2); ?></span>
                                </button>
                            </form>
                        <?php else: ?>
                            <a href="address.php" class="block text-center w-full py-4 px-6 rounded-xl bg-gray-400 text-white font-bold text-base cursor-not-allowed">
                                Add Delivery Address to Place Order
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Right Column: Order Summary (5 cols) -->
            <div class="lg:col-span-5">
                <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm sticky top-28">
                    <h2 class="text-lg font-bold text-gray-900 pb-4 border-b border-gray-100">Order Summary</h2>

                    <!-- Items List -->
                    <div class="mt-4 space-y-4 max-h-80 overflow-y-auto pr-1">
                        <?php foreach ($checkout_items as $item): ?>
                            <div class="flex items-center space-x-4 py-2 border-b border-gray-100 last:border-b-0">
                                <div class="w-16 h-16 rounded-xl overflow-hidden bg-gray-100 border border-gray-200 flex-shrink-0">
                                    <img src="image/product/<?php echo htmlspecialchars($item['img']); ?>" alt="" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-semibold text-gray-900 truncate"><?php echo htmlspecialchars($item['name']); ?></h4>
                                    <p class="text-xs text-gray-500 mt-0.5">Qty: <?php echo $item['quantity']; ?></p>
                                    <p class="text-sm font-bold text-indigo-600 mt-1">₹<?php echo number_format($item['price'], 2); ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Price Breakdown -->
                    <div class="mt-6 pt-4 border-t border-gray-100 space-y-3">
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Subtotal</span>
                            <span class="font-semibold text-gray-900">₹<?php echo number_format($subtotal, 2); ?></span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Shipping</span>
                            <?php if ($shipping === 0): ?>
                                <span class="font-semibold text-emerald-600">FREE</span>
                            <?php else: ?>
                                <span class="font-semibold text-gray-900">₹<?php echo number_format($shipping, 2); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="pt-3 border-t border-gray-100 flex justify-between items-center">
                            <span class="text-base font-bold text-gray-900">Total Payable</span>
                            <span class="text-2xl font-black text-gray-900">₹<?php echo number_format($total, 2); ?></span>
                        </div>
                        <div class="flex justify-between items-center text-xs text-gray-500 pt-2 border-t border-gray-100">
                            <span>Payment Method</span>
                            <span id="summaryMethodBadge" class="font-bold text-indigo-700 bg-indigo-50 px-2.5 py-1 rounded-md border border-indigo-200">
                                Pay via Online
                            </span>
                        </div>
                    </div>

                    <div class="mt-6 p-3.5 bg-gray-50 rounded-xl border border-gray-200 text-xs text-gray-500 flex items-center space-x-2">
                        <i class="zmdi zmdi-shield-check text-xl text-emerald-500"></i>
                        <span>100% Safe & Encrypted Payment Gateway.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
    <script>
        var currentMethod = 'online';
        var totalFormatted = '₹<?php echo number_format($total, 2); ?>';

        function selectPaymentMethod(method) {
            currentMethod = method;
            var optionOnline = document.getElementById('optionOnline');
            var optionCod = document.getElementById('optionCod');
            var badgeOnline = document.getElementById('badgeOnline');
            var badgeCod = document.getElementById('badgeCod');
            var methodInput = document.getElementById('paymentMethodInput');
            var submitBtn = document.getElementById('checkoutSubmitButton');
            var form = document.getElementById('checkoutPaymentForm');
            var selectedBadge = document.getElementById('selectedMethodBadge');
            var summaryBadge = document.getElementById('summaryMethodBadge');

            if (method === 'online') {
                // Online Selected
                optionOnline.className = 'p-5 rounded-2xl border-2 border-indigo-600 bg-indigo-50/40 cursor-pointer relative transition duration-200 shadow-md';
                badgeOnline.className = 'inline-flex items-center text-xs font-bold text-indigo-700 bg-white px-2.5 py-1 rounded-full border border-indigo-200 shadow-xs';

                optionCod.className = 'p-5 rounded-2xl border-2 border-gray-200 bg-white cursor-pointer relative transition duration-200 hover:border-gray-300';
                badgeCod.className = 'hidden';

                if (methodInput) methodInput.value = 'Pay via Online';
                if (form) form.action = 'initiate_tpipay.php';

                if (selectedBadge) {
                    selectedBadge.className = 'text-xs font-semibold px-2.5 py-1 rounded-full bg-indigo-100 text-indigo-800';
                    selectedBadge.innerText = 'Pay via Online Active';
                }
                if (summaryBadge) {
                    summaryBadge.className = 'font-bold text-indigo-700 bg-indigo-50 px-2.5 py-1 rounded-md border border-indigo-200';
                    summaryBadge.innerText = 'Pay via Online';
                }

                if (submitBtn) {
                    submitBtn.className = 'w-full py-4 px-6 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-base transition duration-200 shadow-xl shadow-indigo-600/20 flex items-center justify-center space-x-2';
                    submitBtn.innerHTML = '<i class="zmdi zmdi-lock text-xl"></i><span>Pay via Online</span><span>&bull;</span><span>' + totalFormatted + '</span>';
                }
            } else {
                // COD Selected
                optionCod.className = 'p-5 rounded-2xl border-2 border-emerald-500 bg-emerald-50/40 cursor-pointer relative transition duration-200 shadow-md';
                badgeCod.className = 'inline-flex items-center text-xs font-bold text-emerald-700 bg-white px-2.5 py-1 rounded-full border border-emerald-200 shadow-xs';

                optionOnline.className = 'p-5 rounded-2xl border-2 border-gray-200 bg-white cursor-pointer relative transition duration-200 hover:border-gray-300';
                badgeOnline.className = 'hidden';

                if (methodInput) methodInput.value = 'Cash on Delivery';
                if (form) form.action = 'place_order.php';

                if (selectedBadge) {
                    selectedBadge.className = 'text-xs font-semibold px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800';
                    selectedBadge.innerText = 'Cash on Delivery Active';
                }
                if (summaryBadge) {
                    summaryBadge.className = 'font-bold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-md border border-emerald-200';
                    summaryBadge.innerText = 'Cash on Delivery';
                }

                if (submitBtn) {
                    submitBtn.className = 'w-full py-4 px-6 rounded-xl bg-gray-900 hover:bg-black text-white font-bold text-base transition duration-200 shadow-xl shadow-gray-900/10 flex items-center justify-center space-x-2';
                    submitBtn.innerHTML = '<i class="zmdi zmdi-check-all text-xl"></i><span>Confirm & Place Order (COD)</span><span>&bull;</span><span>' + totalFormatted + '</span>';
                }
            }
        }

        // Form Submit Spinner
        var paymentForm = document.getElementById('checkoutPaymentForm');
        if (paymentForm) {
            paymentForm.addEventListener('submit', function() {
                var btn = document.getElementById('checkoutSubmitButton');
                if (btn) {
                    btn.disabled = true;
                    btn.classList.add('opacity-75', 'cursor-wait');
                    var actionText = (currentMethod === 'online') ? 'Connecting to payment gateway...' : 'Placing your order...';
                    btn.innerHTML = '<i class="fa fa-spinner fa-spin mr-2"></i> ' + actionText;
                }
            });
        }
    </script>

<?php
if (ob_get_level() > 0) {
    ob_end_flush();
}
?>
</body>
</html>