<?php
include('config.php');
// wishlist.php or the file handling the AJAX request
if (isset($_POST['cart']) && isset($_POST['cart_product'])) {
    session_start();
    if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
        $cart_product = $_POST['cart_product'];
        $cart_data = $_POST['cart'];
        $cart_table = mysqli_query($cart_info, "CREATE TABLE IF NOT EXISTS $cart_data (
	c_id INT AUTO_INCREMENT UNIQUE PRIMARY KEY,
	user_name varchar(100),
	cp_detail INT
	)");
        if ($cart_table) {
            $database_name = 'pehunt_usercart';
            $table_name = $cart_data;
            $query = $con->prepare("SELECT COUNT(*) as count FROM information_schema.tables WHERE table_schema = ? AND table_name = ?");
            $query->bind_param("ss", $database_name, $table_name);
            $query->execute();
            $result = $query->get_result();
            $row = $result->fetch_assoc();
            if ($row['count'] > 0) {
                $sql = "SELECT COUNT(*) as count FROM $table_name WHERE cp_detail = ?";
                $table_row = $cart_info->prepare($sql);
                $table_row->bind_param('s', $cart_product);
                $table_row->execute();
                $checked = $table_row->get_result();
                $check_row = $checked->fetch_assoc();
                if (!$check_row['count'] > 0) {
                    $insert_stmt = $cart_info->prepare("INSERT INTO $cart_data (user_name, cp_detail) VALUES (?, ?)");
                    $insert_stmt->bind_param("si", $cart_data, $cart_product);
                    $insert_stmt->execute();
                    $insert_stmt->close();
                } else {
                    echo 'already add';
                }
                $table_row->close();

            }else{
                echo "Product Added";
            }
            $query->close();
        } else{
            echo "Product NOT Added";
        }
    }else{
        echo "Product Not Added";
    }
}
?>