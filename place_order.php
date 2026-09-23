<?php
/**
 * Stark Store - Direct / Cash on Delivery (COD) Order Processor
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
$addr_query = mysqli_query($con, "SELECT address, landmark, city, zip, state FROM users WHERE id = $user_id");
$user_addr  = mysqli_fetch_assoc($addr_query);

if (empty($user_addr['address']) || empty($user_addr['city'])) {
    header('Location: address.php?error=missing_address');
    exit;
}

$full_address = trim($user_addr['address'] . ', ' . ($user_addr['landmark'] ? $user_addr['landmark'] . ', ' : '') . $user_addr['city'] . ' - ' . $user_addr['zip'] . ', ' . $user_addr['state']);

// Fetch items from cart
$cart_stmt = $con->prepare("
    SELECT uc.product_id, uc.quantity, pi.product_price 
    FROM user_cart uc 
    JOIN product_item pi ON uc.product_id = pi.id 
    WHERE uc.user_id = ? OR uc.session_id = ?
");
$cart_stmt->bind_param("is", $user_id, $session_id);
$cart_stmt->execute();
$cart_res = $cart_stmt->get_result();

$product_ids = [];
$total_amount = 0;

while ($item = $cart_res->fetch_assoc()) {
    $qty = max(1, intval($item['quantity']));
    for ($q = 0; $q < $qty; $q++) {
        $product_ids[] = (string)$item['product_id'];
    }
    $total_amount += intval($item['product_price']) * $qty;
}
$cart_stmt->close();

if (empty($product_ids)) {
    // If cart is empty, check if specific check_id products were passed
    if (!empty($_POST['check_id'])) {
        $product_ids = array_map('strval', (array)$_POST['check_id']);
        $total_amount = isset($_POST['total_amount']) ? intval($_POST['total_amount']) : 0;
    } else {
        header('Location: shoping-cart.php');
        exit;
    }
}

// Shipping calculation (free over 1500, otherwise 50)
$shipping = ($total_amount > 1500 || $total_amount == 0) ? 0 : 50;
$final_total = $total_amount + $shipping;

$payment_method = $_POST['payment_method'] ?? 'Cash on Delivery';
$order_ref      = 'ORD-' . strtoupper(substr(uniqid(), 7)) . '-' . $user_id;
$pay_id         = ($payment_method === 'Cash on Delivery') ? 'COD-' . time() : 'PENDING';
$status         = 'Processing';
$currency       = 'INR';
$json_products  = json_encode($product_ids);

// Insert into user_order
$order_stmt = $con->prepare("
    INSERT INTO user_order (user_id, amount, product_id, razorpay_order_id, razorpay_payment_id, currency, status, payment_method, address)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
");
$order_stmt->bind_param("iisssssss", $user_id, $final_total, $json_products, $order_ref, $pay_id, $currency, $status, $payment_method, $full_address);

if ($order_stmt->execute()) {
    $inserted_order_id = $order_stmt->insert_id;
    $order_stmt->close();

    // Clear user cart
    $clear_stmt = $con->prepare("DELETE FROM user_cart WHERE user_id = ? OR session_id = ?");
    $clear_stmt->bind_param("is", $user_id, $session_id);
    $clear_stmt->execute();
    $clear_stmt->close();

    // Set order success session
    $_SESSION['success'] = "order_success";
    $_SESSION['last_order_id'] = $inserted_order_id;
    $_SESSION['last_order_ref'] = $order_ref;

    header('Location: order.php');
    exit;
} else {
    die("Failed to place order: " . $con->error);
}
?>
