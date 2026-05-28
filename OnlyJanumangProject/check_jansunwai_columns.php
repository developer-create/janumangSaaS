<?php
$mysqli = new mysqli('localhost', 'root', '', 'janumang');
if ($mysqli->connect_error) {
    die('Connection failed: ' . $mysqli->connect_error);
}

echo "Jansunwai Table Columns:\n";
echo "========================\n";
$result = $mysqli->query('DESCRIBE jansunwai');
if ($result) {
    while ($row = $result->fetch_assoc()) {
        echo $row['Field'] . " - " . $row['Type'] . " - " . ($row['Null'] == 'YES' ? 'NULL' : 'NOT NULL') . "\n";
    }
} else {
    echo 'Error: ' . $mysqli->error . "\n";
}

$mysqli->close();
?>
