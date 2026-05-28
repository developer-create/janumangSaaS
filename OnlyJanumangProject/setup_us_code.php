<?php
// Simple setup script to create US Code table
require_once 'application/config/database.php';

$db_config = $db['default'];

// Create connection
$conn = new mysqli($db_config['hostname'], $db_config['username'], $db_config['password'], $db_config['database']);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create table
$sql = "CREATE TABLE IF NOT EXISTS `us_code` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(100) NOT NULL UNIQUE,
  `description` varchar(255),
  `status` tinyint(1) DEFAULT 1,
  `created_by` int(11),
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int(11),
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

if ($conn->query($sql) === TRUE) {
    echo "Table created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}

// Insert default codes
$codes = array(
    array('SC', 'SC'),
    array('YC', 'YC'),
    array('WC', 'WC'),
    array('PA', 'PA'),
    array('SM', 'SM'),
    array('EO', 'EO'),
    array('GS', 'GS'),
    array('DCC', 'DCC'),
    array('PW', 'PW'),
    array('NL', 'NL'),
    array('FR', 'FR'),
    array('SO', 'SO'),
    array('ST', 'ST'),
    array('REF', 'REF'),
    array('US', 'US'),
    array('SMW', 'SMW'),
    array('DYC', 'DYC'),
    array('OBC', 'OBC'),
    array('DT', 'DT'),
    array('DP', 'DP'),
    array('MLA', 'MLA'),
    array('AVP', 'AVP'),
    array('MEET', 'MEET'),
    array('MEDIA', 'MEDIA'),
    array('X MLA', 'X MLA'),
    array('BC (बूथ कमेटी)', 'BC (बूथ कमेटी)'),
    array('PP (पेज प्रभारी)', 'PP (पेज प्रभारी)'),
    array('IP (प्रभावशाली व्यक्ति)', 'IP (प्रभावशाली व्यक्ति)'),
    array('FH (परिवार का मुखिया)', 'FH (परिवार का मुखिया)'),
    array('SMM (सोशल मीडिया मित्र)', 'SMM (सोशल मीडिया मित्र)'),
    array('MS (महिला समिति)', 'MS (महिला समिति)'),
    array('FP (फलिया प्रभारी)', 'FP (फलिया प्रभारी)'),
    array('ER (चुनाव प्रभारी)', 'ER (चुनाव प्रभारी)'),
    array('वरिष्ठ', 'वरिष्ठ'),
    array('युवा', 'युवा'),
    array('वोटरप्रभारी(१० घर)', 'वोटरप्रभारी(१० घर)'),
    array('BLA (बूथ लेवल एजेंट)', 'BLA (बूथ लेवल एजेंट)')
);

$inserted = 0;
foreach ($codes as $code) {
    $sql = "INSERT IGNORE INTO `us_code` (`code`, `description`, `status`) VALUES ('" . $conn->real_escape_string($code[0]) . "', '" . $conn->real_escape_string($code[1]) . "', 1)";
    if ($conn->query($sql) === TRUE) {
        $inserted++;
    }
}

echo "Inserted " . $inserted . " codes<br>";
echo "Setup completed successfully!<br>";

$conn->close();
?>
