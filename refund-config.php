<?php
/**
 * Stark Store - Order Cancellation & Refund Handler
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'config.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id   = trim($_POST['order_id'] ?? '');
    $payment_id = trim($_POST['payment_Id'] ?? '');
    $user_id    = $_SESSION['id'] ?? null;

    if (!$user_id) {
        echo json_encode(['status' => 'error', 'message' => 'User not logged in.']);
        exit;
    }

    // Check if order exists for this user
    $stmt = $con->prepare("SELECT id, status, amount, payment_method, razorpay_payment_id FROM user_order WHERE (razorpay_order_id = ? OR id = ?) AND user_id = ?");
    $stmt->bind_param("sii", $order_id, $order_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($order = $result->fetch_assoc()) {
        if ($order['status'] === 'Canceled') {
            echo json_encode(['status' => 'error', 'message' => 'This order is already canceled.']);
            exit;
        }

        // Update status to Canceled
        $updateStmt = $con->prepare("UPDATE user_order SET status = 'Canceled' WHERE id = ?");
        $updateStmt->bind_param("i", $order['id']);

        if ($updateStmt->execute()) {
            // Optional: If payment was captured online via Razorpay, attempt refund
            $refund_msg = 'Order canceled successfully.';
            if ($order['payment_method'] === 'Razorpay' && !empty($order['razorpay_payment_id']) && strpos($order['razorpay_payment_id'], 'pay_') === 0) {
                if (file_exists('razorpay/Razorpay.php')) {
                    require_once 'razorpay/Razorpay.php';
                    try {
                        $keyId = defined('RAZORPAY_KEY_ID') ? RAZORPAY_KEY_ID : 'rzp_test_kBREEooxYkKLPo';
                        $keySecret = defined('RAZORPAY_KEY_SECRET') ? RAZORPAY_KEY_SECRET : 'P5NsdNUNPas0c0C74oCjkk1Y';
                        $api = new \Razorpay\Api\Api($keyId, $keySecret);
                        $payment = $api->payment->fetch($order['razorpay_payment_id']);
                        if ($payment && $payment->status === 'captured') {
                            $payment->refund(['amount' => $order['amount'] * 100]);
                            $refund_msg = 'Order canceled and refund initiated via Razorpay.';
                        }
                    } catch (Exception $e) {
                        // Order is still canceled in database
                        $refund_msg = 'Order canceled. Note: Automatic gateway refund requires active live keys.';
                    }
                }
            }
            echo json_encode(['status' => 'success', 'message' => $refund_msg]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to cancel the order.']);
        }
        $updateStmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'The order requested does not exist.']);
    }
    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>