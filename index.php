<!DOCTYPE html>
<html lang="en">
<?php
session_start();
include('config.php');
mysqli_set_charset($product_info, "utf8mb4");
$wishlist_data = "select * from wishlist";
?>

	<head>
		<title>Home - PeHunt </title>
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
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

	</head>

	<body class="animsition">
		<!-- Header -->
		<header>
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



		<!-- Slider -->
		<section class="section-slide">
			<div class="wrap-slick1">
				<div class="slick1">
					<div class="item-slick1" style="background-image: url(images/slide-01.jpg);">
						<div class="container h-full">
							<div class="flex-col-l-m h-full p-t-100 p-b-30 respon5">
								<div class="layer-slick1 animated visible-false" data-appear="fadeInDown" data-delay="0">
									<span class="ltext-101 cl2 respon2">
										Women Collection 2024
									</span>
								</div>

								<div class="layer-slick1 animated visible-false" data-appear="fadeInUp" data-delay="800">
									<h2 class="ltext-201 cl2 p-t-19 p-b-43 respon1">
										NEW SEASON
									</h2>
								</div>

								<div class="layer-slick1 animated visible-false" data-appear="zoomIn" data-delay="1600">
									<a href="product.php"
										class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
										Shop Now
									</a>
								</div>
							</div>
						</div>
					</div>

					<div class="item-slick1" style="background-image: url(images/slide-02.jpg);">
						<div class="container h-full">
							<div class="flex-col-l-m h-full p-t-100 p-b-30 respon5">
								<div class="layer-slick1 animated visible-false" data-appear="rollIn" data-delay="0">
									<span class="ltext-101 cl2 respon2">
										Men New-Season
									</span>
								</div>

								<div class="layer-slick1 animated visible-false" data-appear="lightSpeedIn"
									data-delay="800">
									<h2 class="ltext-201 cl2 p-t-19 p-b-43 respon1">
										Jackets & Coats
									</h2>
								</div>

								<div class="layer-slick1 animated visible-false" data-appear="slideInUp" data-delay="1600">
									<a href="product.php"
										class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
										Shop Now
									</a>
								</div>
							</div>
						</div>
					</div>

					<div class="item-slick1" style="background-image: url(images/slide-03.jpg);">
						<div class="container h-full">
							<div class="flex-col-l-m h-full p-t-100 p-b-30 respon5">
								<div class="layer-slick1 animated visible-false" data-appear="rotateInDownLeft"
									data-delay="0">
									<span class="ltext-101 cl2 respon2">
										Men Collection 2024
									</span>
								</div>

								<div class="layer-slick1 animated visible-false" data-appear="rotateInUpRight"
									data-delay="800">
									<h2 class="ltext-201 cl2 p-t-19 p-b-43 respon1">
										New arrivals
									</h2>
								</div>

								<div class="layer-slick1 animated visible-false" data-appear="rotateIn" data-delay="1600">
									<a href="product.php"
										class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
										Shop Now
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>


		<!-- Banner -->
		<div class="sec-banner bg0 p-t-80 p-b-50">
			<div class="container">
				<div class="row">
					<div class="col-md-6 col-xl-4 p-b-30 m-lr-auto">
						<!-- Block1 -->
						<div class="block1 wrap-pic-w">
							<img src="images/banner-01.jpg" alt="IMG-BANNER">

							<a href="product.php?product_target=f"
								class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
								<div class="block1-txt-child1 flex-col-l">
									<span class="block1-name ltext-102 trans-04 p-b-8">
										Women
									</span>

									<span class="block1-info stext-102 trans-04">
										Spring 2024
									</span>
								</div>

								<div class="block1-txt-child2 p-b-4 trans-05">
									<div class="block1-link stext-101 cl0 trans-09">
										Shop Now
									</div>
								</div>
							</a>
						</div>
					</div>

					<div class="col-md-6 col-xl-4 p-b-30 m-lr-auto">
						<!-- Block1 -->
						<div class="block1 wrap-pic-w">
							<img src="images/banner-02.jpg" alt="IMG-BANNER">

							<a href="product.php?product_target=m"
								class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
								<div class="block1-txt-child1 flex-col-l">
									<span class="block1-name ltext-102 trans-04 p-b-8">
										Men
									</span>

									<span class="block1-info stext-102 trans-04">
										Spring 2024
									</span>
								</div>

								<div class="block1-txt-child2 p-b-4 trans-05">
									<div class="block1-link stext-101 cl0 trans-09">
										Shop Now
									</div>
								</div>
							</a>
						</div>
					</div>

					<div class="col-md-6 col-xl-4 p-b-30 m-lr-auto">
						<!-- Block1 -->
						<div class="block1 wrap-pic-w">
							<img src="images/banner-03.jpg" alt="IMG-BANNER">

							<a href="product.php?product_target=O"
								class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
								<div class="block1-txt-child1 flex-col-l">
									<span class="block1-name ltext-102 trans-04 p-b-8">
										Accessories
									</span>

									<span class="block1-info stext-102 trans-04">
										New Trend
									</span>
								</div>

								<div class="block1-txt-child2 p-b-4 trans-05">
									<div class="block1-link stext-101 cl0 trans-09">
										Shop Now
									</div>
								</div>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>


		<!-- Product -->
		<section class="bg0 p-t-23 p-b-140">
			<div class="container">
				<div class="p-b-10">
					<h3 class="ltext-103 cl5">
						Product Overview
					</h3>
				</div>

				<div class="flex-w flex-sb-m p-b-52">
					<div class="flex-w flex-l-m filter-tope-group m-tb-10">
						<button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 how-active1" data-filter="*">
							All Products
						</button>

						<button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-filter=".Cloth">
							Cloth
						</button>

						<button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-filter=".Accessories">
							Accessories
						</button>

						<button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-filter=".Belt">
							Belt
						</button>

						<button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-filter=".Shoes">
							Shoes
						</button>

						<button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-filter=".Watches">
							Watches
						</button>
					</div>

					<div class="flex-w flex-c-m m-tb-10">
						<div
							class="flex-c-m stext-106 cl6 size-104 bor4 pointer hov-btn3 trans-04 m-r-8 m-tb-4 js-show-filter">
							<i class="icon-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-filter-list"></i>
							<i class="icon-close-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
							Filter
						</div>

						<div class="flex-c-m stext-106 cl6 size-105 bor4 pointer hov-btn3 trans-04 m-tb-4 js-show-search">
							<i class="icon-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-search"></i>
							<i class="icon-close-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
							Search
						</div>
					</div>

					<!-- Search product -->
					<div class="dis-none panel-search w-full p-t-10 p-b-15">
						<div class="bor8 dis-flex p-l-15">
							<button class="size-113 flex-c-m fs-16 cl2 hov-cl1 trans-04">
								<i class="zmdi zmdi-search"></i>
							</button>

							<input class="mtext-107 cl2 size-114 plh2 p-r-15" type="text" name="search-product"
								placeholder="Search">
						</div>
					</div>
					<?php
						if(isset($_GET['sort_by'] )){
							$sort_by = $_GET['sort_by'];
                            $cls = $_GET['cls'];
						}else{
                            $sort_by = "";
                            $cls = "";
                        }

						if(isset($_GET['price_low']) || isset($_GET['price_high'])){
							$price_low = $_GET['price_low'];
                            $price_high = $_GET['price_high'];
                            $price = "WHERE product_price BETWEEN $price_low AND $price_high";
						}else{
							$price_low = "";
                            $price_high = "";
                            $price = null;
						}

						switch($sort_by){
							case "default":
                                $products = null;
                                break;
                            case "Newness":
                               	$products = "ORDER BY added_at DESC";
                                break;
                            case "Low to High":
                                $products = "ORDER BY product_price ASC";
                                break;
                            case "High to Low":
                                $products = "ORDER BY product_price DESC";
                                break;
							default:
								$products = null;
						}

						$product = "SELECT * FROM product_item LEFT JOIN product_images ON product_item.product_related_img = product_images.pr_id LEFT JOIN product_category ON product_item.product_catg = product_category.pc_id $price $products";
					?>
					<!-- Filter -->
					<div class="dis-none panel-filter w-full p-t-10">
						<div class="wrap-filter flex-w bg6 w-full p-lr-40 p-t-27 p-lr-15-sm">
							<div class="filter-col1 p-r-15 p-b-27">
								<div class="mtext-102 cl2 p-b-15">
									Sort By
								</div>
								<ul>
									<li class="p-b-6">
										<a href="index.php?sort_by=default&cls=filter-link-active&<?php echo isset($_GET['price_low']) ? 'price_low='.$price_low : null; ?>&<?php echo isset($_GET['price_high']) ? 'price_high='.$price_high : null; ?>" class="filter-link stext-106 trans-04 <?php echo $sort_by == 'default' ? $cls : null; ?>">
											Default
										</a>
									</li>

									<!-- <li class="p-b-6">
										<a href="index.php?sort_by=Popularity&cls=filter-link-active" class="filter-link stext-106 trans-04">
											Popularity
										</a>
									</li> -->

									<!-- <li class="p-b-6">
										<a href="index.php?sort_by=rating&cls=filter-link-active" class="filter-link stext-106 trans-04">
											Average rating
										</a>
									</li> -->
									<!-- filter-link-active -->
									<li class="p-b-6">
										<a href="index.php?sort_by=Newness&cls=filter-link-active&<?php echo isset($_GET['price_low']) ? 'price_low='.$price_low : null; ?>&<?php echo isset($_GET['price_high']) ? 'price_high='.$price_high : null; ?>" class="filter-link stext-106 trans-04 <?php echo $sort_by == 'Newness' ? $cls : null;?>">
											Newness
										</a>
									</li>

									<li class="p-b-6">
										<a href="index.php?sort_by=Low to High&cls=filter-link-active&<?php echo isset($_GET['price_low']) ? 'price_low='.$price_low : null; ?>&<?php echo isset($_GET['price_high']) ? 'price_high='.$price_high : null; ?>" class="filter-link stext-106 trans-04 <?php echo $sort_by == 'Low to High' ? $cls : null;?>">
											Price: Low to High
										</a>
									</li>

									<li class="p-b-6">
										<a href="index.php?sort_by=High to Low&cls=filter-link-active&<?php echo isset($_GET['price_low']) ? 'price_low='.$price_low : null; ?>&<?php echo isset($_GET['price_high']) ? 'price_high='.$price_high : null; ?>" class="filter-link stext-106 trans-04 <?php echo $sort_by == 'High to Low' ? $cls : null;?>">
											Price: High to Low
										</a>
									</li>
								</ul>
							</div>

							<div class="filter-col2 p-r-15 p-b-27">
								<div class="mtext-102 cl2 p-b-15">
									Price
								</div>

								<ul>
									<li class="p-b-6">
										<a href="index.php?sort_by=<?php echo $sort_by?>&cls=filter-link-active&price=all" class="filter-link stext-106 trans-04 <?php echo isset($_GET['price']) == 'all' ? $cls : null;?>">
											All
										</a>
									</li>

									<li class="p-b-6">
										<a href="index.php?sort_by=<?php echo $sort_by?>&cls=filter-link-active&price_low=0&price_high=199" class="filter-link stext-106 trans-04 <?php echo $price_low == '0' ? $cls : null;?>">
											₹0.00 - ₹199.00
										</a>
									</li>

									<li class="p-b-6">
										<a href="index.php?sort_by=<?php echo $sort_by?>&cls=filter-link-active&price_low=201&price_high=499" class="filter-link stext-106 trans-04 <?php echo $price_low == '201' ? $cls : null;?>">
											₹201.00 - ₹499.00
										</a>
									</li>

									<li class="p-b-6">
										<a href="index.php?sort_by=<?php echo $sort_by?>&cls=filter-link-active&price_low=501&price_high=1499" class="filter-link stext-106 trans-04 <?php echo $price_low == '501' ? $cls : null;?>">
											₹501.00 - ₹1499.00
										</a>
									</li>

									<li class="p-b-6">
										<a href="index.php?sort_by=<?php echo $sort_by?>&cls=filter-link-active&price_low=1501&price_high=2499" class="filter-link stext-106 trans-04 <?php echo $price_low == '1501' ? $cls : null;?>">
											₹1501.00 - ₹2499.00
										</a>
									</li>

									<li class="p-b-6">
										<a href="index.php?sort_by=<?php echo $sort_by?>&cls=filter-link-active&price_low=2501&price_high=100000" class="filter-link stext-106 trans-04 <?php echo $price_low == '2501' ? $cls : null;?>">
											₹2501.00+
										</a>
									</li>
								</ul>
							</div>

							<!-- <div class="filter-col3 p-r-15 p-b-27">
								<div class="mtext-102 cl2 p-b-15">
									Color
								</div>

								<ul>
									<li class="p-b-6">
										<span class="fs-15 lh-12 m-r-6" style="color: #222;">
											<i class="zmdi zmdi-circle"></i>
										</span>

										<a href="#" class="filter-link stext-106 trans-04">
											Black
										</a>
									</li>

									<li class="p-b-6">
										<span class="fs-15 lh-12 m-r-6" style="color: #4272d7;">
											<i class="zmdi zmdi-circle"></i>
										</span>

										<a href="#" class="filter-link stext-106 trans-04 filter-link-active">
											Blue
										</a>
									</li>

									<li class="p-b-6">
										<span class="fs-15 lh-12 m-r-6" style="color: #b3b3b3;">
											<i class="zmdi zmdi-circle"></i>
										</span>

										<a href="#" class="filter-link stext-106 trans-04">
											Grey
										</a>
									</li>

									<li class="p-b-6">
										<span class="fs-15 lh-12 m-r-6" style="color: #00ad5f;">
											<i class="zmdi zmdi-circle"></i>
										</span>

										<a href="#" class="filter-link stext-106 trans-04">
											Green
										</a>
									</li>

									<li class="p-b-6">
										<span class="fs-15 lh-12 m-r-6" style="color: #fa4251;">
											<i class="zmdi zmdi-circle"></i>
										</span>

										<a href="#" class="filter-link stext-106 trans-04">
											Red
										</a>
									</li>

									<li class="p-b-6">
										<span class="fs-15 lh-12 m-r-6" style="color: #aaa;">
											<i class="zmdi zmdi-circle-o"></i>
										</span>

										<a href="#" class="filter-link stext-106 trans-04">
											White
										</a>
									</li>
								</ul>
							</div> -->

							<!-- <div class="filter-col4 p-b-27">
								<div class="mtext-102 cl2 p-b-15">
									Tags
								</div>

								<div class="flex-w p-t-4 m-r--5">
									<a href="#"
										class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
										Fashion
									</a>

									<a href="#"
										class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
										Lifestyle
									</a>

									<a href="#"
										class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
										Denim
									</a>

									<a href="#"
										class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
										Streetstyle
									</a>

									<a href="#"
										class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
										Crafts
									</a>
								</div>
							</div> -->
						</div>
					</div>
				</div>

				<div class="row isotope-grid">
					<?php
					$product_data = mysqli_query($product_info, $product);
					while ($fetch_product = mysqli_fetch_array($product_data)) {
						$pr_img = json_decode($fetch_product['pr_imgs']);
					?>
						<div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item <?php echo $fetch_product['pc_name'] ?>">
							<!-- Block2 -->
							<div class="block2">
								<div class="block2-pic hov-img0">
									<input type="hidden" value="image/product/pr_imgs/<?php echo $pr_img[0] ?>" class="pr_img1">
									<input type="hidden" value="image/product/pr_imgs/<?php echo $pr_img[1] ?>" class="pr_img2">
									<input type="hidden" value="image/product/pr_imgs/<?php echo $pr_img[2] ?>" class="pr_img3">
									<input type="hidden" value="<?php echo $fetch_product['id'] ?>" class="product_details">
									<img src="image/product/<?php echo $fetch_product['product_img'] ?>" alt="IMG-PRODUCT">
									<a href="#"
										class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
										Quick View
									</a>
								</div>
								<?php

								?>

								<div class="block2-txt flex-w flex-t p-t-14">
									<div class="block2-txt-child1 flex-col-l ">
										<a href="product-detail.php?id=<?php echo $fetch_product['id'] ?>&&name=<?php echo $fetch_product['product_name'] ?>" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6 product_name">
											<?php
												$normalizedText = stripslashes($fetch_product['product_name']);
												$normalizedText = str_replace(["\\r\\n", "\\n", "\\r", "rnrn"], "\n", $normalizedText);
												echo nl2br(htmlspecialchars($normalizedText));	
											?>
										</a>

										<span class="stext-105 cl3">
											<b>₹ <?php echo $fetch_product['product_price'] ?></b>
										</span>
									</div>

									<div class="block2-txt-child2 flex-r p-t-3">
										<form action="wishlist_config.php" method="POST" class="wishlistForm">
											<input type="hidden" value="<?php echo $fetch_product['id'] ?>" name="wish_product">
											<input type="hidden" value="<?php echo isset($_SESSION['wishlist']) ? $_SESSION['wishlist'] : "" ;?>" name="wish">
											<button class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
												<img class="icon-heart1 dis-block trans-04" src="images/icons/icon-heart-01.png"
													alt="ICON">
												<img class="icon-heart2 dis-block trans-04 ab-t-l"
													src="images/icons/icon-heart-02.png" alt="ICON">
											</button>
										</form>
									</div>
								</div>
							</div>
						</div>
					<?php
					}
					?>
				</div>

				<!-- Load more -->
				<div class="flex-c-m flex-w w-full p-t-45">
					<a href="#" class="flex-c-m stext-101 cl5 size-103 bg2 bor1 hov-btn1 p-lr-15 trans-04">
						Load More
					</a>
				</div>
			</div>
		</section>


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
										<div class="item-slick3" data-thumb="" id="slick1">
											<div class="wrap-pic-w pos-relative">
												<img src="" alt="IMG-PRODUCT" id="main_img">

												<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
													href="" id="main_href">
													<i class="fa fa-expand"></i>
												</a>
											</div>
										</div>

										<div class="item-slick3">
											<div class="wrap-pic-w pos-relative">
												<img src="" alt="IMG-PRODUCT1" id="pr_img1">

												<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
													href="" id="pr_href1">
													<i class="fa fa-expand"></i>
												</a>
											</div>
										</div>

										<div class="item-slick3">
											<div class="wrap-pic-w pos-relative">
												<img src="" alt="IMG-PRODUCT" id="pr_img2">

												<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
													href="" id="pr_href2">
													<i class="fa fa-expand"></i>
												</a>
											</div>
										</div>
										<div class="item-slick3">
											<div class="wrap-pic-w pos-relative">
												<img src="" alt="IMG-PRODUCT" id="pr_img3">

												<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
													href="" id="pr_href3">
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
								<h4 class="mtext-105 cl2 js-name-detail p-b-14" id="data_head">
									
								</h4>

								<span class="mtext-106 cl2" id="data_price">
								
								</span>

								<p class="stext-102 cl3 p-t-23">
									
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

											<form action="cart_config.php" method="POST" class="cartForm">
												<input type="hidden" value="" name="cart_product" id="product_cart_details">
												<input type="hidden" value="<?php echo isset($_SESSION['cart']) ? $_SESSION['cart'] : "" ;?>" name="cart">
												<button type="submit"
													class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail">
													Add to cart
												</button>
											</form>
										</div>
									</div>
								</div>
								<div class="flex-w flex-m p-l-100 p-t-40 respon7">
									<div class="flex-m bor9 p-r-10 m-r-11">
										<form action="wishlist_config.php" method="POST" class="wishlistForm">
											<?php
											$product_data = mysqli_query($product_info, $product);
											while ($fetch_product = mysqli_fetch_array($product_data)) {
											?>
												<input type="hidden" value="<?php echo $fetch_product['id'] ?>" name="wish_product">
											<?php
											}
											?>
											<input type="hidden" value="<?php echo isset($_SESSION['wishlist']) ? $_SESSION['wishlist'] : "" ;?>" name="wish">
											<button class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
												<img class="icon-heart1 dis-block trans-04" src="images/icons/icon-heart-01.png"
													alt="ICON">
												<img class="icon-heart2 dis-block trans-04 ab-t-l"
													src="images/icons/icon-heart-02.png" alt="ICON">
											</button>
										</form>
									</div>
									<p>Add in you wishlist</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
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
		<script src="vendor/daterangepicker/moment.min.js"></script>
		<script src="vendor/daterangepicker/daterangepicker.js"></script>
		<script src="vendor/slick/slick.min.js"></script>
		<script src="js/slick-custom.js"></script>
		<script src="vendor/parallax100/parallax100.js"></script>
		<script>
			$('.parallax100').parallax100();
		</script>
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
		<script src="vendor/isotope/isotope.pkgd.min.js"></script>
		<script src="vendor/sweetalert/sweetalert.min.js"></script>
		<script>
			$('.wishlistForm').on('submit', function(e) {
				e.preventDefault();
				$.ajax({
					type: 'POST',
					url: $(this).attr('action'),
					data: $(this).serialize(),
					success: function(response) {
						if (response == "") {
							swal('Your Product', 'is added to wishlist !', 'success');
						} else if (response == "already add") {
							swal('Your Product', 'already added to wishlist !', 'warning');
						}
					},
					error: function(xhr, status, error) {
						alert('An error occurred: ' + error);
					}
				});
			});
			$('.cartForm').on('submit', function(e) {
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
					error: function(err) {
						alert('An error occurred: ');
						console.log('An error occurred: ' + err.responseText);
					}
				});
			});
		</script>
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

		<!-- fetch data -->
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
                                    <a href="product-detail.php?id=${item.product_id}&&name=${item.product_name}" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
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
					url: 'cart-data-config.php',
					type: 'GET',
					dataType: 'json',
					success: function(response) {
						if (response.status === 'success') {
							$('.noti-cart').attr('data-notify', response.count);
							var cartItems = response.data;
							var cartHTML = '';

							cartItems.forEach(function(item) {
								cartHTML += `
                            <li class="header-cart-item flex-w flex-t m-b-12">
                                <div class="header-cart-item-img">
                                    <img src="image/product/${item.product_img}" alt="IMG">
                                </div>
                                <div class="header-cart-item-txt p-t-8">
                                    <a href="product-detail.php?id=${item.product_id}&&name=${item.product_name}" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
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
		<script src="js/main.js"></script>
	<script>
		if (window.history.replaceState) {
			window.history.replaceState(null, null, window.location.href);
		}
	</script>
	</body>

</html>