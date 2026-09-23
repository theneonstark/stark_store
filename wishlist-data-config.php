<?php
/**
 * Stark Store - Fetch Wishlist Items (JSON API)
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
header('Content-Type: application/json');
include 'config.php';

$user_id    = $_SESSION['id'] ?? null;
$session_id = session_id();

stark_ensure_tables($con);

// Support removal from wishlist via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'remove') {
    $remove_id = intval($_POST['product_id'] ?? 0);
    if ($remove_id > 0) {
        if ($user_id) {
            $del = $con->prepare("DELETE FROM user_wishlist WHERE product_id = ? AND (user_id = ? OR session_id = ?)");
            $del->bind_param("iis", $remove_id, $user_id, $session_id);
        } else {
            $del = $con->prepare("DELETE FROM user_wishlist WHERE product_id = ? AND session_id = ?");
            $del->bind_param("is", $remove_id, $session_id);
        }
        $del->execute();
        $del->close();
    }
}

// Fetch wishlist items
if ($user_id) {
    $stmt = $con->prepare("
        SELECT uw.id as wish_id, pi.id as product_id, pi.product_name, pi.product_img, pi.product_price
        FROM user_wishlist uw
        JOIN product_item pi ON uw.product_id = pi.id
        WHERE uw.user_id = ? OR uw.session_id = ?
        ORDER BY uw.id DESC
    ");
    $stmt->bind_param("is", $user_id, $session_id);
} else {
    $stmt = $con->prepare("
        SELECT uw.id as wish_id, pi.id as product_id, pi.product_name, pi.product_img, pi.product_price
        FROM user_wishlist uw
        JOIN product_item pi ON uw.product_id = pi.id
        WHERE uw.session_id = ?
        ORDER BY uw.id DESC
    ");
    $stmt->bind_param("s", $session_id);
}

$stmt->execute();
$result = $stmt->get_result();

$wishlist_items = [];
while ($row = $result->fetch_assoc()) {
    $wishlist_items[] = [
        'product_id'    => $row['product_id'],
        'product_img'   => $row['product_img'],
        'product_name'  => $row['product_name'],
        'product_price' => intval($row['product_price'])
    ];
}
$stmt->close();

$count = count($wishlist_items);

if ($count > 0) {
    echo json_encode([
        'status' => 'success',
        'count'  => $count,
        'data'   => $wishlist_items
    ]);
} else {
    echo json_encode([
        'status'  => 'empty',
        'count'   => 0,
        'message' => 'No products in wishlist',
        'data'    => []
    ]);
}
?>
