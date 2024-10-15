<?php
session_start();
include('config.php');

$table_name = $_SESSION['cart'];
$productId = intval($_POST['productId']);
$remove = mysqli_query($cart_info, "DELETE FROM $table_name WHERE cp_detail = $productId");

if ($remove) {
    $table = mysqli_query($cart_info, "SELECT * FROM $table_name");
    if (mysqli_num_rows($table) == 0) {
        $table_remove = mysqli_query($cart_info, "DROP TABLE IF EXISTS $table_name");
    }
    echo json_encode([
        'status' => 'success',
        'message' => 'Product removed from cart'
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to remove product from cart'
    ]);
}
?>