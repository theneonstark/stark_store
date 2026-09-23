<?php
/**
 * Stark Store - Add to Cart Processor
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include('config.php');

$product_id = isset($_POST['cart_product']) ? intval($_POST['cart_product']) : (isset($_POST['product_id']) ? intval($_POST['product_id']) : 0);
$quantity   = isset($_POST['num-product']) ? max(1, intval($_POST['num-product'])) : 1;

if ($product_id <= 0) {
    echo "Invalid Product";
    exit;
}

$user_id    = $_SESSION['id'] ?? null;
$session_id = session_id();

// Ensure user_cart table exists
stark_ensure_tables($con);

// Check if product already exists in user's cart
if ($user_id) {
    $check_stmt = $con->prepare("SELECT id, quantity FROM user_cart WHERE (user_id = ? OR session_id = ?) AND product_id = ?");
    $check_stmt->bind_param("isi", $user_id, $session_id, $product_id);
} else {
    $check_stmt = $con->prepare("SELECT id, quantity FROM user_cart WHERE session_id = ? AND product_id = ?");
    $check_stmt->bind_param("si", $session_id, $product_id);
}

$check_stmt->execute();
$res = $check_stmt->get_result();

if ($row = $res->fetch_assoc()) {
    // Already in cart - update quantity or return already added
    $new_qty = $row['quantity'] + $quantity;
    $update_stmt = $con->prepare("UPDATE user_cart SET quantity = ?, user_id = COALESCE(?, user_id) WHERE id = ?");
    $update_stmt->bind_param("iii", $new_qty, $user_id, $row['id']);
    $update_stmt->execute();
    $update_stmt->close();
    echo "Product Added";
} else {
    // Insert new cart item
    $insert_stmt = $con->prepare("INSERT INTO user_cart (user_id, session_id, product_id, quantity) VALUES (?, ?, ?, ?)");
    $insert_stmt->bind_param("isii", $user_id, $session_id, $product_id, $quantity);
    if ($insert_stmt->execute()) {
        echo "Product Added";
    } else {
        echo "Product NOT Added";
    }
    $insert_stmt->close();
}

$check_stmt->close();
?>