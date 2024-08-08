-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 08, 2024 at 07:33 PM
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
-- Database: `users_info`
--

-- --------------------------------------------------------

--
-- Table structure for table `kunkunalku78`
--

CREATE TABLE `kunkunalku78` (
  `id` int(10) UNSIGNED NOT NULL,
  `data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `maimanisab74`
--

CREATE TABLE `maimanisab74` (
  `id` int(10) UNSIGNED NOT NULL,
  `data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `punpunitpu85`
--

CREATE TABLE `punpunitpu85` (
  `id` int(10) UNSIGNED NOT NULL,
  `data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sahsahilsa84`
--

CREATE TABLE `sahsahilsa84` (
  `id` int(10) UNSIGNED NOT NULL,
  `data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shashahish96`
--

CREATE TABLE `shashahish96` (
  `id` int(10) UNSIGNED NOT NULL,
  `data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tartarunta74`
--

CREATE TABLE `tartarunta74` (
  `id` int(10) UNSIGNED NOT NULL,
  `data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kunkunalku78`
--
ALTER TABLE `kunkunalku78`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `maimanisab74`
--
ALTER TABLE `maimanisab74`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `punpunitpu85`
--
ALTER TABLE `punpunitpu85`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sahsahilsa84`
--
ALTER TABLE `sahsahilsa84`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shashahish96`
--
ALTER TABLE `shashahish96`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tartarunta74`
--
ALTER TABLE `tartarunta74`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kunkunalku78`
--
ALTER TABLE `kunkunalku78`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `maimanisab74`
--
ALTER TABLE `maimanisab74`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `punpunitpu85`
--
ALTER TABLE `punpunitpu85`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sahsahilsa84`
--
ALTER TABLE `sahsahilsa84`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shashahish96`
--
ALTER TABLE `shashahish96`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tartarunta74`
--
ALTER TABLE `tartarunta74`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
