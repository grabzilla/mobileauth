<?php

$host = 'localhost';
$user = 'root';
$password = '';
$database = 'flutter_db';

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode(['message' => 'Database connection failed: ' . $conn->connect_error]);
    exit();
}
?>