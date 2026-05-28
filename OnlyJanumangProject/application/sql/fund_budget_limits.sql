CREATE TABLE IF NOT EXISTS `fund_budget_limits` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `financial_year` varchar(32) NOT NULL COMMENT 'e.g. 2023-24',
  `fund_key` varchar(64) NOT NULL,
  `total_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_fy_fund` (`financial_year`,`fund_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
