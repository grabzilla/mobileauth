<?php
include 'db_config.php';

if (isset($_POST['name']) && isset($_POST['password'])) {
    $username = $_POST['name']; 
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    
    if ($stmt === false) {
        echo json_encode(['message' => 'Error preparing statement: ' . $conn->error]);
        exit();
    }
    $stmt->bind_param("ss", $username, $password);

    if ($stmt->execute()) {
        echo json_encode(['message' => 'User created Successfully']);
    } else {
        echo json_encode(['message'=> 'SQL Error: ' . $stmt->error]);
    }
    $stmt->close();
} else {
    echo json_encode(['message' => 'Error: Missing username or password in request.']);
}
?>