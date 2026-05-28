-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: sdb-66.hosting.stackcp.net
-- Generation Time: Nov 18, 2025 at 02:36 AM
-- Server version: 10.6.18-MariaDB-log
-- PHP Version: 8.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `janumang-353034313fe5`
--

-- --------------------------------------------------------

--
-- Table structure for table `block_samiti`
--

CREATE TABLE `block_samiti` (
  `id` int(11) NOT NULL,
  `group_id` int(11) DEFAULT NULL COMMENT 'Reference to block_samiti_groups.id',
  `serial_no` varchar(50) DEFAULT NULL COMMENT 'क्र.',
  `block` int(11) DEFAULT NULL COMMENT 'ब्लॉक - block.id',
  `sector` varchar(100) DEFAULT NULL COMMENT 'सेक्टर',
  `micro_sector_no` varchar(50) DEFAULT NULL COMMENT 'माइक्रो सेक्टर न',
  `micro_sector_name` varchar(200) DEFAULT NULL COMMENT 'माइक्रो सेक्टर नाम',
  `booth_name` int(11) DEFAULT NULL COMMENT 'बूथ का नाम - booth.id',
  `booth_no` varchar(50) DEFAULT NULL COMMENT 'बूथ क',
  `gram_panchayat` varchar(200) DEFAULT NULL COMMENT 'ग्राम पंचायत',
  `village` varchar(200) DEFAULT NULL COMMENT 'गांव का नाम',
  `faliya` varchar(200) DEFAULT NULL COMMENT 'फलिया',
  `member_name` varchar(200) NOT NULL COMMENT 'सदस्य का नाम',
  `father_name` varchar(200) DEFAULT NULL COMMENT 'पिता का नाम',
  `age` int(11) DEFAULT NULL COMMENT 'उम्र',
  `position` varchar(100) DEFAULT NULL COMMENT 'पद',
  `mobile_number` varchar(15) DEFAULT NULL COMMENT 'मोबाइल नम्बर',
  `remark` text DEFAULT NULL COMMENT 'रिमार्क',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Block Samiti (ब्लॉक समिति)';

--
-- Dumping data for table `block_samiti`
--

INSERT INTO `block_samiti` (`id`, `group_id`, `serial_no`, `block`, `sector`, `micro_sector_no`, `micro_sector_name`, `booth_name`, `booth_no`, `gram_panchayat`, `village`, `faliya`, `member_name`, `father_name`, `age`, `position`, `mobile_number`, `remark`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(2, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'hj', 'jainsaab', 15, 'Trissur Archdiocese', '7566043133', '7566043133', 1, NULL, '2025-11-12 13:23:45', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `block_samiti`
--
ALTER TABLE `block_samiti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `block` (`block`),
  ADD KEY `booth_name` (`booth_name`),
  ADD KEY `group_id` (`group_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `block_samiti`
--
ALTER TABLE `block_samiti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
