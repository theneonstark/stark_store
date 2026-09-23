<?php
/**
 * Stark Store - Wishlist Toggle Processor
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include('config.php');

$wish_product = isset($_POST['wish_product']) ? intval($_POST['wish_product']) : (isset($_POST['product_id']) ? intval($_POST['product_id']) : 0);

if ($wish_product <= 0) {
    echo "Invalid Product";
    exit;
}

$user_id    = $_SESSION['id'] ?? null;
$session_id = session_id();

stark_ensure_tables($con);

// Check if already in wishlist
if ($user_id) {
    $check_stmt = $con->prepare("SELECT id FROM user_wishlist WHERE (user_id = ? OR session_id = ?) AND product_id = ?");
    $check_stmt->bind_param("isi", $user_id, $session_id, $wish_product);
} else {
    $check_stmt = $con->prepare("SELECT id FROM user_wishlist WHERE session_id = ? AND product_id = ?");
    $check_stmt->bind_param("si", $session_id, $wish_product);
}

$check_stmt->execute();
$res = $check_stmt->get_result();

if ($res->fetch_assoc()) {
    echo "already add";
} else {
    $insert_stmt = $con->prepare("INSERT INTO user_wishlist (user_id, session_id, product_id) VALUES (?, ?, ?)");
    $insert_stmt->bind_param("isi", $user_id, $session_id, $wish_product);
    if ($insert_stmt->execute()) {
        echo "Product Added";
    } else {
        echo "Error adding product";
    }
    $insert_stmt->close();
}

$check_stmt->close();
?>