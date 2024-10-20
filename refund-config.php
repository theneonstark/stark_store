<?php
require_once 'razorpay/Razorpay.php';
use Razorpay\Api\Api;

session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'];
    $payment_Id = $_POST['payment_Id'];
    $user_id = $_SESSION['id'];

    // Initialize Razorpay API
    $apiKey = 'rzp_test_kBREEooxYkKLPo';
    $apiSecret = 'P5NsdNUNPas0c0C74oCjkk1Y';
    $api = new Api($apiKey, $apiSecret);

    // Query to check if the order exists
    $query = "SELECT * FROM user_order.user_order WHERE razorpay_order_id = ? AND user_id = ?";
    $stmt = $user_order->prepare($query);
    $stmt->bind_param("si", $order_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $updateQuery = "UPDATE user_order.user_order SET status = 'Canceled' WHERE razorpay_order_id = ? AND user_id = ?";
        $updateStmt = $user_order->prepare($updateQuery);
        $updateStmt->bind_param("si", $order_id, $user_id);

        if ($updateStmt->execute()) {
            try {
                $payment = $api->payment->fetch($payment_Id);
                if ($payment->status === 'captured') {
                    echo json_encode(['status' => 'success', 'message' => 'Order canceled and refunded successfully']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Order canceled, but payment status is not captured, refund not initiated']);
                }
            } catch (Exception $e) {
                echo json_encode(['status' => 'error', 'message' => 'Order canceled, but failed to refund: ' . $e->getMessage()]);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to cancel the order']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'The id provided does not exist']);
    }
}
?>