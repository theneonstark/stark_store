<?php
session_start();
include 'config.php'; 

$cart_user = $_SESSION['cart'];
$cart_db = "usercart";

$cart_table_query = $con->prepare("SELECT COUNT(*) as count FROM information_schema.tables WHERE table_schema = ? AND table_name = ?");
$cart_table_query->bind_param("ss", $cart_db, $cart_user);
$cart_table_query->execute();
$cart_table_result = $cart_table_query->get_result();
$cart_table_row = $cart_table_result->fetch_assoc();

if ($cart_table_row['count'] > 0) {
    $cart_details = mysqli_query($con, "SELECT * FROM usercart.$cart_user uw JOIN product.product_item pi ON uw.cp_detail = pi.id WHERE uw.cp_detail AND pi.id");
    $cart_items = [];

    while ($cart_fetch = mysqli_fetch_assoc($cart_details)) {
        $cart_items[] = [
            'product_img' => $cart_fetch['product_img'],
            'product_name' => $cart_fetch['product_name'],
            'product_price' => $cart_fetch['product_price'],
        ];
    }

    echo json_encode(['status' => 'success', 'data' => $cart_items]);
} else {
    echo json_encode(['status' => 'empty', 'message' => 'No products in cart']);
}
?>
