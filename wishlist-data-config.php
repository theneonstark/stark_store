<?php
session_start();
include 'config.php'; 

$wish_user = $_SESSION['wishlist']; 
$wish_db = "wishlist";

$wish_table_query = $con->prepare("SELECT COUNT(*) as count FROM information_schema.tables WHERE table_schema = ? AND table_name = ?");
$wish_table_query->bind_param("ss", $wish_db, $wish_user);
$wish_table_query->execute();
$wish_table_result = $wish_table_query->get_result();
$wish_table_row = $wish_table_result->fetch_assoc();

if ($wish_table_row['count'] > 0) {
    $wish_details = mysqli_query($con, "SELECT * FROM wishlist.$wish_user uw JOIN product.product_item pi ON uw.wp_detail = pi.id");
    $wish_count = mysqli_query($con, "SELECT COUNT(*) as total FROM wishlist.$wish_user");
    $wish_row = mysqli_fetch_assoc($wish_count);

    $wishlist_items = [];

    while ($wish_fetch = mysqli_fetch_assoc($wish_details)) {
        $wishlist_items[] = [
            'product_id' => $wish_fetch['id'],
            'product_img' => $wish_fetch['product_img'],
            'product_name' => $wish_fetch['product_name'],
            'product_price' => $wish_fetch['product_price'],
        ];
    }

    echo json_encode([
        'status' => 'success',
        'count' => $wish_row['total'],
        'data' => $wishlist_items
    ]);
} else {
    echo json_encode(['status' => 'empty', 'message' => 'No products in wishlist']);
}
