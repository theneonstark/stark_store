<?php
session_start();
include('config.php'); 
require_once './razorpay/Razorpay.php';

use Razorpay\Api\Api;

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['id'])) {
    die(json_encode(['status' => 'failure', 'error' => 'User not logged in.']));
}

$user_id = $_SESSION['id'];
$keyId = 'rzp_live_RZ695j5VbYE6fI'; 
$keySecret = '8vAbxasZlsrqRlapFCdl9eam';

$api = new Api($keyId, $keySecret);
$payment_id = $_POST['payment_id'];
$order_id = $_POST['order_id'];
$signature = $_POST['signature'];
$product_id = $_SESSION['product_id'];
$ids = json_encode($product_id);
$amount = $_SESSION['total_price'];
$currency = 'INR';
$address = $_SESSION['address'];

try {
    // Verify payment signature
    $attributes = [
        'razorpay_order_id' => $order_id,
        'razorpay_payment_id' => $payment_id,
        'razorpay_signature' => $signature
    ];

    $api->utility->verifyPaymentSignature($attributes);
    $status = 'completed';

        $sql = "INSERT INTO user_order (user_id, razorpay_payment_id, razorpay_order_id, amount, currency, status, address, product_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $user_order->prepare($sql);
            if ($stmt === false) {
                die(json_encode(['status' => 'failure', 'error' => 'MySQL prepare error: ' . $user_order->error]));
            }
            if (!$stmt->bind_param('ssssssss', $user_id, $payment_id, $order_id, $amount, $currency, $status, $address, $ids)) {
                die(json_encode(['status' => 'failure', 'error' => 'MySQL bind_param error: ' . $stmt->error]));
            }

            if (!$stmt->execute()) {
                die(json_encode(['status' => 'failure', 'error' => 'MySQL execute error: ' . $stmt->error]));
            }

            $stmt->close();
            echo json_encode(['status' => 'success']);
            $_SESSION['success'] = "order_success";
            header('location: order.php');

} catch (Exception $e) {
    echo json_encode(['status' => 'failure', 'error' => $e->getMessage()]);
}
?>