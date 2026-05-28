<?php
$mysqli = new mysqli('localhost', 'root', '', 'janumang');
if ($mysqli->connect_error) {
    die('Connection failed: ' . $mysqli->connect_error);
}

echo "Village Table Structure:\n";
echo "========================\n";
$result = $mysqli->query('DESCRIBE village');
if ($result) {
    while ($row = $result->fetch_assoc()) {
        echo $row['Field'] . ' - ' . $row['Type'] . "\n";
    }
} else {
    echo 'Error: ' . $mysqli->error . "\n";
}

echo "\n\nSample Village Data:\n";
echo "====================\n";
$result = $mysqli->query('SELECT * FROM village LIMIT 5');
if ($result) {
    while ($row = $result->fetch_assoc()) {
        print_r($row);
    }
} else {
    echo 'Error: ' . $mysqli->error . "\n";
}

$mysqli->close();
?>
