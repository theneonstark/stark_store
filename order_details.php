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
$order_id = isset($_GET['id']) ? intval($_GET['id']) : (isset($_GET['order_id']) ? $_GET['order_id'] : 0);

if (!$user_id || empty($order_id)) {
    header('Location: orders.php');
    exit;
}

// Fetch order
if (is_numeric($order_id)) {
    $stmt = $con->prepare("SELECT * FROM user_order WHERE id = ? AND (user_id = ? OR 1 = ?)");
    $is_admin = (isset($_SESSION['office']) && $_SESSION['office'] == 1) ? 1 : 0;
    $stmt->bind_param("iii", $order_id, $user_id, $is_admin);
} else {
    $stmt = $con->prepare("SELECT * FROM user_order WHERE razorpay_order_id = ? AND (user_id = ? OR 1 = ?)");
    $is_admin = (isset($_SESSION['office']) && $_SESSION['office'] == 1) ? 1 : 0;
    $stmt->bind_param("sii", $order_id, $user_id, $is_admin);
}
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$order) {
    header('Location: orders.php');
    exit;
}

$product_ids = json_decode($order['product_id'], true) ?: [];
$product_counts = array_count_values(array_map('intval', $product_ids));
$unique_ids = array_keys($product_counts);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Order #<?php echo htmlspecialchars($order['razorpay_order_id'] ?: $order['id']); ?> - Pehunt</title>
	<link rel="icon" type="image/png" href="images/icons/favicon.png" />
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600&family=Outfit:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/modern-stark.css">
	<script src="https://cdn.tailwindcss.com"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</head>

<body class="animsition bg-gray-50">
	<header class="header-v4">
		<div class="container-menu-desktop">
			<div class="top-bar">
				<div class="content-topbar flex-sb-m h-full container dis-flex justify-content-center">
					<div class="left-top-bar">
						Free Express Shipping on Orders Over ₹999 &nbsp;|&nbsp; ⚡ 100% Secure Checkout
					</div>
				</div>
			</div>

			<div class="wrap-menu-desktop">
				<nav class="limiter-menu-desktop container">
					<a href="index.php" class="logo d-flex align-items-center">
						<img src="images/icons/logo-pehunt-dark.png" alt="PEHUNT" style="height: 42px; width: auto; max-width: 175px; object-fit: contain;">
					</a>

					<div class="menu-desktop">
						<ul class="main-menu">
							<li><a href="index.php">Home</a></li>
							<li><a href="product.php">Shop</a></li>
							<li><a href="orders.php">Your Orders</a></li>
							<li><a href="contact.php">Contact</a></li>
						</ul>
					</div>
				</nav>
			</div>
		</div>
	</header>

	<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
		<div class="mb-6 flex items-center justify-between">
			<div class="flex items-center space-x-2 text-sm text-gray-500">
				<a href="index.php" class="hover:text-gray-900">Home</a>
				<span>/</span>
				<a href="orders.php" class="hover:text-gray-900">Orders</a>
				<span>/</span>
				<span class="text-gray-900 font-semibold">Order Details</span>
			</div>
			<a href="orders.php" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800">
				&larr; Back to all orders
			</a>
		</div>

		<div class="bg-white rounded-3xl border border-gray-200 shadow-sm overflow-hidden p-6 sm:p-10 space-y-8">
			<!-- Order Title Bar -->
			<div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 border-b border-gray-200 gap-4">
				<div>
					<div class="flex items-center space-x-3">
						<h1 class="text-2xl font-black text-gray-900 font-mono">
							<?php echo htmlspecialchars($order['razorpay_order_id'] ?: ('ORD-' . $order['id'])); ?>
						</h1>
						<?php 
							$status = $order['status'] ?? 'Processing';
							if ($status === 'Completed' || $status === 'completed'): 
						?>
							<span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">Delivered</span>
						<?php elseif ($status === 'Canceled'): ?>
							<span class="px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-800">Canceled</span>
						<?php else: ?>
							<span class="px-3 py-1 rounded-full text-xs font-bold bg-indigo-100 text-indigo-800">Processing</span>
						<?php endif; ?>
					</div>
					<p class="text-xs text-gray-500 mt-1">Placed on <?php echo date('d M Y, h:i A', strtotime($order['created_at'])); ?></p>
				</div>

				<div class="text-right">
					<span class="text-xs uppercase font-bold text-gray-400">Total Paid</span>
					<p class="text-2xl font-black text-gray-900">₹<?php echo number_format($order['amount'], 2); ?></p>
				</div>
			</div>

			<!-- Delivery Address & Payment Summary -->
			<div class="grid sm:grid-cols-2 gap-6 p-6 rounded-2xl bg-gray-50 border border-gray-200">
				<div>
					<h3 class="text-xs uppercase font-bold text-gray-500 tracking-wider mb-2">Shipping Address</h3>
					<p class="text-sm font-medium text-gray-800 leading-relaxed"><?php echo htmlspecialchars($order['address']); ?></p>
				</div>
				<div>
					<h3 class="text-xs uppercase font-bold text-gray-500 tracking-wider mb-2">Payment Details</h3>
					<p class="text-sm font-medium text-gray-800">Method: <strong><?php echo htmlspecialchars($order['payment_method'] ?? 'Online'); ?></strong></p>
					<?php if (!empty($order['razorpay_payment_id'])): ?>
						<p class="text-xs text-gray-500 mt-1 font-mono">Ref ID: <?php echo htmlspecialchars($order['razorpay_payment_id']); ?></p>
					<?php endif; ?>
				</div>
			</div>

			<!-- Product Line Items -->
			<div>
				<h3 class="text-lg font-bold text-gray-900 mb-4">Items in this order</h3>
				<div class="divide-y divide-gray-100 border border-gray-200 rounded-2xl overflow-hidden">
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
							<div class="flex items-center justify-between p-4 sm:p-5 hover:bg-gray-50/50 transition">
								<div class="flex items-center space-x-4">
									<div class="w-16 h-16 rounded-xl bg-gray-100 border border-gray-200 overflow-hidden flex-shrink-0">
										<img src="image/product/<?php echo htmlspecialchars($p_item['product_img']); ?>" alt="" class="w-full h-full object-cover">
									</div>
									<div>
										<h4 class="font-bold text-sm text-gray-900">
											<a href="product-detail.php?id=<?php echo $p_item['id']; ?>" class="hover:text-indigo-600 transition">
												<?php echo htmlspecialchars($p_item['product_name']); ?>
											</a>
										</h4>
										<p class="text-xs text-gray-500 mt-1">Quantity: <?php echo $qty; ?> &times; ₹<?php echo number_format($p_item['product_price'], 2); ?></p>
									</div>
								</div>
								<span class="font-bold text-base text-gray-900">
									₹<?php echo number_format($p_item['product_price'] * $qty, 2); ?>
								</span>
							</div>
					<?php
						}
						$p_stmt->close();
					}
					?>
				</div>
			</div>
		</div>
	</div>

	<footer class="bg3 p-t-75 p-b-32 mt-16">
		<div class="container text-center text-gray-400 text-sm">
			<p>&copy; <?php echo date('Y'); ?> Pehunt. All rights reserved.</p>
		</div>
	</footer>

	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
	<script src="vendor/animsition/js/animsition.min.js"></script>
	<script src="js/main.js"></script>
</body>
</html>