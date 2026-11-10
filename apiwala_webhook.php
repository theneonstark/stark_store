<?php
/**
 * Stark Store - Apiwala TPIPay Webhook / Callback Handler
 */
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include('config.php');

// Read raw request body
$raw_input = file_get_contents('php://input');
$json_data = json_decode($raw_input, true) ?: [];

// Combine incoming data from JSON, POST, and GET
$params = array_merge($_GET, $_POST, $json_data);

// Log incoming webhook for auditing & debugging
$log_entry = date('[Y-m-d H:i:s] ') . "TPIPay Callback: " . json_encode($params) . "\n";
@file_put_contents(__DIR__ . '/apiwala_callback.log', $log_entry, FILE_APPEND);

// Extract transaction parameters
$apitxnid = trim($params['apitxnid'] ?? ($params['order_id'] ?? ($params['client_id'] ?? '')));
$status_raw = trim($params['status'] ?? ($params['statuscode'] ?? ''));
$status_upper = strtoupper($status_raw);
$txnid = trim($params['txnid'] ?? ($params['ref_id'] ?? ($params['utr'] ?? ($params['rrn'] ?? ''))));
$is_redirect = !empty($params['redirect_return']) || (!empty($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'text/html') !== false);

if (empty($apitxnid)) {
    if ($is_redirect) {
        header('Location: orders.php');
        exit;
    }
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'Missing apitxnid']);
    exit;
}

// Find order by apitxnid (stored in razorpay_order_id)
$stmt = $con->prepare("SELECT * FROM user_order WHERE razorpay_order_id = ? LIMIT 1");
$stmt->bind_param("s", $apitxnid);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$order) {
    if ($is_redirect) {
        header('Location: orders.php');
        exit;
    }
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'Order not found for transaction ' . $apitxnid]);
    exit;
}

$order_id = $order['id'];
$user_id  = $order['user_id'];

// Check success conditions
// Apiwala / gateways use SUCCESS, TXN, COMPLETED, 200, or true
$is_success = in_array($status_upper, ['SUCCESS', 'TXN', 'COMPLETED', 'PAID', 'TRUE', '1']);

if ($is_success) {
    $new_status = 'Completed';
    $final_txnid = !empty($txnid) ? $txnid : ('TPIPAY-' . time());

    $up_stmt = $con->prepare("UPDATE user_order SET status = ?, razorpay_payment_id = ? WHERE id = ?");
    $up_stmt->bind_param("ssi", $new_status, $final_txnid, $order_id);
    $up_stmt->execute();
    $up_stmt->close();

    // Clear cart for this user
    if ($user_id) {
        $session_id = session_id();
        $clear_stmt = $con->prepare("DELETE FROM user_cart WHERE user_id = ? OR session_id = ?");
        $clear_stmt->bind_param("is", $user_id, $session_id);
        $clear_stmt->execute();
        $clear_stmt->close();
    }

    // Set order success session for user
    $_SESSION['success'] = "order_success";
    $_SESSION['last_order_id'] = $order_id;
    $_SESSION['last_order_ref'] = $apitxnid;

    if ($is_redirect) {
        header('Location: order.php');
        exit;
    }

    header('Content-Type: application/json');
    echo json_encode([
        'status'  => 'success',
        'message' => 'Order successfully marked as Completed',
        'order_id' => $order_id,
        'apitxnid' => $apitxnid
    ]);
    exit;
} else {
    // If failure is explicitly indicated
    if (in_array($status_upper, ['FAILED', 'FAILURE', 'ERR', 'CANCELLED', 'REJECTED'])) {
        $failed_status = 'Payment Failed';
        $up_stmt = $con->prepare("UPDATE user_order SET status = ? WHERE id = ?");
        $up_stmt->bind_param("si", $failed_status, $order_id);
        $up_stmt->execute();
        $up_stmt->close();
    }

    if ($is_redirect) {
        header('Location: orders.php?payment_error=failed');
        exit;
    }

    header('Content-Type: application/json');
    echo json_encode([
        'status'  => 'acknowledged',
        'message' => 'Callback recorded with status: ' . $status_raw,
        'order_id' => $order_id,
        'apitxnid' => $apitxnid
    ]);
    exit;
}
