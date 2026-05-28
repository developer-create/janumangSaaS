-- phpMyAdmin SQL Dump
-- Table structure for table `ganesh_samiti`
--

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Table structure for table `ganesh_samiti`
--

CREATE TABLE `ganesh_samiti` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL COMMENT 'Reference to ganesh_samiti_groups.id',
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Ganesh Samiti Members (गणेश समिति सदस्य)';

--
-- Indexes for table `ganesh_samiti`
--
ALTER TABLE `ganesh_samiti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_id` (`group_id`);

--
-- AUTO_INCREMENT for table `ganesh_samiti`
--
ALTER TABLE `ganesh_samiti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for table `ganesh_samiti`
--
ALTER TABLE `ganesh_samiti`
  ADD CONSTRAINT `fk_ganesh_samiti_group` FOREIGN KEY (`group_id`) REFERENCES `ganesh_samiti_groups` (`id`) ON DELETE CASCADE;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;