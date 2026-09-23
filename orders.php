<?php
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include("config.php");

if (!isset($_SESSION['email']) && !isset($_SESSION['google_email'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['id'] ?? null;
if (!$user_id) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Your Orders - Stark Store</title>
	<link rel="icon" type="image/png" href="images/icons/favicon.png" />
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<script src="https://cdn.tailwindcss.com"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</head>

<body class="animsition bg-gray-50">
	<!-- Header -->
	<header class="header-v4">
		<div class="container-menu-desktop">
			<div class="top-bar">
				<div class="content-topbar flex-sb-m h-full container dis-flex justify-content-center">
					<div class="left-top-bar">
						Free shipping for standard orders over ₹1500
					</div>
				</div>
			</div>

			<div class="wrap-menu-desktop">
				<nav class="limiter-menu-desktop container">
					<a href="index.php" class="logo">
						<img src="images/icons/logo-01.png" alt="IMG-LOGO">
					</a>

					<div class="menu-desktop">
						<ul class="main-menu">
							<li><a href="index.php">Home</a></li>
							<li><a href="product.php">Shop</a></li>
							<li class="label1" data-label1="hot"><a href="shoping-cart.php">Your Cart</a></li>
							<li><a href="contact.php">Contact</a></li>
						</ul>
					</div>

					<div class="wrap-icon-header flex-w flex-r-m">
						<div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 js-show-modal-search">
							<i class="zmdi zmdi-search"></i>
						</div>
						<div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti noti-cart js-show-cart" data-notify="0">
							<i class="zmdi zmdi-shopping-cart"></i>
						</div>
						<div class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti noti-wish js-show-wishlist" data-notify="0">
							<i class="zmdi zmdi-favorite-outline"></i>
						</div>
						<div class="dropdown">
							<div class="dis-block d-flex align-items-center icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-22 dropdown-toggle" data-bs-toggle="dropdown">
								<i class="zmdi zmdi-account-circle"></i>
								<span class="h6 m-0 ml-2"><?php echo htmlspecialchars($_SESSION['name'] ?? 'User'); ?></span>
							</div>
							<div class="dropdown-menu border-0 rounded px-3 py-3 shadow" style="background: rgba(255, 255, 255, 0.95); min-width: 180px;">
								<li><a href="orders.php" class="dropdown-item font-weight-bold active">Your Orders</a></li>
								<li><a href="address.php" class="dropdown-item font-weight-bold">Address Details</a></li>
								<div class="dropdown-divider"></div>
								<li><a href="logout.php" class="dropdown-item text-danger font-weight-bold">Logout</a></li>
							</div>
						</div>
					</div>
				</nav>
			</div>
		</div>
	</header>

	<!-- Cart & Wishlist Drawers -->
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

	<!-- Orders Section -->
	<section class="py-12 relative min-h-screen">
		<div class="w-full max-w-5xl px-4 md:px-6 mx-auto">
			<div class="flex items-center justify-between pb-6 border-b border-gray-200 mb-8">
				<div>
					<h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Your Orders</h1>
					<p class="text-sm text-gray-500 mt-1">Track current shipments and view your purchase history.</p>
				</div>
				<a href="product.php" class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm transition">
					Browse Shop
				</a>
			</div>

			<?php
			$order_stmt = $con->prepare("SELECT * FROM user_order WHERE user_id = ? ORDER BY id DESC");
			$order_stmt->bind_param("i", $user_id);
			$order_stmt->execute();
			$orders_res = $order_stmt->get_result();

			if ($orders_res->num_rows > 0) {
				while ($order = $orders_res->fetch_assoc()) {
					$product_ids = json_decode($order['product_id'], true);
					if (!is_array($product_ids)) {
						$product_ids = [];
					}
					// Count quantities of each product ID
					$product_counts = array_count_values(array_map('intval', $product_ids));
					$unique_ids = array_keys($product_counts);
					$status = $order['status'] ?? 'Processing';
			?>
					<div class="bg-white border border-gray-200 rounded-2xl mb-6 shadow-sm overflow-hidden">
						<!-- Order Header -->
						<div class="flex flex-col sm:flex-row sm:items-center justify-between p-6 bg-gray-50/80 border-b border-gray-200 gap-4">
							<div class="space-y-1">
								<div class="flex items-center space-x-3">
									<span class="text-xs uppercase font-bold text-gray-400">Order</span>
									<span class="font-bold text-base text-gray-900 font-mono"><?php echo htmlspecialchars($order['razorpay_order_id'] ?: ('ORD-' . $order['id'])); ?></span>
									<?php if ($status === 'Completed' || $status === 'completed'): ?>
										<span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">Delivered</span>
									<?php elseif ($status === 'Canceled'): ?>
										<span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-100 text-rose-800">Canceled</span>
									<?php else: ?>
										<span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-100 text-indigo-800">Processing</span>
									<?php endif; ?>
								</div>
								<p class="text-xs text-gray-500">
									Placed on <?php echo date('d M Y, h:i A', strtotime($order['created_at'])); ?> &bull; 
									Payment: <span class="font-medium text-gray-700"><?php echo htmlspecialchars($order['payment_method'] ?? 'Online'); ?></span>
								</p>
							</div>

							<div class="flex items-center space-x-3">
								<span class="text-lg font-black text-gray-900 mr-2">₹<?php echo number_format($order['amount'], 2); ?></span>
								
								<a href="order_details.php?id=<?php echo $order['id']; ?>" class="px-4 py-2 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-100 text-xs font-bold transition">
									Details
								</a>

								<?php if ($status !== "Canceled" && $status !== "Completed"): ?>
									<button class="cancel-order-btn px-4 py-2 rounded-xl bg-rose-50 text-rose-700 hover:bg-rose-100 border border-rose-200 text-xs font-bold transition"
										data-order-id="<?php echo htmlspecialchars($order['razorpay_order_id'] ?: $order['id']); ?>"
										data-payment-id="<?php echo htmlspecialchars($order['razorpay_payment_id'] ?? ''); ?>">
										Cancel Order
									</button>
								<?php endif; ?>
							</div>
						</div>

						<!-- Ordered Products List -->
						<div class="p-6 divide-y divide-gray-100">
							<?php
							if (!empty($unique_ids)) {
								$placeholders = implode(',', array_fill(0, count($unique_ids), '?'));
								$types = str_repeat('i', count($unique_ids));
								$p_stmt = $con->prepare("SELECT id, product_name, product_price, product_img FROM product_item WHERE id IN ($placeholders)");
								$p_stmt->bind_param($types, ...$unique_ids);
								$p_stmt->execute();
								$p_res = $p_stmt->get_result();

								while ($p_item = $p_res->fetch_assoc()) {
									$qty = $product_counts[$p_item['id']] ?? 1;
							?>
									<div class="flex items-center justify-between py-4 first:pt-0 last:pb-0">
										<div class="flex items-center space-x-4">
											<div class="w-16 h-16 rounded-xl bg-gray-100 border border-gray-200 overflow-hidden flex-shrink-0">
												<img src="image/product/<?php echo htmlspecialchars($p_item['product_img']); ?>" alt="" class="w-full h-full object-cover">
											</div>
											<div>
												<h3 class="font-bold text-sm text-gray-900">
													<a href="product-detail.php?id=<?php echo $p_item['id']; ?>" class="hover:text-indigo-600 transition">
														<?php echo htmlspecialchars($p_item['product_name']); ?>
													</a>
												</h3>
												<p class="text-xs text-gray-500 mt-1">Quantity: <?php echo $qty; ?> &bull; Unit Price: ₹<?php echo number_format($p_item['product_price'], 2); ?></p>
											</div>
										</div>
										<span class="font-bold text-sm text-gray-900">
											₹<?php echo number_format($p_item['product_price'] * $qty, 2); ?>
										</span>
									</div>
							<?php
								}
								$p_stmt->close();
							} else {
								echo '<p class="text-sm text-gray-400">Order item records archived.</p>';
							}
							?>
						</div>

						<!-- Delivery Address Footer -->
						<div class="px-6 py-3 bg-gray-50 text-xs text-gray-500 border-t border-gray-100 flex items-center justify-between">
							<span class="truncate max-w-lg"><strong>Deliver to:</strong> <?php echo htmlspecialchars($order['address']); ?></span>
						</div>
					</div>
			<?php
				}
				$order_stmt->close();
			} else {
			?>
				<div class="text-center py-16 px-4 bg-white rounded-3xl border border-gray-200 shadow-sm">
					<div class="w-20 h-20 bg-indigo-50 text-indigo-500 rounded-full flex items-center justify-center mx-auto mb-4">
						<i class="zmdi zmdi-shopping-basket text-4xl"></i>
					</div>
					<h3 class="text-xl font-bold text-gray-900">No Orders Yet</h3>
					<p class="text-sm text-gray-500 mt-1 max-w-sm mx-auto">You have not placed any orders yet. Explore our latest arrivals to get started!</p>
					<a href="product.php" class="mt-6 inline-flex px-6 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm transition">
						Start Shopping
					</a>
				</div>
			<?php } ?>
		</div>
	</section>

	<footer class="bg3 p-t-75 p-b-32">
		<div class="container text-center text-gray-400 text-sm">
			<p>&copy; <?php echo date('Y'); ?> Stark Store. All rights reserved.</p>
		</div>
	</footer>

	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
	<script src="vendor/animsition/js/animsition.min.js"></script>
	<script>
		$(document).ready(function () {
			$(".cancel-order-btn").click(function (e) {
				e.preventDefault();
				const orderId = $(this).data('order-id');
				const paymentId = $(this).data('payment-id');

				Swal.fire({
					title: 'Cancel Order?',
					text: "Are you sure you want to cancel this order?",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#e11d48',
					cancelButtonColor: '#64748b',
					confirmButtonText: 'Yes, cancel it',
					cancelButtonText: 'No, keep order'
				}).then((result) => {
					if (result.isConfirmed) {
						$.ajax({
							url: 'refund-config.php',
							method: 'POST',
							data: { order_id: orderId, payment_Id: paymentId },
							dataType: 'json',
							success: function (response) {
								if (response.status === 'success') {
									Swal.fire('Canceled!', response.message, 'success').then(() => {
										location.reload();
									});
								} else {
									Swal.fire('Notice', response.message, 'info');
								}
							},
							error: function () {
								Swal.fire('Error', 'Failed to communicate with server.', 'error');
							}
						});
					}
				});
			});
		});
	</script>
	<script src="js/main.js"></script>
</body>
</html>