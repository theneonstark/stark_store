<!DOCTYPE html>
<html lang="en">

<head>
	<?php
	session_start();
	include('config.php');
	$product = "SELECT * FROM product_item LEFT JOIN product_images ON product_item.product_related_img = product_images.pr_id LEFT JOIN product_category ON product_item.product_catg = product_category.pc_id;
		";
	$wishlist_data = "select * from wishlist";
	?>
	<title>About</title>
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
						if (isset($_SESSION['email']) || isset($_SESSION['google_email'])) {
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
								if (isset($_SESSION['email']) || isset($_SESSION['google_email'])) {
								?>
									<a href="#" class="dropdown-item font-weight-bold">Profile</a>
									<a href="orders.php" class="dropdown-item font-weight-bold">Your Orders</a>
									<a href="#" class="dropdown-item font-weight-bold">Your Wishlist</a>
									<div class="dropdown-divider"></div>
									<a href="logout.php" class="dropdown-item text-danger font-weight-bold">Logout</a>
								<?php
								} else {
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
						if (isset($_SESSION['email']) || isset($_SESSION['google_email'])) {
						?>
							<li><a href="#" class="dropdown-item font-weight-bold">Profile</a></li>
							<li><a href="orders.php" class="dropdown-item font-weight-bold">Your Orders</a></li>
							<li><a href="#" class="dropdown-item font-weight-bold">Your Wishlist</a></li>
							<div class="dropdown-divider"></div>
							<li><a href="logout.php" class="dropdown-item text-danger font-weight-bold">Logout</a></li>
						<?php
						} else {
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

	<!-- wishlist -->
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
			About
		</h2>
	</section>


	<!-- Content page -->
	<section class="bg0 p-t-75 p-b-120">
		<div class="container">
			<!-- About PeHunt -->
			<div class="row p-b-148">
				<div class="col-md-7 col-lg-8">
					<div class="p-t-7 p-r-85 p-r-15-lg p-r-0-md">
						<h3 class="mtext-111 cl2 p-b-16">
							About PeHunt
						</h3>

						<p class="stext-113 cl6 p-b-26">
							Welcome to PeHunt, your go-to destination for all things modern, stylish, and innovative. We’re more than just an e-commerce platform; we are a brand committed to bringing you products that elevate your everyday life with quality, value, and the latest trends. At PeHunt, we believe that shopping should be an experience—one that’s seamless, enjoyable, and tailored to you.
						</p>

						<h3 class="mtext-111 cl2 p-b-16">
							Why PeHunt?
						</h3>
						<p class="stext-113 cl6 p-b-26">
							We understand that shopping online can sometimes be overwhelming. With countless options available, it’s often difficult to find what you need without sacrificing quality or affordability. That’s why PeHunt is committed to being different. Here’s what sets us apart:

						<ul>
							<li class="stext-10 cl6 p-b-26"><strong>Quality Assurance:</strong> We hand-pick every item in our store, ensuring that it meets our high standards for quality and durability. We work with trusted suppliers and manufacturers to bring you products that you can rely on.</li>
							<li class="stext-10 cl6 p-b-26"><strong>Customer-Centric Approach:</strong> Your satisfaction is our priority. From the moment you land on our website to the time your package arrives, we are dedicated to providing an exceptional shopping experience. Our customer support team is always ready to assist with any questions or concerns.</li>
							<li class="stext-10 cl6 p-b-26"><strong>Trendy and Innovative Products:</strong> We stay on top of the latest trends in fashion, technology, home decor, and more to ensure that PeHunt is always stocked with products that reflect the current style and innovation.</li>
							<li class="stext-10 cl6 p-b-26"><strong>Secure and Convenient Shopping:</strong> We know how important it is to have a hassle-free shopping experience. Our platform is designed to be user-friendly and secure, offering multiple payment options and ensuring the privacy of your personal information.</li>
						</ul>
						</p>
						<p class="stext-113 cl6 p-b-26">
							Any questions? Let us know in store at <strong> Pehunt soultion OPC Pvt Ltd , Office No GF-05, H73, Sector 63 Noida UP 201301  </strong>
						</p>
					</div>
				</div>

				<div class="col-11 col-md-5 col-lg-4 m-lr-auto">
					<div class="how-bor1 ">
						<div class="hov-img0">
							<img src="images/about-01.jpg" alt="IMG">
						</div>
					</div>
				</div>
			</div>
			<!-- Founder -->
			<!-- <div class="row p-b-148">
				<div class="order-md-2 col-md-7 col-lg-8 p-b-30">
					<div class="p-t-7 p-l-85 p-l-15-lg p-l-0-md">
						<h3 class="mtext-111 cl2 p-b-16">
							PeHunt's Founder & Dev. ()
						</h3>

						<p class="stext-113 cl6 p-b-26">
						<ul>
							<li class="stext-10 cl6 p-b-26"><strong>PeHunt</strong> is an innovative and dynamic e-commerce platform designed to offer customers a seamless, convenient, and enjoyable online shopping experience. Powered by cutting-edge technologies like HTML, CSS, JavaScript, PHP, MySQL, Bootstrap, Tailwind, jQuery, AJAX, and more, <strong>PeHunt</strong> stands out in the competitive digital marketplace. Whether you're searching for fashion, electronics, home goods, or lifestyle products, <strong>PeHunt</strong> has it all.</li>
							<li class="stext-10 cl6 p-b-26">One of the key features of <strong>PeHunt</strong> is its user-friendly interface, which is both responsive and visually appealing. The store ensures smooth navigation across devices, allowing users to browse, add to cart, and check out effortlessly. Behind the scenes, dynamic features such as Cart.js handle real-time cart updates, while Email.js ensures prompt communication for order confirmations and queries, providing a personalized customer experience.</li>
							<li class="stext-10 cl6 p-b-26">Security and performance are top priorities at <strong>PeHunt</strong>. The use of MySQL for robust database management guarantees the safe storage of customer data and transaction details. Additionally, the platform's integration with Swiper.js enhances product image galleries, offering customers a clear and interactive product view before making a purchase.</li>
							<li class="stext-10 cl6 p-b-26"><strong>PeHunt</strong> also includes tailored features such as wishlist options, secure payment gateways, and detailed product modals to ensure every customer has the tools they need for an informed purchase decision. With a clean design powered by Tailwind and Bootstrap, shoppers are treated to an aesthetically pleasing yet highly functional online shopping environment.</li>
							<li class="stext-10 cl6 p-b-26"><strong>PeHunt</strong> is committed to staying ahead of e-commerce trends, continually upgrading its features and performance to provide a shopping experience that’s fast, secure, and satisfying for all.</li>
						</ul>
						</p>
					</div>
				</div>

				<div class="order-md-1 col-11 col-md-5 col-lg-4 m-lr-auto p-b-30">
					<div class="how-bor2">
						<div class="hov-img0">
							<img src="images/founder.jpeg" alt="IMG">
						</div>
					</div>
				</div>
			</div> -->
			<!-- Graphics -->
			<!-- <div class="row p-b-148">
				<div class="col-md-7 col-lg-8">
					<div class="p-t-7 p-r-85 p-r-15-lg p-r-0-md">
						<h3 class="mtext-111 cl2 p-b-16">
							Our Graphic Designer (Sahil Gautam)
						</h3>

						<p class="stext-113 cl6 p-b-26">
							<strong>Sahil</strong>, the talented graphic designer behind <strong>PeHunt</strong>, plays a pivotal role in crafting the visual identity of the website. His creativity is evident in the sleek and modern design, contributing to the overall user experience by making the site not only functional but visually appealing. <strong>Sahil</strong> ensures that each element of the website—from banners and product images to logos and icons—resonates with the brand’s identity and enhances the shopping experience. His designs are tailored to provide clarity and engage users, offering a seamless blend of aesthetics and usability.

							<strong>Sahil</strong>'s eye for detail ensures that every graphic aligns perfectly with the website's overall theme, creating a cohesive and professional appearance. His work complements the technical backbone of <strong>PeHunt</strong>, ensuring that it stands out in a competitive market with a memorable, polished look.
						</p>
					</div>
				</div>

				<div class="col-11 col-md-5 col-lg-4 m-lr-auto">
					<div class="how-bor1 ">
						<div class="hov-img0">
							<img src="images/Graphic.jpeg" alt="IMG">
						</div>
					</div>
				</div>
			</div> -->
			<!-- Analytics manager -->
			<!-- <div class="row p-b-148">
				<div class="order-md-2 col-md-7 col-lg-8 p-b-30">
					<div class="p-t-7 p-l-85 p-l-15-lg p-l-0-md">
						<h3 class="mtext-111 cl2 p-b-16">
							Analytics manager (Punit Nigam)
						</h3>

						<p class="stext-113 cl6 p-b-26">
						<ul>
							<li class="stext-10 cl6 p-b-26">
								<strong>The Role of an Analytics Manager for PeHunt</strong>
								The analytics manager for the PeHunt website plays a pivotal role in ensuring the success of the e-commerce platform by leveraging data-driven insights to inform strategic decisions. This position encompasses various responsibilities focused on data collection, analysis, and reporting, ultimately contributing to the optimization of marketing efforts, user experience, and overall business performance.
							</li>
							<li class="stext-10 cl6 p-b-26">
								<strong>Data Collection and Management</strong>
								A primary responsibility of the analytics manager is the implementation and management of data collection tools. Utilizing platforms like Google Analytics, Adobe Analytics, or similar tools, the manager ensures the website effectively captures relevant data, such as user behavior, traffic sources, conversion rates, and demographic information. This involves configuring tracking codes, setting up event tracking for specific user interactions, and maintaining data integrity to ensure accuracy.
							</li>
							<li class="stext-10 cl6 p-b-26">
								<strong>Performance Analysis</strong>
								Once data is collected, the analytics manager analyzes it to extract meaningful insights. Key performance indicators (KPIs) such as page views, bounce rates, and average session durations are scrutinized to gauge website performance. By identifying trends and patterns in user behavior, the manager can determine which products or marketing campaigns are performing well and which areas may need improvement. This analysis helps in understanding customer preferences, leading to more targeted marketing strategies.
							</li>
							<li class="stext-10 cl6 p-b-26">
								<strong>Reporting</strong>
								An essential function of the analytics manager is to create and present reports that communicate insights to various stakeholders, including product managers, marketing teams, and executives. These reports are crafted to be clear and actionable, often featuring visualizations and dashboards that make complex data more accessible. Regular reporting not only tracks performance but also aids in making informed decisions based on real-time data.
							</li>
							<li class="stext-10 cl6 p-b-26">
								<strong>Conversion Rate Optimization (CRO)</strong>
								The analytics manager also plays a critical role in conversion rate optimization. By conducting A/B tests and multivariate tests, they evaluate different elements of the website to determine what drives higher conversion rates. Collaborating with the marketing team, the manager can implement changes based on these findings, optimizing landing pages, product descriptions, and call-to-action buttons to enhance the user experience and increase sales..
							</li>
							<li class="stext-10 cl6 p-b-26">
								<strong>User Experience (UX) Insights</strong>
								Understanding the user journey is crucial for the success of any e-commerce website. The analytics manager gathers data on user interactions to identify pain points and obstacles in the purchasing process. By analyzing user flows and drop-off rates, they can provide actionable recommendations for improving website usability, thus enhancing the overall shopping experience..
							</li>
							<li class="stext-10 cl6 p-b-26">
								<strong>Market Research</strong>
								In addition to analyzing internal data, the analytics manager conducts market research to understand competitor performance and emerging market trends. This research can inform product development and marketing strategies, identifying new opportunities for growth based on data-driven insights.
							</li>
							<li class="stext-10 cl6 p-b-26">
								<strong>Collaboration and Communication</strong>
								Effective collaboration is key in the role of an analytics manager. Working closely with marketing, product management, and IT teams, the manager ensures that analytics strategies align with overall business objectives. Their expertise supports data-driven decision-making across the organization, fostering a culture of continuous improvement.</li>
						</ul>
						</p>
					</div>
				</div>

				<div class="order-md-1 col-11 col-md-5 col-lg-4 m-lr-auto p-b-30">
					<div class="how-bor2">
						<div class="hov-img0">
							<img src="images/Analytics.jpeg" alt="IMG">
						</div>
					</div>
				</div>
			</div> -->
			<!-- Product Manager -->
			<!-- Our Mission -->
			<div class="row p-b-148">
				<div class="order-md-2 col-md-7 col-lg-8 p-b-30">
					<div class="p-t-7 p-l-85 p-l-15-lg p-l-0-md">
						<h3 class="mtext-111 cl2 p-b-16">
							Our Mission
						</h3>

						<p class="stext-113 cl6 p-b-26">
							<strong>PeHunt</strong> was founded with a vision: to create an online store where quality meets convenience. Starting from humble beginnings, we’ve grown into a trusted name in the e-commerce space, with a wide range of products that cater to a diverse customer base. Our founders shared a common goal of building a store that offers something for everyone, whether it’s a trendy piece of clothing, the latest tech gadget, or a stylish home accessory. Over the years, we’ve evolved and expanded, but our core values have remained the same—quality, affordability, and customer satisfaction.
						</p>

						<div class="bor16 p-l-29 p-b-9 m-t-22">
							<p class="stext-114 cl6 p-r-40 p-b-11">
								Creativity is just connecting things. When you ask creative people how they did something, they feel a little guilty because they didn't really do it, they just saw something. It seemed obvious to them after a while.
							</p>

							<span class="stext-111 cl8">
								- Steve Job’s
							</span>
						</div>
					</div>
				</div>

				<div class="order-md-1 col-11 col-md-5 col-lg-4 m-lr-auto p-b-30">
					<div class="how-bor2">
						<div class="hov-img0">
							<img src="images/about-02.jpg" alt="IMG">
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>



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

				<div class="col-sm-6 col-lg-4 p-b-50">
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
					</script> All rights reserved | Pehunt soultion OPC Pvt Ltd
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