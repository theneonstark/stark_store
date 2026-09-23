-- Stark Store Complete Unified Database Schema & Seed Data
-- Compatible with MySQL 5.7+, MySQL 8.0+, MariaDB

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------
-- Table structure for `department`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `department` (
  `dept_id` int(11) NOT NULL,
  `dept_name` varchar(120) NOT NULL,
  PRIMARY KEY (`dept_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `department` (`dept_id`, `dept_name`) VALUES
(1, 'admin'),
(2, 'user')
ON DUPLICATE KEY UPDATE `dept_name`=VALUES(`dept_name`);

-- --------------------------------------------------------
-- Table structure for `admins`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(150) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `profile_img` text DEFAULT 'user_profile.jpg',
  `office` int(11) DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `admins` (`id`, `name`, `username`, `email`, `password`, `created_at`, `profile_img`, `office`) VALUES
(1, 'Shahid', 'neonPeHunt', 'admin@PeHuntstore.com', 'admin123', '2024-08-03 10:17:53', 'user_profile.jpg', 1)
ON DUPLICATE KEY UPDATE `name`=VALUES(`name`);

-- --------------------------------------------------------
-- Table structure for `google_user`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `google_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sub` text NOT NULL,
  `name` text NOT NULL,
  `given_name` text NOT NULL,
  `picture` text NOT NULL,
  `email` text NOT NULL,
  `email_verify` tinyint(1) NOT NULL,
  `dept` int(11) DEFAULT 2,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Table structure for `users`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `Mobile` varchar(100) NOT NULL,
  `password` varchar(150) NOT NULL,
  `profile_img` text DEFAULT 'user_profile.jpg',
  `office` int(11) DEFAULT 2,
  `username` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `wishlist` varchar(100) DEFAULT 'user_wishlist',
  `cart` varchar(100) DEFAULT 'user_cart',
  `address` text DEFAULT NULL,
  `landmark` text DEFAULT NULL,
  `city` text DEFAULT NULL,
  `zip` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` (`id`, `name`, `email`, `Mobile`, `password`, `profile_img`, `office`, `username`, `created_at`, `wishlist`, `cart`, `address`, `landmark`, `city`, `zip`, `state`) VALUES
(11, 'Tarun', 'tarun@gmail.com', '9632587410', 'tarun123', 'user_profile.jpg', 2, 'Tartarunta96', '2024-08-10 07:51:05', 'user_wishlist', 'user_cart', NULL, NULL, NULL, NULL, NULL),
(12, 'Sahil', 'sahil@gmail.com', '7418529630', 'sahil123', 'user_profile.jpg', 2, 'Sahsahilsa74', '2024-08-10 08:07:27', 'user_wishlist', 'user_cart', 'H.No 452, Green Park', 'Opposite Metro Station', 'New Delhi', '110016', 'Delhi'),
(13, 'Manish', 'manish@gmail.com', '8526541254', 'manish123', 'user_profile.jpg', 2, 'Manmanisma85', '2024-08-10 08:13:23', 'user_wishlist', 'user_cart', NULL, NULL, NULL, NULL, NULL),
(14, 'Punit', 'punit@gmail.com', '9856745872', 'pun123', 'user_profile.jpg', 2, 'Punpunitpu98', '2024-08-10 18:35:06', 'user_wishlist', 'user_cart', 'AB-145, Harsh Vihar, OM Nagar', 'Near GYM', 'Badarpur', '110044', 'New Delhi')
ON DUPLICATE KEY UPDATE `name`=VALUES(`name`);

-- --------------------------------------------------------
-- Table structure for `product_category`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `product_category` (
  `pc_id` int(11) NOT NULL,
  `pc_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`pc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `product_category` (`pc_id`, `pc_name`) VALUES
(1, 'Cloth'),
(2, 'Watches'),
(3, 'Shoes'),
(4, 'Belt'),
(5, 'Accessories'),
(6, 'Other')
ON DUPLICATE KEY UPDATE `pc_name`=VALUES(`pc_name`);

-- --------------------------------------------------------
-- Table structure for `product_images`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `product_images` (
  `pr_id` int(11) NOT NULL,
  `pr_imgs` text DEFAULT NULL,
  PRIMARY KEY (`pr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `product_images` (`pr_id`, `pr_imgs`) VALUES
(10, '[\"41VhSSlalQL._SL1198_.jpg\",\"61E0Jzp-JVL._SY879_.jpg\",\"61zdJmxjmuL._SL1500_.jpg\"]'),
(11, '[\"51YmKgWW8yL._SL1198_.jpg\",\"719gA5x-+eL._SY879_.jpg\",\"715m7v58JDL._SL1500_.jpg\"]'),
(12, '[\"41557PpoauL.jpg\",\"31lRz5TGgwL.jpg\",\"61dUjRK9hlL._SY575_.jpg\"]'),
(13, '[\"71Sz0Z8pN3L._SL1500_.jpg\",\"81YevpdhIFL._SL1500_.jpg\",\"71Y65B456dL._SL1500_.jpg\"]'),
(14, '[\"61zi7stGeBL._SY879_.jpg\",\"71po53JscwL._SY879_.jpg\",\"71WN+O34voL._SY879_.jpg\"]'),
(15, '[\"51LekMMIUTL._SX679_.jpg\",\"61STWDiipfL.jpg\",\"61wH1og5TrL._SX679_.jpg\"]'),
(16, '[\"71sWDULjp1L._SL1500_.jpg\",\"718YrDupr0L._SL1500_.jpg\",\"61HGSEvjMyL._SL1200_.jpg\"]'),
(17, '[\"61gRzURpwPL._SX385_.jpg\",\"61k-Up1smUL.jpg\",\"617aCMTyxVL._SX342_.jpg\"]'),
(18, '[\"41O5h3w01bL.jpg\",\"61kVB5UhudL._SY741_.jpg\",\"81-22a+3KJL._SY741_.jpg\"]'),
(19, '[\"81edCHW+MlL._SX679_.jpg\",\"41y0wxhknBL.jpg\",\"61oAd7c6svL._SX342_.jpg\"]'),
(20, '[\"91CfNNPQZcL._SY741_.jpg\",\"61S9EPYVbrL._SY741_.jpg\",\"614RgcJkQAL._SY445_.jpg\"]'),
(21, '[\"614u99dX+HL._SL1500_.jpg\",\"61C8JNTZQdL._SL1500_.jpg\",\"61xfIdV7maL._SL1500_.jpg\"]'),
(23, '[\"61-p5iMBC5L._SL1500_.jpg\",\"61lEfUv8gbL._SL1500_.jpg\",\"71UMrTcV3NL._SL1500_.jpg\"]'),
(24, '[\"61zr-tqC2ML._SY450_.jpg\",\"71ZKr1fJFQL._SL1500_.jpg\",\"61MdlCQ+-oL._SL1500_.jpg\"]')
ON DUPLICATE KEY UPDATE `pr_imgs`=VALUES(`pr_imgs`);

-- --------------------------------------------------------
-- Table structure for `product_item`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `product_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) NOT NULL,
  `product_img` varchar(255) NOT NULL,
  `product_price` int(11) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `product_description` text NOT NULL,
  `product_related_img` int(11) DEFAULT NULL,
  `product_catg` int(11) DEFAULT NULL,
  `added_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `product_item` (`id`, `product_name`, `product_img`, `product_price`, `gender`, `product_description`, `product_related_img`, `product_catg`, `added_at`) VALUES
(10, 'Lymio Men T-Shirt || T-Shirt for Men || Polo T Shirt || T-Shirt (polo-30-33)', '61J70J3DBwL._SY879_.jpg', 1299, 'M', 'Men T-Shirt || T-Shirt for Men || Polo T Shirt || T-Shirt\r\nPattern Type: Plain\r\nSleeve Length: Short Sleeve\r\nColor Disclaimer: Product color might slightly vary due to photographic lighting sources or your monitor settings\r\nFit type-Regular Fit', 10, 1, '2024-11-03 08:38:04'),
(11, 'Lux Cozi Mens Regular Fit Polo Neck Half Sleeve Solid Casual T-Shirt', '718j9P1Gf4L._SY879_.jpg', 1498, 'M', 'Lux Cozi Mens Regular Fit Polo Neck Half Sleeve Solid Casual T-shirt is a stylish and comfortable choice for casual wear.\r\nThe half sleeves offer a relaxed and versatile style, perfect for warmer weather or layering under jackets.\r\nThe solid color design adds a touch of elegance and makes it easy to pair with different bottoms.\r\nIt is suitable for various occasions, including casual outings, social gatherings, and relaxed work environments.\r\nThe T-shirt is designed with a classic polo neck, giving it a sophisticated and timeless look.', 11, 1, '2024-11-03 08:38:04'),
(12, 'Fox Racing uniquesex-adult Modern', '31WPIRNSGQL.jpg', 49999, 'M', 'Dual BOA Li2 system provides on the move micro-adjustability and improved power transfer to the pedals.\r\nOne-piece welded seamless upper reduces weight. Molded toe cap is designed to protect against rock strikes. Molded internal stiffening plate optimizes power transfer and off-bike comfort. and offers a precise fit.\r\nUltratac rubber compound provides excellent durability and unprecedented grip.\r\nHigh and low arch support options for a custom fit.\r\n2-bolt cleat system is compatible with all major pedal suppliers.', 12, 3, '2024-11-03 08:38:04'),
(13, 'Lymio Men T-Shirt || T-Shirt for Men || Plain T Shirt || T-Shirt (Polo-18-21)', '71Jukhvw8DL._SL1500_.jpg', 799, 'M', 'Men T Shirt || T-Shirt For Men || Plain T Shirt || T-Shirt\r\nPattern Type: Plain\r\nSleeve Length: Short Sleeve\r\nColor Disclaimer: Product color might slightly vary due to photographic lighting sources or your monitor settings\r\nFit type-Regular Fit', 13, 1, '2024-11-03 08:38:04'),
(14, 'Lymio Men T-Shirt || Regular Fit T-Shirt for Men || Plain T Shirt || T-Shirt (Polo-11-13)', '71DGe7O4jCL._SY879_.jpg', 499, 'M', 'Men T Shirt || T-Shirt For Men || Plain T Shirt || T-Shirt\r\nPattern Type: Plain\r\nSleeve Length: Short Sleeve\r\nColor Disclaimer: Product color might slightly vary due to photographic lighting sources or your monitor settings', 14, 1, '2024-11-03 08:38:04'),
(15, 'Samsung Galaxy Watch4 Classic LTE (4.6cm, Black)', 'ab.jpg', 10999, 'M', 'Only compatible with Android Smartphones (Runs on Wear OS Powered by Samsung)\r\nBioelectrical Impedance Analysis Sensor for Body Composition Analysis, Optical Heart Rate Sensor.\r\nHealth Monitoring features such as Advanced Sleep Analysis & Women Health.', 15, 2, '2024-11-03 08:38:04'),
(16, 'OnePlus Watch 2 with Wear OS4,Snapdragon W5 Chipset,Upto 100 hrs Battery Life,1.43 AMOLED Display', '71RYeHLHnGL._SL1500_.jpg', 23499, 'M', 'OS + Chipsets + Storage Wear OS 4, Snapdragon W5 + BES2700 dual chipsets with 2GB RAM and 32GB ROM memory;Battery Life + Fast Charging Up to 100 hours battery life in Smart Mode (Up to 48 hours with heavy use), and 12 days battery life in Power Saver Mode. Fully charged in 60 minutes with VOOC fast charging, and 24 hours of use with 10 minutes of charging.\r\n1.43\" AMOLED Display Default brightness of 600 nits, up to 1000 nits in High Brightness mode. 466*466 resolution with 326 PPI.;Design & Durability Stainless Steel chassis and Sapphire Crystal cover, Military grade MIL-STD-810H standard certified. 5 ATM + IP68 rated.', 16, 2, '2024-11-03 08:38:04'),
(17, 'Columbia Women\'s W Omni-Heat Infinity Knit LS Crew', '613WyitV6yL.jpg', 4999, 'F', 'Features: Omni-Heat Infinity advanced thermal reflective., Omni-Wick., Comfort stretch., Captures and neutralizes Odor for long-lasting freshness.', 17, 1, '2024-11-03 08:38:04'),
(18, 'Libas Purple Yoke Design Silk Blend Anarkali Kurta With Churidar & Dupatta', '61-COg8J9RL._SY606_.jpg', 2879, 'F', 'Top Color : Purple\r\nSet Contents : 1 Kurta 1 Churidar 1 Dupatta\r\nTop Pattern : Yoke Design\r\nTop Fabric :Silk Blend\r\nOccasion : Festive', 18, 1, '2024-11-03 08:38:04'),
(19, 'BIBA Women Rayon Printed Straight Kurta', '71ovBo96PEL._SX342_.jpg', 1479, 'F', 'Colour : Green\r\nKurta Fit : Straight\r\nWash Care : Wash Separately In Cold Water, Do Not Bleach, Dry In Shade, Medium To Hot Iron.,Made In India\r\nPackage Includes : Kurta\r\nDepartment : Women\r\nKurta', 19, 1, '2024-11-03 08:38:04'),
(20, 'W for Woman Solid Straight Kurta Sets With Slim Pants & Dupatta', '71RbvzziCrL._SY679_.jpg', 2200, 'F', 'Product Description: This off-white coloured viscose kurta set for women has straight silhouette and regular fit. The kurta is designed in round neck and has 3/4 sleeve. This beautiful solid kurta for women is crafted in rayon fabric which is comfy, stylish and add premium look.', 20, 1, '2024-11-03 08:38:04'),
(21, 'OnePlus Bullets Wireless Z2 Bluetooth in-Ear Neckband', '61DpOqDGGRL._SL1500_.jpg', 1299, 'O', 'A quick 10-minute charge delivers up to 20 hours of immersive audio playback; The flagship-level battery life delivers up to 30 hours of non-stop music on a single charge. A large 12.4 mm bass driver delivers uncompromisingly deep bass for powerful beats.', 21, 5, '2024-11-03 08:38:04'),
(23, 'Samsung Galaxy Buds Fe (White)| Powerful Active Noise Cancellation', '61dTcv+ma3L._SL1500_.jpg', 3999, 'O', 'SUPERIOR SOUND - Indulge in rich sound of Galaxy Buds FE with deep, powerful bass from the new 1-way speaker, no matter what you\'re listening to. Active Noise Canceling instantly puts you alone with your music in a quiet space.', 23, 5, '2024-11-03 08:38:04'),
(24, 'boAt Rockerz 255 Z Plus Bluetooth in-Ear Neckband', '61vaxn5X09L._SY450_.jpg', 1299, 'O', 'AI-ENx Technology: Hustle on the go with crystal-clear calls regardless of your location using the boAt Rockerz 255 Z Plus Neckband Earphones. 50 hrs of Playtime. Magnetic Power Buds.', 24, 5, '2024-11-03 08:39:46')
ON DUPLICATE KEY UPDATE `product_name`=VALUES(`product_name`);

-- --------------------------------------------------------
-- Table structure for `user_cart` (Unified Cart Table)
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `user_cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `session_id` varchar(100) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_session_id` (`session_id`),
  KEY `idx_product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Table structure for `user_wishlist` (Unified Wishlist Table)
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `user_wishlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `session_id` varchar(100) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_session_id` (`session_id`),
  KEY `idx_product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Table structure for `user_order`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `user_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `product_id` longtext DEFAULT NULL,
  `razorpay_order_id` varchar(255) DEFAULT NULL,
  `razorpay_payment_id` varchar(255) DEFAULT NULL,
  `currency` varchar(10) DEFAULT 'INR',
  `status` varchar(50) DEFAULT 'Processing',
  `payment_method` varchar(50) DEFAULT 'Cash on Delivery',
  `address` longtext DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `user_order` (`id`, `user_id`, `amount`, `product_id`, `razorpay_order_id`, `razorpay_payment_id`, `currency`, `status`, `payment_method`, `address`, `created_at`) VALUES
(15, 14, 13596, '[\"15\",\"10\",\"14\",\"13\"]', 'order_P2eqsBW4rFZj8M', 'pay_P2eqycaKNtE8Xc', 'INR', 'Completed', 'Razorpay', 'AB-145, Harsh Vihar, OM Nagar,Near GYM,Badarpur,110044-New Delhi', '2024-09-28 16:48:53'),
(16, 14, 13596, '[\"15\",\"10\",\"14\",\"13\"]', 'order_P2fkcaMC9qDRZz', 'pay_P2fkxn8vGYzSQb', 'INR', 'Completed', 'Razorpay', 'AB-145, Harsh Vihar, OM Nagar,Near GYM,Badarpur,110044-New Delhi', '2024-09-28 17:41:53'),
(17, 14, 15094, '[\"15\",\"10\",\"14\",\"13\",\"11\"]', 'order_P2fpDe8JYBE1Bj', 'pay_P2fpJBPPJHZPCG', 'INR', 'Completed', 'Razorpay', 'AB-145, Harsh Vihar, OM Nagar,Near GYM,Badarpur,110044-New Delhi', '2024-09-28 17:46:04')
ON DUPLICATE KEY UPDATE `amount`=VALUES(`amount`);

-- --------------------------------------------------------
-- Table structure for `admin_notify`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `admin_notify` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `notify_name` varchar(100) NOT NULL,
  `notify_email` varchar(100) NOT NULL,
  `notify_username` varchar(100) NOT NULL,
  `notify_img` varchar(100) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `notify_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `admin_notify` (`id`, `notify_name`, `notify_email`, `notify_username`, `notify_img`, `active`, `notify_active`) VALUES
(1, 'Shahid', 'mohd47149@gmail.com', 'neonPeHunt', 'user_profile.jpg', 1, 0),
(12, 'Shahid', 'mohd47149@gmail.com', 'Shamohd4sh98', 'user_profile.jpg', 1, 0)
ON DUPLICATE KEY UPDATE `notify_name`=VALUES(`notify_name`);

-- --------------------------------------------------------
-- Table structure for `queries`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `queries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `queries` (`id`, `email`, `message`) VALUES
(1, 'mohd47149@gmail.com', 'Welcome to Stark Store support!')
ON DUPLICATE KEY UPDATE `message`=VALUES(`message`);

-- --------------------------------------------------------
-- Table structure for `posts`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `story` text DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `posted_by` int(11) NOT NULL DEFAULT 1,
  `blog_img` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `posts` (`id`, `title`, `story`, `tags`, `posted_by`, `blog_img`, `created_at`, `updated_at`) VALUES
(4, 'From Vision to Reality: The Journey of Building Stark Store', 'In a world increasingly reliant on e-commerce, building Stark Store was born out of a desire for a premium shopping experience.', '[\"Store\",\"Launch\",\"Tech\",\"Fashion\"]', 1, 'PeHunt.jpg', '2024-10-29 19:29:52', '2024-10-29 19:29:52')
ON DUPLICATE KEY UPDATE `title`=VALUES(`title`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
