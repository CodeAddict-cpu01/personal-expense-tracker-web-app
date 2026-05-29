<?php
include 'db.php';

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE email='$email'";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // 🔥 VERIFY PASSWORD
    if (password_verify($password, $row['password'])) {

        echo json_encode([
            "status" => "success",
            "user_id" => $row['id'],
            "name" => $row['name']
        ]);

    } else {
        echo json_encode(["status" => "error"]);
    }

} else {
    echo json_encode(["status" => "error"]);
}
?>