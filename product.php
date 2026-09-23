<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include('config.php');
stark_ensure_tables($con);
?>
<!DOCTYPE html>
<html lang="en">

	<head>
		<title>Shop Collection - Stark Store</title>
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
		<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
		<link rel="stylesheet" type="text/css" href="vendor/slick/slick.css">
		<link rel="stylesheet" type="text/css" href="vendor/MagnificPopup/magnific-popup.css">
		<link rel="stylesheet" type="text/css" href="vendor/perfect-scrollbar/perfect-scrollbar.css">
		<link rel="stylesheet" type="text/css" href="css/util.css">
		<link rel="stylesheet" type="text/css" href="css/main.css">
		<link rel="stylesheet" type="text/css" href="css/modern-stark.css">
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
							Free Express Shipping on Orders Over ₹999 &nbsp;|&nbsp; ⚡ Use Code: <strong>STARK15</strong> for 15% OFF
						</div>
					</div>
				</div>

				<div class="wrap-menu-desktop">
					<nav class="limiter-menu-desktop container">

						<!-- Logo desktop -->
						<a href="index.php" class="stark-brand-logo">
							<span class="brand-icon"><i class="fa fa-bolt"></i></span>
							<span class="brand-text">STARK</span>
							<span class="brand-badge">STORE</span>
						</a>

						<!-- Menu desktop -->
						<div class="menu-desktop">
							<ul class="main-menu">
								<li>
									<a href="index.php">Home</a>
								</li>

								<li class="active-menu">
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
				<!-- Logo mobile -->
				<div class="logo-mobile">
					<a href="index.php" class="stark-brand-logo">
						<span class="brand-icon"><i class="fa fa-bolt"></i></span>
						<span class="brand-text">STARK</span>
					</a>
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

		<!-- Title page -->
		<section class="txt-center p-lr-15 p-tb-55" style="background: linear-gradient(135deg, #090d16 0%, #1e1b4b 100%); position: relative; overflow: hidden;">
			<div class="container" style="position: relative; z-index: 2;">
				<span class="stark-badge stark-badge-primary mb-2" style="background: rgba(99,102,241,0.25); color: #a5b4fc; border-color: rgba(99,102,241,0.5);">
					✨ Complete Collection 2026
				</span>
				<h2 class="ltext-105 cl0 txt-center" style="font-weight: 800; font-size: clamp(28px, 4vw, 42px); letter-spacing: -0.03em; margin-bottom: 8px;">
					Discover The Latest Drops
				</h2>
				<p class="stext-107 cl7 txt-center" style="max-width: 620px; margin: 0 auto; color: #94a3b8; font-size: 14.5px;">
					Explore the newest apparel, minimalist watches, premium footwear and curated lifestyle accessories.
				</p>
			</div>
		</section>

		<!-- Product -->
		<div class="bg0 p-t-40 p-b-140">
			<div class="container">
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
						<form action="product.php" method="GET" class="bor8 dis-flex p-l-15 w-full">
							<button type="submit" class="size-113 flex-c-m fs-16 cl2 hov-cl1 trans-04">
								<i class="zmdi zmdi-search"></i>
							</button>

							<input class="mtext-107 cl2 size-114 plh2 p-r-15" type="text" name="search"
								value="<?php echo htmlspecialchars($_GET['search'] ?? ($_GET['search-product'] ?? '')); ?>"
								placeholder="Search products by name or description...">
						</form>
					</div>

					<!-- Filter -->
					<?php
					$conditions = [];

					// Search keyword
					$search_val = trim($_GET['search'] ?? ($_GET['search-product'] ?? ''));
					if (!empty($search_val)) {
						$clean_search = mysqli_real_escape_string($con, $search_val);
						$conditions[] = "(product_item.product_name LIKE '%$clean_search%' OR product_item.product_description LIKE '%$clean_search%')";
					}

					// Category filter
					if (!empty($_GET['catg'])) {
						$catg_id = intval($_GET['catg']);
						$conditions[] = "product_item.product_catg = $catg_id";
					}

					// Gender filter
					$product_target = isset($_GET['product_target']) ? mysqli_real_escape_string($con, $_GET['product_target']) : '';
					if (!empty($product_target)) {
						$conditions[] = "product_item.gender = '$product_target'";
					}

					// Price filter
					$price_low = isset($_GET['price_low']) && is_numeric($_GET['price_low']) ? floatval($_GET['price_low']) : 0;
					$price_high = isset($_GET['price_high']) && is_numeric($_GET['price_high']) ? floatval($_GET['price_high']) : 0;
					if ($price_high > 0) {
						$conditions[] = "product_item.product_price BETWEEN $price_low AND $price_high";
					}

					$where_sql = !empty($conditions) ? "WHERE " . implode(" AND ", $conditions) : "";

					// Sort
					$sort_by = $_GET['sort_by'] ?? 'default';
					$cls = $_GET['cls'] ?? 'filter-link-active';

					$sort_sql = "ORDER BY product_item.id DESC";
					switch ($sort_by) {
						case "Newness":
							$sort_sql = "ORDER BY product_item.id DESC";
							break;
						case "Low to High":
							$sort_sql = "ORDER BY product_item.product_price ASC";
							break;
						case "High to Low":
							$sort_sql = "ORDER BY product_item.product_price DESC";
							break;
					}

					$product = "SELECT product_item.*, product_images.pr_imgs, product_category.pc_name 
								FROM product_item 
								LEFT JOIN product_images ON (product_item.product_related_img = product_images.pr_id OR product_item.id = product_images.pr_id) 
								LEFT JOIN product_category ON product_item.product_catg = product_category.pc_id 
								$where_sql 
								$sort_sql";
					?>
					<div class="dis-none panel-filter w-full p-t-10">
						<div class="wrap-filter flex-w bg6 w-full p-lr-40 p-t-27 p-lr-15-sm">
							<div class="filter-col1 p-r-15 p-b-27">
								<div class="mtext-102 cl2 p-b-15">
									Sort By
								</div>
								<ul>
									<li class="p-b-6">
										<a href="product.php?<?php echo isset($product_target) ? 'product_target='.$product_target : null;?>&sort_by=default&cls=filter-link-active&<?php echo isset($_GET['price_low']) ? 'price_low='.$price_low : null; ?>&<?php echo isset($_GET['price_high']) ? 'price_high='.$price_high : null; ?>" class="filter-link stext-106 trans-04 <?php echo $sort_by == 'default' ? $cls : null; ?>">
											Default
										</a>
									</li>

									<!-- <li class="p-b-6">
										<a href="product.php?sort_by=Popularity&cls=filter-link-active" class="filter-link stext-106 trans-04">
											Popularity
										</a>
									</li> -->

									<!-- <li class="p-b-6">
										<a href="product.php?sort_by=rating&cls=filter-link-active" class="filter-link stext-106 trans-04">
											Average rating
										</a>
									</li> -->
									<!-- filter-link-active -->
									<li class="p-b-6">
										<a href="product.php?<?php echo isset($product_target) ? 'product_target='.$product_target : null;?>&sort_by=Newness&cls=filter-link-active&<?php echo isset($_GET['price_low']) ? 'price_low='.$price_low : null; ?>&<?php echo isset($_GET['price_high']) ? 'price_high='.$price_high : null; ?>" class="filter-link stext-106 trans-04 <?php echo $sort_by == 'Newness' ? $cls : null;?>">
											Newness
										</a>
									</li>

									<li class="p-b-6">
										<a href="product.php?<?php echo isset($product_target) ? 'product_target='.$product_target : null;?>&sort_by=Low to High&cls=filter-link-active&<?php echo isset($_GET['price_low']) ? 'price_low='.$price_low : null; ?>&<?php echo isset($_GET['price_high']) ? 'price_high='.$price_high : null; ?>" class="filter-link stext-106 trans-04 <?php echo $sort_by == 'Low to High' ? $cls : null;?>">
											Price: Low to High
										</a>
									</li>

									<li class="p-b-6">
										<a href="product.php?<?php echo isset($product_target) ? 'product_target='.$product_target : null;?>&sort_by=High to Low&cls=filter-link-active&<?php echo isset($_GET['price_low']) ? 'price_low='.$price_low : null; ?>&<?php echo isset($_GET['price_high']) ? 'price_high='.$price_high : null; ?>" class="filter-link stext-106 trans-04 <?php echo $sort_by == 'High to Low' ? $cls : null;?>">
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
										<a href="product.php?<?php echo isset($product_target) ? 'product_target='.$product_target : null;?>&sort_by=<?php echo $sort_by?>&cls=filter-link-active&price=all" class="filter-link stext-106 trans-04 <?php echo isset($_GET['price']) == 'all' ? $cls : null;?>">
											All
										</a>
									</li>

									<li class="p-b-6">
										<a href="product.php?<?php echo isset($product_target) ? 'product_target='.$product_target : null;?>&sort_by=<?php echo $sort_by?>&cls=filter-link-active&price_low=0&price_high=199" class="filter-link stext-106 trans-04 <?php echo $price_low == '0' ? $cls : null;?>">
											₹0.00 - ₹199.00
										</a>
									</li>

									<li class="p-b-6">
										<a href="product.php?<?php echo isset($product_target) ? 'product_target='.$product_target : null;?>&sort_by=<?php echo $sort_by?>&cls=filter-link-active&price_low=201&price_high=499" class="filter-link stext-106 trans-04 <?php echo $price_low == '201' ? $cls : null;?>">
											₹201.00 - ₹499.00
										</a>
									</li>

									<li class="p-b-6">
										<a href="product.php?<?php echo isset($product_target) ? 'product_target='.$product_target : null;?>&sort_by=<?php echo $sort_by?>&cls=filter-link-active&price_low=501&price_high=1499" class="filter-link stext-106 trans-04 <?php echo $price_low == '501' ? $cls : null;?>">
											₹501.00 - ₹1499.00
										</a>
									</li>

									<li class="p-b-6">
										<a href="product.php?<?php echo isset($product_target) ? 'product_target='.$product_target : null;?>&sort_by=<?php echo $sort_by?>&cls=filter-link-active&price_low=1501&price_high=2499" class="filter-link stext-106 trans-04 <?php echo $price_low == '1501' ? $cls : null;?>">
											₹1501.00 - ₹2499.00
										</a>
									</li>

									<li class="p-b-6">
										<a href="product.php?<?php echo isset($product_target) ? 'product_target='.$product_target : null;?>&sort_by=<?php echo $sort_by?>&cls=filter-link-active&price_low=2501&price_high=100000" class="filter-link stext-106 trans-04 <?php echo $price_low == '2501' ? $cls : null;?>">
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
					$product_data = mysqli_query($con, $product);
					while ($fetch_product = mysqli_fetch_array($product_data)) {
						$pr_img_arr = !empty($fetch_product['pr_imgs']) ? json_decode($fetch_product['pr_imgs'], true) : [];
						$main_pic = !empty($fetch_product['product_img']) ? 'image/product/' . $fetch_product['product_img'] : 'images/product-placeholder.jpg';
						$img1 = !empty($pr_img_arr[0]) ? 'image/product/pr_imgs/' . $pr_img_arr[0] : $main_pic;
						$img2 = !empty($pr_img_arr[1]) ? 'image/product/pr_imgs/' . $pr_img_arr[1] : $img1;
						$img3 = !empty($pr_img_arr[2]) ? 'image/product/pr_imgs/' . $pr_img_arr[2] : $img1;
						$category_class = htmlspecialchars($fetch_product['pc_name'] ?? '');
					?>
						<div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item <?php echo $category_class; ?>">
							<!-- Block2 -->
							<div class="block2">
								<div class="block2-pic hov-img0">
									<input type="hidden" value="<?php echo htmlspecialchars($img1); ?>" class="pr_img1">
									<input type="hidden" value="<?php echo htmlspecialchars($img2); ?>" class="pr_img2">
									<input type="hidden" value="<?php echo htmlspecialchars($img3); ?>" class="pr_img3">
									<input type="hidden" value="<?php echo $fetch_product['id']; ?>" class="product_details">
									<input type="hidden" value="<?php echo $fetch_product['product_price']; ?>" class="product_price">
									<img src="<?php echo htmlspecialchars($main_pic); ?>" alt="<?php echo htmlspecialchars($fetch_product['product_name']); ?>" onerror="this.src='images/product-placeholder.jpg'">
									<a href="#"
										class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
										Quick View
									</a>
								</div>

								<div class="block2-txt flex-w flex-t p-t-14">
									<div class="block2-txt-child1 flex-col-l ">
										<a href="product-detail.php?id=<?php echo $fetch_product['id']; ?>" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6 product_name">
											<?php echo htmlspecialchars($fetch_product['product_name']); ?>
										</a>

										<span class="stext-105 cl3">
											<b>₹ <?php echo number_format($fetch_product['product_price'], 2); ?></b>
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
		</div>


		<!-- Footer -->
		<footer class="bg3 p-t-75 p-b-32">
			<div class="container">
				<div class="row">
					<div class="col-sm-6 col-lg-3 p-b-50">
						<a href="index.php" class="stark-brand-logo mb-3" style="color: #fff !important;">
							<span class="brand-icon"><i class="fa fa-bolt"></i></span>
							<span class="brand-text" style="background: linear-gradient(135deg, #ffffff 0%, #a5b4fc 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">STARK</span>
							<span class="brand-badge" style="background: rgba(99,102,241,0.2); color: #818cf8;">STORE</span>
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
						<form class="stark-newsletter-form" onsubmit="event.preventDefault(); swal('Subscribed!', 'Welcome to the Stark VIP Club!', 'success');">
							<input type="email" placeholder="Enter your email" required>
							<button type="submit">Join <i class="fa fa-paper-plane ml-1"></i></button>
						</form>
					</div>
				</div>

				<div class="p-t-30 p-b-10" style="border-top: 1px solid rgba(255,255,255,0.08);">
					<div class="d-flex flex-wrap justify-content-between align-items-center">
						<p class="stext-107 cl6 m-0">
							&copy; <?php echo date('Y'); ?> <strong>Stark Store</strong>. All rights reserved. Built with precision & modern aesthetics.
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
									Lightweight Jacket
								</h4>

								<span class="mtext-106 cl2" id="data_price">
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
											<form action="cart_config.php" method="POST" class="cartForm">
												<input type="hidden" value="" name="cart_product" id="product_cart_details">
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
											<input type="hidden" value="" name="wish_product" id="product_wish_details">
											<button type="submit" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2" title="Add to Wishlist">
												<img class="icon-heart1 dis-block trans-04" src="images/icons/icon-heart-01.png"
													alt="ICON">
												<img class="icon-heart2 dis-block trans-04 ab-t-l"
													src="images/icons/icon-heart-02.png" alt="ICON">
											</button>
										</form>
									</div>
									<p>Add to your wishlist</p>
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
				e.preventDefault(); // Prevent the form from submitting the traditional way

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
			// setInterval(fetchWishlistData, 2000);

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

			// setInterval(fetchCartData, 2000);

			$(document).ready(function() {
				fetchCartData();
				fetchWishlistData();
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
		<!--===============================================================================================-->
		<script src="js/main.js"></script>
	</body>

</html>