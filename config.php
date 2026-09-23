<?php
/**
 * Stark Store - Central Configuration & Database Connection Manager
 */

// Disable error reporting output in production, enable in development
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
ini_set('display_errors', 0);
if (function_exists('mysqli_report')) {
    mysqli_report(MYSQLI_REPORT_OFF);
}


// Database connection parameters
// You can customize these constants or override them via environment variables
$db_host = getenv('DB_HOST') ?: '127.0.0.1';
$db_user = getenv('DB_USER') ?: 'root';
$db_pass = getenv('DB_PASS') !== false ? getenv('DB_PASS') : '';
$db_name = getenv('DB_NAME') ?: 'stark_store';

// Legacy credential fallback credentials
$legacy_users = [
    ['user' => $db_user, 'pass' => $db_pass],
    ['user' => 'root', 'pass' => ''],
    ['user' => 'root', 'pass' => 'root'],
    ['user' => 'pehunt_member', 'pass' => 'BJ;RDe;0?[7V']
];

$db = false;
$active_user = $db_user;
$active_pass = $db_pass;

// Try connecting with configured / fallback credentials
foreach ($legacy_users as $cred) {
    // Suppress warnings during connection test
    $link = @mysqli_connect($db_host, $cred['user'], $cred['pass']);
    if ($link) {
        $active_user = $cred['user'];
        $active_pass = $cred['pass'];
        
        // Check if primary database exists, or create it if missing
        $select = @mysqli_select_db($link, $db_name);
        if (!$select) {
            // Check for alternative db names
            foreach (['pehunt_user', 'pehunt_store', 'stark_store'] as $alt_db) {
                if (@mysqli_select_db($link, $alt_db)) {
                    $db_name = $alt_db;
                    $select = true;
                    break;
                }
            }
        }

        // If database still doesn't exist, try to create it
        if (!$select) {
            @mysqli_query($link, "CREATE DATABASE IF NOT EXISTS `$db_name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            if (@mysqli_select_db($link, $db_name)) {
                $select = true;
                // Auto-import seed schema if available
                $schema_file = __DIR__ . '/stark_store_complete.sql';
                if (file_exists($schema_file)) {
                    $sql = file_get_contents($schema_file);
                    @mysqli_multi_query($link, $sql);
                    while (@mysqli_more_results($link) && @mysqli_next_result($link)) {;}
                }
            }
        }

        if ($select) {
            $db = $link;
            break;
        } else {
            mysqli_close($link);
        }
    }
}

// Define connection constants
defined('DB_HOST') or define('DB_HOST', $db_host);
defined('DB_USER') or define('DB_USER', $active_user);
defined('DB_PASS') or define('DB_PASS', $active_pass);
defined('DB_NAME') or define('DB_NAME', $db_name);

// Payment Gateway Configuration (Razorpay)
defined('RAZORPAY_KEY_ID') or define('RAZORPAY_KEY_ID', 'rzp_test_kBREEooxYkKLPo');
defined('RAZORPAY_KEY_SECRET') or define('RAZORPAY_KEY_SECRET', 'P5NsdNUNPas0c0C74oCjkk1Y');
defined('ENABLE_COD') or define('ENABLE_COD', true);

// Set UTF-8 charset
if ($db) {
    mysqli_set_charset($db, "utf8mb4");
}

// In unified mode, all handles point to the primary consolidated database
$con            = $db;
$product_info   = $db;
$wishlist_info  = $db;
$fandq_info     = $db;
$cart_info      = $db;
$user_order     = $db;
$notification   = $db;
$blog           = $db;

/**
 * Ensure unified cart & wishlist tables exist
 */
function stark_ensure_tables($conn) {
    if (!$conn) return;
    
    // Ensure user_cart exists
    mysqli_query($conn, "CREATE TABLE IF NOT EXISTS `user_cart` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `user_id` int(11) DEFAULT NULL,
        `session_id` varchar(100) DEFAULT NULL,
        `product_id` int(11) NOT NULL,
        `quantity` int(11) NOT NULL DEFAULT 1,
        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        KEY `idx_user_id` (`user_id`),
        KEY `idx_session_id` (`session_id`),
        KEY `idx_product_id` (`product_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    // Ensure user_wishlist exists
    mysqli_query($conn, "CREATE TABLE IF NOT EXISTS `user_wishlist` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `user_id` int(11) DEFAULT NULL,
        `session_id` varchar(100) DEFAULT NULL,
        `product_id` int(11) NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        KEY `idx_user_id` (`user_id`),
        KEY `idx_session_id` (`session_id`),
        KEY `idx_product_id` (`product_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    
    // Ensure payment_method column exists in user_order
    $col_check = mysqli_query($conn, "SHOW COLUMNS FROM `user_order` LIKE 'payment_method'");
    if ($col_check && mysqli_num_rows($col_check) == 0) {
        @mysqli_query($conn, "ALTER TABLE `user_order` ADD COLUMN `payment_method` varchar(50) DEFAULT 'Cash on Delivery' AFTER `status`");
    }
}

if ($db) {
    stark_ensure_tables($db);
}

/**
 * Helper to get current session identifier (guest or logged in)
 */
function get_cart_identifier() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    return [
        'user_id'    => $_SESSION['id'] ?? null,
        'session_id' => session_id()
    ];
}