<?php
$config = include('config/database.php');
$host = $config['connections']['mysql']['host'];
$user = $config['connections']['mysql']['username'];
$password = $config['connections']['mysql']['password'];
$db = $config['connections']['mysql']['database'];

$conn = new mysqli($host, $user, $password, $db);
if ($conn->connect_error) {
    die('Connection error: ' . $conn->connect_error);
}

$result = $conn->query('SELECT MAX(CAST(SUBSTRING(PricingID, 4) AS UNSIGNED)) as max_num FROM pricing');
$row = $result->fetch_assoc();
echo 'Max PricingID number: ' . ($row['max_num'] ?? 0) . PHP_EOL;

$result = $conn->query('SELECT PricingID, ProductID FROM pricing ORDER BY PricingID DESC LIMIT 10');
echo "\nLatest Pricing Records:\n";
while ($row = $result->fetch_assoc()) {
    echo $row['PricingID'] . ' - ' . $row['ProductID'] . PHP_EOL;
}

$conn->close();
?>
