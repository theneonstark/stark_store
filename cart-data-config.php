<?php
/**
 * Stark Store - Fetch Cart Items (JSON API)
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
header('Content-Type: application/json');
include 'config.php';

$user_id    = $_SESSION['id'] ?? null;
$session_id = session_id();

stark_ensure_tables($con);

// Fetch items for logged-in user or active session
if ($user_id) {
    $stmt = $con->prepare("
        SELECT uc.id as cart_item_id, uc.quantity, uc.product_id, pi.product_name, pi.product_img, pi.product_price
        FROM user_cart uc
        JOIN product_item pi ON uc.product_id = pi.id
        WHERE uc.user_id = ? OR uc.session_id = ?
        ORDER BY uc.id DESC
    ");
    $stmt->bind_param("is", $user_id, $session_id);
} else {
    $stmt = $con->prepare("
        SELECT uc.id as cart_item_id, uc.quantity, uc.product_id, pi.product_name, pi.product_img, pi.product_price
        FROM user_cart uc
        JOIN product_item pi ON uc.product_id = pi.id
        WHERE uc.session_id = ?
        ORDER BY uc.id DESC
    ");
    $stmt->bind_param("s", $session_id);
}

$stmt->execute();
$result = $stmt->get_result();

$cart_items = [];
$total_count = 0;
$subtotal = 0;

while ($row = $result->fetch_assoc()) {
    $qty = max(1, intval($row['quantity']));
    $price = intval($row['product_price']);
    $item_total = $price * $qty;
    $total_count += $qty;
    $subtotal += $item_total;

    $cart_items[] = [
        'cart_id'      => $row['cart_item_id'],
        'product_id'   => $row['product_id'],
        'product_img'  => $row['product_img'],
        'product_name' => $row['product_name'],
        'product_price'=> $price,
        'quantity'     => $qty,
        'item_total'   => $item_total
    ];
}
$stmt->close();

if (!empty($cart_items)) {
    echo json_encode([
        'status'   => 'success',
        'count'    => $total_count,
        'subtotal' => $subtotal,
        'data'     => $cart_items
    ]);
} else {
    echo json_encode([
        'status'   => 'empty',
        'count'    => 0,
        'subtotal' => 0,
        'message'  => 'No products in cart',
        'data'     => []
    ]);
}
?>
