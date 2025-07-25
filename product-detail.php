<!DOCTYPE html>
<html lang="en">
<?php
include('config.php');
mysqli_set_charset($product_info, "utf8mb4");
session_start();
?>

<head>
	<title>Product Detail</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="images/icons/favicon.png" />
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/linearicons-v1.0.0/icon-font.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
	<link rel="stylesheet" type="text/css" href="vendor/slick/slick.css">
	<link rel="stylesheet" type="text/css" href="vendor/MagnificPopup/magnific-popup.css">
	<link rel="stylesheet" type="text/css" href="vendor/perfect-scrollbar/perfect-scrollbar.css">
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/swiper.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
	<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
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

					<!-- <li>
						<a href="#">Blog</a>
					</li> -->

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

	<?php
	if (isset($_GET['id']) && isset($_GET['name'])) {
		$product_id = $_GET['id'];
		$product_name = $_GET['name'];
		$query = "SELECT * FROM product_item LEFT JOIN product_images ON product_item.product_related_img = product_images.pr_id LEFT JOIN product_category ON product_item.product_catg = product_category.pc_id WHERE product_item.id = ?";
		$stmt = $product_info->prepare($query);
		$stmt->bind_param('i', $product_id);
		$stmt->execute();
		$result = $stmt->get_result();
		$product_details = $result->fetch_assoc();
		if ($product_details) {
			$pr_img = json_decode($product_details['pr_imgs']);
	?>
			<!-- breadcrumb -->
			<div class="container">
				<div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
					<a href="index.php" class="stext-109 cl8 hov-cl1 trans-04">
						Home
						<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
					</a>

					<a href="product.php" class="stext-109 cl8 hov-cl1 trans-04">
						Men
						<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
					</a>

					<span class="stext-109 cl4">
						<?php echo $product_details['product_name'] ?>
					</span>
				</div>
			</div>

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

			<!-- Product Detail -->
			<section class="sec-product-detail bg0 p-t-65 p-b-60">
				<div class="container">
					<div class="row">
						<div class="col-md-6 col-lg-7 p-b-30">
							<div class="p-l-25 p-r-30 p-lr-0-lg">
								<div class="swiper mySwiper2">
									<div class="swiper-wrapper">
										<div class="swiper-slide">
											<img src="image/product/<?php echo $product_details['product_img'] ?>" />
										</div>
										<div class="swiper-slide">
											<img src="image/product/pr_imgs/<?php echo $pr_img[0] ?>" />
										</div>
										<div class="swiper-slide">
											<img src="image/product/pr_imgs/<?php echo $pr_img[1] ?>" />
										</div>
										<div class="swiper-slide">
											<img src="image/product/pr_imgs/<?php echo $pr_img[2] ?>" />
										</div>
									</div>
								</div>
								<div class="swiper mySwiper">
									<div class="swiper-wrapper">
										<div class="swiper-zoom-container">
											<img src="https://swiperjs.com/demos/images/nature-1.jpg" />
										</div>
										<div class="swiper-slide">
											<img src="image/product/<?php echo $product_details['product_img'] ?>" />
										</div>
										<div class="swiper-slide">
											<img src="image/product/pr_imgs/<?php echo $pr_img[0] ?>" />
										</div>
										<div class="swiper-slide">
											<img src="image/product/pr_imgs/<?php echo $pr_img[1] ?>" />
										</div>
										<div class="swiper-slide">
											<img src="image/product/pr_imgs/<?php echo $pr_img[2] ?>" />
										</div>
									</div>
								</div>
								<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

								<!-- Initialize Swiper -->
								<script>
									var swiper = new Swiper(".mySwiper", {
										loop: true,
										spaceBetween: 10,
										slidesPerView: 4,
										freeMode: true,
										watchSlidesProgress: true,
									});
									var swiper2 = new Swiper(".mySwiper2", {
										loop: true,
										spaceBetween: 10,
										thumbs: {
											swiper: swiper,
										},
									});
								</script>
							</div>
						</div>

						<div class="col-md-6 col-lg-5 p-b-30">
							<div class="p-r-50 p-t-5 p-lr-0-lg">
								<h4 class="mtext-105 cl2 js-name-detail p-b-14">
									<?php echo $product_details['product_name'] ?>
								</h4>

								<span class="mtext-106 cl2">
									<?php echo $product_details['product_price'] ?>
								</span>

								<p class="stext-102 cl3 p-t-23">
									<?php echo $product_details['product_description'] ?>
								</p>

								<!--  -->
								<div class="p-t-33">
									<div class="flex-w flex-r-m p-b-10">
										<div class="size-203 flex-c-m respon6">
											Size
										</div>

										<div class="size-204 respon6-next">
											<div class="rs1-select2 bor8 bg0">
												<select class="js-select2" name="time">
													<option>Choose an option</option>
													<option>Size S</option>
													<option>Size M</option>
													<option>Size L</option>
													<option>Size XL</option>
												</select>
												<div class="dropDownSelect2"></div>
											</div>
										</div>
									</div>

									<div class="flex-w flex-r-m p-b-10">
										<div class="size-203 flex-c-m respon6">
											Color
										</div>

										<div class="size-204 respon6-next">
											<div class="rs1-select2 bor8 bg0">
												<select class="js-select2" name="time">
													<option>Choose an option</option>
													<option>Red</option>
													<option>Blue</option>
													<option>White</option>
													<option>Grey</option>
												</select>
												<div class="dropDownSelect2"></div>
											</div>
										</div>
									</div>

									<div class="flex-w flex-r-m p-b-10">
										<div class="size-204 flex-w flex-m respon6-next">
											<div class="wrap-num-product flex-w m-r-20 m-tb-10">
												<div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
													<i class="fs-16 zmdi zmdi-minus"></i>
												</div>

												<input class="mtext-104 cl3 txt-center num-product" type="number"
													name="num-product" value="1">

												<div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
													<i class="fs-16 zmdi zmdi-plus"></i>
												</div>
											</div>

											<!-- <form action="cart_config.php" method="POST" class="cartForm">
												<input type="hidden" value="" name="cart_product" id="product_cart_details">
												<input type="hidden" value="<?php echo isset($_SESSION['cart']) ? $_SESSION['cart'] : "" ; ?>" name="cart">
												<button type="submit"
													class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail">
													Add to cart
												</button>
											</form> -->
											<form action="checkout.php" method="POST">
												<input type="hidden" value="<?php echo $product_details['id'] ?>" name="check_id[]" id="product_buy_details">
												<input type="hidden" value="<?php echo $product_details['product_price'] ?>" name="check_price[]" id="product_buy_price">
												<button name="checkout"
													class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail">
													Buy Now
												</button>
											</form>
										</div>
									</div>
								</div>

								<!--  -->
								<div class="flex-w flex-m p-l-100 p-t-40 respon7">
									<div class="flex-m bor9 p-r-10 m-r-11">
									<form action="wishlist_config.php" method="POST" class="wishlistForm">
											<input type="hidden" value="<?php echo $fetch_product['id'] ?>" name="wish_product">
											<input type="hidden" value="<?php echo isset($_SESSION['wishlist']) ? $_SESSION['wishlist'] : "" ; ?>" name="wish">
											<button class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
												<img class="icon-heart1 dis-block trans-04" src="images/icons/icon-heart-01.png"
													alt="ICON">
												<img class="icon-heart2 dis-block trans-04 ab-t-l"
													src="images/icons/icon-heart-02.png" alt="ICON">
											</button>
										</form>
									</div>

									<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
										data-tooltip="Facebook">
										<i class="fa fa-facebook"></i>
									</a>

									<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
										data-tooltip="Twitter">
										<i class="fa fa-twitter"></i>
									</a>

									<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
										data-tooltip="Google Plus">
										<i class="fa fa-google-plus"></i>
									</a>
								</div>
							</div>
						</div>
					</div>

					<div class="bor10 m-t-50 p-t-43 p-b-40">
						<!-- Tab01 -->
						<div class="tab01">
							<!-- Nav tabs -->
							<ul class="nav nav-tabs" role="tablist">
								<li class="nav-item p-b-10">
									<a class="nav-link active" data-toggle="tab" href="#description" role="tab">Description</a>
								</li>

								<li class="nav-item p-b-10">
									<a class="nav-link" data-toggle="tab" href="#information" role="tab">Additional
										information</a>
								</li>

								<li class="nav-item p-b-10">
									<a class="nav-link" data-toggle="tab" href="#reviews" role="tab">Reviews (1)</a>
								</li>
							</ul>

							<!-- Tab panes -->
							<div class="tab-content p-t-43">
								<!-- - -->
								<div class="tab-pane fade show active" id="description" role="tabpanel">
									<div class="how-pos2 p-lr-15-md">
										<p class="stext-102 cl6">
										Discover the perfect blend of quality, style, and value with this must-have item. Designed to meet your everyday needs, this product offers exceptional performance and durability, making it a great addition to your lifestyle. Whether you're shopping for yourself or looking for the perfect gift, this product delivers satisfaction with every use. Crafted with care and precision, it complements a wide range of preferences and purposes. Shop now and experience the difference!
										</p>
									</div>
								</div>

								<!-- - -->
								<div class="tab-pane fade" id="information" role="tabpanel">
									<div class="row">
										<div class="col-sm-10 col-md-8 col-lg-6 m-lr-auto">
											<ul class="p-lr-28 p-lr-15-sm">
												<li class="flex-w flex-t p-b-7">
													<span class="stext-102 cl3 size-205">
														Weight
													</span>

													<span class="stext-102 cl6 size-206">
														0.79 kg
													</span>
												</li>

												<li class="flex-w flex-t p-b-7">
													<span class="stext-102 cl3 size-205">
														Dimensions
													</span>

													<span class="stext-102 cl6 size-206">
														110 x 33 x 100 cm
													</span>
												</li>

												<li class="flex-w flex-t p-b-7">
													<span class="stext-102 cl3 size-205">
														Materials
													</span>

													<span class="stext-102 cl6 size-206">
														60% cotton
													</span>
												</li>

												<li class="flex-w flex-t p-b-7">
													<span class="stext-102 cl3 size-205">
														Color
													</span>

													<span class="stext-102 cl6 size-206">
														Black, Blue, Grey, Green, Red, White
													</span>
												</li>

												<li class="flex-w flex-t p-b-7">
													<span class="stext-102 cl3 size-205">
														Size
													</span>

													<span class="stext-102 cl6 size-206">
														XL, L, M, S
													</span>
												</li>
											</ul>
										</div>
									</div>
								</div>

								<!-- - -->
								<div class="tab-pane fade" id="reviews" role="tabpanel">
									<div class="row">
										<div class="col-sm-10 col-md-8 col-lg-6 m-lr-auto">
											<div class="p-b-30 m-lr-15-sm">
												<!-- Review -->
												<div class="flex-w flex-t p-b-68">
													<div class="wrap-pic-s size-109 bor0 of-hidden m-r-18 m-t-6">
														<img src="images/avatar-01.jpg" alt="AVATAR">
													</div>

													<!-- <div class="size-207">
														<div class="flex-w flex-sb-m p-b-17">
															<span class="mtext-107 cl2 p-r-20">
																Ariana Grande
															</span>

															<span class="fs-18 cl11">
																<i class="zmdi zmdi-star"></i>
																<i class="zmdi zmdi-star"></i>
																<i class="zmdi zmdi-star"></i>
																<i class="zmdi zmdi-star"></i>
																<i class="zmdi zmdi-star-half"></i>
															</span>
														</div>

														<p class="stext-102 cl6">
															Quod autem in homine praestantissimum atque optimum est, id
															deseruit. Apud ceteros autem philosophos
														</p>
													</div> -->
												</div>

												<!-- Add review -->
												<form class="w-full">
													<h5 class="mtext-108 cl2 p-b-7">
														Add a review
													</h5>

													<p class="stext-102 cl6">
														Your email address will not be published. Required fields are marked *
													</p>

													<div class="flex-w flex-m p-t-50 p-b-23">
														<span class="stext-102 cl3 m-r-16">
															Your Rating
														</span>

														<span class="wrap-rating fs-18 cl11 pointer">
															<i class="item-rating pointer zmdi zmdi-star-outline"></i>
															<i class="item-rating pointer zmdi zmdi-star-outline"></i>
															<i class="item-rating pointer zmdi zmdi-star-outline"></i>
															<i class="item-rating pointer zmdi zmdi-star-outline"></i>
															<i class="item-rating pointer zmdi zmdi-star-outline"></i>
															<input class="dis-none" type="number" name="rating">
														</span>
													</div>

													<div class="row p-b-25">
														<div class="col-12 p-b-5">
															<label class="stext-102 cl3" for="review">Your review</label>
															<textarea class="size-110 bor8 stext-102 cl2 p-lr-20 p-tb-10"
																id="review" name="review"></textarea>
														</div>

														<div class="col-sm-6 p-b-5">
															<label class="stext-102 cl3" for="name">Name</label>
															<input class="size-111 bor8 stext-102 cl2 p-lr-20" id="name"
																type="text" name="name">
														</div>

														<div class="col-sm-6 p-b-5">
															<label class="stext-102 cl3" for="email">Email</label>
															<input class="size-111 bor8 stext-102 cl2 p-lr-20" id="email"
																type="text" name="email">
														</div>
													</div>

													<button
														class="flex-c-m stext-101 cl0 size-112 bg7 bor11 hov-btn3 p-lr-15 trans-04 m-b-10">
														Submit
													</button>
												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="bg6 flex-c-m flex-w size-302 m-t-73 p-tb-15">
					<span class="stext-107 cl6 p-lr-25">
						SKU: JAK-01
					</span>

					<span class="stext-107 cl6 p-lr-25">
						<?php echo $product_details['pc_name'] ?>
					</span>
				</div>
			</section>

	<?php

		} else {
			echo "Product not found.";
		}
	} else {
		echo "Product ID or name not provided.";
	}
	?>

	<!-- Related Products -->
	<!-- <section class="sec-relate-product bg0 p-t-45 p-b-105">
		<div class="container">
			<div class="p-b-45">
				<h3 class="ltext-106 cl5 txt-center">
					Related Products
				</h3>
			</div> -->

			<!-- Slide2 -->
			<!-- <div class="wrap-slick2">
				<div class="slick2">
					<div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15"> -->
						<!-- Block2 -->
						<!-- <div class="block2">
							<div class="block2-pic hov-img0">
								<img src="images/product-01.jpg" alt="IMG-PRODUCT">

								<a href="#"
									class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
									Quick View
								</a>
							</div>

							<div class="block2-txt flex-w flex-t p-t-14">
								<div class="block2-txt-child1 flex-col-l ">
									<a href="product-detail.php"
										class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
										Esprit Ruffle Shirt
									</a>

									<span class="stext-105 cl3">
										$16.64
									</span>
								</div>

								<div class="block2-txt-child2 flex-r p-t-3">
									<a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
										<img class="icon-heart1 dis-block trans-04" src="images/icons/icon-heart-01.png"
											alt="ICON">
										<img class="icon-heart2 dis-block trans-04 ab-t-l"
											src="images/icons/icon-heart-02.png" alt="ICON">
									</a>
								</div>
							</div>
						</div>
					</div> -->

					<!-- <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15"> -->
						<!-- Block2 -->
						<!-- <div class="block2">
							<div class="block2-pic hov-img0">
								<img src="images/product-02.jpg" alt="IMG-PRODUCT">

								<a href="#"
									class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
									Quick View
								</a>
							</div>

							<div class="block2-txt flex-w flex-t p-t-14">
								<div class="block2-txt-child1 flex-col-l ">
									<a href="product-detail.php"
										class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
										Herschel supply
									</a>

									<span class="stext-105 cl3">
										$35.31
									</span>
								</div>

								<div class="block2-txt-child2 flex-r p-t-3">
									<a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
										<img class="icon-heart1 dis-block trans-04" src="images/icons/icon-heart-01.png"
											alt="ICON">
										<img class="icon-heart2 dis-block trans-04 ab-t-l"
											src="images/icons/icon-heart-02.png" alt="ICON">
									</a>
								</div>
							</div>
						</div> -->
					<!-- </div> -->

					<!-- <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15"> -->
						<!-- Block2 -->
						<!-- <div class="block2">
							<div class="block2-pic hov-img0">
								<img src="images/product-03.jpg" alt="IMG-PRODUCT">

								<a href="#"
									class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
									Quick View
								</a>
							</div>

							<div class="block2-txt flex-w flex-t p-t-14">
								<div class="block2-txt-child1 flex-col-l ">
									<a href="product-detail.php"
										class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
										Only Check Trouser
									</a>

									<span class="stext-105 cl3">
										$25.50
									</span>
								</div>

								<div class="block2-txt-child2 flex-r p-t-3">
									<a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
										<img class="icon-heart1 dis-block trans-04" src="images/icons/icon-heart-01.png"
											alt="ICON">
										<img class="icon-heart2 dis-block trans-04 ab-t-l"
											src="images/icons/icon-heart-02.png" alt="ICON">
									</a>
								</div>
							</div>
						</div> -->
					<!-- </div> -->

					<!-- <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15"> -->
						<!-- Block2 -->
						<!-- <div class="block2">
							<div class="block2-pic hov-img0">
								<img src="images/product-04.jpg" alt="IMG-PRODUCT">

								<a href="#"
									class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
									Quick View
								</a>
							</div>

							<div class="block2-txt flex-w flex-t p-t-14">
								<div class="block2-txt-child1 flex-col-l ">
									<a href="product-detail.php"
										class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
										Classic Trench Coat
									</a>

									<span class="stext-105 cl3">
										$75.00
									</span>
								</div>

								<div class="block2-txt-child2 flex-r p-t-3">
									<a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
										<img class="icon-heart1 dis-block trans-04" src="images/icons/icon-heart-01.png"
											alt="ICON">
										<img class="icon-heart2 dis-block trans-04 ab-t-l"
											src="images/icons/icon-heart-02.png" alt="ICON">
									</a>
								</div>
							</div>
						</div> -->
					<!-- </div> -->

					<!-- <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15"> -->
						<!-- Block2 -->
						<!-- <div class="block2">
							<div class="block2-pic hov-img0">
								<img src="images/product-05.jpg" alt="IMG-PRODUCT">

								<a href="#"
									class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
									Quick View
								</a>
							</div>

							<div class="block2-txt flex-w flex-t p-t-14">
								<div class="block2-txt-child1 flex-col-l ">
									<a href="product-detail.php"
										class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
										Front Pocket Jumper
									</a>

									<span class="stext-105 cl3">
										$34.75
									</span>
								</div>

								<div class="block2-txt-child2 flex-r p-t-3">
									<a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
										<img class="icon-heart1 dis-block trans-04" src="images/icons/icon-heart-01.png"
											alt="ICON">
										<img class="icon-heart2 dis-block trans-04 ab-t-l"
											src="images/icons/icon-heart-02.png" alt="ICON">
									</a>
								</div>
							</div>
						</div> -->
					<!-- </div> -->

					<!-- <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15"> -->
						<!-- Block2 -->
						<!-- <div class="block2">
							<div class="block2-pic hov-img0">
								<img src="images/product-06.jpg" alt="IMG-PRODUCT">

								<a href="#"
									class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
									Quick View
								</a>
							</div>

							<div class="block2-txt flex-w flex-t p-t-14">
								<div class="block2-txt-child1 flex-col-l ">
									<a href="product-detail.php"
										class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
										Vintage Inspired Classic
									</a>

									<span class="stext-105 cl3">
										$93.20
									</span>
								</div>

								<div class="block2-txt-child2 flex-r p-t-3">
									<a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
										<img class="icon-heart1 dis-block trans-04" src="images/icons/icon-heart-01.png"
											alt="ICON">
										<img class="icon-heart2 dis-block trans-04 ab-t-l"
											src="images/icons/icon-heart-02.png" alt="ICON">
									</a>
								</div>
							</div>
						</div> -->
					<!-- </div> -->

					<!-- <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15"> -->
						<!-- Block2 -->
						<!-- <div class="block2">
							<div class="block2-pic hov-img0">
								<img src="images/product-07.jpg" alt="IMG-PRODUCT">

								<a href="#"
									class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
									Quick View
								</a>
							</div>

							<div class="block2-txt flex-w flex-t p-t-14">
								<div class="block2-txt-child1 flex-col-l ">
									<a href="product-detail.php"
										class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
										Shirt in Stretch Cotton
									</a>

									<span class="stext-105 cl3">
										$52.66
									</span>
								</div>

								<div class="block2-txt-child2 flex-r p-t-3">
									<a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
										<img class="icon-heart1 dis-block trans-04" src="images/icons/icon-heart-01.png"
											alt="ICON">
										<img class="icon-heart2 dis-block trans-04 ab-t-l"
											src="images/icons/icon-heart-02.png" alt="ICON">
									</a>
								</div>
							</div>
						</div> -->
					<!-- </div> -->

					<!-- <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15"> -->
						<!-- Block2 -->
						<!-- <div class="block2">
							<div class="block2-pic hov-img0">
								<img src="images/product-08.jpg" alt="IMG-PRODUCT">

								<a href="#"
									class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
									Quick View
								</a>
							</div>

							<div class="block2-txt flex-w flex-t p-t-14">
								<div class="block2-txt-child1 flex-col-l ">
									<a href="product-detail.php"
										class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
										Pieces Metallic Printed
									</a>

									<span class="stext-105 cl3">
										$18.96
									</span>
								</div>

								<div class="block2-txt-child2 flex-r p-t-3">
									<a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
										<img class="icon-heart1 dis-block trans-04" src="images/icons/icon-heart-01.png"
											alt="ICON">
										<img class="icon-heart2 dis-block trans-04 ab-t-l"
											src="images/icons/icon-heart-02.png" alt="ICON">
									</a>
								</div>
							</div>
						</div> -->
					<!-- </div> -->
				<!-- </div> -->
			<!-- </div> -->
		<!-- </div> -->
	<!-- </section> -->


	<!-- Footer -->
	<footer class="bg3 p-t-75 p-b-32">
			<div class="container">
				<div class="row">
					<div class="col-sm-6 col-lg-4 p-b-50">
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

					<div class="col-sm-6 col-lg-4 p-b-50">
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
								<a href="shipping-policy.php" class="stext-107 cl7 hov-cl1 trans-04">
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

					<div class="col-sm-6 col-lg-4 p-b-50">
						<h4 class="stext-301 cl0 p-b-30">
							GET IN TOUCH
						</h4>
						<p class="stext-107 cl7 size-201">
							care@pehunt.in
						</p>

						<p class="stext-107 cl7 size-201">
							Any questions? Let us know in store at Pehunt solution OPC Pvt Ltd , Office No GF-05, H73, Gautambudha nagar, Sector 63 Noida UP 201301
						</p>
						<li>
								<a href="about.php">About</a>
							</li>

						<!-- <div class="p-t-27">
							<a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
								<i class="fa fa-facebook"></i>
							</a>

							<a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
								<i class="fa fa-instagram"></i>
							</a>

							<a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
								<i class="fa fa-pinterest-p"></i>
							</a>
						</div> -->
					</div>

					<!-- <div class="col-sm-6 col-lg-4 p-b-50">
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
						</script> All rights reserved | Pehunt solution OPC Pvt Ltd 
						<!-- <i
							class="fa fa-heart-o" aria-hidden="true"></i> by <a href="#"
							target="_blank"></a> &amp; distributed by <a href="#"
							target="_blank">PeHunt</a> -->
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

	<!-- Modal1 -->
	<div class="wrap-modal1 js-modal1 p-t-60 p-b-20">
		<div class="overlay-modal1 js-hide-modal1"></div>

		<div class="container">
			<div class="bg0 p-t-60 p-b-30 p-lr-15-lg how-pos3-parent">
				<button class="how-pos3 hov3 trans-04 js-hide-modal1">
					<img src="images/icons/icon-close.png" alt="CLOSE">
				</button>

				<div class="row">
					<div class="col-md-6 col-lg-7 p-b-30">
						<div class="p-l-25 p-r-30 p-lr-0-lg">
							<div class="wrap-slick3 flex-sb flex-w">
								<div class="wrap-slick3-dots"></div>
								<div class="wrap-slick3-arrows flex-sb-m flex-w"></div>

								<div class="slick3 gallery-lb">
									<div class="item-slick3" data-thumb="images/product-detail-01.jpg">
										<div class="wrap-pic-w pos-relative">
											<img src="images/product-detail-01.jpg" alt="IMG-PRODUCT">

											<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
												href="images/product-detail-01.jpg">
												<i class="fa fa-expand"></i>
											</a>
										</div>
									</div>

									<div class="item-slick3" data-thumb="images/product-detail-02.jpg">
										<div class="wrap-pic-w pos-relative">
											<img src="images/product-detail-02.jpg" alt="IMG-PRODUCT">

											<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
												href="images/product-detail-02.jpg">
												<i class="fa fa-expand"></i>
											</a>
										</div>
									</div>

									<div class="item-slick3" data-thumb="images/product-detail-03.jpg">
										<div class="wrap-pic-w pos-relative">
											<img src="images/product-detail-03.jpg" alt="IMG-PRODUCT">

											<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
												href="images/product-detail-03.jpg">
												<i class="fa fa-expand"></i>
											</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-6 col-lg-5 p-b-30">
						<div class="p-r-50 p-t-5 p-lr-0-lg">
							<h4 class="mtext-105 cl2 js-name-detail p-b-14">
								Lightweight Jacket
							</h4>

							<span class="mtext-106 cl2">
								$58.79
							</span>

							<p class="stext-102 cl3 p-t-23">
								Nulla eget sem vitae eros pharetra viverra. Nam vitae luctus ligula. Mauris consequat
								ornare feugiat.
							</p>

							<!--  -->
							<div class="p-t-33">
								<div class="flex-w flex-r-m p-b-10">
									<div class="size-203 flex-c-m respon6">
										Size
									</div>

									<div class="size-204 respon6-next">
										<div class="rs1-select2 bor8 bg0">
											<select class="js-select2" name="time">
												<option>Choose an option</option>
												<option>Size S</option>
												<option>Size M</option>
												<option>Size L</option>
												<option>Size XL</option>
											</select>
											<div class="dropDownSelect2"></div>
										</div>
									</div>
								</div>

								<div class="flex-w flex-r-m p-b-10">
									<div class="size-203 flex-c-m respon6">
										Color
									</div>

									<div class="size-204 respon6-next">
										<div class="rs1-select2 bor8 bg0">
											<select class="js-select2" name="time">
												<option>Choose an option</option>
												<option>Red</option>
												<option>Blue</option>
												<option>White</option>
												<option>Grey</option>
											</select>
											<div class="dropDownSelect2"></div>
										</div>
									</div>
								</div>

								<div class="flex-w flex-r-m p-b-10">
									<div class="size-204 flex-w flex-m respon6-next">
										<div class="wrap-num-product flex-w m-r-20 m-tb-10">
											<div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
												<i class="fs-16 zmdi zmdi-minus"></i>
											</div>

											<input class="mtext-104 cl3 txt-center num-product" type="number"
												name="num-product" value="1">

											<div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
												<i class="fs-16 zmdi zmdi-plus"></i>
											</div>
										</div>

										<button
											class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail">
											Add to cart
										</button>
									</div>
								</div>
							</div>

							<!--  -->
							<div class="flex-w flex-m p-l-100 p-t-40 respon7">
								<div class="flex-m bor9 p-r-10 m-r-11">
									<a href="#"
										class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 js-addwish-detail tooltip100"
										data-tooltip="Add to Wishlist">
										<i class="zmdi zmdi-favorite"></i>
									</a>
								</div>

								<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
									data-tooltip="Facebook">
									<i class="fa fa-facebook"></i>
								</a>

								<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
									data-tooltip="Twitter">
									<i class="fa fa-twitter"></i>
								</a>

								<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
									data-tooltip="Google Plus">
									<i class="fa fa-google-plus"></i>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
	<script>
		$(".js-select2").each(function() {
			$(this).select2({
				minimumResultsForSearch: 20,
				dropdownParent: $(this).next('.dropDownSelect2')
			});
		})
	</script>
	<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/slick/slick.min.js"></script>
	<script src="js/slick-custom.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/parallax100/parallax100.js"></script>
	<script>
		$('.parallax100').parallax100();
	</script>
	<!--===============================================================================================-->
	<script src="vendor/MagnificPopup/jquery.magnific-popup.min.js"></script>
	<script>
		$('.gallery-lb').each(function() { // the containers for all your galleries
			$(this).magnificPopup({
				delegate: 'a', // the selector for gallery item
				type: 'image',
				gallery: {
					enabled: true
				},
				mainClass: 'mfp-fade'
			});
		});
	</script>
	<!--===============================================================================================-->
	<script src="vendor/isotope/isotope.pkgd.min.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/sweetalert/sweetalert.min.js"></script>
	<script>
		$('.wishlistForm').on('submit', function(e) {
				e.preventDefault();
				$.ajax({
					type: 'POST',
					url: $(this).attr('action'),
					data: $(this).serialize(),
					success: function(response) {
						if (response == "Product Added") {
							swal('Your Product', 'is added to Cart !', 'success');
						} else if (response == "already add") {
							swal('Your Product', 'already added to Cart !', 'warning');
						}


					},
					error: function(xhr, status, error) {
						alert('An error occurred: ' + error);
					}
				});
			});
		$('.cartForm').on('submit', function(e) {
			e.preventDefault(); // Prevent the form from submitting the traditional way

			$.ajax({
				type: 'POST',
				url: $(this).attr('action'),
				data: $(this).serialize(),
				success: function(response) {
					if (response == "") {
						swal('Your Product', 'is added to Cart !', 'success');
					} else if (response == "already add") {
						swal('Your Product', 'already added to Cart !', 'warning');
					}


				},
				error: function(xhr, status, error) {
					alert('An error occurred: ' + error);
				}
			});
		});
	</script>
	<!--===============================================================================================-->
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
						$('.header-cart-wrapitem').html('<h1>Add Product</h1>');
						$('.noti-cart').attr('data-notify', 0);
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
	<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>

</html>