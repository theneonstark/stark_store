<?php
/**
 * Stark Store - Shopping Cart Page
 * Resilient, AJAX-powered, supports guest & logged-in users
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include('config.php');
stark_ensure_tables($con);

$user_id    = $_SESSION['id'] ?? null;
$session_id = session_id();
$user_name  = $_SESSION['name'] ?? 'Account';
$is_logged_in = isset($_SESSION['email']) || isset($_SESSION['google_email']);

// Query cart items from user_cart joined with product_item
if ($user_id) {
    $cart_stmt = $con->prepare("
        SELECT uc.id AS cart_row_id, uc.quantity, uc.product_id, pi.product_name, pi.product_price, pi.product_img, pi.product_catg
        FROM user_cart uc
        JOIN product_item pi ON uc.product_id = pi.id
        WHERE uc.user_id = ? OR uc.session_id = ?
        ORDER BY uc.id DESC
    ");
    $cart_stmt->bind_param("is", $user_id, $session_id);
} else {
    $cart_stmt = $con->prepare("
        SELECT uc.id AS cart_row_id, uc.quantity, uc.product_id, pi.product_name, pi.product_price, pi.product_img, pi.product_catg
        FROM user_cart uc
        JOIN product_item pi ON uc.product_id = pi.id
        WHERE uc.session_id = ?
        ORDER BY uc.id DESC
    ");
    $cart_stmt->bind_param("s", $session_id);
}

$cart_stmt->execute();
$cart_res = $cart_stmt->get_result();

$cart_items = [];
$cart_subtotal = 0;
$cart_total_qty = 0;

while ($row = $cart_res->fetch_assoc()) {
    $qty = max(1, intval($row['quantity']));
    $price = floatval($row['product_price']);
    $item_subtotal = $qty * $price;
    $cart_subtotal += $item_subtotal;
    $cart_total_qty += $qty;
    $row['calculated_subtotal'] = $item_subtotal;
    $cart_items[] = $row;
}
$cart_stmt->close();

$shipping_fee = ($cart_subtotal > 999 || $cart_subtotal == 0) ? 0 : 99;
$grand_total = $cart_subtotal + $shipping_fee;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Shopping Cart - Pehunt</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
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
	<link rel="stylesheet" type="text/css" href="css/product-add.css">
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
	<style>
		.btn-cart-remove {
			background: none;
			border: none;
			color: #e65540;
			cursor: pointer;
			font-size: 18px;
			padding: 4px 8px;
			transition: all 0.2s ease;
		}
		.btn-cart-remove:hover {
			color: #c0392b;
			transform: scale(1.15);
		}
		.cart-summary-card {
			background: #fbfbfb;
			border: 1px solid #e6e6e6;
			border-radius: 12px;
			padding: 24px;
		}
		.empty-cart-box {
			text-align: center;
			padding: 60px 20px;
		}
		.empty-cart-icon {
			font-size: 72px;
			color: #bbb;
			margin-bottom: 20px;
		}
		.num-product {
			pointer-events: none;
		}
	</style>
</head>

<body class="animsition">
	<!-- Header -->
	<header class="header-v4">
		<!-- Header desktop -->
		<div class="container-menu-desktop">
			<div class="top-bar">
				<div class="content-topbar flex-sb-m h-full container dis-flex justify-content-center">
					<div class="left-top-bar">
						Free shipping for orders over ₹999 | 100% Quality Guaranteed
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
							<li>
								<a href="index.php">Home</a>
							</li>
							<li>
								<a href="product.php">Shop</a>
							</li>
							<li class="label1 active-menu" data-label1="hot">
								<a href="shoping-cart.php">Your Cart</a>
							</li>
							<li>
								<a href="contact.php">Contact</a>
							</li>
						</ul>
					</div>

					<!-- Icon header -->
					<div class="wrap-icon-header flex-w flex-r-m">
						<div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 js-show-modal-search">
							<i class="zmdi zmdi-search"></i>
						</div>
						<div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti noti-cart js-show-cart" data-notify="<?php echo $cart_total_qty; ?>">
							<i class="zmdi zmdi-shopping-cart"></i>
						</div>
						<span class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti noti-wish js-show-wishlist">
							<i class="zmdi zmdi-favorite-outline"></i>
						</span>

						<?php if ($is_logged_in): ?>
						<div class="dropdown">
							<div class="dis-block d-flex align-items-center icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-22 dropdown-toggle" data-bs-toggle="dropdown" style="cursor: pointer;">
								<i class="zmdi zmdi-account-circle"></i>
								<span class="h6 m-0 ml-2"><?php echo htmlspecialchars($user_name); ?></span>
							</div>
							<div class="dropdown-menu border-0 rounded px-3 py-3 shadow" style="background: rgba(255, 255, 255, 0.95);">
								<a href="address.php" class="dropdown-item font-weight-bold">Delivery Address</a>
								<a href="orders.php" class="dropdown-item font-weight-bold">Your Orders</a>
								<div class="dropdown-divider"></div>
								<a href="logout.php" class="dropdown-item text-danger font-weight-bold">Logout</a>
							</div>
						</div>
						<?php else: ?>
						<div class="p-l-20">
							<a href="login.php" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04" style="height: 38px; border-radius: 20px;">
								Login
							</a>
						</div>
						<?php endif; ?>
					</div>
				</nav>
			</div>
		</div>

		<!-- Header Mobile -->
		<div class="wrap-header-mobile">
			<div class="logo-mobile">
				<a href="index.php"><img src="images/icons/logo-pehunt-dark.png" alt="PEHUNT" style="height: 34px; width: auto; object-fit: contain;"></a>
			</div>
			<div class="wrap-icon-header flex-w flex-r-m m-r-15">
				<div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 js-show-modal-search">
					<i class="zmdi zmdi-search"></i>
				</div>
				<div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti noti-cart js-show-cart" data-notify="<?php echo $cart_total_qty; ?>">
					<i class="zmdi zmdi-shopping-cart"></i>
				</div>
				<span class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti noti-wish js-show-wishlist">
					<i class="zmdi zmdi-favorite-outline"></i>
				</span>
			</div>
			<div class="btn-show-menu-mobile hamburger hamburger--squeeze">
				<span class="hamburger-box">
					<span class="hamburger-inner"></span>
				</span>
			</div>
		</div>

		<!-- Menu Mobile -->
		<div class="menu-mobile">
			<ul class="main-menu-m">
				<li><a href="index.php">Home</a></li>
				<li><a href="product.php">Shop</a></li>
				<li><a href="shoping-cart.php" class="label1 rs1" data-label1="hot">Cart</a></li>
				<li><a href="contact.php">Contact</a></li>
				<?php if ($is_logged_in): ?>
				<li>
					<a href="orders.php">Your Orders</a>
				</li>
				<li>
					<a href="address.php">Your Address</a>
				</li>
				<li>
					<a href="logout.php" class="text-danger">Logout (<?php echo htmlspecialchars($user_name); ?>)</a>
				</li>
				<?php else: ?>
				<li><a href="login.php">Login / Register</a></li>
				<?php endif; ?>
			</ul>
		</div>

		<!-- Modal Search -->
		<div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
			<div class="container-search-header">
				<button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-search">
					<img src="images/icons/icon-close2.png" alt="CLOSE">
				</button>
				<form action="product.php" method="GET" class="wrap-search-header flex-w p-l-15">
					<button class="flex-c-m trans-04">
						<i class="zmdi zmdi-search"></i>
					</button>
					<input class="plh3" type="text" name="search" placeholder="Search products...">
				</form>
			</div>
		</div>
	</header>

	<!-- Cart Sidebar Drawer -->
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

	<!-- Wishlist Sidebar Drawer -->
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

	<!-- Breadcrumb -->
	<div class="container">
		<div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
			<a href="index.php" class="stext-109 cl8 hov-cl1 trans-04">
				Home
				<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
			</a>
			<span class="stext-109 cl4">Shopping Cart</span>
		</div>
	</div>

	<!-- Cart Content Section -->
	<div class="bg0 p-t-40 p-b-85">
		<div class="container">
			<div id="cart-full-view" style="<?php echo empty($cart_items) ? 'display: none;' : ''; ?>">
				<form action="checkout.php" method="POST">
					<div class="row">
						<!-- Cart Items Table Column -->
						<div class="col-lg-8 col-xl-8 m-b-50">
							<div class="wrap-table-shopping-cart border rounded-3 shadow-sm bg-white overflow-hidden">
								<table class="table-shopping-cart mb-0">
									<thead>
										<tr class="table_head bg-light">
											<th class="column-1">Product</th>
											<th class="column-2">Name</th>
											<th class="column-3">Price</th>
											<th class="column-4">Quantity</th>
											<th class="column-5">Total</th>
											<th class="column-6 text-center">Action</th>
										</tr>
									</thead>
									<tbody id="cart-table-body">
										<?php foreach ($cart_items as $item): ?>
										<tr class="table_row" data-product-id="<?php echo $item['product_id']; ?>" data-unit-price="<?php echo $item['product_price']; ?>">
											<input type="hidden" name="check_id[]" value="<?php echo $item['product_id']; ?>">
											<td class="column-1">
												<div class="how-itemcart1">
													<img src="image/product/<?php echo htmlspecialchars($item['product_img']); ?>" 
													     alt="<?php echo htmlspecialchars($item['product_name']); ?>"
													     onerror="this.src='images/product-placeholder.jpg'">
												</div>
											</td>
											<td class="column-2 p-r-15">
												<a href="product-detail.php?id=<?php echo $item['product_id']; ?>" class="cl2 hov-cl1 trans-04 font-weight-bold">
													<?php echo htmlspecialchars($item['product_name']); ?>
												</a>
											</td>
											<td class="column-3 text-nowrap">
												₹ <?php echo number_format($item['product_price'], 2); ?>
											</td>
											<td class="column-4">
												<div class="wrap-num-product flex-w m-l-auto m-r-auto">
													<button type="button" class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m" title="Decrease">
														<i class="fs-16 zmdi zmdi-minus"></i>
													</button>
													<input class="mtext-104 cl3 txt-center num-product" type="number"
														name="num-product[<?php echo $item['product_id']; ?>]" 
														value="<?php echo $item['quantity']; ?>" readonly>
													<button type="button" class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m" title="Increase">
														<i class="fs-16 zmdi zmdi-plus"></i>
													</button>
												</div>
											</td>
											<td class="column-5 row-total text-nowrap font-weight-bold cl1">
												₹ <?php echo number_format($item['calculated_subtotal'], 2); ?>
											</td>
											<td class="column-6 text-center">
												<button type="button" class="btn-cart-remove" title="Remove Item">
													<i class="zmdi zmdi-delete"></i>
												</button>
											</td>
										</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							</div>

							<!-- Continue Shopping Link -->
							<div class="flex-w flex-sb-m p-t-18 p-b-15">
								<a href="product.php" class="stext-101 cl2 hov-cl1 trans-04">
									&larr; Continue Shopping
								</a>
							</div>
						</div>

						<!-- Cart Summary Column -->
						<div class="col-lg-4 col-xl-4 m-b-50">
							<div class="cart-summary-card shadow-sm">
								<h4 class="mtext-109 cl2 p-b-20 border-bottom">
									Order Summary
								</h4>

								<div class="flex-w flex-t p-t-15 p-b-15 border-bottom">
									<div class="size-208">
										<span class="stext-110 cl2">Subtotal:</span>
									</div>
									<div class="size-209 text-right">
										<span class="mtext-110 cl2 font-weight-bold" id="cart-summary-subtotal">
											₹ <?php echo number_format($cart_subtotal, 2); ?>
										</span>
									</div>
								</div>

								<div class="flex-w flex-t p-t-15 p-b-15 border-bottom">
									<div class="size-208">
										<span class="stext-110 cl2">Shipping:</span>
									</div>
									<div class="size-209 text-right">
										<span class="stext-112 cl2 font-weight-bold" id="cart-summary-shipping">
											<?php echo ($shipping_fee === 0) ? '<span class="text-success">FREE</span>' : '₹ ' . number_format($shipping_fee, 2); ?>
										</span>
										<div class="text-muted" style="font-size: 11px;">
											<?php echo ($cart_subtotal > 999) ? 'Free shipping applied!' : 'Free shipping on orders over ₹999'; ?>
										</div>
									</div>
								</div>

								<div class="flex-w flex-t p-t-20 p-b-25">
									<div class="size-208">
										<span class="mtext-101 cl2 font-weight-bold">Total:</span>
									</div>
									<div class="size-209 text-right">
										<span class="mtext-110 cl1 font-weight-bold" style="font-size: 22px;" id="cart-summary-grandtotal">
											₹ <?php echo number_format($grand_total, 2); ?>
										</span>
									</div>
								</div>

								<button type="submit" class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer w-100 rounded-pill shadow-sm" style="font-size: 15px; height: 50px;">
									Proceed to Checkout
								</button>

								<div class="text-center p-t-15">
									<span class="text-muted" style="font-size: 12px;">
										<i class="fa fa-lock m-r-5 text-success"></i> 256-Bit SSL Encrypted & Secure Checkout
									</span>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>

			<!-- Empty Cart State -->
			<div id="cart-empty-view" class="empty-cart-box" style="<?php echo !empty($cart_items) ? 'display: none;' : ''; ?>">
				<div class="empty-cart-icon">
					<i class="zmdi zmdi-shopping-cart"></i>
				</div>
				<h3 class="mtext-109 cl2 p-b-10">Your Shopping Cart is Empty</h3>
				<p class="stext-115 cl6 p-b-30">Looks like you haven't added any items to your cart yet. Explore our curated collections and discover great styles!</p>
				<a href="product.php" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 m-lr-auto rounded-pill" style="max-width: 220px;">
					Start Shopping
				</a>
			</div>
		</div>
	</div>

	<!-- Footer -->
	<footer class="bg3 p-t-75 p-b-32">
		<div class="container">
			<div class="row">
				<div class="col-sm-6 col-lg-3 p-b-50">
					<a href="index.php" class="d-inline-block mb-3">
						<img src="images/icons/logo-01.png" alt="PEHUNT" style="height: 40px; width: auto; max-width: 180px; object-fit: contain;">
					</a>
					<p class="stext-107 cl7 m-b-20" style="line-height: 1.6;">
						Premium fashion, streetwear & modern lifestyle essentials. Engineered for maximum comfort, cutting-edge style, and daily confidence.
					</p>
					<div class="d-flex align-items-center">
						<a href="#" class="stark-social-link"><i class="fa fa-instagram"></i></a>
						<a href="#" class="stark-social-link"><i class="fa fa-twitter"></i></a>
						<a href="#" class="stark-social-link"><i class="fa fa-facebook"></i></a>
						<a href="#" class="stark-social-link"><i class="fa fa-youtube-play"></i></a>
					</div>
				</div>

				<div class="col-sm-6 col-lg-3 p-b-50">
					<h4 class="stext-301 cl0 p-b-25">
						Collections
					</h4>

					<ul>
						<li class="p-b-10">
							<a href="product.php?product_target=f" class="stext-107 cl7 hov-cl1 trans-04">
								Women's Apparel
							</a>
						</li>

						<li class="p-b-10">
							<a href="product.php?product_target=m" class="stext-107 cl7 hov-cl1 trans-04">
								Men's Streetwear
							</a>
						</li>

						<li class="p-b-10">
							<a href="product.php?product_target=O" class="stext-107 cl7 hov-cl1 trans-04">
								Accessories & Bags
							</a>
						</li>

						<li class="p-b-10">
							<a href="product.php" class="stext-107 cl7 hov-cl1 trans-04">
								New Season Drops
							</a>
						</li>
					</ul>
				</div>

				<div class="col-sm-6 col-lg-3 p-b-50">
					<h4 class="stext-301 cl0 p-b-25">
						Customer Support
					</h4>

					<ul>
						<li class="p-b-10">
							<a href="orders.php" class="stext-107 cl7 hov-cl1 trans-04">
								Track My Orders
							</a>
						</li>

						<li class="p-b-10">
							<a href="return-policy.php" class="stext-107 cl7 hov-cl1 trans-04">
								Returns & Refunds
							</a>
						</li>

						<li class="p-b-10">
							<a href="shipping-policy.php" class="stext-107 cl7 hov-cl1 trans-04">
								Shipping & Delivery
							</a>
						</li>

						<li class="p-b-10">
							<a href="terms-of-use-and-condition.php" class="stext-107 cl7 hov-cl1 trans-04">
								Terms of Service
							</a>
						</li>

						<li class="p-b-10">
							<a href="contact.php" class="stext-107 cl7 hov-cl1 trans-04">
								Contact Support
							</a>
						</li>
					</ul>
				</div>

				<div class="col-sm-6 col-lg-3 p-b-50">
					<h4 class="stext-301 cl0 p-b-25">
						Stay in the Loop
					</h4>
					<p class="stext-107 cl7 m-b-15">
						Subscribe for exclusive drops, private sale invites and 15% off your first purchase.
					</p>
					<form class="stark-newsletter-form" onsubmit="event.preventDefault(); swal('Subscribed!', 'Welcome to the Pehunt VIP Club!', 'success');">
						<input type="email" placeholder="Enter your email" required>
						<button type="submit">Join <i class="fa fa-paper-plane ml-1"></i></button>
					</form>
				</div>
			</div>

			<div class="p-t-30 p-b-10" style="border-top: 1px solid rgba(255,255,255,0.08);">
				<div class="d-flex flex-wrap justify-content-between align-items-center">
					<p class="stext-107 cl6 m-0">
						&copy; <?php echo date('Y'); ?> <strong>Pehunt</strong>. All rights reserved. Built with precision & modern aesthetics.
					</p>
					<div class="flex-c-m flex-w p-t-4">
						<a href="#" class="m-all-1"><img src="images/icons/icon-pay-01.png" alt="PAYPAL"></a>
						<a href="#" class="m-all-1"><img src="images/icons/icon-pay-02.png" alt="VISA"></a>
						<a href="#" class="m-all-1"><img src="images/icons/icon-pay-03.png" alt="MASTERCARD"></a>
						<a href="#" class="m-all-1"><img src="images/icons/icon-pay-04.png" alt="EXPRESS"></a>
						<a href="#" class="m-all-1"><img src="images/icons/icon-pay-05.png" alt="DISCOVER"></a>
					</div>
				</div>
			</div>
		</div>
	</footer>

	<!-- Back to top -->
	<div class="btn-back-to-top" id="myBtn">
		<span class="symbol-btn-back-to-top">
			<i class="zmdi zmdi-chevron-up"></i>
		</span>
	</div>

	<!-- Scripts -->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
	<script src="vendor/animsition/js/animsition.min.js"></script>
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="vendor/select2/select2.min.js"></script>
	<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
	<script>
		$('.js-pscroll').each(function(){
			$(this).css('position','relative');
			$(this).css('overflow','hidden');
			var ps = new PerfectScrollbar(this, {
				wheelSpeed: 1,
				scrollingThreshold: 1000,
				wheelPropagation: false,
			});
			$(window).on('resize', function(){
				ps.update();
			})
		});
	</script>

	<!-- AJAX Cart & Wishlist Handler -->
	<script>
		function formatCurrency(val) {
			return '₹ ' + parseFloat(val).toFixed(2);
		}

		function recalculateSummary(cartSubtotal) {
			var subtotal = parseFloat(cartSubtotal) || 0;
			var shipping = (subtotal > 999 || subtotal === 0) ? 0 : 99;
			var grand = subtotal + shipping;

			$('#cart-summary-subtotal').text(formatCurrency(subtotal));
			if (shipping === 0) {
				$('#cart-summary-shipping').html('<span class="text-success">FREE</span>');
			} else {
				$('#cart-summary-shipping').text(formatCurrency(shipping));
			}
			$('#cart-summary-grandtotal').text(formatCurrency(grand));

			if (subtotal <= 0) {
				$('#cart-full-view').hide();
				$('#cart-empty-view').fadeIn();
			}
		}

		function fetchWishlistData() {
			$.ajax({
				url: 'wishlist-data-config.php',
				type: 'GET',
				dataType: 'json',
				success: function(response) {
					if (response.status === 'success') {
						$('.noti-wish').attr('data-notify', response.count);
						var wishlistItems = response.data || [];
						var wishlistHTML = '';
						wishlistItems.forEach(function(item) {
							wishlistHTML += `
							<li class="header-cart-item flex-w flex-t m-b-12">
								<div class="header-cart-item-img">
									<img src="image/product/${item.product_img}" alt="IMG" onerror="this.src='images/product-placeholder.jpg'">
								</div>
								<div class="header-cart-item-txt p-t-8">
									<a href="product-detail.php?id=${item.id}" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
										${item.product_name}
									</a>
									<span class="header-cart-item-info">₹ ${item.product_price}</span>
								</div>
							</li>`;
						});
						$('.header-wishlist-wrapitem').html(wishlistHTML);
					} else {
						$('.header-wishlist-wrapitem').html('<p class="p-3 text-muted">No wishlist items</p>');
						$('.noti-wish').attr('data-notify', 0);
					}
				}
			});
		}

		function fetchCartData() {
			$.ajax({
				url: 'cart-data-config.php',
				type: 'GET',
				dataType: 'json',
				success: function(response) {
					if (response.status === 'success') {
						$('.noti-cart').attr('data-notify', response.count);
						var cartItems = response.data || [];
						var cartHTML = '';
						cartItems.forEach(function(item) {
							cartHTML += `
							<li class="header-cart-item flex-w flex-t m-b-12">
								<div class="header-cart-item-img">
									<img src="image/product/${item.product_img}" alt="IMG" onerror="this.src='images/product-placeholder.jpg'">
								</div>
								<div class="header-cart-item-txt p-t-8">
									<a href="product-detail.php?id=${item.id}" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
										${item.product_name}
									</a>
									<span class="header-cart-item-info">Qty: ${item.quantity || 1} &times; ₹ ${item.product_price}</span>
								</div>
							</li>`;
						});
						$('.header-cart-wrapitem').html(cartHTML);
					} else {
						$('.header-cart-wrapitem').html('<p class="p-3 text-muted">Your cart is empty</p>');
						$('.noti-cart').attr('data-notify', 0);
					}
				}
			});
		}

		$(document).ready(function() {
			fetchCartData();
			fetchWishlistData();

			// Plus button: increase quantity live
			$(document).on('click', '.btn-num-product-up', function(e) {
				e.preventDefault();
				var $row = $(this).closest('.table_row');
				var productId = $row.data('product-id');
				var $input = $row.find('.num-product');

				$.ajax({
					url: 'cart-update-config.php',
					type: 'POST',
					dataType: 'json',
					data: {
						product_id: productId,
						action: 'inc'
					},
					success: function(res) {
						if (res.status === 'success') {
							$input.val(res.quantity);
							$row.find('.row-total').text(formatCurrency(res.item_subtotal));
							recalculateSummary(res.cart_subtotal);
							$('.noti-cart').attr('data-notify', res.cart_count);
							fetchCartData();
						}
					}
				});
			});

			// Minus button: decrease quantity live
			$(document).on('click', '.btn-num-product-down', function(e) {
				e.preventDefault();
				var $row = $(this).closest('.table_row');
				var productId = $row.data('product-id');
				var $input = $row.find('.num-product');
				var currentQty = parseInt($input.val()) || 1;

				if (currentQty <= 1) {
					if (!confirm('Do you want to remove this item from your cart?')) {
						return;
					}
				}

				$.ajax({
					url: 'cart-update-config.php',
					type: 'POST',
					dataType: 'json',
					data: {
						product_id: productId,
						action: 'dec'
					},
					success: function(res) {
						if (res.status === 'success') {
							if (res.action === 'removed' || res.quantity <= 0) {
								$row.fadeOut(300, function() {
									$(this).remove();
									if ($('#cart-table-body tr').length === 0) {
										$('#cart-full-view').hide();
										$('#cart-empty-view').fadeIn();
									}
								});
							} else {
								$input.val(res.quantity);
								$row.find('.row-total').text(formatCurrency(res.item_subtotal));
							}
							recalculateSummary(res.cart_subtotal);
							$('.noti-cart').attr('data-notify', res.cart_count);
							fetchCartData();
						}
					}
				});
			});

			// Remove button (trash icon): instant remove
			$(document).on('click', '.btn-cart-remove', function(e) {
				e.preventDefault();
				var $row = $(this).closest('.table_row');
				var productId = $row.data('product-id');

				if (confirm('Are you sure you want to remove this item?')) {
					$.ajax({
						url: 'cart-remove-config.php',
						type: 'POST',
						dataType: 'json',
						data: {
							productId: productId
						},
						success: function(res) {
							if (res.status === 'success') {
								$row.fadeOut(300, function() {
									$(this).remove();
									if ($('#cart-table-body tr').length === 0) {
										$('#cart-full-view').hide();
										$('#cart-empty-view').fadeIn();
									}
								});
								// Fetch updated cart data to recalculate
								$.getJSON('cart-data-config.php', function(cartData) {
									var newTotal = cartData.total_price || 0;
									recalculateSummary(newTotal);
									$('.noti-cart').attr('data-notify', cartData.count || 0);
									fetchCartData();
								});
							}
						}
					});
				}
			});
		});
	</script>
	<script src="js/main.js"></script>
</body>
</html>