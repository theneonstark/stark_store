-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 10, 2024 at 11:10 PM
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
-- Database: `wishlist`
--

-- --------------------------------------------------------

--
-- Table structure for table `14punit_wishlist`
--

CREATE TABLE `14punit_wishlist` (
  `w_id` int(11) NOT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `wp_detail` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `14punit_wishlist`
--

INSERT INTO `14punit_wishlist` (`w_id`, `user_name`, `wp_detail`) VALUES
(11, '14Punit_wishlist', 3),
(12, '14Punit_wishlist', 4),
(13, '14Punit_wishlist', 5);

-- --------------------------------------------------------

--
-- Table structure for table `user_wishlist`
--

CREATE TABLE `user_wishlist` (
  `w_id` int(11) NOT NULL,
  `user_name` varchar(150) NOT NULL,
  `wp_detail` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_wishlist`
--

INSERT INTO `user_wishlist` (`w_id`, `user_name`, `wp_detail`) VALUES
(1, 'userwow', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `14punit_wishlist`
--
ALTER TABLE `14punit_wishlist`
  ADD PRIMARY KEY (`w_id`);

--
-- Indexes for table `user_wishlist`
--
ALTER TABLE `user_wishlist`
  ADD UNIQUE KEY `w_id` (`w_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `14punit_wishlist`
--
ALTER TABLE `14punit_wishlist`
  MODIFY `w_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user_wishlist`
--
ALTER TABLE `user_wishlist`
  MODIFY `w_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
