<!DOCTYPE html>
<html lang="en">

<head>
	<?php
	include("config.php");
	session_start();
	?>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="icon" type="image/png" href="images/icons/favicon.png" />
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
	<script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
	<header class="header-v4">
		<!-- Header desktop -->
		<div class="container-menu-desktop">
			<!-- Topbar -->
			<div class="top-bar">
				<div class="content-topbar flex-sb-m h-full container">
					<div class="left-top-bar">
						Free shipping for standard order over $100
					</div>
				</div>
			</div>

			<div class="wrap-menu-desktop how-shadow1">
				<nav class="limiter-menu-desktop container">

					<!-- Logo desktop -->
					<a href="#" class="logo">
						<img src="images/icons/logo-01.png" alt="IMG-LOGO">
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

							<li class="label1" data-label1="hot">
								<a href="shoping-cart.php">Your Cart</a>
							</li>

							<li>
								<a href="blog.php">Blog</a>
							</li>

							<li>
								<a href="about.php">About</a>
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

						<?php
						$cart_user = $_SESSION['cart'];
						$cart_db = "usercart";
						// Prepare the SQL query
						$cart_table_query = $con->prepare("SELECT COUNT(*) as count FROM information_schema.tables WHERE table_schema = ? AND table_name = ?");
						$cart_table_query->bind_param("ss", $cart_db, $cart_user);
						$cart_table_query->execute();
						$cart_table_result = $cart_table_query->get_result();
						$cart_table_row = $cart_table_result->fetch_assoc();
						if ($cart_table_row['count'] > 0) {
							$cart_details = mysqli_query($cart_info, "SELECT COUNT(*) FROM $cart_user");
						?>
							<div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti js-show-cart"
								data-notify="<?php echo mysqli_num_rows($cart_details) ?>">
								<i class="zmdi zmdi-shopping-cart"></i>
							</div>
						<?php
						} else {
						?>
							<div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 js-show-cart">
								<i class="zmdi zmdi-shopping-cart"></i>
							</div>
						<?php
						}
						?>
						<?php
						$wish_user = $_SESSION['wishlist'];
						$wish_db = "wishlist";
						// Prepare the SQL query
						$wish_table_query = $con->prepare("SELECT COUNT(*) as count FROM information_schema.tables WHERE table_schema = ? AND table_name = ?");
						$wish_table_query->bind_param("ss", $wish_db, $wish_user);
						$wish_table_query->execute();
						$wish_table_result = $wish_table_query->get_result();
						$wish_table_row = $wish_table_result->fetch_assoc();
						if ($wish_table_row['count'] > 0) {
							$wish_details = mysqli_query($wishlist_info, "SELECT * FROM $wish_user");
						?>
							<span
								class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-wishlist"
								data-notify="<?php echo mysqli_num_rows($wish_details) ?>">
								<i class="zmdi zmdi-favorite-outline"></i>
							</span>
						<?php
							// }
						} else {
						?>
							<span
								class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 js-show-wishlist">
								<i class="zmdi zmdi-favorite-outline"></i>
							</span>
						<?php
						}
						?>
						<a href="logout.php"
							class="dis-block d-flex align-items-center icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-22">
							<i class="zmdi zmdi-account-circle"></i>
							<span class="h6 m-0 ml-2"><?php echo $_SESSION['name']; ?></span>
						</a>
					</div>
				</nav>
			</div>
		</div>

		<!-- Header Mobile -->
		<div class="wrap-header-mobile">
			<!-- Logo moblie -->
			<div class="logo-mobile">
				<a href="index.php"><img src="images/icons/logo-01.png" alt="IMG-LOGO"></a>
			</div>

			<!-- Icon header -->
			<div class="wrap-icon-header flex-w flex-r-m m-r-15">
				<div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 js-show-modal-search">
					<i class="zmdi zmdi-search"></i>
				</div>
				<?php
				$cart_user = $_SESSION['cart'];
				$cart_db = "usercart";
				// Prepare the SQL query
				$cart_table_query = $con->prepare("SELECT COUNT(*) as count FROM information_schema.tables WHERE table_schema = ? AND table_name = ?");
				$cart_table_query->bind_param("ss", $cart_db, $cart_user);
				$cart_table_query->execute();
				$cart_table_result = $cart_table_query->get_result();
				$cart_table_row = $cart_table_result->fetch_assoc();
				if ($cart_table_row['count'] > 0) {
					$cart_details = mysqli_query($cart_info, "SELECT COUNT(*) FROM $cart_user");
				?>
					<div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti js-show-cart"
						data-notify="<?php echo mysqli_num_rows($cart_details) ?>">
						<i class="zmdi zmdi-shopping-cart"></i>
					</div>
				<?php
				} else {
				?>
					<div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 js-show-cart">
						<i class="zmdi zmdi-shopping-cart"></i>
					</div>
				<?php
				}
				?>

				<?php
				$wish_user = $_SESSION['wishlist'];
				$wish_db = "wishlist";
				$wish_table_query = $con->prepare("SELECT COUNT(*) as count FROM information_schema.tables WHERE table_schema = ? AND table_name = ?");
				$wish_table_query->bind_param("ss", $wish_db, $wish_user);
				$wish_table_query->execute();
				$wish_table_result = $wish_table_query->get_result();
				$wish_table_row = $wish_table_result->fetch_assoc();
				if ($wish_table_row['count'] > 0) {
					$wish_details = mysqli_query($wishlist_info, "SELECT COUNT(*) FROM $wish_user");
				?>
					<span
						class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-wishlist"
						data-notify="<?php echo mysqli_num_rows($wish_details) ?>">
						<i class="zmdi zmdi-favorite-outline"></i>
					</span>
				<?php
					// }
				} else {
				?>
					<span
						class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 js-show-wishlist">
						<i class="zmdi zmdi-favorite-outline"></i>
					</span>
				<?php
				}
				?>
				<a href="#" class="dis-block d-flex align-items-center icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10">
					<i class="zmdi zmdi-account-circle"></i>
					<span class="h6 m-0 ml-2"><?php echo $_SESSION['name']; ?></span>
				</a>
			</div>

			<!-- Button show menu -->
			<div class="btn-show-menu-mobile hamburger hamburger--squeeze">
				<span class="hamburger-box">
					<span class="hamburger-inner"></span>
				</span>
			</div>
		</div>


		<!-- Menu Mobile -->
		<div class="menu-mobile">
			<ul class="main-menu-m">
				<li>
					<a href="index.php">Home</a>
					<span class="arrow-main-menu-m">
						<i class="fa fa-angle-right" aria-hidden="true"></i>
					</span>
				</li>

				<li>
					<a href="product.php">Shop</a>
				</li>

				<li>
					<a href="shoping-cart.php" class="label1 rs1" data-label1="hot">Features</a>
				</li>

				<li>
					<a href="blog.php">Blog</a>
				</li>

				<li>
					<a href="about.php">About</a>
				</li>

				<li>
					<a href="contact.php">Contact</a>
				</li>
			</ul>
		</div>

		<!-- Modal Search -->
		<div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
			<div class="container-search-header">
				<button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-search">
					<img src="images/icons/icon-close2.png" alt="CLOSE">
				</button>

				<form class="wrap-search-header flex-w p-l-15">
					<button class="flex-c-m trans-04">
						<i class="zmdi zmdi-search"></i>
					</button>
					<input class="plh3" type="text" name="search" placeholder="Search...">
				</form>
			</div>
		</div>
	</header>

	<!-- Cart -->
	<div class="wrap-header-cart js-panel-cart">
		<div class="s-full js-hide-cart"></div>

		<div class="header-cart flex-col-l p-l-65 p-r-25">
			<div class="header-cart-title flex-w flex-sb-m p-b-8">
				<span class="mtext-103 cl2">
					Your Cart
				</span>

				<div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-cart">
					<i class="zmdi zmdi-close"></i>
				</div>
			</div>

			<div class="header-cart-content flex-w js-pscroll">
				<ul class="header-cart-wrapitem w-full">
					<?php
					$cart_user = $_SESSION['cart'];
					$cart_db = "usercart";
					// Prepare the SQL query
					$cart_table_query = $con->prepare("SELECT COUNT(*) as count FROM information_schema.tables WHERE table_schema = ? AND table_name = ?");
					$cart_table_query->bind_param("ss", $cart_db, $cart_user);
					$cart_table_query->execute();
					$cart_table_result = $cart_table_query->get_result();
					$cart_table_row = $cart_table_result->fetch_assoc();
					if ($cart_table_row['count'] > 0) {
						$cart_details = mysqli_query($cart_info, "SELECT * FROM usercart.$cart_user uw JOIN product.product_item pi ON uw.cp_detail = pi.id WHERE uw.cp_detail AND pi.id ");
						while ($cart_fetch = mysqli_fetch_assoc($cart_details)) {
					?>
							<li class="header-cart-item flex-w flex-t m-b-12">
								<div class="header-cart-item-img">
									<img src="image/product/<?php echo $cart_fetch['product_img']; ?>" alt="IMG">
								</div>

								<div class="header-cart-item-txt p-t-8">
									<a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
										<?php echo $cart_fetch['product_name']; ?>
									</a>

									<span class="header-cart-item-info">
										₹ <?php echo $cart_fetch['product_price']; ?>
									</span>
								</div>
							</li>
						<?php
						}
						?>
				</ul>
			<?php
					} else {
			?>
				<h1>Add Product</h1>
			<?php
					}
			?>
			</div>
		</div>
	</div>

	<!-- Wishlist -->
	<div class="wrap-header-wishlist js-panel-wishlist">
		<div class="s-full js-hide-wishlist"></div>

		<div class="header-wishlist flex-col-l p-l-65 p-r-25">
			<div class="header-wishlist-title flex-w flex-sb-m p-b-8">
				<span class="mtext-103 cl2">
					Your Wishlist
				</span>

				<div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-wishlist">
					<i class="zmdi zmdi-close"></i>
				</div>
			</div>

			<div class="header-cart-content flex-w js-pscroll">
				<ul class="header-cart-wrapitem w-full">
					<?php
					$wish_user = $_SESSION['wishlist'];
					$wish_db = "wishlist";
					// Prepare the SQL query
					$wish_table_query = $con->prepare("SELECT COUNT(*) as count FROM information_schema.tables WHERE table_schema = ? AND table_name = ?");
					$wish_table_query->bind_param("ss", $wish_db, $wish_user);
					$wish_table_query->execute();
					$wish_table_result = $wish_table_query->get_result();
					$wish_table_row = $wish_table_result->fetch_assoc();
					if ($wish_table_row['count'] > 0) {
						$wish_details = mysqli_query($wishlist_info, "SELECT * FROM wishlist.$wish_user uw JOIN product.product_item pi ON uw.wp_detail = pi.id WHERE uw.wp_detail AND pi.id ");
						while ($wish_fetch = mysqli_fetch_assoc($wish_details)) {
					?>
							<li class="header-cart-item flex-w flex-t m-b-12">
								<div class="header-cart-item-img">
									<img src="image/product/<?php echo $wish_fetch['product_img']; ?>" alt="IMG">
								</div>

								<div class="header-cart-item-txt p-t-8">
									<a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
										<?php echo $wish_fetch['product_name']; ?>
									</a>

									<span class="header-cart-item-info">
										₹ <?php echo $wish_fetch['product_price']; ?>
									</span>
								</div>
							</li>
						<?php
						}
						?>
				</ul>
			<?php
					} else {
			?>
				<h1>Add Product</h1>
			<?php
					}
			?>
			</div>
		</div>
	</div>
	<!-- order-details -->
	 <?php
	 	if(isset($_GET['id']) && isset($_GET['order_id'])){
			echo $_GET['id'];
			echo $_GET['order_id'];
		}
	 ?>
	<div class="container-fluid">

		<div class="container">
			<!-- Title -->
			<div class="d-flex justify-content-between align-items-center py-3">
				<h2 class="h5 mb-0"><a href="#" class="text-muted"></a> Order #16123222</h2>
			</div>

			<!-- Main content -->
			<div class="row">
				<div class="col-lg-8">
					<!-- Details -->
					<div class="card mb-4">
						<div class="card-body">
							<div class="mb-3 d-flex justify-content-between">
								<div>
									<span class="me-3">22-11-2021</span>
									<span class="me-3">#16123222</span>
									<span class="me-3">Visa -1234</span>
									<span class="badge rounded-pill bg-info">SHIPPING</span>
								</div>
								<div class="d-flex">
									<button class="btn btn-link p-0 me-3 d-none d-lg-block btn-icon-text"><i class="bi bi-download"></i> <span class="text">Invoice</span></button>
									<div class="dropdown">
										<button class="btn btn-link p-0 text-muted" type="button" data-bs-toggle="dropdown">
											<i class="bi bi-three-dots-vertical"></i>
										</button>
										<ul class="dropdown-menu dropdown-menu-end">
											<li><a class="dropdown-item" href="#"><i class="bi bi-pencil"></i> Edit</a></li>
											<li><a class="dropdown-item" href="#"><i class="bi bi-printer"></i> Print</a></li>
										</ul>
									</div>
								</div>
							</div>
							<table class="table table-borderless">
								<tbody>
									<tr>
										<td>
											<div class="d-flex mb-2">
												<div class="flex-shrink-0">
													<img src="https://www.bootdey.com/image/280x280/87CEFA/000000" alt="" width="35" class="img-fluid">
												</div>
												<div class="flex-lg-grow-1 ms-3">
													<h6 class="small mb-0"><a href="#" class="text-reset">Wireless Headphones with Noise Cancellation Tru Bass Bluetooth HiFi</a></h6>
													<span class="small">Color: Black</span>
												</div>
											</div>
										</td>
										<td>1</td>
										<td class="text-end">$79.99</td>
									</tr>
									<tr>
										<td>
											<div class="d-flex mb-2">
												<div class="flex-shrink-0">
													<img src="https://www.bootdey.com/image/280x280/FF69B4/000000" alt="" width="35" class="img-fluid">
												</div>
												<div class="flex-lg-grow-1 ms-3">
													<h6 class="small mb-0"><a href="#" class="text-reset">Smartwatch IP68 Waterproof GPS and Bluetooth Support</a></h6>
													<span class="small">Color: White</span>
												</div>
											</div>
										</td>
										<td>1</td>
										<td class="text-end">$79.99</td>
									</tr>
								</tbody>
								<tfoot>
									<tr>
										<td colspan="2">Subtotal</td>
										<td class="text-end">$159,98</td>
									</tr>
									<tr>
										<td colspan="2">Shipping</td>
										<td class="text-end">$20.00</td>
									</tr>
									<tr>
										<td colspan="2">Discount (Code: NEWYEAR)</td>
										<td class="text-danger text-end">-$10.00</td>
									</tr>
									<tr class="fw-bold">
										<td colspan="2">TOTAL</td>
										<td class="text-end">$169,98</td>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
					<!-- Payment -->
					<div class="card mb-4">
						<div class="card-body">
							<div class="row">
								<div class="col-lg-6">
									<h3 class="h6">Payment Method</h3>
									<p>Visa -1234 <br>
										Total: $169,98 <span class="badge bg-success rounded-pill">PAID</span></p>
								</div>
								<div class="col-lg-6">
									<h3 class="h6">Billing address</h3>
									<address>
										<strong>John Doe</strong><br>
										1355 Market St, Suite 900<br>
										San Francisco, CA 94103<br>
										<abbr title="Phone">P:</abbr> (123) 456-7890
									</address>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-4">
					<!-- Customer Notes -->
					<div class="card mb-4">
						<div class="card-body">
							<h3 class="h6">Customer Notes</h3>
							<p>Sed enim, faucibus litora velit vestibulum habitasse. Cras lobortis cum sem aliquet mauris rutrum. Sollicitudin. Morbi, sem tellus vestibulum porttitor.</p>
						</div>
					</div>
					<div class="card mb-4">
						<!-- Shipping information -->
						<div class="card-body">
							<h3 class="h6">Shipping Information</h3>
							<strong>FedEx</strong>
							<span><a href="#" class="text-decoration-underline" target="_blank">FF1234567890</a> <i class="bi bi-box-arrow-up-right"></i> </span>
							<hr>
							<h3 class="h6">Address</h3>
							<address>
								<strong>John Doe</strong><br>
								1355 Market St, Suite 900<br>
								San Francisco, CA 94103<br>
								<abbr title="Phone">P:</abbr> (123) 456-7890
							</address>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<footer class="bg3 p-t-75 p-b-32">
		<div class="container">
			<div class="row">
				<div class="col-sm-6 col-lg-3 p-b-50">
					<h4 class="stext-301 cl0 p-b-30">
						Categories
					</h4>

					<ul>
						<li class="p-b-10">
							<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
								Women
							</a>
						</li>

						<li class="p-b-10">
							<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
								Men
							</a>
						</li>

						<li class="p-b-10">
							<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
								Shoes
							</a>
						</li>

						<li class="p-b-10">
							<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
								Watches
							</a>
						</li>
					</ul>
				</div>

				<div class="col-sm-6 col-lg-3 p-b-50">
					<h4 class="stext-301 cl0 p-b-30">
						Help
					</h4>

					<ul>
						<li class="p-b-10">
							<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
								Track Order
							</a>
						</li>

						<li class="p-b-10">
							<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
								Returns
							</a>
						</li>

						<li class="p-b-10">
							<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
								Shipping
							</a>
						</li>

						<li class="p-b-10">
							<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
								FAQs
							</a>
						</li>
					</ul>
				</div>

				<div class="col-sm-6 col-lg-3 p-b-50">
					<h4 class="stext-301 cl0 p-b-30">
						GET IN TOUCH
					</h4>

					<p class="stext-107 cl7 size-201">
						Any questions? Let us know in store at 8th floor, 379 Hudson St, New York, NY 10018 or call us
						on (+1) 96 716 6879
					</p>

					<div class="p-t-27">
						<a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
							<i class="fa fa-facebook"></i>
						</a>

						<a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
							<i class="fa fa-instagram"></i>
						</a>

						<a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
							<i class="fa fa-pinterest-p"></i>
						</a>
					</div>
				</div>

				<div class="col-sm-6 col-lg-3 p-b-50">
					<h4 class="stext-301 cl0 p-b-30">
						Newsletter
					</h4>

					<form>
						<div class="wrap-input1 w-full p-b-4">
							<input class="input1 bg-none plh1 stext-107 cl7" type="text" name="email"
								placeholder="email@example.com">
							<div class="focus-input1 trans-04"></div>
						</div>

						<div class="p-t-18">
							<button class="flex-c-m stext-101 cl0 size-103 bg1 bor1 hov-btn2 p-lr-15 trans-04">
								Subscribe
							</button>
						</div>
					</form>
				</div>
			</div>

			<div class="p-t-40">
				<div class="flex-c-m flex-w p-b-18">
					<a href="#" class="m-all-1">
						<img src="images/icons/icon-pay-01.png" alt="ICON-PAY">
					</a>

					<a href="#" class="m-all-1">
						<img src="images/icons/icon-pay-02.png" alt="ICON-PAY">
					</a>

					<a href="#" class="m-all-1">
						<img src="images/icons/icon-pay-03.png" alt="ICON-PAY">
					</a>

					<a href="#" class="m-all-1">
						<img src="images/icons/icon-pay-04.png" alt="ICON-PAY">
					</a>

					<a href="#" class="m-all-1">
						<img src="images/icons/icon-pay-05.png" alt="ICON-PAY">
					</a>
				</div>

				<p class="stext-107 cl6 txt-center">
					<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
					Copyright &copy;
					<script>
						document.write(new Date().getFullYear());
					</script> All rights reserved | Made with <i
						class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com"
						target="_blank">Colorlib</a> &amp; distributed by <a href="https://themewagon.com"
						target="_blank">ThemeWagon</a>
					<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->

				</p>
			</div>
		</div>
	</footer>

	<div class="btn-back-to-top" id="myBtn">
		<span class="symbol-btn-back-to-top">
			<i class="zmdi zmdi-chevron-up"></i>
		</span>
	</div>

	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
	<script src="vendor/animsition/js/animsition.min.js"></script>
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="vendor/select2/select2.min.js"></script>
	<script>
		$(".js-select2").each(function() {
			$(this).select2({
				minimumResultsForSearch: 20,
				dropdownParent: $(this).next('.dropDownSelect2')
			});
		})
	</script>
	<script src="vendor/MagnificPopup/jquery.magnific-popup.min.js"></script>
	<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
	<script>
		$('.js-pscroll').each(function() {
			$(this).css('position', 'relative');
			$(this).css('overflow', 'hidden');
			var ps = new PerfectScrollbar(this, {
				wheelSpeed: 1,
				scrollingThreshold: 1000,
				wheelPropagation: false,
			});

			$(window).on('resize', function() {
				ps.update();
			})
		});
	</script>
	<script>
		$(document).ready(function() {
			$("#cardPayment").slideUp(10);
			// Listen for changes on payment method radio buttons
			$(".peer").on("change", function() {
				if ($("#Card").is(':checked')) {
					$("#cardPayment").slideDown();
				} else {
					$("#cardPayment").slideDown();

				}
			});
		});
	</script>
	<script src="js/main.js"></script>
</body>

</html>