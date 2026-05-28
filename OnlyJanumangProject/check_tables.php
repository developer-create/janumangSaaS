<?php
// Database connection configuration
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'janumang';

// Create connection
$conn = new mysqli($hostname, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset to utf8
$conn->set_charset("utf8");

echo "=== AVAILABLE TABLES ===\n\n";

// Get all tables
$query = "SHOW TABLES";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $tables = array();
    while ($row = $result->fetch_row()) {
        $tables[] = $row[0];
    }
    
    foreach ($tables as $table) {
        echo "Table: " . $table . "\n";
        
        // Get columns for this table
        $colQuery = "SHOW COLUMNS FROM " . $table;
        $colResult = $conn->query($colQuery);
        
        if ($colResult->num_rows > 0) {
            echo "  Columns: ";
            $cols = array();
            while ($col = $colResult->fetch_assoc()) {
                $cols[] = $col['Field'];
            }
            echo implode(", ", $cols) . "\n";
        }
        echo "\n";
    }
}

$conn->close();
?>
