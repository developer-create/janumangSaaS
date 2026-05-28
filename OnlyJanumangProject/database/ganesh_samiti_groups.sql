-- phpMyAdmin SQL Dump
-- Table structure for table `ganesh_samiti_groups`
--

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Table structure for table `ganesh_samiti_groups`
--

CREATE TABLE `ganesh_samiti_groups` (
  `id` int(11) NOT NULL,
  `serial_no` varchar(50) DEFAULT NULL COMMENT 'क्र.',
  `year` varchar(10) DEFAULT NULL COMMENT 'वर्ष',
  `ganesh_samiti_name` varchar(200) DEFAULT NULL COMMENT 'गणेश समिति नाम',
  `block` int(11) DEFAULT NULL COMMENT 'ब्लॉक - block.id',
  `sector` varchar(100) DEFAULT NULL COMMENT 'सेक्टर',
  `micro_sector_no` varchar(50) DEFAULT NULL COMMENT 'माइक्रो सेक्टर न',
  `micro_sector_name` varchar(200) DEFAULT NULL COMMENT 'माइक्रो सेक्टर नाम',
  `booth_name` int(11) DEFAULT NULL COMMENT 'बूथ का नाम - booth.id',
  `booth_no` varchar(50) DEFAULT NULL COMMENT 'बूथ न',
  `gram_panchayat` varchar(200) DEFAULT NULL COMMENT 'ग्राम पंचायत',
  `village` varchar(200) DEFAULT NULL COMMENT 'गांव का नाम',
  `faliya` varchar(200) DEFAULT NULL COMMENT 'फलिया',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Ganesh Samiti Groups/Locations (गणेश समिति)';

--
-- Indexes for table `ganesh_samiti_groups`
--
ALTER TABLE `ganesh_samiti_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `block` (`block`),
  ADD KEY `booth_name` (`booth_name`);

--
-- AUTO_INCREMENT for table `ganesh_samiti_groups`
--
ALTER TABLE `ganesh_samiti_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for table `ganesh_samiti_groups`
--
ALTER TABLE `ganesh_samiti_groups`
  ADD CONSTRAINT `fk_ganesh_samiti_groups_block` FOREIGN KEY (`block`) REFERENCES `block` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_ganesh_samiti_groups_booth` FOREIGN KEY (`booth_name`) REFERENCES `booth` (`id`) ON DELETE SET NULL;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;