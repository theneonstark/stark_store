-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 17, 2024 at 10:36 PM
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
(11, '[\"51YmKgWW8yL._SL1198_.jpg\",\"719gA5x-+eL._SY879_.jpg\",\"715m7v58JDL._SL1500_.jpg\"]');

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
(11, 'Lux Cozi Mens Regular Fit Polo Neck Half Sleeve Solid Casual T-Shirt', '718j9P1Gf4L._SY879_.jpg', '1498', 'M', 'Lux Cozi Mens Regular Fit Polo Neck Half Sleeve Solid Casual T-shirt is a stylish and comfortable choice for casual wear.\r\nThe half sleeves offer a relaxed and versatile style, perfect for warmer weather or layering under jackets.\r\nThe solid color design adds a touch of elegance and makes it easy to pair with different bottoms.\r\nIt is suitable for various occasions, including casual outings, social gatherings, and relaxed work environments.\r\nThe T-shirt is designed with a classic polo neck, giving it a sophisticated and timeless look.', 11, 1);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
