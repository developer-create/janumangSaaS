-- Use this script with the `janumang` database

-- Mandir Samiti Table
CREATE TABLE IF NOT EXISTS `mandir_samiti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `serial_number` varchar(50) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `mandir_samiti_name` varchar(200) DEFAULT NULL,
  `block_name` varchar(100) DEFAULT NULL,
  `sector` varchar(100) DEFAULT NULL,
  `micro_sector_number` varchar(100) DEFAULT NULL,
  `micro_sector_name` varchar(150) DEFAULT NULL,
  `booth_number` varchar(100) DEFAULT NULL,
  `booth_name` varchar(150) DEFAULT NULL,
  `panchayat` varchar(150) DEFAULT NULL,
  `gram` varchar(150) DEFAULT NULL,
  `faliya` varchar(150) DEFAULT NULL,
  `member_name` varchar(150) DEFAULT NULL,
  `father_name` varchar(150) DEFAULT NULL,
  `age` varchar(20) DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `mobile_number` varchar(20) DEFAULT NULL,
  `remark` text,
  `status` varchar(20) DEFAULT 'Active',
  `created_on` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

