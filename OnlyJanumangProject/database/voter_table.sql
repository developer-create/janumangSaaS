-- Voter Table Creation SQL
-- Run this SQL in your database to create the voter table

CREATE TABLE IF NOT EXISTS `voter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `father_name` varchar(255) NOT NULL,
  `mobile_no` varchar(20) NOT NULL,
  `age` int(11) NOT NULL,
  `full_address` text NOT NULL,
  `block_id` int(11) NOT NULL,
  `booth_id` int(11) NOT NULL,
  `booth_no` varchar(50) DEFAULT NULL,
  `panchayat_id` int(11) NOT NULL,
  `village_id` int(11) NOT NULL,
  `falia_majra` varchar(255) DEFAULT NULL,
  `voter_id_epic` varchar(50) NOT NULL,
  `voter_image` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `block_id` (`block_id`),
  KEY `booth_id` (`booth_id`),
  KEY `panchayat_id` (`panchayat_id`),
  KEY `village_id` (`village_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

