<?php
/**
 * Stark Store - Apiwala TPIPay (Pay via Online) Order Initiator
 */
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

// Verify user address
$addr_query = mysqli_query($con, "SELECT name, email, Mobile, address, landmark, city, zip, state FROM users WHERE id = " . intval($user_id));
$user_addr  = mysqli_fetch_assoc($addr_query) ?: [];

if (empty($user_addr['address']) || empty($user_addr['city'])) {
    header('Location: address.php?error=missing_address');
    exit;
}

$full_address = trim(($user_addr['address'] ?? '') . ', ' . (!empty($user_addr['landmark']) ? $user_addr['landmark'] . ', ' : '') . ($user_addr['city'] ?? '') . ' - ' . ($user_addr['zip'] ?? '') . ', ' . ($user_addr['state'] ?? ''));

// Fetch items for order
$product_ids  = [];
$total_amount = 0;
$checkout_items = [];

if (!empty($_POST['check_id'])) {
    $submitted_ids = (array)$_POST['check_id'];
    foreach ($submitted_ids as $pid) {
        $pid = intval($pid);
        if ($pid <= 0) continue;

        $qty = 1;
        $q_stmt = $con->prepare("SELECT quantity FROM user_cart WHERE (user_id = ? OR session_id = ?) AND product_id = ? LIMIT 1");
        $q_stmt->bind_param("isi", $user_id, $session_id, $pid);
        $q_stmt->execute();
        $q_res = $q_stmt->get_result();
        if ($q_row = $q_res->fetch_assoc()) {
            $qty = max(1, intval($q_row['quantity']));
        }
        $q_stmt->close();

        $p_stmt = $con->prepare("SELECT id, product_name, product_price, product_img FROM product_item WHERE id = ?");
        $p_stmt->bind_param("i", $pid);
        $p_stmt->execute();
        $p_res = $p_stmt->get_result();
        if ($p_row = $p_res->fetch_assoc()) {
            for ($q = 0; $q < $qty; $q++) {
                $product_ids[] = (string)$pid;
            }
            $checkout_items[] = [
                'id'       => $p_row['id'],
                'name'     => $p_row['product_name'],
                'price'    => intval($p_row['product_price']),
                'img'      => $p_row['product_img'],
                'quantity' => $qty
            ];
            $total_amount += intval($p_row['product_price']) * $qty;
        }
        $p_stmt->close();
    }
} else {
    // Fetch all items from user_cart
    $cart_stmt = $con->prepare("
        SELECT uc.product_id, uc.quantity, pi.id, pi.product_name, pi.product_price, pi.product_img
        FROM user_cart uc 
        JOIN product_item pi ON uc.product_id = pi.id 
        WHERE uc.user_id = ? OR uc.session_id = ?
    ");
    $cart_stmt->bind_param("is", $user_id, $session_id);
    $cart_stmt->execute();
    $cart_res = $cart_stmt->get_result();

    while ($item = $cart_res->fetch_assoc()) {
        $qty = max(1, intval($item['quantity']));
        for ($q = 0; $q < $qty; $q++) {
            $product_ids[] = (string)$item['product_id'];
        }
        $checkout_items[] = [
            'id'       => $item['id'],
            'name'     => $item['product_name'],
            'price'    => intval($item['product_price']),
            'img'      => $item['product_img'],
            'quantity' => $qty
        ];
        $total_amount += intval($item['product_price']) * $qty;
    }
    $cart_stmt->close();
}

if (empty($product_ids)) {
    header('Location: shoping-cart.php');
    exit;
}

// Shipping calculation (free over ₹1500, otherwise ₹50)
$shipping    = ($total_amount > 1500 || $total_amount == 0) ? 0 : 50;
$final_total = $total_amount + $shipping;

// Customer contact info
$customer_name  = trim($user_addr['name'] ?: ($_SESSION['name'] ?? 'Valued Customer'));
$customer_email = trim($user_addr['email'] ?: ($_SESSION['email'] ?? ($_SESSION['google_email'] ?? 'customer@gmail.com')));
$raw_mobile     = $user_addr['Mobile'] ?: ($user_addr['mobile'] ?? '');
$clean_mobile   = preg_replace('/[^0-9]/', '', $raw_mobile);
if (strlen($clean_mobile) < 10) {
    // Fallback if not saved in address
    $clean_mobile = '9874563210';
} else {
    $clean_mobile = substr($clean_mobile, -10);
}

// Generate unique transaction ID
$apitxnid       = 'STK' . date('ymdHis') . rand(100, 999);
$payment_method = 'Pay via Online';
$status         = 'Pending';
$currency       = 'INR';
$json_products  = json_encode($product_ids);
$pay_id         = 'PENDING';

// Insert pending order in database
$order_stmt = $con->prepare("
    INSERT INTO user_order (user_id, amount, product_id, razorpay_order_id, razorpay_payment_id, currency, status, payment_method, address)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
");
$order_stmt->bind_param("iisssssss", $user_id, $final_total, $json_products, $apitxnid, $pay_id, $currency, $status, $payment_method, $full_address);

if (!$order_stmt->execute()) {
    die("Database error while creating order: " . $con->error);
}

$inserted_order_id = $order_stmt->insert_id;
$order_stmt->close();

// Save session state
$_SESSION['pending_order_id'] = $inserted_order_id;
$_SESSION['pending_apitxnid'] = $apitxnid;
$_SESSION['last_order_id']    = $inserted_order_id;
$_SESSION['last_order_ref']   = $apitxnid;

// Determine callback URL
$callback_url = defined('APIWALA_CALLBACK_URL') && !empty(APIWALA_CALLBACK_URL) ? APIWALA_CALLBACK_URL : '';
if (empty($callback_url)) {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || ($_SERVER['SERVER_PORT'] ?? 80) == 443) ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $dir = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $callback_url = $protocol . $host . ($dir ? $dir : '') . '/apiwala_webhook.php';
}

$api_key    = (defined('APIWALA_API_KEY') && APIWALA_API_KEY !== 'YOUR_API_KEY') ? APIWALA_API_KEY : 'vXALSf0wFOXoRpN7oIMfzkB7796gcocFvaCEOgJS';
$partner_id = (defined('APIWALA_PARTNER_ID') && APIWALA_PARTNER_ID !== 'YOUR_PARTNER_ID') ? APIWALA_PARTNER_ID : '25';
$endpoint   = defined('APIWALA_ENDPOINT') ? APIWALA_ENDPOINT : 'https://apiwala.in/production/api/collection/order/tpipay';

// Payload for Apiwala TPIPay API
$payload = [
    'partner_id' => is_numeric($partner_id) ? intval($partner_id) : $partner_id,
    'apitxnid'   => $apitxnid,
    'mobile'     => $clean_mobile,
    'name'       => $customer_name,
    'email'      => $customer_email,
    'amount'     => (string)$final_total,
    'callback'   => $callback_url
];

// Handle case where API credentials are still placeholder
$is_placeholder = empty($api_key) || in_array($api_key, ['YOUR_API_KEY', 'YOUR_ACTUAL_API_KEY', 'CHANGEME']);

$response = null;
$http_code = 0;
$curl_error = null;

if (!$is_placeholder) {
    $ch = curl_init($endpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'api-key: ' . $api_key,
        'Content-Type: application/json',
        'Accept: application/json'
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curl_error = curl_error($ch);
    curl_close($ch);

    // Audit log response for debugging
    $log_entry = date('[Y-m-d H:i:s] ') . "TPIPay Initiate [Order $inserted_order_id | Txn $apitxnid] HTTP $http_code: " . ($response ?: $curl_error) . "\n";
    @file_put_contents(__DIR__ . '/apiwala_tpipay.log', $log_entry, FILE_APPEND);
}

$res_data = null;
if (!empty($response)) {
    $res_data = json_decode($response, true);
    if (!is_array($res_data)) {
        $clean_response = trim($response, "\xEF\xBB\xBF \t\n\r\0\x0B");
        $res_data = json_decode($clean_response, true);
    }
}

// Check if response contains a redirect / checkout / payment URL
$redirect_url = null;
if (is_array($res_data)) {
    // 1. Check direct keys
    if (!empty($res_data['checkout_url'])) {
        $redirect_url = $res_data['checkout_url'];
    } elseif (!empty($res_data['payment_url'])) {
        $redirect_url = $res_data['payment_url'];
    } elseif (!empty($res_data['redirect_url'])) {
        $redirect_url = $res_data['redirect_url'];
    } elseif (!empty($res_data['url'])) {
        $redirect_url = $res_data['url'];
    // 2. Check nested in 'data'
    } elseif (!empty($res_data['data']['checkout_url'])) {
        $redirect_url = $res_data['data']['checkout_url'];
    } elseif (!empty($res_data['data']['payment_url'])) {
        $redirect_url = $res_data['data']['payment_url'];
    } elseif (!empty($res_data['data']['redirect_url'])) {
        $redirect_url = $res_data['data']['redirect_url'];
    } elseif (!empty($res_data['data']['url'])) {
        $redirect_url = $res_data['data']['url'];
    // 3. Check nested in 'result'
    } elseif (!empty($res_data['result']['checkout_url'])) {
        $redirect_url = $res_data['result']['checkout_url'];
    } elseif (!empty($res_data['result']['payment_url'])) {
        $redirect_url = $res_data['result']['payment_url'];
    } elseif (!empty($res_data['result']['redirect_url'])) {
        $redirect_url = $res_data['result']['redirect_url'];
    } elseif (!empty($res_data['result']['url'])) {
        $redirect_url = $res_data['result']['url'];
    }

    // 4. Fallback search for any http/https URL string
    if (empty($redirect_url)) {
        foreach ($res_data as $key => $val) {
            if (is_string($val) && (stripos($val, 'http://') === 0 || stripos($val, 'https://') === 0)) {
                $redirect_url = $val;
                break;
            }
        }
    }

    // If gateway returns txnid / transaction_id, store it with the order
    $gateway_txnid = $res_data['txnid'] ?? ($res_data['transaction_id'] ?? ($res_data['data']['txnid'] ?? ($res_data['data']['transaction_id'] ?? null)));
    if (!empty($gateway_txnid)) {
        $_SESSION['gateway_txnid'] = $gateway_txnid;
        $up_stmt = $con->prepare("UPDATE user_order SET razorpay_payment_id = ? WHERE id = ?");
        $up_stmt->bind_param("si", $gateway_txnid, $inserted_order_id);
        $up_stmt->execute();
        $up_stmt->close();
    }
}

// Check if QR code / intent string is returned
$qr_string = $res_data['qr_string'] ?? ($res_data['data']['qr_string'] ?? ($res_data['intent_url'] ?? ($res_data['data']['intent_url'] ?? null)));
$qr_image  = $res_data['qr_code_image'] ?? ($res_data['data']['qr_code_image'] ?? null);

// If checkout / payment URL is available, redirect user directly to payment portal
if (!empty($redirect_url)) {
    if (ob_get_length()) {
        ob_end_clean();
    }
    header("Location: " . $redirect_url);
    echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="0;url=' . htmlspecialchars($redirect_url) . '">
    <title>Redirecting to Payment Gateway...</title>
    <script>window.location.href = ' . json_encode($redirect_url) . ';</script>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; background: #f8fafc; color: #1e293b; }
        .card { background: white; padding: 2.5rem; border-radius: 1.25rem; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1); text-align: center; max-width: 440px; width: 90%; }
        .spinner { width: 44px; height: 44px; border: 4px solid #e2e8f0; border-top-color: #4f46e5; border-radius: 50%; animation: spin 0.9s linear infinite; margin: 0 auto 1.5rem; }
        @keyframes spin { to { transform: rotate(360deg); } }
        a.btn { display: inline-block; margin-top: 1.25rem; padding: 0.8rem 1.6rem; background: #4f46e5; color: white; text-decoration: none; border-radius: 0.6rem; font-weight: 700; font-size: 0.95rem; }
    </style>
</head>
<body>
    <div class="card">
        <div class="spinner"></div>
        <h2 style="margin: 0 0 0.5rem; font-size: 1.35rem; font-weight: 800;">Redirecting to Payment Gateway...</h2>
        <p style="margin: 0; color: #64748b; font-size: 0.875rem; line-height: 1.5;">Please wait while we redirect you to complete your payment.</p>
        <a href="' . htmlspecialchars($redirect_url) . '" class="btn">Click here if not redirected</a>
    </div>
</body>
</html>';
    exit;
}

// If QR or intent is returned, redirect to payment display screen
if (!empty($qr_string) || !empty($qr_image)) {
    $_SESSION['payment_qr_data'] = [
        'order_id'    => $inserted_order_id,
        'apitxnid'    => $apitxnid,
        'amount'      => $final_total,
        'qr_string'   => $qr_string,
        'qr_image'    => $qr_image,
        'intent_url'  => $res_data['intent_url'] ?? ($res_data['data']['intent_url'] ?? $qr_string)
    ];
    header("Location: tpipay_payment_screen.php");
    exit;
}

// If here, either credentials need setup or API returned an error or message
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Payment - Stark Store</title>
    <link rel="icon" type="image/png" href="images/icons/favicon.png" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/modern-stark.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen text-gray-900 font-sans">
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

    <div class="max-w-2xl mx-auto px-4 py-12">
        <div class="bg-white rounded-3xl border border-gray-200 shadow-xl overflow-hidden p-6 sm:p-10">
            <?php if ($is_placeholder): ?>
                <!-- Configuration Guidance Card -->
                <div class="text-center">
                    <div class="w-16 h-16 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center mx-auto mb-5 shadow-lg shadow-amber-500/10">
                        <i class="zmdi zmdi-key text-3xl font-bold"></i>
                    </div>
                    <h2 class="text-2xl font-black text-gray-900">API Credentials Setup Required</h2>
                    <p class="text-sm text-gray-500 mt-2">
                        Online Payment via <span class="font-bold text-gray-800">Apiwala TPIPay</span> is integrated! To initiate live gateway requests, please configure your merchant credentials.
                    </p>
                </div>

                <div class="mt-6 p-4 rounded-2xl bg-gray-50 border border-gray-200 text-left text-xs font-mono space-y-2">
                    <p class="text-gray-400 font-sans font-bold uppercase text-[11px]">Configuration in config.php:</p>
                    <div class="p-3 bg-gray-900 text-emerald-400 rounded-xl overflow-x-auto">
                        define('APIWALA_API_KEY', 'YOUR_ACTUAL_API_KEY');<br>
                        define('APIWALA_PARTNER_ID', YOUR_PARTNER_ID);
                    </div>
                </div>

                <div class="mt-6 p-4 rounded-2xl bg-indigo-50 border border-indigo-100 text-left text-xs text-indigo-900 space-y-2">
                    <p class="font-bold text-sm text-indigo-950 flex items-center">
                        <i class="zmdi zmdi-info mr-2 text-base text-indigo-600"></i> Order Details Generated:
                    </p>
                    <div class="grid grid-cols-2 gap-2 text-xs pt-1">
                        <div><span class="text-indigo-400">Transaction ID:</span> <span class="font-bold font-mono"><?php echo htmlspecialchars($apitxnid); ?></span></div>
                        <div><span class="text-indigo-400">Total Amount:</span> <span class="font-bold text-indigo-700">₹<?php echo number_format($final_total, 2); ?></span></div>
                        <div><span class="text-indigo-400">Customer:</span> <span class="font-bold"><?php echo htmlspecialchars($customer_name); ?></span></div>
                        <div><span class="text-indigo-400">Mobile:</span> <span class="font-bold"><?php echo htmlspecialchars($clean_mobile); ?></span></div>
                    </div>
                </div>

                <!-- Simulation Button for Developer Testing -->
                <div class="mt-8 space-y-3">
                    <form action="apiwala_webhook.php" method="POST">
                        <input type="hidden" name="apitxnid" value="<?php echo htmlspecialchars($apitxnid); ?>">
                        <input type="hidden" name="status" value="SUCCESS">
                        <input type="hidden" name="txnid" value="TEST-TPIPAY-<?php echo time(); ?>">
                        <input type="hidden" name="amount" value="<?php echo $final_total; ?>">
                        <input type="hidden" name="redirect_return" value="1">
                        <button type="submit" class="w-full py-3.5 px-6 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm transition flex items-center justify-center space-x-2 shadow-lg shadow-indigo-600/20">
                            <i class="zmdi zmdi-flash text-lg"></i>
                            <span>Simulate Successful Payment (Test Mode)</span>
                        </button>
                    </form>

                    <a href="checkout.php" class="block text-center py-3 px-6 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-50 font-bold text-sm transition">
                        &larr; Return to Checkout
                    </a>
                </div>

            <?php else: ?>
                <!-- Gateway API Response / Error Card -->
                <div class="text-center">
                    <div class="w-16 h-16 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center mx-auto mb-5 shadow-lg shadow-rose-500/10">
                        <i class="zmdi zmdi-alert-triangle text-3xl font-bold"></i>
                    </div>
                    <h2 class="text-2xl font-black text-gray-900">Payment Gateway Response</h2>
                    <p class="text-sm text-gray-500 mt-2">
                        Apiwala returned a response while initializing the transaction.
                    </p>
                </div>

                <div class="mt-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-left text-xs text-rose-900 space-y-2">
                    <p class="font-bold text-rose-800">Response details:</p>
                    <p class="font-mono text-xs break-all bg-white p-3 rounded-lg border border-rose-200">
                        <?php echo htmlspecialchars($response ?: ($curl_error ?: 'HTTP ' . $http_code . ' No response body')); ?>
                    </p>
                    <p class="text-xs text-rose-700">
                        Please check if your API Key is active, your Partner ID is correct, or if your server IP requires whitelisting on your Apiwala dashboard.
                    </p>
                </div>

                <div class="mt-8 flex flex-col sm:flex-row gap-3">
                    <a href="checkout.php" class="flex-1 text-center py-3.5 px-6 rounded-xl bg-gray-900 hover:bg-black text-white font-bold text-sm transition">
                        &larr; Try Cash on Delivery Instead
                    </a>
                    <a href="orders.php" class="flex-1 text-center py-3.5 px-6 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-50 font-bold text-sm transition">
                        View Pending Orders
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
