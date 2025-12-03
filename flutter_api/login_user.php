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

set_error_handler(function($errno, $errstr) {
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode(['message' => 'PHP Error: ' . $errstr]);
    exit();
});

if (isset($_POST['name']) && isset($_POST['password'])) {
    $username = $_POST['name']; 
    $password_input = $_POST['password'];

    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    
    if ($stmt === false) {
        http_response_code(500);
        echo json_encode(['message' => 'Error preparing statement: ' . $conn->error]);
        exit();
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];

        if (password_verify($password_input, $hashed_password)) {
            http_response_code(200);
            echo json_encode(['message' => 'Login Successful']);
        } else {
            http_response_code(401);
            echo json_encode(['message'=> 'Invalid credentials']);
        }
    } else {
        http_response_code(401);
        echo json_encode(['message'=> 'Invalid credentials']);
    }
    
    $stmt->close();
} else {
    http_response_code(400);
    echo json_encode(['message' => 'Error: Missing username or password in request.']);
}
?>