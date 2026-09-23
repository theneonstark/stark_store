<?php
/**
 * Stark Store - Admin Security & Authentication Guard
 */
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config.php';

// Check if user is logged in AND is an admin (office == 1 or in admins table)
$is_admin = false;

if (isset($_SESSION['email'])) {
    if (isset($_SESSION['office']) && $_SESSION['office'] == 1) {
        $is_admin = true;
    } elseif (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true) {
        $is_admin = true;
    } else {
        // Double check against admins table
        $check_email = $_SESSION['email'];
        $chk_stmt = $con->prepare("SELECT id FROM admins WHERE email = ?");
        $chk_stmt->bind_param("s", $check_email);
        $chk_stmt->execute();
        if ($chk_stmt->get_result()->num_rows > 0) {
            $is_admin = true;
            $_SESSION['office'] = 1;
            $_SESSION['is_admin'] = true;
        }
        $chk_stmt->close();
    }
}

if (!$is_admin) {
    header('Location: ../login.php?error=admin_required');
    exit;
}
?>
