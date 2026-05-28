<?php
// Test the village AJAX endpoint
$panchayat_id = isset($_GET['panchayat_id']) ? $_GET['panchayat_id'] : 219; // Default from screenshot

$mysqli = new mysqli('localhost', 'root', '', 'janumang');
if ($mysqli->connect_error) {
    die('Connection failed: ' . $mysqli->connect_error);
}

echo "Testing Village Fetch for Panchayat ID: $panchayat_id\n";
echo "=================================================\n\n";

$stmt = $mysqli->prepare('SELECT * FROM village WHERE panchayatid = ?');
$stmt->bind_param('i', $panchayat_id);
$stmt->execute();
$result = $stmt->get_result();

$villages = [];
while ($row = $result->fetch_assoc()) {
    $villages[] = $row;
}

echo "Number of villages found: " . count($villages) . "\n\n";

if (count($villages) > 0) {
    echo "Villages:\n";
    foreach ($villages as $village) {
        echo "ID: " . $village['id'] . " - Name: " . $village['name'] . "\n";
    }
} else {
    echo "No villages found for this panchayat.\n";
    echo "\nLet's check if this panchayat exists:\n";
    
    $stmt2 = $mysqli->prepare('SELECT * FROM panchayat WHERE id = ?');
    $stmt2->bind_param('i', $panchayat_id);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
    
    if ($result2->num_rows > 0) {
        $panchayat = $result2->fetch_assoc();
        echo "Panchayat found: " . $panchayat['name'] . " (ID: " . $panchayat['id'] . ")\n";
        echo "Booth ID: " . $panchayat['boothid'] . "\n";
        echo "Block ID: " . $panchayat['blockid'] . "\n";
    } else {
        echo "Panchayat not found!\n";
    }
}

echo "\n\nJSON Response (as would be returned by AJAX):\n";
echo json_encode($villages, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

$mysqli->close();
?>
