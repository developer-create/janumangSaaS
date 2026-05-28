<?php
// Test autoload paths
$apppath = __DIR__ . '/application/';

echo "Testing autoload paths:\n";
echo str_repeat("-", 80) . "\n";

// Path 1
$path1 = $apppath . '../vendor/autoload.php';
echo "Path 1: $path1\n";
echo "Exists: " . (file_exists($path1) ? "✓ YES" : "✗ NO") . "\n";
if (file_exists($path1)) {
    echo "Real path: " . realpath($path1) . "\n";
}

echo "\n";

// Path 2
$path2 = $apppath . 'third_party/google-api-php-client/vendor/autoload.php';
echo "Path 2: $path2\n";
echo "Exists: " . (file_exists($path2) ? "✓ YES" : "✗ NO") . "\n";
if (file_exists($path2)) {
    echo "Real path: " . realpath($path2) . "\n";
}

echo "\n" . str_repeat("-", 80) . "\n";

// Try to load
if (file_exists($path1)) {
    echo "Loading Path 1...\n";
    require_once $path1;
    if (class_exists('Google_Client')) {
        echo "✓ Google_Client class found!\n";
    } else {
        echo "✗ Google_Client class NOT found\n";
    }
} else if (file_exists($path2)) {
    echo "Loading Path 2...\n";
    require_once $path2;
    if (class_exists('Google_Client')) {
        echo "✓ Google_Client class found!\n";
    } else {
        echo "✗ Google_Client class NOT found\n";
    }
} else {
    echo "✗ No autoload path found!\n";
}
?>
