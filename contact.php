<!DOCTYPE html>
<html lang="en">
<?php
session_start();
include ('config.php');
$product = "select * from product_item";
$wishlist_data = "select * from wishlist";
// if (isset($_SESSION['email']) && isset($_SESSION['password'])) {

	if(isset($_POST['send'])){
		$mail = $_POST['email'];
		$msg = $_POST['msg'];
		$send_query = mysqli_query($fandq_info, "INSERT INTO queries (email, message) VALUES ('$mail', '$msg')");
	}

	?>
<head>
	<title>Contact</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">	
	<link rel="icon" type="image/png" href="images/icons/favicon.png"/>
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
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</head>
<body class="animsition">
	
	<!-- Header -->
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

								<li>
									<!-- <a href="#">Blog</a> -->
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

					<li>
						<a href="about.php">About</a>
					</li>

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

	<!-- Title page -->
	<section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('images/bg-01.jpg');">
		<h2 class="ltext-105 cl0 txt-center">
			Contact
		</h2>
	</section>	


	<!-- Content page -->
	<section class="bg0 p-t-104 p-b-116">
		<div class="container">
			<div class="flex-w flex-tr">
				<div class="size-210 bor10 p-lr-70 p-t-55 p-b-70 p-lr-15-lg w-full-md">
					<form method="POST">
						<h4 class="mtext-105 cl2 txt-center p-b-30">
							Send Us A Message
						</h4>

						<div class="bor8 m-b-20 how-pos4-parent">
							<input class="stext-111 cl2 plh3 size-116 p-l-62 p-r-30" type="email" name="email" placeholder="Your Email Address">
							<img class="how-pos4 pointer-none" src="images/icons/icon-email.png" alt="ICON">
						</div>

						<div class="bor8 m-b-30">
							<textarea class="stext-111 cl2 plh3 size-120 p-lr-28 p-tb-25" name="msg" placeholder="How Can We Help?"></textarea>
						</div>

						<button class="flex-c-m stext-101 cl0 size-121 bg3 bor1 hov-btn3 p-lr-15 trans-04 pointer" name="send">
							Submit
						</button>
					</form>
				</div>

				<div class="size-210 bor10 flex-w flex-col-m p-lr-93 p-tb-30 p-lr-15-lg w-full-md">
					<div class="flex-w w-full p-b-42">
						<span class="fs-18 cl5 txt-center size-211">
							<span class="lnr lnr-map-marker"></span>
						</span>

						<div class="size-212 p-t-2">
							<span class="mtext-110 cl2">
								Address
							</span>

							<p class="stext-115 cl6 size-213 p-t-18">
							Pehunt soultion OPC Pvt Ltd , Office No GF-05, H73, Sector 63 Noida UP 201301
							</p>
						</div>
					</div>

					<div class="flex-w w-full p-b-42">
						<span class="fs-18 cl5 txt-center size-211">
							<span class="lnr lnr-phone-handset"></span>
						</span>

						<div class="size-212 p-t-2">
							<span class="mtext-110 cl2">
								Lets Talk
							</span>

							<p class="stext-115 cl1 size-213 p-t-18">
								+91 9220747031
							</p>
						</div>
					</div>

					<div class="flex-w w-full">
						<span class="fs-18 cl5 txt-center size-211">
							<span class="lnr lnr-envelope"></span>
						</span>

						<div class="size-212 p-t-2">
							<span class="mtext-110 cl2">
								Sale Support
							</span>

							<p class="stext-115 cl1 size-213 p-t-18">
								care@pehunt.com
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>	
	
	
	<!-- Map -->
	<!-- <div class="map">
		<div class="size-303" id="google_map" data-map-x="40.691446" data-map-y="-73.886787" data-pin="images/icons/pin.png" data-scrollwhell="0" data-draggable="1" data-zoom="11"></div>
	</div> -->



	<!-- Footer -->
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
								 Terms & Conditions
								</a>
							</li>
						</ul>
					</div>

					<div class="col-sm-6 col-lg-3 p-b-50">
						<h4 class="stext-301 cl0 p-b-30">
							GET IN TOUCH
						</h4>

						<p class="stext-107 cl7 size-201">
							Any questions? Let us know in store at Pehunt soultion OPC Pvt Ltd , Office No GF-05, H73, Sector 63 Noida UP 201301
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


	<!-- Back to top -->
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
		$(".js-select2").each(function(){
			$(this).select2({
				minimumResultsForSearch: 20,
				dropdownParent: $(this).next('.dropDownSelect2')
			});
		})
	</script>
	<script src="vendor/MagnificPopup/jquery.magnific-popup.min.js"></script>
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
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAKFWBqlKAGCeS1rMVoaNlwyayu0e0YRes"></script>
	<script src="js/map-custom.js"></script>
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
	<?php
// }
?>
 <script>
    if (window.history.replaceState) {
      window.history.replaceState(null, null, window.location.href);
    }
  </script>
</body>
</html>