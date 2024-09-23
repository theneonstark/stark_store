-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 23, 2024 at 01:57 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `user`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(150) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `profile_img` text DEFAULT 'user_profile.jpg',
  `office` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `username`, `email`, `password`, `created_at`, `updated_at`, `profile_img`, `office`) VALUES
(1, 'Shahid', 'neonstark', 'admin@starkstore.com', 'admin123', '2024-08-03 10:17:53', '2024-08-05 04:50:16', 'user_profile.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `dept_id` int(11) NOT NULL,
  `dept_name` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`dept_id`, `dept_name`) VALUES
(1, 'admin'),
(2, 'user');

-- --------------------------------------------------------

--
-- Table structure for table `google_user`
--

CREATE TABLE `google_user` (
  `id` int(11) NOT NULL,
  `sub` text NOT NULL,
  `name` text NOT NULL,
  `given_name` text NOT NULL,
  `picture` text NOT NULL,
  `email` text NOT NULL,
  `email_verify` tinyint(1) NOT NULL,
  `dept` int(11) DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `Mobile` varchar(100) NOT NULL,
  `password` varchar(150) NOT NULL,
  `profile_img` text DEFAULT 'user_profile.jpg',
  `office` int(11) DEFAULT 2,
  `username` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `wishlist` varchar(100) DEFAULT 'user_wishlist',
  `cart` varchar(100) DEFAULT 'user_cart',
  `address` text DEFAULT NULL,
  `landmark` text DEFAULT NULL,
  `city` text DEFAULT NULL,
  `zip` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `Mobile`, `password`, `profile_img`, `office`, `username`, `created_at`, `updated_at`, `wishlist`, `cart`, `address`, `landmark`, `city`, `zip`, `state`) VALUES
(11, 'Tarun', 'tarun@gmail.com', '9632587410', 'tarun123', 'user_profile.jpg', 2, 'Tartarunta96', '2024-08-10 07:51:05', '2024-08-10 18:57:37', '11Tarun_wishlist', '11Tarun', NULL, NULL, NULL, NULL, NULL),
(12, 'Sahil', 'sahil@gmail.com', '7418529630', 'sahil123', 'user_profile.jpg', 2, 'Sahsahilsa74', '2024-08-10 08:07:27', '2024-08-11 16:07:27', '12Sahil_wishlist', '12Sahil_cart', NULL, NULL, NULL, NULL, NULL),
(13, 'Manish', 'manish@gmail.com', '8526541254', 'manish123', 'user_profile.jpg', 2, 'Manmanisma85', '2024-08-10 08:13:23', '2024-08-11 17:29:58', '13Manish_wishlist', '13Manish_cart', NULL, NULL, NULL, NULL, NULL),
(14, 'Punit', 'punit@gmail.com', '9856745872', 'pun123', 'user_profile.jpg', 2, 'Punpunitpu98', '2024-08-10 18:35:06', '2024-09-20 08:31:04', '14Punit_wishlist', '14Punit_cart', 'AB-145, Harsh Vihar, OM Nagar', 'Near GYM', 'Badarpur', '110044', 'New Delhi'),
(15, 'rahul', 'rahul@gmail.com', '8541236529', 'rah123', 'user_profile.jpg', 2, 'rahrahulra85', '2024-08-10 18:42:34', '2024-08-10 18:44:41', '15rahul_wishlist', 'user_cart', NULL, NULL, NULL, NULL, NULL),
(16, 'zara', 'zara@gmail.com', '9652745285', 'zara123', 'user_profile.jpg', 2, 'zarzara@za96', '2024-08-10 18:47:02', '2024-08-10 18:47:30', '16zara_wishlist', 'user_cart', NULL, NULL, NULL, NULL, NULL),
(17, 'Aysha', 'aysha@gmail.com', '9874123685', 'aysha123', 'user_profile.jpg', 2, 'Aysayshaay98', '2024-08-10 18:49:22', '2024-08-11 16:08:24', '17Aysha_wishlist', '17Aysha_cart', NULL, NULL, NULL, NULL, NULL),
(18, 'Mohit', 'mohit@gmail.com', '7452145638', 'momo123', 'user_profile.jpg', 2, 'Mohmohitmo74', '2024-08-21 18:33:30', '2024-08-21 18:33:30', 'user_wishlist', 'user_cart', NULL, NULL, NULL, NULL, NULL),
(19, 'Kunal', 'kunal@gmail.com', '7845212365', 'kun123', 'user_profile.jpg', 2, 'Kunkunalku78', '2024-08-21 18:34:54', '2024-08-21 18:34:54', 'user_wishlist', 'user_cart', NULL, NULL, NULL, NULL, NULL),
(20, 'Gungun', 'gungun@gmail.com', '8965232145', 'gun009', 'user_profile.jpg', 2, 'Gungungugu89', '2024-08-21 18:35:41', '2024-08-21 18:35:41', 'user_wishlist', 'user_cart', NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `office` (`office`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`dept_id`);

--
-- Indexes for table `google_user`
--
ALTER TABLE `google_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `dept` (`dept`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`) USING HASH,
  ADD KEY `office` (`office`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `google_user`
--
ALTER TABLE `google_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admins`
--
ALTER TABLE `admins`
  ADD CONSTRAINT `admins_ibfk_1` FOREIGN KEY (`office`) REFERENCES `department` (`dept_id`);

--
-- Constraints for table `google_user`
--
ALTER TABLE `google_user`
  ADD CONSTRAINT `google_user_ibfk_1` FOREIGN KEY (`dept`) REFERENCES `department` (`dept_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `office` FOREIGN KEY (`office`) REFERENCES `department` (`dept_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
