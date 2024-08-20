-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 20, 2024 at 09:07 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `product`
--

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE `product_category` (
  `pc_id` int(11) NOT NULL,
  `pc_name` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_category`
--

INSERT INTO `product_category` (`pc_id`, `pc_name`) VALUES
(1, 'Cloth'),
(2, 'Watches'),
(3, 'Shoes'),
(4, 'Belt'),
(5, 'Accessories'),
(6, 'Other');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `pr_id` int(11) NOT NULL,
  `pr_imgs` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`pr_id`, `pr_imgs`) VALUES
(10, '[\"41VhSSlalQL._SL1198_.jpg\",\"61E0Jzp-JVL._SY879_.jpg\",\"61zdJmxjmuL._SL1500_.jpg\"]'),
(11, '[\"51YmKgWW8yL._SL1198_.jpg\",\"719gA5x-+eL._SY879_.jpg\",\"715m7v58JDL._SL1500_.jpg\"]'),
(12, '[\"41557PpoauL.jpg\",\"31lRz5TGgwL.jpg\",\"61dUjRK9hlL._SY575_.jpg\"]'),
(13, '[\"71Sz0Z8pN3L._SL1500_.jpg\",\"81YevpdhIFL._SL1500_.jpg\",\"71Y65B456dL._SL1500_.jpg\"]'),
(14, '[\"61zi7stGeBL._SY879_.jpg\",\"71po53JscwL._SY879_.jpg\",\"71WN+O34voL._SY879_.jpg\"]'),
(15, '[\"51LekMMIUTL._SX679_.jpg\",\"61STWDiipfL.jpg\",\"61wH1og5TrL._SX679_.jpg\"]'),
(16, '[\"71sWDULjp1L._SL1500_.jpg\",\"718YrDupr0L._SL1500_.jpg\",\"61HGSEvjMyL._SL1200_.jpg\"]');

-- --------------------------------------------------------

--
-- Table structure for table `product_item`
--

CREATE TABLE `product_item` (
  `id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `product_img` varchar(100) NOT NULL,
  `product_price` varchar(100) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `product_description` text NOT NULL,
  `product_related_img` int(11) DEFAULT NULL,
  `product_catg` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_item`
--

INSERT INTO `product_item` (`id`, `product_name`, `product_img`, `product_price`, `gender`, `product_description`, `product_related_img`, `product_catg`) VALUES
(10, 'Lymio Men T-Shirt || T-Shirt for Men || Polo T Shirt || T-Shirt (polo-30-33)', '61J70J3DBwL._SY879_.jpg', '1299', 'M', 'Men T-Shirt || T-Shirt for Men || Polo T Shirt || T-Shirt\r\nPattern Type: Plain\r\nSleeve Length: Short Sleeve\r\nColor Disclaimer: Product color might slightly vary due to photographic lighting sources or your monitor settings\r\nFit type-Regular Fit', 10, 1),
(11, 'Lux Cozi Mens Regular Fit Polo Neck Half Sleeve Solid Casual T-Shirt', '718j9P1Gf4L._SY879_.jpg', '1498', 'M', 'Lux Cozi Mens Regular Fit Polo Neck Half Sleeve Solid Casual T-shirt is a stylish and comfortable choice for casual wear.\r\nThe half sleeves offer a relaxed and versatile style, perfect for warmer weather or layering under jackets.\r\nThe solid color design adds a touch of elegance and makes it easy to pair with different bottoms.\r\nIt is suitable for various occasions, including casual outings, social gatherings, and relaxed work environments.\r\nThe T-shirt is designed with a classic polo neck, giving it a sophisticated and timeless look.', 11, 1),
(12, 'Fox Racing uniquesex-adult Modern', '31WPIRNSGQL.jpg', '49999', 'M', 'Dual BOA Li2 system provides on the move micro-adjustability and improved power transfer to the pedals.\r\nOne-piece welded seamless upper reduces weight. Molded toe cap is designed to protect against rock strikes. Molded internal stiffening plate optimizes power transfer and off-bike comfort. and offers a precise fit.\r\nUltratac rubber compound provides excellent durability and unprecedented grip.\r\nHigh and low arch support options for a custom fit.\r\n2-bolt cleat system is compatible with all major pedal suppliers.', 12, 3),
(13, 'Lymio Men T-Shirt || T-Shirt for Men || Plain T Shirt || T-Shirt (Polo-18-21)', '71Jukhvw8DL._SL1500_.jpg', '799', 'M', 'Men T Shirt || T-Shirt For Men || Plain T Shirt || T-Shirt\r\nPattern Type: Plain\r\nSleeve Length: Short Sleeve\r\nColor Disclaimer: Product color might slightly vary due to photographic lighting sources or your monitor settings\r\nFit type-Regular Fit', 13, 1),
(14, 'Lymio Men T-Shirt || Regular Fit T-Shirt for Men || Plain T Shirt || T-Shirt (Polo-11-13)', '71DGe7O4jCL._SY879_.jpg', '499', 'M', 'Men T Shirt || T-Shirt For Men || Plain T Shirt || T-Shirt\r\nPattern Type: Plain\r\nSleeve Length: Short Sleeve\r\nColor Disclaimer: Product color might slightly vary due to photographic lighting sources or your monitor settings', 14, 1),
(15, 'Samsung Galaxy Watch4 Classic LTE (4.6cm, Black)', 'ab.jpg', '10999', 'M', 'Only compatible with Android Smartphones (Runs on Wear OS Powered by Samsung)\r\nBioelectrical Impedance Analysis Sensor for Body Composition Analysis, Optical Heart Rate Sensor.\r\nHealth Monitoring features such as Advanced Sleep Analysis & Women Health.', 15, 2),
(16, 'OnePlus Watch 2 with Wear OS4,Snapdragon W5 Chipset,Upto 100 hrs Battery Life,1.43’’ AMOLED Display,', '71RYeHLHnGL._SL1500_.jpg', '23499', 'M', 'OS + Chipsets + Storage Wear OS 4, Snapdragon W5 + BES2700 dual chipsets with 2GB RAM and 32GB ROM memory;Battery Life + Fast Charging Up to 100 hours battery life in Smart Mode (Up to 48 hours with heavy use), and 12 days battery life in Power Saver Mode. Fully charged in 60 minutes with VOOC fast charging, and 24 hours of use with 10 minutes of charging.\r\n1.43\" AMOLED Display Default brightness of 600 nits, up to 1000 nits in High Brightness mode. 466*466 resolution with 326 PPI.;Design & Durability Stainless Steel chassis and Sapphire Crystal cover, Military grade MIL-STD-810H standard certified. 5 ATM + IP68 rated.', 16, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`pc_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`pr_id`),
  ADD UNIQUE KEY `pr_id` (`pr_id`);

--
-- Indexes for table `product_item`
--
ALTER TABLE `product_item`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `fk_product_related_img` (`product_related_img`),
  ADD KEY `fk_product_catg` (`product_catg`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `product_item`
--
ALTER TABLE `product_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product_item`
--
ALTER TABLE `product_item`
  ADD CONSTRAINT `fk_product_catg` FOREIGN KEY (`product_catg`) REFERENCES `product_category` (`pc_id`),
  ADD CONSTRAINT `fk_product_related_img` FOREIGN KEY (`product_related_img`) REFERENCES `product_images` (`pr_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
