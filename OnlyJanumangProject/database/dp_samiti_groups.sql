-- DP Samiti Groups Table (following Block Samiti structure)
-- This table stores location/group information

CREATE TABLE IF NOT EXISTS `dp_samiti_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `serial_no` varchar(50) DEFAULT NULL,
  `block` int(11) DEFAULT NULL,
  `sector` varchar(255) DEFAULT NULL,
  `micro_sector_no` varchar(100) DEFAULT NULL,
  `micro_sector_name` varchar(255) DEFAULT NULL,
  `booth_name` int(11) DEFAULT NULL,
  `booth_no` varchar(100) DEFAULT NULL,
  `gram_panchayat` varchar(255) DEFAULT NULL,
  `village` varchar(255) DEFAULT NULL,
  `faliya` varchar(255) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `block` (`block`),
  KEY `booth_name` (`booth_name`),
  CONSTRAINT `dp_samiti_groups_ibfk_1` FOREIGN KEY (`block`) REFERENCES `block` (`id`),
  CONSTRAINT `dp_samiti_groups_ibfk_2` FOREIGN KEY (`booth_name`) REFERENCES `booth` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
