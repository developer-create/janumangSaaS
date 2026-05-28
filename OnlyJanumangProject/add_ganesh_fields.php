<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "janumang";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "ALTER TABLE ganesh_samiti 
    ADD COLUMN block_name VARCHAR(100) AFTER ganesh_samiti_name,
    ADD COLUMN sector VARCHAR(100) AFTER block_name,
    ADD COLUMN micro_sector_number VARCHAR(50) AFTER sector,
    ADD COLUMN micro_sector_name VARCHAR(100) AFTER micro_sector_number,
    ADD COLUMN booth_number VARCHAR(50) AFTER micro_sector_name,
    ADD COLUMN booth_name VARCHAR(100) AFTER booth_number,
    ADD COLUMN panchayat VARCHAR(100) AFTER booth_name,
    ADD COLUMN gram VARCHAR(100) AFTER panchayat,
    ADD COLUMN faliya VARCHAR(100) AFTER gram,
    ADD COLUMN member_name VARCHAR(100) AFTER faliya,
    ADD COLUMN father_name VARCHAR(100) AFTER member_name,
    ADD COLUMN age VARCHAR(10) AFTER father_name,
    ADD COLUMN position VARCHAR(100) AFTER age";
    
    $pdo->exec($sql);
    echo "Database updated successfully with new fields\n";
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>