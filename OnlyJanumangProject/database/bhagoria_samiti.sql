CREATE TABLE IF NOT EXISTS `bhagoria_samiti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `serial_no` varchar(50) DEFAULT NULL,
  `block` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `var` varchar(50) DEFAULT NULL COMMENT 'Day of week in Hindi',
  `bhagoria_hat` varchar(255) DEFAULT NULL,
  `dol_ki_sankhya` varchar(100) DEFAULT NULL COMMENT 'Number of Dol',
  `prabhari_ka_naam` varchar(255) DEFAULT NULL COMMENT 'In-charge Name',
  `mobile_number` varchar(15) DEFAULT NULL,
  `remark` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
