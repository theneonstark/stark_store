<?php
include('config.php');
// wishlist.php or the file handling the AJAX request
if (isset($_POST['wish']) && isset($_POST['wish_product'])) {
    session_start();
    if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
        $wish_product = $_POST['wish_product'];
        $wish_data = $_POST['wish'];
        $wish_table = mysqli_query($wishlist_info, "CREATE TABLE IF NOT EXISTS $wish_data (
	w_id INT AUTO_INCREMENT UNIQUE PRIMARY KEY,
	user_name varchar(100),
	wp_detail INT
	)");
        if ($wish_table) {
            $database_name = 'wishlist';
            $table_name = $wish_data;
            $query = $con->prepare("SELECT COUNT(*) as count FROM information_schema.tables WHERE table_schema = ? AND table_name = ?");
            $query->bind_param("ss", $database_name, $table_name);
            $query->execute();
            $result = $query->get_result();
            $row = $result->fetch_assoc();
            if ($row['count'] > 0) {
                $sql = "SELECT COUNT(*) as count FROM $table_name WHERE wp_detail = ?";
                $table_row = $wishlist_info->prepare($sql);
                $table_row->bind_param('s', $wish_product);
                $table_row->execute();
                $checked = $table_row->get_result();
                $check_row = $checked->fetch_assoc();
                if (!$check_row['count'] > 0) {
                    $insert_stmt = $wishlist_info->prepare("INSERT INTO $wish_data (user_name, wp_detail) VALUES (?, ?)");
                    $insert_stmt->bind_param("si", $wish_data, $wish_product);
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
            echo "Product Added";
        }
    }else{
        echo "Product Added";
    }
}
?>