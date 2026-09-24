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
$addr_query = mysqli_query($con, "SELECT * FROM users WHERE id = $user_id");
$user_data  = mysqli_fetch_assoc($addr_query);

$has_address = !empty($user_data['address']) && !empty($user_data['city']);
$full_address = $has_address ? trim($user_data['address'] . ', ' . ($user_data['landmark'] ? $user_data['landmark'] . ', ' : '') . $user_data['city'] . ' - ' . $user_data['zip'] . ', ' . $user_data['state']) : '';
$_SESSION['address'] = $full_address;

// Determine products in checkout
$checkout_items = [];
$subtotal = 0;

if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST['check_id'])) {
    // Products submitted via form (e.g. from shoping-cart.php or Buy Now)
    $product_ids = (array)$_POST['check_id'];
    foreach ($product_ids as $pid) {
        $pid = intval($pid);
        $p_res = mysqli_query($con, "SELECT id, product_name, product_price, product_img FROM product_item WHERE id = $pid");
        if ($p_row = mysqli_fetch_assoc($p_res)) {
            $checkout_items[] = [
                'id'       => $p_row['id'],
                'name'     => $p_row['product_name'],
                'price'    => intval($p_row['product_price']),
                'img'      => $p_row['product_img'],
                'quantity' => 1
            ];
            $subtotal += intval($p_row['product_price']);
        }
    }
} else {
    // Fetch directly from user_cart
    $cart_stmt = $con->prepare("
        SELECT uc.product_id, uc.quantity, pi.product_name, pi.product_price, pi.product_img
        FROM user_cart uc
        JOIN product_item pi ON uc.product_id = pi.id
        WHERE uc.user_id = ? OR uc.session_id = ?
    ");
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

// Setup Razorpay order ID if online payment is initiated
$razorpay_order_id = '';
$razorpay_error = '';
$keyId = defined('RAZORPAY_KEY_ID') ? RAZORPAY_KEY_ID : 'rzp_test_kBREEooxYkKLPo';
$keySecret = defined('RAZORPAY_KEY_SECRET') ? RAZORPAY_KEY_SECRET : 'P5NsdNUNPas0c0C74oCjkk1Y';

if (file_exists('./razorpay/Razorpay.php')) {
    require_once './razorpay/Razorpay.php';
    try {
        $api = new \Razorpay\Api\Api($keyId, $keySecret);
        $order = $api->order->create([
            'amount'          => $total * 100,
            'currency'        => 'INR',
            'receipt'         => 'rcpt_' . $user_id . '_' . time(),
            'payment_capture' => 1
        ]);
        $razorpay_order_id = $order['id'];
    } catch (Exception $e) {
        $razorpay_error = $e->getMessage();
    }
}
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
    <link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/modern-stark.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</head>

<body class="animsition bg-gray-50">

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
                                <p class="font-bold text-gray-900"><?php echo htmlspecialchars($user_data['name']); ?></p>
                                <p class="text-sm text-gray-700 mt-1"><?php echo htmlspecialchars($user_data['address']); ?></p>
                                <?php if (!empty($user_data['landmark'])): ?>
                                    <p class="text-xs text-gray-500">Landmark: <?php echo htmlspecialchars($user_data['landmark']); ?></p>
                                <?php endif; ?>
                                <p class="text-sm font-semibold text-gray-800 mt-1">
                                    <?php echo htmlspecialchars($user_data['city'] . ' - ' . $user_data['zip'] . ', ' . $user_data['state']); ?>
                                </p>
                                <p class="text-xs text-gray-500 mt-2">Mobile: <?php echo htmlspecialchars($user_data['Mobile'] ?? 'N/A'); ?></p>
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

                <!-- Payment Method Selection Card -->
                <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
                    <div class="flex items-center space-x-3 pb-4 border-b border-gray-100">
                        <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold">2</div>
                        <h2 class="text-lg font-bold text-gray-900">Payment Method</h2>
                    </div>

                    <div class="mt-4 space-y-3">
                        <!-- COD Option -->
                        <label class="flex items-center justify-between p-4 rounded-xl border border-gray-200 hover:border-indigo-400 cursor-pointer transition bg-white has-[:checked]:border-indigo-600 has-[:checked]:bg-indigo-50/40">
                            <div class="flex items-center space-x-3">
                                <input type="radio" name="pay_option" value="cod" class="text-indigo-600 focus:ring-indigo-500 h-4 w-4" checked>
                                <div>
                                    <p class="font-bold text-sm text-gray-900">Cash on Delivery (COD)</p>
                                    <p class="text-xs text-gray-500">Pay cash directly when your parcel is delivered to your doorstep</p>
                                </div>
                            </div>
                            <span class="text-xs font-semibold px-2.5 py-1 rounded bg-green-100 text-green-800">Recommended</span>
                        </label>

                        <!-- Razorpay Online Option -->
                        <label class="flex items-center justify-between p-4 rounded-xl border border-gray-200 hover:border-indigo-400 cursor-pointer transition bg-white has-[:checked]:border-indigo-600 has-[:checked]:bg-indigo-50/40">
                            <div class="flex items-center space-x-3">
                                <input type="radio" name="pay_option" value="razorpay" class="text-indigo-600 focus:ring-indigo-500 h-4 w-4">
                                <div>
                                    <p class="font-bold text-sm text-gray-900">Online Payment (UPI, Cards, NetBanking)</p>
                                    <p class="text-xs text-gray-500">Fast, encrypted payment powered by Razorpay</p>
                                </div>
                            </div>
                            <div class="flex space-x-1">
                                <span class="text-xs font-semibold px-2 py-0.5 rounded bg-blue-100 text-blue-700">UPI</span>
                                <span class="text-xs font-semibold px-2 py-0.5 rounded bg-purple-100 text-purple-700">Cards</span>
                            </div>
                        </label>
                    </div>

                    <!-- Place Order Actions -->
                    <div class="mt-6">
                        <?php if ($has_address): ?>
                            <!-- COD Form -->
                            <form id="codForm" action="place_order.php" method="POST">
                                <input type="hidden" name="payment_method" value="Cash on Delivery">
                                <?php foreach ($checkout_items as $ci): ?>
                                    <input type="hidden" name="check_id[]" value="<?php echo $ci['id']; ?>">
                                <?php endforeach; ?>
                                <button type="submit" id="codButton" class="w-full py-4 px-6 rounded-xl bg-gray-900 hover:bg-gray-800 text-white font-bold text-base transition shadow-xl shadow-gray-900/10 flex items-center justify-center space-x-2">
                                    <span>Place Order (Cash on Delivery)</span>
                                    <span>&bull;</span>
                                    <span>₹<?php echo number_format($total, 2); ?></span>
                                </button>
                            </form>

                            <!-- Razorpay Button -->
                            <button id="rzpButton" class="hidden w-full py-4 px-6 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-base transition shadow-xl shadow-indigo-600/20 flex items-center justify-center space-x-2">
                                <span>Pay Now via Razorpay</span>
                                <span>&bull;</span>
                                <span>₹<?php echo number_format($total, 2); ?></span>
                            </button>
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
                    </div>

                    <div class="mt-6 p-3.5 bg-gray-50 rounded-xl border border-gray-200 text-xs text-gray-500 flex items-center space-x-2">
                        <i class="zmdi zmdi-shield-check text-xl text-emerald-500"></i>
                        <span>100% Safe & Secure Checkout with SSL encryption.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Razorpay SDK -->
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="vendor/animsition/js/animsition.min.js"></script>
    <script>
        // Toggle payment button based on selected payment radio
        $('input[name="pay_option"]').on('change', function() {
            if ($(this).val() === 'razorpay') {
                $('#codButton').addClass('hidden');
                $('#rzpButton').removeClass('hidden');
            } else {
                $('#codButton').removeClass('hidden');
                $('#rzpButton').addClass('hidden');
            }
        });

        // Razorpay Payment Handler
        var rzpBtn = document.getElementById('rzpButton');
        if (rzpBtn) {
            rzpBtn.addEventListener('click', function(e) {
                e.preventDefault();

                <?php if (!empty($razorpay_order_id)): ?>
                var options = {
                    "key": "<?php echo $keyId; ?>",
                    "amount": "<?php echo $total * 100; ?>",
                    "currency": "INR",
                    "name": "Stark Store",
                    "description": "Order Payment",
                    "image": "images/icons/logo-01.png",
                    "order_id": "<?php echo $razorpay_order_id; ?>",
                    "handler": function(response) {
                        // Send AJAX verification and ONLY navigate after server confirmation
                        $.ajax({
                            url: "verify_payment.php",
                            type: "POST",
                            dataType: "json",
                            data: {
                                payment_id: response.razorpay_payment_id,
                                order_id: response.razorpay_order_id,
                                signature: response.razorpay_signature
                            },
                            success: function(res) {
                                if (res.status === 'success') {
                                    window.location.href = res.redirect || "order.php";
                                } else {
                                    alert("Payment verification failed: " + (res.error || "Unknown error"));
                                }
                            },
                            error: function(err) {
                                alert("Failed to communicate with verification server.");
                            }
                        });
                    },
                    "prefill": {
                        "name": "<?php echo htmlspecialchars($user_data['name'] ?? ''); ?>",
                        "email": "<?php echo htmlspecialchars($user_data['email'] ?? ''); ?>",
                        "contact": "<?php echo htmlspecialchars($user_data['Mobile'] ?? ''); ?>"
                    },
                    "theme": {
                        "color": "#4f46e5"
                    }
                };
                var rzp = new Razorpay(options);
                rzp.open();
                <?php else: ?>
                alert("Razorpay is currently in offline mode. Please choose Cash on Delivery (COD) to complete your order.");
                <?php endif; ?>
            });
        }
    </script>
</body>
</html>