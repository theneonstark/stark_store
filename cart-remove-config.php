<?php
/**
 * Stark Store - Remove Item from Cart
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
header('Content-Type: application/json');
include('config.php');

$productId = isset($_POST['productId']) ? intval($_POST['productId']) : (isset($_POST['product_id']) ? intval($_POST['product_id']) : 0);
$cartId    = isset($_POST['cart_id']) ? intval($_POST['cart_id']) : 0;

$user_id    = $_SESSION['id'] ?? null;
$session_id = session_id();

stark_ensure_tables($con);

if ($productId <= 0 && $cartId <= 0) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid product identifier'
    ]);
    exit;
}

if ($cartId > 0) {
    if ($user_id) {
        $stmt = $con->prepare("DELETE FROM user_cart WHERE id = ? AND (user_id = ? OR session_id = ?)");
        $stmt->bind_param("iis", $cartId, $user_id, $session_id);
    } else {
        $stmt = $con->prepare("DELETE FROM user_cart WHERE id = ? AND session_id = ?");
        $stmt->bind_param("is", $cartId, $session_id);
    }
} else {
    if ($user_id) {
        $stmt = $con->prepare("DELETE FROM user_cart WHERE product_id = ? AND (user_id = ? OR session_id = ?)");
        $stmt->bind_param("iis", $productId, $user_id, $session_id);
    } else {
        $stmt = $con->prepare("DELETE FROM user_cart WHERE product_id = ? AND session_id = ?");
        $stmt->bind_param("is", $productId, $session_id);
    }
}

if ($stmt && $stmt->execute()) {
    $stmt->close();
    
    // Fetch remaining count
    if ($user_id) {
        $cnt_res = mysqli_query($con, "SELECT SUM(quantity) as total FROM user_cart WHERE user_id = $user_id OR session_id = '$session_id'");
    } else {
        $cnt_res = mysqli_query($con, "SELECT SUM(quantity) as total FROM user_cart WHERE session_id = '$session_id'");
    }
    $cnt_row = mysqli_fetch_assoc($cnt_res);
    $total_count = intval($cnt_row['total'] ?? 0);

    echo json_encode([
        'status'  => 'success',
        'count'   => $total_count,
        'message' => 'Product removed from cart'
    ]);
} else {
    echo json_encode([
        'status'  => 'error',
        'message' => 'Failed to remove product from cart'
    ]);
}
?>