<?php
/**
 * Stark Store - Central Configuration & Database Connection Manager
 */

// Error reporting: Log errors to file; display only in debug mode
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
if (isset($_GET['debug']) && $_GET['debug'] === '1') {
    ini_set('display_errors', 1);
} else {
    ini_set('display_errors', 0);
}
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/php_error.log');

if (function_exists('mysqli_report')) {
    mysqli_report(MYSQLI_REPORT_OFF);
}

// Database connection parameters
$env_host = getenv('DB_HOST');
$db_hosts = $env_host ? [$env_host, 'localhost', '127.0.0.1'] : ['localhost', '127.0.0.1'];
$db_user  = getenv('DB_USER') ?: 'root';
$db_pass  = getenv('DB_PASS') !== false ? getenv('DB_PASS') : '';
$db_name  = getenv('DB_NAME') ?: 'stark_store';

// Legacy credential fallback credentials
$legacy_users = [
    ['user' => $db_user, 'pass' => $db_pass],
    ['user' => 'root', 'pass' => ''],
    ['user' => 'root', 'pass' => 'root'],
    ['user' => 'pehunt_member', 'pass' => 'BJ;RDe;0?[7V']
];

$possible_dbs = array_unique([$db_name, 'stark_store', 'pehunt_store', 'pehunt_user', 'pehunt_db', 'pehunt_stark', 'pehunt_ecommerce', 'pehunt_pehunt']);

$db = false;
$active_host = 'localhost';
$active_user = $db_user;
$active_pass = $db_pass;

// Try connecting across hosts and credentials
foreach ($db_hosts as $h) {
    if ($db) break;
    foreach ($legacy_users as $cred) {
        $link = @mysqli_connect($h, $cred['user'], $cred['pass']);
        if ($link) {
            $active_host = $h;
            $active_user = $cred['user'];
            $active_pass = $cred['pass'];
            
            // Try selecting primary or candidate databases
            $select = false;
            foreach ($possible_dbs as $cand_db) {
                if (@mysqli_select_db($link, $cand_db)) {
                    $db_name = $cand_db;
                    $select = true;
                    break;
                }
            }

            // If still not selected, discover accessible databases with tables
            if (!$select) {
                $db_res = @mysqli_query($link, "SHOW DATABASES");
                if ($db_res) {
                    while ($db_row = mysqli_fetch_row($db_res)) {
                        $cand = $db_row[0];
                        if (in_array($cand, ['information_schema', 'performance_schema', 'mysql', 'sys'])) continue;
                        if (@mysqli_select_db($link, $cand)) {
                            $tbl_chk = @mysqli_query($link, "SHOW TABLES LIKE 'users'");
                            if ($tbl_chk && mysqli_num_rows($tbl_chk) > 0) {
                                $db_name = $cand;
                                $select = true;
                                break;
                            }
                        }
                    }
                }
            }

            // If database still doesn't exist, try to create it (local environments)
            if (!$select) {
                @mysqli_query($link, "CREATE DATABASE IF NOT EXISTS `$db_name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                if (@mysqli_select_db($link, $db_name)) {
                    $select = true;
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
}

// Define connection constants
defined('DB_HOST') or define('DB_HOST', $active_host);
defined('DB_USER') or define('DB_USER', $active_user);
defined('DB_PASS') or define('DB_PASS', $active_pass);
defined('DB_NAME') or define('DB_NAME', $db_name);

// Payment Gateway Configuration (Razorpay)
defined('RAZORPAY_KEY_ID') or define('RAZORPAY_KEY_ID', 'rzp_test_kBREEooxYkKLPo');
defined('RAZORPAY_KEY_SECRET') or define('RAZORPAY_KEY_SECRET', 'P5NsdNUNPas0c0C74oCjkk1Y');
defined('ENABLE_COD') or define('ENABLE_COD', true);

// Payment Gateway Configuration (Apiwala TPIPay - Pay via Online)
defined('APIWALA_API_KEY') or define('APIWALA_API_KEY', getenv('APIWALA_API_KEY') ?: 'YOUR_API_KEY');
defined('APIWALA_PARTNER_ID') or define('APIWALA_PARTNER_ID', getenv('APIWALA_PARTNER_ID') ?: 'YOUR_PARTNER_ID');
defined('APIWALA_ENDPOINT') or define('APIWALA_ENDPOINT', 'https://apiwala.in/production/api/collection/order/tpipay');
defined('APIWALA_CALLBACK_URL') or define('APIWALA_CALLBACK_URL', getenv('APIWALA_CALLBACK_URL') ?: '');

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