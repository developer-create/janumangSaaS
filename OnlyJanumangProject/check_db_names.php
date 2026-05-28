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

echo "=== DATABASE NAMES CHECK ===\n\n";

// Function to display table data
function displayTableData($conn, $tableName, $columnName) {
    echo "--- " . strtoupper($columnName) . " NAMES ---\n";
    $query = "SELECT DISTINCT " . $columnName . " FROM " . $tableName . " ORDER BY " . $columnName;
    $result = $conn->query($query);
    
    if ($result === false) {
        echo "Error: " . $conn->error . "\n";
        return;
    }
    
    if ($result->num_rows > 0) {
        $count = 0;
        while ($row = $result->fetch_assoc()) {
            $count++;
            echo $count . ". " . $row[$columnName] . "\n";
        }
        echo "Total: " . $count . " records\n";
    } else {
        echo "No records found.\n";
    }
    echo "\n";
}

// Check each table
displayTableData($conn, 'district', 'name');
displayTableData($conn, 'block', 'name');
displayTableData($conn, 'panchayat', 'name');
displayTableData($conn, 'vidhan_sabha', 'vidhan_sabha_name');
displayTableData($conn, 'village', 'name');

$conn->close();
?>
