<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include 'db_config.php';

$sql = "SELECT id, username AS name, password FROM users";
$result = $conn->query($sql);

$users = [];

while($row = $result->fetch_assoc()) {
    $users[] = $row;
}

echo json_encode($users);
?>