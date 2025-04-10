-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 14, 2024 at 08:49 PM
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
-- Database: `notification`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_notify`
--

CREATE TABLE `admin_notify` (
  `id` int(11) NOT NULL,
  `notify_name` varchar(100) NOT NULL,
  `notify_email` varchar(100) NOT NULL,
  `notify_username` varchar(100) NOT NULL,
  `notify_img` varchar(100) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `notify_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_notify`
--

INSERT INTO `admin_notify` (`id`, `notify_name`, `notify_email`, `notify_username`, `notify_img`, `active`, `notify_active`) VALUES
(1, 'Shahid', ' mohd47149@gmail.com', 'neonPeHunt', 'user_profile.jpg', 1, 0),
(12, 'Shahid', ' mohd47149@gmail.com', 'Shamohd4sh98', 'user_profile.jpg', 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_notify`
--
ALTER TABLE `admin_notify`
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_notify`
--
ALTER TABLE `admin_notify`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
