<?php
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include('config.php');

if (!isset($_SESSION['email']) && !isset($_SESSION['google_email'])) {
    header('Location: login.php');
    exit;
}

$success_msg = '';
$error_msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_address'])) {
    $id = intval($_SESSION['id'] ?? 0);
    $house = trim($_POST['house'] ?? '');
    $landmark = trim($_POST['landmark'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $zip = trim($_POST['zip'] ?? '');
    $state = trim($_POST['state'] ?? '');

    if ($id > 0 && !empty($house) && !empty($city)) {
        $stmt = $con->prepare("UPDATE users SET address = ?, landmark = ?, city = ?, zip = ?, state = ? WHERE id = ?");
        $stmt->bind_param("sssssi", $house, $landmark, $city, $zip, $state, $id);
        if ($stmt->execute()) {
            $_SESSION['address'] = $house . ', ' . $landmark . ', ' . $city . ', ' . $zip . '-' . $state;
            $stmt->close();
            header('Location: checkout.php');
            exit;
        } else {
            $error_msg = "Failed to update address. Please try again.";
        }
    } else {
        $error_msg = "Please fill in all required address fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shipping Address - Pehunt</title>
    <link rel="icon" type="image/png" href="images/icons/favicon.png" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600&family=Outfit:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/linearicons-v1.0.0/icon-font.min.css">
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
    <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
    <link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <link rel="stylesheet" type="text/css" href="vendor/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/modern-stark.css">
    <link rel="stylesheet" type="text/css" href="css/address.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</head>

<body>
<header class="header-v4">
    <!-- Header desktop -->
    <div class="container-menu-desktop">
        <!-- Topbar -->
        <div class="top-bar">
            <div class="content-topbar flex-sb-m h-full container dis-flex justify-content-center">
                <div class="left-top-bar">
                    Free Express Shipping on Orders Over ₹999 &nbsp;|&nbsp; ⚡ 100% Secure Checkout
                </div>
            </div>
        </div>

        <div class="wrap-menu-desktop">
            <nav class="limiter-menu-desktop container">
                <!-- Logo desktop -->
                <a href="index.php" class="logo d-flex align-items-center">
                    <img src="images/icons/logo-pehunt-dark.png" alt="PEHUNT" style="height: 42px; width: auto; max-width: 175px; object-fit: contain;">
                </a>

                <!-- Menu desktop -->
                <div class="menu-desktop">
                    <ul class="main-menu">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="product.php">Shop</a></li>
                        <li class="label1" data-label1="hot"><a href="shoping-cart.php">Your Cart</a></li>
                        <li><a href="contact.php">Contact</a></li>
                    </ul>
                </div>

                <!-- Icon header -->
                <div class="wrap-icon-header flex-w flex-r-m">
                    <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 js-show-modal-search">
                        <i class="zmdi zmdi-search"></i>
                    </div>
                    <?php if (isset($_SESSION['email']) || isset($_SESSION['google_email'])) { ?>
                        <div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti noti-cart js-show-cart" data-notify="0">
                            <i class="zmdi zmdi-shopping-cart"></i>
                        </div>
                        <div class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti noti-wish js-show-wishlist" data-notify="0">
                            <i class="zmdi zmdi-favorite-outline"></i>
                        </div>
                    <?php } ?>
                    <div class="dropdown">
                        <div class="dis-block d-flex align-items-center icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-22 dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="zmdi zmdi-account-circle"></i>
                            <span class="h6 m-0 ml-2"><?php echo htmlspecialchars($_SESSION['name'] ?? 'User'); ?></span>
                        </div>
                        <div class="dropdown-menu border-0 rounded px-3 py-3 shadow" style="background: rgba(255, 255, 255, 0.95); min-width: 180px;">
                            <li><a href="orders.php" class="dropdown-item font-weight-bold">Your Orders</a></li>
                            <li><a href="address.php" class="dropdown-item font-weight-bold active">Address Details</a></li>
                            <div class="dropdown-divider"></div>
                            <li><a href="logout.php" class="dropdown-item text-danger font-weight-bold">Logout</a></li>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</header>

<!-- Cart Drawer -->
<div class="wrap-header-cart js-panel-cart">
    <div class="s-full js-hide-cart"></div>
    <div class="header-cart flex-col-l p-l-65 p-r-25">
        <div class="header-cart-title flex-w flex-sb-m p-b-8">
            <span class="mtext-103 cl2">Your Cart</span>
            <div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-cart">
                <i class="zmdi zmdi-close"></i>
            </div>
        </div>
        <div class="header-cart-content flex-w js-pscroll">
            <ul class="header-cart-wrapitem w-full"></ul>
        </div>
    </div>
</div>

<!-- Wishlist Drawer -->
<div class="wrap-header-wishlist js-panel-wishlist">
    <div class="s-full js-hide-wishlist"></div>
    <div class="header-wishlist flex-col-l p-l-65 p-r-25">
        <div class="header-wishlist-title flex-w flex-sb-m p-b-8">
            <span class="mtext-103 cl2">Your Wishlist</span>
            <div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-wishlist">
                <i class="zmdi zmdi-close"></i>
            </div>
        </div>
        <div class="header-cart-content flex-w js-pscroll">
            <ul class="header-wishlist-wrapitem w-full"></ul>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <?php if ($error_msg): ?>
        <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm font-medium">
            <?php echo htmlspecialchars($error_msg); ?>
        </div>
    <?php endif; ?>

    <div class="grid lg:grid-cols-2 gap-10">
        <!-- Current Saved Address -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 sm:p-8">
            <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Delivery Address</h2>
                    <p class="text-sm text-gray-500 mt-1">Your current registered shipping location.</p>
                </div>
                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100">Default</span>
            </div>

            <div class="mt-6">
                <?php
                    $address_id = intval($_SESSION['id'] ?? 0);
                    $fetch_address = mysqli_query($con, "SELECT * FROM users WHERE id = $address_id");
                    $curr_address = mysqli_fetch_assoc($fetch_address);
                    
                    if ($curr_address && !empty($curr_address['address'])):
                ?>
                    <div class="p-5 rounded-xl bg-gray-50 border border-gray-200">
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="font-bold text-gray-900 text-base"><?php echo htmlspecialchars($curr_address['name']); ?></h3>
                                <p class="text-sm text-gray-600 mt-1 font-medium"><?php echo htmlspecialchars($curr_address['address']); ?></p>
                                <?php if (!empty($curr_address['landmark'])): ?>
                                    <p class="text-xs text-gray-500 mt-1">Landmark: <?php echo htmlspecialchars($curr_address['landmark']); ?></p>
                                <?php endif; ?>
                                <p class="text-sm text-gray-800 font-semibold mt-2">
                                    <?php echo htmlspecialchars($curr_address['city'] . ' - ' . $curr_address['zip'] . ', ' . $curr_address['state']); ?>
                                </p>
                                <p class="text-xs text-gray-500 mt-2">Phone: <?php echo htmlspecialchars($curr_address['Mobile'] ?? 'N/A'); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 flex gap-4">
                        <a href="checkout.php" class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-gray-900 hover:bg-gray-800 text-white font-semibold text-sm transition">
                            Proceed to Checkout &rarr;
                        </a>
                    </div>
                <?php else: ?>
                    <div class="text-center py-8 px-4 border-2 border-dashed border-gray-200 rounded-xl">
                        <i class="zmdi zmdi-pin text-4xl text-gray-300"></i>
                        <p class="text-sm text-gray-500 mt-2">No delivery address saved yet.</p>
                        <p class="text-xs text-gray-400">Please enter your address in the form to the right.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Update / Add Address Form -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 sm:p-8">
            <h2 class="text-xl font-bold text-gray-900 pb-4 border-b border-gray-100">
                <?php echo !empty($curr_address['address']) ? 'Update Address' : 'Add New Address'; ?>
            </h2>
            <p class="text-sm text-gray-500 mt-1 mb-6">Enter your complete delivery details for accurate shipping.</p>

            <form method="POST" class="space-y-5">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">Flat, House no., Building, Apartment</label>
                    <input type="text" name="house" value="<?php echo htmlspecialchars($curr_address['address'] ?? ''); ?>" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm outline-none transition" placeholder="e.g. Flat 402, Sunshine Heights" required>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">Landmark</label>
                        <input type="text" name="landmark" value="<?php echo htmlspecialchars($curr_address['landmark'] ?? ''); ?>" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm outline-none transition" placeholder="e.g. Near City Park">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">City</label>
                        <input type="text" name="city" value="<?php echo htmlspecialchars($curr_address['city'] ?? ''); ?>" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm outline-none transition" placeholder="e.g. New Delhi" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">Pincode / Zip</label>
                        <input type="text" name="zip" value="<?php echo htmlspecialchars($curr_address['zip'] ?? ''); ?>" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm outline-none transition" placeholder="e.g. 110001" required>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">State</label>
                        <input type="text" name="state" value="<?php echo htmlspecialchars($curr_address['state'] ?? ''); ?>" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm outline-none transition" placeholder="e.g. Delhi" required>
                    </div>
                </div>

                <button type="submit" name="new_address" class="w-full py-3.5 px-6 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm transition shadow-lg shadow-indigo-600/20">
                    Save Address & Continue
                </button>
            </form>
        </div>
    </div>
</div>

<footer class="bg3 p-t-75 p-b-32 mt-16">
    <div class="container text-center text-gray-400 text-sm">
        <p>&copy; <?php echo date('Y'); ?> Stark Store. All rights reserved.</p>
    </div>
</footer>

<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<script src="vendor/animsition/js/animsition.min.js"></script>
<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script>
    function fetchCartData() {
        $.ajax({
            url: 'cart-data-config.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    $('.noti-cart').attr('data-notify', response.count);
                } else {
                    $('.noti-cart').attr('data-notify', 0);
                }
            }
        });
    }

    function fetchWishlistData() {
        $.ajax({
            url: 'wishlist-data-config.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    $('.noti-wish').attr('data-notify', response.count);
                } else {
                    $('.noti-wish').attr('data-notify', 0);
                }
            }
        });
    }

    $(document).ready(function() {
        fetchCartData();
        fetchWishlistData();
    });
</script>
<script src="js/main.js"></script>
</body>
</html>