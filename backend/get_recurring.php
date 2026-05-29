<?php
include 'db.php';

$user_id = $_GET['user_id'];

$result =
mysqli_query(
$conn,
"SELECT *
 FROM recurring_expenses
 WHERE user_id='$user_id'"
);

$data = [];

while($row=mysqli_fetch_assoc($result)){
    $data[] = $row;
}

echo json_encode($data);
?>