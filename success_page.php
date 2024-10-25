<?php
include('config.php');
session_start();

// Check if the user is logged in
if (!isset($_SESSION['google_loggedin'])) {
    header('Location: signup.php');
    exit;
}

try {
    $full_details = $_SESSION['full_details'] ?? [];

    // Ensure all required fields are available
    if (empty($full_details['sub']) || empty($full_details['email'])) {
        throw new Exception("Incomplete user details from Google.");
    }

    // Extract user information
    $sub = $full_details['sub'];
    $name = $full_details['name'] ?? '';
    $given_name = $full_details['given_name'] ?? '';
    $picture = $full_details['picture'] ?? '';
    $email = $full_details['email'];
    $email_verified = $full_details['email_verified'] ?? 'false';

    // Check if user exists
    $check_user = $con->prepare("SELECT * FROM google_user WHERE email = ? OR sub = ?");
    $check_user->bind_param("ss", $email, $sub);
    $check_user->execute();
    $google_user_result = $check_user->get_result();

    // If the user doesn't exist, create new entries
    if ($google_user_result->num_rows === 0) {
        $g_user = $con->prepare("INSERT INTO google_user (sub, name, given_name, picture, email, email_verify) VALUES (?, ?, ?, ?, ?, ?)");
        $g_user->bind_param("ssssss", $sub, $name, $given_name, $picture, $email, $email_verified);
        if (!$g_user->execute()) {
            throw new Exception("Error inserting Google user: " . $g_user->error);
        }

        $user = $con->prepare("INSERT INTO users (name, profile_img, email) VALUES (?, ?, ?)");
        $user->bind_param("sss", $name, $picture, $email);
        if (!$user->execute()) {
            throw new Exception("Error inserting user: " . $user->error);
        }
    }

    // Fetch user details securely
    $fetch_details = $con->prepare("SELECT * FROM users WHERE email = ?");
    $fetch_details->bind_param("s", $email);
    if (!$fetch_details->execute()) {
        throw new Exception("Error fetching user details: " . $fetch_details->error);
    }

    $result = $fetch_details->get_result();
    if ($fetch = $result->fetch_assoc()) {
        // Store user details in session
        $_SESSION['id'] = $fetch['id'] ?? null;
        $_SESSION['name'] = $fetch['name'] ?? null;
        $_SESSION['email'] = $fetch['email'] ?? null;
        $_SESSION['Mobile'] = $fetch['Mobile'] ?? null;
        $_SESSION['password'] = $fetch['password'] ?? null;
        $_SESSION['profile_img'] = $fetch['profile_img'] ?? null;
        $_SESSION['office'] = $fetch['office'] ?? null;
        $_SESSION['username'] = $fetch['username'] ?? null;
        $_SESSION['wishlist'] = $fetch['wishlist'] ?? null;
        $_SESSION['cart'] = $fetch['cart'] ?? null;

        // Update wishlist and cart if needed
        foreach (['wishlist' => '_wishlist', 'cart' => '_cart'] as $key => $suffix) {
            if ($_SESSION[$key] == "user_$key") {
                $new_value = $_SESSION['id'] . str_replace(' ', '', $_SESSION['name']) . $suffix;

                $update_stmt = $con->prepare("UPDATE users SET $key = ? WHERE id = ?");
                $update_stmt->bind_param("si", $new_value, $_SESSION['id']);
                if (!$update_stmt->execute()) {
                    throw new Exception("Error updating $key: " . $update_stmt->error);
                }
                $_SESSION[$key] = $new_value; // Update session value
            }
        }

        // Redirect to the main page
        header('Location: index.php');
        exit;
    } else {
        throw new Exception("User details not found in the database.");
    }
} catch (Exception $e) {
    // Log the error for further analysis
    error_log("Error: " . $e->getMessage());
    echo "An error occurred. Please try again later.";
} finally {
    $con->close();
}
