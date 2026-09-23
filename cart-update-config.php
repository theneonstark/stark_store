<?php
/**
 * Stark Store - Dynamic Cart Quantity Update (AJAX)
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
header('Content-Type: application/json');
include('config.php');

$productId = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
$quantity  = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;
$action    = $_POST['action'] ?? ''; // 'inc', 'dec', or 'set'

$user_id    = $_SESSION['id'] ?? null;
$session_id = session_id();

stark_ensure_tables($con);

if ($productId <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid product ID']);
    exit;
}

// Find existing item
if ($user_id) {
    $stmt = $con->prepare("
        SELECT uc.id, uc.quantity, pi.product_price 
        FROM user_cart uc 
        JOIN product_item pi ON uc.product_id = pi.id
        WHERE uc.product_id = ? AND (uc.user_id = ? OR uc.session_id = ?)
    ");
    $stmt->bind_param("iis", $productId, $user_id, $session_id);
} else {
    $stmt = $con->prepare("
        SELECT uc.id, uc.quantity, pi.product_price 
        FROM user_cart uc 
        JOIN product_item pi ON uc.product_id = pi.id
        WHERE uc.product_id = ? AND uc.session_id = ?
    ");
    $stmt->bind_param("is", $productId, $session_id);
}

$stmt->execute();
$res = $stmt->get_result();

if ($row = $res->fetch_assoc()) {
    $current_qty = intval($row['quantity']);
    $price = intval($row['product_price']);

    if ($action === 'inc') {
        $new_qty = $current_qty + 1;
    } elseif ($action === 'dec') {
        $new_qty = $current_qty - 1;
    } else {
        $new_qty = max(0, $quantity);
    }

    if ($new_qty <= 0) {
        $del = $con->prepare("DELETE FROM user_cart WHERE id = ?");
        $del->bind_param("i", $row['id']);
        $del->execute();
        $del->close();
        $item_total = 0;
        $removed = true;
    } else {
        $upd = $con->prepare("UPDATE user_cart SET quantity = ? WHERE id = ?");
        $upd->bind_param("ii", $new_qty, $row['id']);
        $upd->execute();
        $upd->close();
        $item_total = $price * $new_qty;
        $removed = false;
    }

    // Compute updated overall subtotal and count
    if ($user_id) {
        $calc_res = mysqli_query($con, "
            SELECT SUM(uc.quantity) as total_qty, SUM(uc.quantity * pi.product_price) as subtotal
            FROM user_cart uc
            JOIN product_item pi ON uc.product_id = pi.id
            WHERE uc.user_id = $user_id OR uc.session_id = '$session_id'
        ");
    } else {
        $calc_res = mysqli_query($con, "
            SELECT SUM(uc.quantity) as total_qty, SUM(uc.quantity * pi.product_price) as subtotal
            FROM user_cart uc
            JOIN product_item pi ON uc.product_id = pi.id
            WHERE uc.session_id = '$session_id'
        ");
    }
    $calc = mysqli_fetch_assoc($calc_res);
    $total_qty = intval($calc['total_qty'] ?? 0);
    $subtotal  = intval($calc['subtotal'] ?? 0);

    echo json_encode([
        'status'     => 'success',
        'removed'    => $removed,
        'quantity'   => $new_qty,
        'item_total' => $item_total,
        'subtotal'   => $subtotal,
        'count'      => $total_qty
    ]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Item not found in cart']);
}
$stmt->close();
?>
