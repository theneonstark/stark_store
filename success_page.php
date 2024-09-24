<?php
include('config.php');
session_start();

if (!isset($_SESSION['google_loggedin'])) {
    header('Location: signup.php');
    exit;
}

try {
    $full_details = $_SESSION['full_details'];
    $google_loggedin = $_SESSION['google_loggedin'];
    $google_email = $_SESSION['google_email'];
    $google_name = $_SESSION['google_name'];
    $google_picture = $_SESSION['google_picture'];

    $sub = $full_details['sub'];
    $name = $full_details['name'];
    $given = $full_details['given_name'];
    $pic = $full_details['picture'];
    $email = $full_details['email'];
    $email_v = $full_details['email_verified'];

    $check_user = $con->prepare("SELECT * FROM google_user WHERE email = ? OR sub = ?");
    $check_user->bind_param("ss", $email, $sub);
    $check_user->execute();
    $google_user_result = $check_user->get_result();

    if (!$google_user_result->num_rows) {
        $g_user = $con->prepare("INSERT INTO google_user (sub, name, given_name, picture, email, email_verify) VALUES (?,?,?,?,?,?)");
        $g_user->bind_param("ssssss", $sub, $name, $given, $pic, $email, $email_v);
        if (!$g_user->execute()) {
            throw new Exception("Error inserting Google user: " . $g_user->error);
        }

        $user = $con->prepare("INSERT INTO users (name, profile_img, email) VALUES (?,?,?)");
        $user->bind_param("sss", $name, $pic, $email);
        if (!$user->execute()) {
            throw new Exception("Error inserting user: " . $user->error);
        }

        $fetch_details = $con->prepare("SELECT * FROM users WHERE email = ?");
        $fetch_details->bind_param("s", $email);
        if (!$fetch_details->execute()) {
            throw new Exception("Error fetching user details: " . $fetch_details->error);
        }

        $result = $fetch_details->get_result();
        if ($fetch = $result->fetch_array()) {
            foreach (['id', 'name', 'email', 'Mobile', 'password', 'profile_img', 'office', 'username', 'wishlist', 'cart'] as $key) {
                $_SESSION[$key] = $fetch[$key];
            }

            if ($_SESSION['wishlist'] == 'user_wishlist') {
                $id = $_SESSION['id'];
                $name = $_SESSION['name'];
                $wish = '_wishlist';
                $new_wishlist = $id . $name . $wish;

                $update_stmt = $con->prepare("UPDATE users SET wishlist = ? WHERE id = ?");
                $update_stmt->bind_param("si", $new_wishlist, $id);
                if (!$update_stmt->execute()) {
                    throw new Exception("Error updating wishlist: " . $update_stmt->error);
                }

                $_SESSION['wishlist'] = $new_wishlist;
            }

            if ($_SESSION['cart'] == 'user_cart') {
                $id = $_SESSION['id'];
                $name = $_SESSION['name'];
                $cart = '_cart';
                $new_cart = $id . $name . $cart;

                $update_stmt = $con->prepare("UPDATE users SET cart = ? WHERE id = ?");
                $update_stmt->bind_param("si", $new_cart, $id);
                if (!$update_stmt->execute()) {
                    throw new Exception("Error updating cart: " . $update_stmt->error);
                }

                $_SESSION['cart'] = $new_cart;
                header('Location: index.php');
                exit;
            } else {
                $_SESSION['cart'] = $new_cart;
                header('Location: index.php');
                exit;
            }
        } else {
            throw new Exception("User details not found in the database.");
        }
    } else {
        $fetch_details = $con->prepare("SELECT * FROM users WHERE email = ?");
        $fetch_details->bind_param("s", $email);
        if (!$fetch_details->execute()) {
            throw new Exception("Error fetching user details: " . $fetch_details->error);
        }

        $result = $fetch_details->get_result();
        if ($fetch = $result->fetch_array()) {
            foreach (['id', 'name', 'email', 'Mobile', 'password', 'profile_img', 'office', 'username', 'wishlist', 'cart'] as $key) {
                $_SESSION[$key] = $fetch[$key];
            }

            if ($_SESSION['wishlist'] == 'user_wishlist') {
                $id = $_SESSION['id'];
                $name = $_SESSION['name'];
                $wish = '_wishlist';
                $new_wishlist = $id . $name . $wish;

                $update_stmt = $con->prepare("UPDATE users SET wishlist = ? WHERE id = ?");
                $update_stmt->bind_param("si", $new_wishlist, $id);
                if (!$update_stmt->execute()) {
                    throw new Exception("Error updating wishlist: " . $update_stmt->error);
                }

                $_SESSION['wishlist'] = $new_wishlist;
            }

            if ($_SESSION['cart'] == 'user_cart') {
                $id = $_SESSION['id'];
                $name = $_SESSION['name'];
                $cart = '_cart';
                $new_cart = $id . $name . $cart;

                $update_stmt = $con->prepare("UPDATE users SET cart = ? WHERE id = ?");
                $update_stmt->bind_param("si", $new_cart, $id);
                if (!$update_stmt->execute()) {
                    throw new Exception("Error updating cart: " . $update_stmt->error);
                }

                $_SESSION['cart'] = $new_cart;
                header('Location: index.php');
                exit;
            } else {
                $_SESSION['cart'] = $new_cart;
                header('Location: index.php');
                exit;
            }
        } else {
            throw new Exception("User details not found in the database.");
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
} finally {
    $con->close();
}
?>
