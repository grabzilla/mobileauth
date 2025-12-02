<?php
include 'db_config.php';

$name = $_POST['name'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$sql = "INSERT INTO users (name,password) VALUES ('$name','$password')";

if($conn ->query($sql) === TRUE){
    echo json_encode(['message' => 'User created Successfully']);
}else{
    echo json_encode(['message'=> $conn -> error]);
}
?>