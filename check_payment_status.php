<?php
/**
 * Stark Store - AJAX Payment Status Checker for Online Gateway
 */
header('Content-Type: application/json');
include('config.php');

$apitxnid = trim($_GET['apitxnid'] ?? ($_POST['apitxnid'] ?? ''));

if (empty($apitxnid)) {
    echo json_encode(['status' => 'error', 'message' => 'Missing apitxnid']);
    exit;
}

$stmt = $con->prepare("SELECT id, status, razorpay_order_id, razorpay_payment_id FROM user_order WHERE razorpay_order_id = ? LIMIT 1");
$stmt->bind_param("s", $apitxnid);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$order) {
    echo json_encode(['status' => 'not_found']);
    exit;
}

$is_completed = (strtolower($order['status']) === 'completed');

if ($is_completed) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['success'] = "order_success";
    $_SESSION['last_order_id'] = $order['id'];
    $_SESSION['last_order_ref'] = $order['razorpay_order_id'];
}

echo json_encode([
    'status'       => $order['status'],
    'is_completed' => $is_completed,
    'order_id'     => $order['id'],
    'redirect'     => 'order.php'
]);
