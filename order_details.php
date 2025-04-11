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
							Free shipping for standard order over $100
						</div>
					</div>
				</div>

				<div class="wrap-menu-desktop">
					<nav class="limiter-menu-desktop container">

						<!-- Logo desktop -->
						<a href="index.php" class="logo">
							<img src="images/icons/logo-01.png" alt="IMG-LOGO">
						</a>

						<!-- Menu desktop -->
						<div class="menu-desktop">
							<ul class="main-menu">
								<li class="active-menu">
									<a href="index.php">Home</a>
								</li>

								<li>
									<a href="product.php">Shop</a>
								</li>

								<li class="label1" data-label1="hot">
									<a href="shoping-cart.php">Your Cart</a>
								</li>

								<!-- <li>
									<a href="#">Blog</a>
								</li> -->

								<!-- <li>
									<a href="about.php">About</a>
								</li> -->

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
                                if(isset($_SESSION['email']) || isset($_SESSION['google_email'])){
                            ?>
							<div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti noti-cart js-show-cart">
								<i class="zmdi zmdi-shopping-cart"></i>
							</div>
							<div class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti noti-wish js-show-wishlist">
								<i class="zmdi zmdi-favorite-outline"></i>
							</div>
                            <?php
                                }
                            ?>
							<div class="dropdown">
								<div class="dis-block d-flex align-items-center icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-22 dropdown-toggle" data-bs-toggle="dropdown">
									<i class="zmdi zmdi-account-circle"></i>
									<span class="h6 m-0 ml-2"><?php echo isset($_SESSION['name']) ? $_SESSION['name'] : "User"; ?></span>
								</div>
								<div class="dropdown-menu border-0 rounded px-3 py-3" style="background: rgba(255, 255, 255, 0.5);">
									<?php
                                        if(isset($_SESSION['email']) || isset($_SESSION['google_email'])){
                                    ?>
                                        <a href="#" class="dropdown-item font-weight-bold">Profile</a>
									<a href="orders.php" class="dropdown-item font-weight-bold">Your Orders</a>
									<a href="#" class="dropdown-item font-weight-bold">Your Wishlist</a>
									<div class="dropdown-divider"></div>
									<a href="logout.php" class="dropdown-item text-danger font-weight-bold">Logout</a>
                                    <?php
                                        }else{
                                    ?>
                                    <a href="login.php" class="dropdown-item font-weight-bold">Login</a>
                                    <?php
                                        }
                                    ?>
								</div>
							</div>

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
						<a href="shoping-cart.php" class="label1 rs1" data-label1="hot">Cart</a>
					</li>

					<li>
						<!-- <a href="#">Blog</a> -->
					</li>

					<!-- <li>
						<a href="about.php">About</a>
					</li> -->

					<li>
						<a href="contact.php">Contact</a>
					</li>
					<li>
					<li>
						<!-- <a href="index.php">Home</a> -->
						<span class="h6 m-0 ml-2"><?php echo isset($_SESSION['name']) ? $_SESSION['name'] : "User"; ?></span>
						<ul class="sub-menu-m">
							<?php
                                        if(isset($_SESSION['email']) || isset($_SESSION['google_email'])){
                                    ?>
                                        <li><a href="#" class="dropdown-item font-weight-bold">Profile</a></li>
									<li><a href="orders.php" class="dropdown-item font-weight-bold">Your Orders</a></li>
									<li><a href="#" class="dropdown-item font-weight-bold">Your Wishlist</a></li>
									<div class="dropdown-divider"></div>
									<li><a href="logout.php" class="dropdown-item text-danger font-weight-bold">Logout</a></li>
                                    <?php
                                        }else{
                                    ?>
                                    <li><a href="login.php" class="dropdown-item font-weight-bold">Login</a></li>
                                    <?php
                                        }
                                    ?>
						</ul>
						<span class="arrow-main-menu-m">
							<i class="fa fa-angle-right" aria-hidden="true"></i>
						</span>
					</li>
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
				</ul>
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
				<ul class="header-wishlist-wrapitem w-full">
				</ul>
			</div>
		</div>
	</div>
	<!-- order-details -->
	<?php
	if (isset($_GET['id']) && isset($_GET['order_id'])) {
		$order_user = $_GET['id'];
		$order_id = $_GET['order_id'];
		$order_details = mysqli_query($user_order, "SELECT * FROM user_order WHERE razorpay_order_id = '$order_id'");
		if ($order_row = mysqli_fetch_assoc($order_details)) {
	?>
			<div class="container-fluid">

				<div class="container">
					<!-- Title -->
					<div class="d-flex justify-content-between align-items-center py-3">
						<h2 class="h5 mb-0"><a href="#" class="text-muted"><?php echo $order_id ?></a></h2>
					</div>

					<!-- Main content -->
					<div class="row">
						<div class="col-lg-8">
							<!-- Details -->
							<div class="card mb-4">
								<div class="card-body">
									<div class="mb-3 d-flex justify-content-between">
										<div>
											<span class="me-3"><?php echo $order_row['created_at'] ?></span>
											<span class="badge rounded-pill bg-info">SHIPPING</span>
										</div>
										<div class="d-flex">
											<button class="btn btn-link p-0 me-3 d-none d-lg-block btn-icon-text"><span class="text">Invoice</span></button>
										</div>
									</div>
									<table class="table table-borderless">
										<tbody>
											<?php
											$product_ids = json_decode($order_row['product_id']);
											for ($i = 0; $i <= count($product_ids); $i++) {
												$order_product = mysqli_query($user_order, "SELECT * FROM pehunt_user_order.user_order uo JOIN pehunt_product.product_item pi ON CAST(JSON_UNQUOTE(JSON_EXTRACT(uo.product_id, '$[$i]')) AS UNSIGNED) = pi.id ORDER BY uo.id DESC LIMIT 1;");
												if ($row = mysqli_fetch_assoc($order_product)) {
											?>
													<tr>
														<td>
															<div class="d-flex mb-2">
																<div class="flex-shrink-0">
																	<img src="./image/product/<?php echo $row['product_img'] ?>" alt="" width="35" class="img-fluid">
																</div>
																<div class="flex-lg-grow-1 ms-3">
																	<h6 class="small mb-0"><a href="product-detail.php?id=<?php echo $row['id'] ?>&&name=<?php echo $row['product_name'] ?>" class="text-reset"><?php echo $row['product_name'] ?></a></h6>
																	<span class="small">Color: Black</span>
																</div>
															</div>
														</td>
														<td></td>
														<td class="text-end">$<?php echo $row['product_price'] ?></td>
													</tr>
											<?php
												}
											}
											?>
										</tbody>
										<tfoot>
											<tr>
												<td colspan="2">Subtotal</td>
												<td class="text-end">$15699</td>
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
												<strong><?php echo $_SESSION['name'] ?></strong><br>
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
	<?php
		}
	}
	?>
	<footer class="bg3 p-t-75 p-b-32">
			<div class="container">
				<div class="row">
					<div class="col-sm-6 col-lg-3 p-b-50">
						<h4 class="stext-301 cl0 p-b-30">
							Categories
						</h4>

						<ul>
							<li class="p-b-10">
								<a href="product.php?product_target=f" class="stext-107 cl7 hov-cl1 trans-04">
									Women
								</a>
							</li>

							<li class="p-b-10">
								<a href="product.php?product_target=m" class="stext-107 cl7 hov-cl1 trans-04">
									Men
								</a>
							</li>

							<li class="p-b-10">
								<a href="product.php" class="stext-107 cl7 hov-cl1 trans-04">
									Shoes
								</a>
							</li>

							<li class="p-b-10">
								<a href="product.php" class="stext-107 cl7 hov-cl1 trans-04">
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
								<a href="order_details.php" class="stext-107 cl7 hov-cl1 trans-04">
									Track Order
								</a>
							</li>

							<li class="p-b-10">
								<a href="return-policy.php" class="stext-107 cl7 hov-cl1 trans-04">
									Return Policy
								</a>
							</li>

							<li class="p-b-10">
								<a href="orders.php" class="stext-107 cl7 hov-cl1 trans-04">
									Shipping
								</a>
							</li>

							<li class="p-b-10">
								<a href="terms-of-use-and-condition.php" class="stext-107 cl7 hov-cl1 trans-04">
								Terms and Condition
								</a>
							</li>
						</ul>
					</div>

					<div class="col-sm-6 col-lg-3 p-b-50">
						<h4 class="stext-301 cl0 p-b-30">
							GET IN TOUCH
						</h4>
						<p class="stext-107 cl7 size-201">
							care@gmail.com
						</p>

						<p class="stext-107 cl7 size-201">
							Any questions? Let us know in store at Pehunt soultion OPC Pvt Ltd , Office No GF-05, H73, Sector 63 Noida UP 201301
						</p>
						<li>
								<a href="about.php">About</a>
							</li>

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

					<!-- <div class="col-sm-6 col-lg-3 p-b-50">
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
					</div> -->
				</div>

				<div class="p-t-40">
					<p class="stext-107 cl6 txt-center">
						<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
						Copyright &copy;
						<script>
							document.write(new Date().getFullYear());
						</script> All rights reserved | Made with <i
							class="fa fa-heart-o" aria-hidden="true"></i> by <a href="#"
							target="_blank"></a> &amp; distributed by <a href="#"
							target="_blank">PeHunt</a>
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
	<script>
	function fetchWishlistData() {
				$.ajax({
					url: 'wishlist-data-config.php',
					type: 'GET',
					dataType: 'json',
					success: function(response) {
						if (response.status === 'success') {
							$('.noti-wish').attr('data-notify', response.count);
							var wishlistItems = response.data;
							var wishlistHTML = '';

							wishlistItems.forEach(function(item) {
								wishlistHTML += `
                            <li class="header-cart-item flex-w flex-t m-b-12">
                                <div class="header-cart-item-img">
                                    <img src="image/product/${item.product_img}" alt="IMG">
                                </div>
                                <div class="header-cart-item-txt p-t-8">
                                    <a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
                                        ${item.product_name}
                                    </a>
                                    <span class="header-cart-item-info">
                                        ₹ ${item.product_price}
                                    </span>
                                </div>
                            </li>`;
							});
							$('.header-wishlist-wrapitem').html(wishlistHTML);
						} else if (response.status === 'empty') {
							$('.header-wishlist-wrapitem').html('<h1>Add Product</h1>');
							$('.noti-wish').attr('data-notify', 0);
						}
					},
					error: function() {
						console.error('Error fetching wishlist data');
					}
				});
			}
			setInterval(fetchWishlistData, 2000);

			function fetchCartData() {
				$.ajax({
					url: 'cart-data-config.php', // PHP script for fetching cart data
					type: 'GET',
					dataType: 'json',
					success: function(response) {
						if (response.status === 'success') {
							// Update cart count
							$('.noti-cart').attr('data-notify', response.count);

							// Build the cart items HTML
							var cartItems = response.data;
							var cartHTML = '';

							cartItems.forEach(function(item) {
								cartHTML += `
                            <li class="header-cart-item flex-w flex-t m-b-12">
                                <div class="header-cart-item-img">
                                    <img src="image/product/${item.product_img}" alt="IMG">
                                </div>
                                <div class="header-cart-item-txt p-t-8">
                                    <a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
                                        ${item.product_name}
                                    </a>
                                    <span class="header-cart-item-info">
                                        ₹ ${item.product_price}
                                    </span>
                                </div>
                            </li>`;
							});

							// Update cart items in the DOM
							$('.header-cart-wrapitem').html(cartHTML);
						} else if (response.status === 'empty') {
							// Display "Add Product" message when cart is empty
							$('.header-cart-wrapitem').html('<h1>Add Product</h1>');
							$('.noti-cart').attr('data-notify', 0); // Set notify to 0
						}
					},
					error: function() {
						console.error('Error fetching cart data');
					}
				});
			}

			setInterval(fetchCartData, 2000);

			$(document).ready(function() {
				fetchCartData();
				fetchWishlistData();
			});
</script>
	<script src="js/main.js"></script>
</body>

</html>