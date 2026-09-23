<?php
/**
 * Stark Store - Razorpay Payment Verification (AJAX)
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
header('Content-Type: application/json');
include('config.php');
require_once './razorpay/Razorpay.php';

use Razorpay\Api\Api;

if (!isset($_SESSION['id'])) {
    echo json_encode(['status' => 'failure', 'error' => 'User not logged in.']);
    exit;
}

$user_id    = $_SESSION['id'];
$session_id = session_id();

$keyId     = defined('RAZORPAY_KEY_ID') ? RAZORPAY_KEY_ID : 'rzp_test_kBREEooxYkKLPo';
$keySecret = defined('RAZORPAY_KEY_SECRET') ? RAZORPAY_KEY_SECRET : 'P5NsdNUNPas0c0C74oCjkk1Y';

$payment_id = $_POST['payment_id'] ?? '';
$order_id   = $_POST['order_id'] ?? '';
$signature  = $_POST['signature'] ?? '';

$product_ids = $_SESSION['product_id'] ?? [];
$amount      = intval($_SESSION['total_price'] ?? 0);
$currency    = 'INR';
$address     = $_SESSION['address'] ?? '';
$ids         = json_encode($product_ids);

try {
    $api = new Api($keyId, $keySecret);
    $attributes = [
        'razorpay_order_id'   => $order_id,
        'razorpay_payment_id' => $payment_id,
        'razorpay_signature'  => $signature
    ];

    $api->utility->verifyPaymentSignature($attributes);
    $status = 'Completed';
    $payment_method = 'Razorpay';

    $stmt = $con->prepare("
        INSERT INTO user_order (user_id, razorpay_payment_id, razorpay_order_id, amount, currency, status, payment_method, address, product_id)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("issssssss", $user_id, $payment_id, $order_id, $amount, $currency, $status, $payment_method, $address, $ids);
    
    if (!$stmt->execute()) {
        echo json_encode(['status' => 'failure', 'error' => 'Database error: ' . $stmt->error]);
        exit;
    }
    
    $inserted_id = $stmt->insert_id;
    $stmt->close();

    // Clear user cart
    $clear_stmt = $con->prepare("DELETE FROM user_cart WHERE user_id = ? OR session_id = ?");
    $clear_stmt->bind_param("is", $user_id, $session_id);
    $clear_stmt->execute();
    $clear_stmt->close();

    $_SESSION['success'] = "order_success";
    $_SESSION['last_order_id'] = $inserted_id;
    $_SESSION['last_order_ref'] = $order_id;

    echo json_encode(['status' => 'success', 'redirect' => 'order.php']);
    exit;

} catch (Exception $e) {
    echo json_encode(['status' => 'failure', 'error' => $e->getMessage()]);
    exit;
}
?>