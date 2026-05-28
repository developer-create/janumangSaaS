<?php
// Test script to check dropdown data

// Direct database connection
$mysqli = new mysqli('localhost', 'root', '', 'janumang2');

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Get ALL districts
echo "ALL DISTRICTS:\n";
echo "==============\n";
$result = $mysqli->query("SELECT * FROM district");
while($row = $result->fetch_assoc()) {
    echo "ID: " . $row['id'] . " Name: " . $row['name'] . "\n";
}

echo "\n\nALL VIDHAN SABHAS:\n";
echo "==================\n";
$result = $mysqli->query("SELECT id, vidhan_sabha_name FROM vidhan_sabha");
while($row = $result->fetch_assoc()) {
    echo "ID: " . $row['id'] . " Name: " . $row['vidhan_sabha_name'] . "\n";
}

echo "\n\nDHAR in district table?\n";
$result = $mysqli->query("SELECT * FROM district WHERE name LIKE '%DHAR%'");
if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo json_encode($row) . "\n";
    }
} else {
    echo "NOT FOUND\n";
}

echo "\n\nGANDHWANI in vidhan_sabha table?\n";
$result = $mysqli->query("SELECT * FROM vidhan_sabha WHERE vidhan_sabha_name LIKE '%GANDHWANI%'");
if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo json_encode($row) . "\n";
    }
} else {
    echo "NOT FOUND\n";
}

$mysqli->close();
?>
