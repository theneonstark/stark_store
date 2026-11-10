<?php
/**
 * PeHunt - Admin Security & Authentication Guard
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config.php';

// Check if user is logged in AND is an admin (office == 1 or in admins table)
$is_admin = false;

if (isset($_SESSION['email'])) {
    if (isset($_SESSION['office']) && (int)$_SESSION['office'] === 1) {
        $is_admin = true;
    } elseif (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true) {
        $is_admin = true;
    } elseif (!empty($con)) {
        // Double check against admins table
        $check_email = $_SESSION['email'];
        try {
            $chk_stmt = $con->prepare("SELECT id FROM admins WHERE email = ?");
            if ($chk_stmt) {
                $chk_stmt->bind_param("s", $check_email);
                $chk_stmt->execute();
                $chk_res = $chk_stmt->get_result();
                if ($chk_res && $chk_res->num_rows > 0) {
                    $is_admin = true;
                    $_SESSION['office'] = 1;
                    $_SESSION['is_admin'] = true;
                }
                $chk_stmt->close();
            }
        } catch (Throwable $e) {
            error_log("Admin auth check DB error: " . $e->getMessage());
        }
    }
}

if (!$is_admin) {
    if (!headers_sent()) {
        header('Location: ../login.php?error=admin_required');
    }
    // Fail-safe HTML + JS redirect so the user never sees a blank white screen
    echo '<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="refresh" content="0;url=../login.php?error=admin_required">
  <title>Redirecting to Login...</title>
  <script>window.location.href = "../login.php?error=admin_required";</script>
</head>
<body style="font-family:sans-serif;text-align:center;padding:50px;">
  <h2>Access Denied</h2>
  <p>Please log in with an administrator account to access the dashboard.</p>
  <p><a href="../login.php?error=admin_required" style="color:#6366f1;font-weight:bold;">Click here to sign in &rarr;</a></p>
</body>
</html>';
    exit;
}
