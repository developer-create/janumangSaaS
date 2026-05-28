-- Vidhan Sabha table creation script
CREATE TABLE IF NOT EXISTS `vidhan_sabha` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `serial_no` varchar(50) NOT NULL,
  `vidhan_sabha_name` varchar(255) NOT NULL,
  `district_id` int(11),
  `created_by` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `serial_no` (`serial_no`),
  KEY `created_by` (`created_by`),
  KEY `added_by` (`added_by`),
  KEY `district_id` (`district_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
