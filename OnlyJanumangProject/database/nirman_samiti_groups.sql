-- Table structure for table `nirman_samiti_groups`

CREATE TABLE `nirman_samiti_groups` (
  `id` int(11) NOT NULL,
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
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Nirman Samiti Groups/Locations (निर्माण समिति)';

--
-- Indexes for table `nirman_samiti_groups`
--
ALTER TABLE `nirman_samiti_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `block` (`block`),
  ADD KEY `booth_name` (`booth_name`);

--
-- AUTO_INCREMENT for table `nirman_samiti_groups`
--
ALTER TABLE `nirman_samiti_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;
