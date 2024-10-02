-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 02, 2024 at 06:01 PM
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
-- Database: `user_order`
--

-- --------------------------------------------------------

--
-- Table structure for table `user_order`
--

CREATE TABLE `user_order` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `product_id` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`product_id`)),
  `razorpay_order_id` varchar(255) DEFAULT NULL,
  `razorpay_payment_id` varchar(225) DEFAULT NULL,
  `currency` varchar(10) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `address` longtext DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_order`
--

INSERT INTO `user_order` (`id`, `user_id`, `amount`, `product_id`, `razorpay_order_id`, `razorpay_payment_id`, `currency`, `status`, `address`, `created_at`) VALUES
(15, 14, 13596, '[\"15\",\"10\",\"14\",\"13\"]', 'order_P2eqsBW4rFZj8M', 'pay_P2eqycaKNtE8Xc', 'INR', 'completed', 'AB-145, Harsh Vihar, OM Nagar,Near GYM,Badarpur,110044-New Delhi', '2024-09-28 16:48:53'),
(16, 14, 13596, '[\"15\",\"10\",\"14\",\"13\"]', 'order_P2fkcaMC9qDRZz', 'pay_P2fkxn8vGYzSQb', 'INR', 'completed', 'AB-145, Harsh Vihar, OM Nagar,Near GYM,Badarpur,110044-New Delhi', '2024-09-28 17:41:53'),
(17, 14, 15094, '[\"15\",\"10\",\"14\",\"13\",\"11\"]', 'order_P2fpDe8JYBE1Bj', 'pay_P2fpJBPPJHZPCG', 'INR', 'completed', 'AB-145, Harsh Vihar, OM Nagar,Near GYM,Badarpur,110044-New Delhi', '2024-09-28 17:46:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user_order`
--
ALTER TABLE `user_order`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user_order`
--
ALTER TABLE `user_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
