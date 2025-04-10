<?php
session_start();
include 'config.php'; // Database connection

$cart_user = $_SESSION['cart']; // Assuming this session stores the cart table name
$cart_db = "pehunt_usercart";

// Check if the cart table exists
$cart_table_query = $con->prepare("SELECT COUNT(*) as count FROM information_schema.tables WHERE table_schema = ? AND table_name = ?");
$cart_table_query->bind_param("ss", $cart_db, $cart_user);
$cart_table_query->execute();
$cart_table_result = $cart_table_query->get_result();
$cart_table_row = $cart_table_result->fetch_assoc();

if ($cart_table_row['count'] > 0) {
    // Fetch cart product details
    $cart_details = mysqli_query($con, "SELECT * FROM pehunt_usercart.$cart_user uw 
                                        JOIN product.product_item pi ON uw.cp_detail = pi.id");
    $cart_count = mysqli_query($con, "SELECT COUNT(*) as total FROM pehunt_usercart.$cart_user");
    $cart_row = mysqli_fetch_assoc($cart_count);

    $cart_items = [];

    while ($cart_fetch = mysqli_fetch_assoc($cart_details)) {
        $cart_items[] = [
            'product_id' => $cart_fetch['id'],
            'product_img' => $cart_fetch['product_img'],
            'product_name' => $cart_fetch['product_name'],
            'product_price' => $cart_fetch['product_price'],
        ];
    }

    // Return the count and cart items as JSON
    echo json_encode([
        'status' => 'success',
        'count' => $cart_row['total'],
        'data' => $cart_items
    ]);
} else {
    echo json_encode(['status' => 'empty', 'message' => 'No products in cart']);
}
?>
