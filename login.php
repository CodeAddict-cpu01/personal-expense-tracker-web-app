<?php
include "db.php";

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE email='$email'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

if ($user && password_verify($password, $user['password'])) {
    echo json_encode([
        "status" => "success",
        "user_id" => $user['id'],
        "name" => $user['name']
    ]);
} else {
    echo json_encode(["status" => "error"]);
}
?>